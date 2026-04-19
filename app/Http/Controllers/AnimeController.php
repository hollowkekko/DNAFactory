<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Services\JikanCacheService;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::paginate(12);
        return view('anime.index', compact('animes'));
    }

    public function show($mal_id)
    {
        $anime = Anime::findOrFail($mal_id);

        // Prendi le reviews cacheate (opzionale, le view può comunque farle con AlpineJS)
        // Se vuoi usarle nel backend: $reviews = JikanCacheService::getAnimeReviews($mal_id);

        return view('anime.show', compact('anime'));
    }
}