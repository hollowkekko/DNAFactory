<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\WatchHistory;
use App\Services\JikanCacheService;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Anime::query();

        // Filtra per genere se specificato
        if ($request->has('genre')) {
            $genre = $request->input('genre');
            $query->whereJsonContains('genres', $genre);
        }

        $sort = $request->input('sort', 'popular');

        if ($sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('score', 'desc');
        }

        $animes = $query->paginate(12);
        return view('anime.index', compact('animes'));
    }

    public function show($mal_id, Request $request)
    {
        $anime = Anime::findOrFail($mal_id);

        // Traccia la visualizzazione solo se viene cliccato "Riproduci"
        if (auth()->check() && $request->query('action') === 'play') {
            WatchHistory::updateOrCreate(
                ['user_id' => auth()->id(), 'anime_id' => $anime->mal_id],
                ['watch_date' => now()]
            );
        }

        // Prendi le reviews cacheate (opzionale, le view può comunque farle con AlpineJS)
        // Se vuoi usarle nel backend: $reviews = JikanCacheService::getAnimeReviews($mal_id);

        return view('anime.show', compact('anime'));
    }
}