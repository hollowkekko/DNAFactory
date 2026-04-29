<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anime extends Model
{
    use HasFactory;

    protected $primaryKey = 'mal_id';
    
    // non è un numero che si autoincrementa da solo
    public $incrementing = false;

    protected $fillable = ['mal_id', 'title', 'image_url', 'banner_url', 'logo_url', 'synopsis', 'score', 'episodes', 'genres'];

    // cast per convertire genres da JSON a array
    protected $casts = [
        'genres' => 'array',
    ];

    public function viewers(): HasMany
    {
        return $this->hasMany(WatchHistory::class, 'anime_id', 'mal_id');
    }
}