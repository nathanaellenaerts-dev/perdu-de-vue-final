<?php

namespace App\Http\Controllers;

use App\Models\Place;

class PlaceController extends Controller
{
    // O6 : Affiche le lieu et tous ses objets (restitués compris)
    public function show(Place $place)
    {
        $place->load('items.tags', 'items.photos', 'items.place');

        return view('places.show', compact('place'));
    }
}
