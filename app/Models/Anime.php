<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anime extends Model
{
    use HasFactory;

    // 1. Diciamo a Laravel che la chiave primaria si chiama 'mal_id'
    protected $primaryKey = 'mal_id';
    
    // 2. Gli diciamo che non è un numero che si autoincrementa da solo
    public $incrementing = false;

    // 3. Autorizziamo lo script a riempire questi campi
    protected $fillable = ['mal_id', 'title', 'image_url', 'banner_url', 'logo_url', 'synopsis', 'score', 'episodes', 'genres'];

    // 4. Cast per convertire genres da JSON a array
    protected $casts = [
        'genres' => 'array',
    ];

    public function viewers(): HasMany
    {
        return $this->hasMany(WatchHistory::class, 'anime_id', 'mal_id');
    }
}