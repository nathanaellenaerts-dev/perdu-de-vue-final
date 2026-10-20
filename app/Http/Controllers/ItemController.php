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
        $query = Item::with(['place', 'tags'])->whereNull('returned_at');

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
            $query->where('place_id', $request->lieu);
        }

        // Filtre par couleur
        if ($request->filled('couleur')) {
            $query->where('color', $request->couleur);
        }
        $sort = $request->input('tri', 'date-desc'); // Valeur par défaut

        match ($sort) {
            'date-asc' => $query->oldest('found_on'),
            'name-asc' => $query->orderBy('name', 'asc'),
            'name-desc' => $query->orderBy('name', 'desc'),
            default => $query->latest('found_on'), // 'date-desc' ou valeur invalide interceptée
        };

        $items = $query->latest('found_on')
            ->paginate(9)
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
    public function returnItem(Item $item)
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

    public function store(Request $request)
    {
        // 1. On valide et on récupère les données propres
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'place_id' => 'required|exists:places,id',
            'found_on' => 'required|date',
            'color' => 'required|string|max:50', // S'assure que color peut être null s'il est vide
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. On crée l'objet en utilisant les données validées (et on exclut 'photos' qui n'est pas une colonne de la table items)
        $item = Item::create(collect($validatedData)->except('photos')->toArray());

/// 3. Gestion ultra-directe des photos
    if ($request->hasFile('photos')) {
        $isFirst = true;

        foreach ($request->file('photos') as $file) {
            if ($file) {
                // SOLUTION RADICALE : On génère un nom unique et on déplace manuellement le fichier
                $filename = uniqid('item_') . '.' . $file->getClientOriginalExtension();

                // On stocke directement dans storage/app/public/items
                $destinationPath = storage_path('app/public/items');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                $file->move($destinationPath, $filename);
                $path = 'items/' . $filename;

                // Enregistrement en base de données
                $item->photos()->create([
                    'path' => $path,
                    'is_cover' => $isFirst,
                ]);

                $isFirst = false;
            }
        }
    }

        return redirect()->route('items.index')
            ->with('success', __('L\'objet a été ajouté avec succès.'));
    }

    // Modification de l'objet
    public function update(ItemRequest $request, Item $item)
    {
        $data = $request->validated();

        // Remplacement de la photo
        if ($request->hasFile('photo')) {
            // Suppression de l'ancienne photo si elle existe
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($data);
        $item->tags()->sync($request->input('tags', []));

        return redirect()->route('items.index')->with('success', __('L\'objet a été modifié.'));
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



