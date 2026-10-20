<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'traveler_name',
        'traveler_email',
        'traveler_phone',
        'lost_on',
        'item_name',
        'description',
        'item_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
