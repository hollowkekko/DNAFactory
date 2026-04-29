<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manga extends Model
{
    use HasFactory;

    protected $primaryKey = 'mal_id';
    public $incrementing = false;
    protected $fillable = ['mal_id', 'title', 'image_url', 'banner_url', 'logo_url', 'synopsis', 'score', 'genres'];

    // cast per convertire genres da JSON a array
    protected $casts = [
        'genres' => 'array',
    ];

    public function readers(): HasMany
    {
        return $this->hasMany(ReadHistory::class, 'manga_id', 'mal_id');
    }
}