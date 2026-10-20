<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Place;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function index()
    {
        // 1. Statistiques par Lieu
        // On compte le nombre d'objets liés à chaque lieu
        $itemsByPlace = Place::withCount('items')->orderBy('items_count', 'desc')->get();
        $totalItems = Item::count();

        // 2. Statistiques par Mois (en utilisant selectRaw et groupBy)
        // Compatible SQLite / MySQL (extraction du mois de la colonne found_on)
        $itemsByMonth = Item::selectRaw("strftime('%Y-%m', found_on) as month, count(*) as total")
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6) // Les 6 derniers mois par exemple
            ->get();

        return view('stats.index', compact('itemsByPlace', 'itemsByMonth', 'totalItems'));
    }
}
