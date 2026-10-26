<?php

namespace App\Http\Controllers;

use App\Enums\Color;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;


class ItemController extends Controller
{
    // O4 : Liste des objets non restitués avec filtres ?lieu= et ?couleur=
    public function index(Request $request)
    {
        $query = Item::with(['place', 'tags', 'photos'])->whereNull('returned_at');

        // Recherche par texte (nom ou description)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par lieu
        if ($request->filled('lieu')) {
            // Une valeur de lieu invalide ne doit pas être ignorée silencieusement.
            if (filter_var($request->input('lieu'), FILTER_VALIDATE_INT) !== false) {
                $query->where('place_id', (int) $request->input('lieu'));
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Filtre par couleur
        if ($request->filled('couleur')) {
            $color = Color::tryFrom((string) $request->input('couleur'));
            if ($color !== null) {
                $query->where('color', $color->value);
            }
        }
        $sort = $request->input('tri', 'date-desc'); // Valeur par défaut

        match ($sort) {
            'date-asc' => $query->oldest('found_on'),
            'name-asc' => $query->orderBy('name', 'asc'),
            'name-desc' => $query->orderBy('name', 'desc'),
            default => $query->latest('found_on'), // 'date-desc' ou valeur invalide interceptée
        };

        $items = $query->paginate(9)
            ->withQueryString(); // Conserve tous les paramètres (?, q=..., lieu=..., couleur=...) dans la pagination

        $places = Place::orderBy('name')->get();
        $colors = Color::cases();

        return view('items.index', compact('items', 'places', 'colors'));
    }

    // O5 : Fiche détaillée d'un objet
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    // O7 : Formulaire d'ajout
    public function create()
    {
        $places = Place::all();
        $tags = Tag::all();

        return view('items.create', compact('places', 'tags'));
    }

    // O8 : Formulaire de modification pré-rempli
    public function edit(Item $item)
    {
        $places = Place::all();
        $tags = Tag::all();

        return view('items.edit', compact('item', 'places', 'tags'));
    }

    // O9 : Restituer l'objet
    public function return(Item $item)
    {
        // Sécurité au cas où l'utilisateur clique depuis un deuxième onglet obsolète
        if ($item->isReturned()) {
            $formattedDate = $item->returned_at->format('d/m/Y');

            return redirect()->route('items.show', $item)
                ->with('success', __('Cet objet a déjà été restitué le :date.', ['date' => $formattedDate]));
        }

        $item->update(['returned_at' => now()]);

        return redirect()->route('items.index')
            ->with('success', __('« :name » a retrouvé son propriétaire.', ['name' => $item->name]));
    }

public function store(ItemRequest $request)
{
    // 1. Données déjà validées par ItemRequest
    $validatedData = $request->validated();

    // 2. Création de l'objet (sans photos ni tags, qui ne sont pas des colonnes de items)
    $item = Item::create(
        collect($validatedData)->except(['photos', 'tags'])->toArray()
    );

    // 3. Étiquettes
    $item->tags()->sync($request->input('tags', []));

    // 4. Photos
    $this->storePhotos($item, $request);

    return redirect()->route('items.index')
        ->with('success', __('L\'objet a été ajouté avec succès.'));
}

public function update(ItemRequest $request, Item $item)
{
    // 1. Données déjà validées par ItemRequest (la même que l'ajout)
    $validatedData = $request->validated();

    // 2. Mise à jour des informations de l'objet
    $item->update(
        collect($validatedData)->except(['photos', 'tags'])->toArray()
    );

    // 3. Mise à jour des tags
    $item->tags()->sync($request->input('tags', []));

    // 4. Ajout des nouvelles photos
    $this->storePhotos($item, $request);

    return redirect()->route('items.index')
        ->with('success', __('L\'objet a été modifié avec succès.'));
}
// Enregistre les photos envoyées (même méthode pour l'ajout et la modification)
private function storePhotos(Item $item, Request $request): void
{
    if (!$request->hasFile('photos')) {
        return;
    }

    // Si l'objet n'a aucune photo, la première sera la couverture
    $isFirst = $item->photos()->count() === 0;

    foreach ($request->file('photos') as $file) {
        if (!$file || !$file->isValid()) {
            continue;
        }

        $filename = uniqid('item_') . '.' . $file->getClientOriginalExtension();

        $destinationPath = storage_path('app/public/items');

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }

        $file->move($destinationPath, $filename);

        $item->photos()->create([
            'path' => 'items/' . $filename,
            'is_cover' => $isFirst,
        ]);

        $isFirst = false;
    }
}

// Suppression complète de l'objet et de TOUTES ses photos
public function destroy(Item $item)
{
    // On boucle sur chaque photo de la relation pour les effacer du disque
    foreach ($item->photos as $photo) {
        if ($photo->path && Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }
    }

    // Si votre table photos n'a pas de contrainte ON DELETE CASCADE, on force la suppression des enregistrements
    $item->photos()->delete();

    // Suppression de l'objet principal
    $item->delete();

    return redirect()->route('items.index')->with('success', __('L\'objet et ses photos ont été supprimés.'));
}


// Suppression d'une seule photo
public function destroyPhoto(Photo $photo)
{
    // 1. Suppression du fichier physique
    if ($photo->path && Storage::disk('public')->exists($photo->path)) {
        Storage::disk('public')->delete($photo->path);
    }

    $itemId = $photo->item_id;
    $wasCover = $photo->is_cover;

    // 2. Suppression de la ligne en BDD
    $photo->delete();

    // 3. Si c'était la photo de couverture, on réattribue la couverture à une autre photo s'il en reste
    if ($wasCover) {
        $nextPhoto = Photo::where('item_id', $itemId)->first();
        if ($nextPhoto) {
            $nextPhoto->update(['is_cover' => true]);
        }
    }

    return back()->with('success', __('La photo a été supprimée.'));
}

}
