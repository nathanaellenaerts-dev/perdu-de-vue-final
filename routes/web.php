<?php
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\StatController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. ROUTES SPÉCIFIQUES & PUBLIQUES (En premier)
// ==========================================
Route::redirect('/', '/objets');
Route::get('/objets', [ItemController::class, 'index'])->name('items.index');
Route::get('/objets/nouveau', [ItemController::class, 'create'])->name('items.create');
Route::post('/objets', [ItemController::class, 'store'])->name('items.store');

// Formulaire public pour les voyageurs
Route::get('/perdu', [ClaimController::class, 'createPublic'])->name('claims.public.create');
Route::post('/perdu', [ClaimController::class, 'storePublic'])->name('claims.public.store');

// Espace Claims / Rapprochement (Placé avant {item} pour éviter les conflits 404)
Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
Route::get('/claims/{claim}', [ClaimController::class, 'show'])->name('claims.show');
Route::patch('/claims/{claim}/link', [ClaimController::class, 'linkItem'])->name('claims.link');
Route::patch('/claims/{claim}/unlink', [ClaimController::class, 'unlinkItem'])->name('claims.unlink');

Route::get('/statistiques', [StatController::class, 'index'])->name('stats.index');
Route::view('/composants', 'styleguide')->name('styleguide');
Route::delete('/photos/{photo}', [ItemController::class, 'destroyPhoto'])->name('photos.destroy');


// ==========================================
// 2. ROUTES AVEC PARAMÈTRES DYNAMIQUES (Ensuite)
// ==========================================
Route::get('/objets/{item}', [ItemController::class, 'show'])->name('items.show');
Route::get('/objets/{item}/modifier', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/objets/{item}', [ItemController::class, 'update'])->name('items.update');
Route::patch('/items/{item}/return', [ItemController::class, 'returnItem'])->name('items.return');
Route::delete('/objets/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

// Routes pour les lieux
Route::get('/lieux/{place}', [PlaceController::class, 'show'])->name('places.show');
//route pour les langues
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
