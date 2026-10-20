<?php

namespace App\Models;

use App\Enums\Color;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['place_id', 'name', 'description', 'color', 'found_on', 'returned_at',])]
class Item extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'color' => Color::class,
            'found_on' => 'date',
            'returned_at' => 'date',
        ];
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    public function claims()
{
    return $this->hasMany(Claim::class);
}
// Relation vers toutes les photos de l'objet
public function photos(): HasMany
{
    return $this->hasMany(Photo::class);
}

// Raccourci pour récupérer la photo de couverture
public function coverPhoto()
{
    return $this->photos()->where('is_cover', true)->first() ?? $this->photos()->first();
}
}
