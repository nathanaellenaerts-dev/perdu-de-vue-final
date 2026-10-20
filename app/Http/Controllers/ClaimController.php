<?php
namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    // Formulaire public /perdu
public function createPublic()
{
    return view('claims.create'); 
}
public function storePublic(Request $request)
{
    $validated = $request->validate([
        'traveler_name'  => 'required|string|max:255',
        'traveler_email' => 'required|email|max:255',
        'traveler_phone' => 'nullable|string|max:50',
        'lost_on'        => 'required|date',
        'item_name'      => 'required|string|max:255',
        'description'    => 'required|string',
    ]);

    Claim::create($validated);

    return redirect()->route('claims.public.create')
                     ->with('success', __('Votre déclaration de perte a bien été enregistrée.'));
}
    // Liste des déclarations et de leurs rapprochements
    public function index()
    {
        $claims = Claim::with('item')->latest()->paginate(20);
        return view('claims.index', compact('claims'));
    }

    // Page de détail + Match
    public function show(Claim $claim)
    {
        $claim->load('item');
        // Liste des objets en stock non restitués
        $availableItems = Item::whereNull('returned_at')->latest()->get();

        return view('claims.show', compact('claim', 'availableItems'));
    }

    // Lier l'objet trouvé à la déclaration
    public function linkItem(Request $request, Claim $claim)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        $claim->update(['item_id' => $request->item_id]);

        return back()->with('success', __('Liaison effectuée avec succès !'));
    }

    // Retirer la liaison
    public function unlinkItem(Claim $claim)
    {
        $claim->update(['item_id' => null]);

        return back()->with('success', __('La liaison a été retirée.'));
    }
}
