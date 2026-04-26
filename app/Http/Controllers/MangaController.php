<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\ReadHistory;
use App\Services\JikanCacheService;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index(Request $request)
    {
        $query = Manga::query();

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

        $mangas = $query->paginate(12);
        return view('manga.index', compact('mangas'));
    }

    public function show($mal_id, Request $request)
    {
        $manga = Manga::findOrFail($mal_id);

        // Traccia la visualizzazione solo se viene cliccato "Inizia lettura"
        if (auth()->check() && $request->query('action') === 'read') {
            ReadHistory::updateOrCreate(
                ['user_id' => auth()->id(), 'manga_id' => $manga->mal_id],
                ['read_date' => now()]
            );
        }

        // Prendi le reviews cacheate (opzionale, le view può comunque farle con AlpineJS)
        // Se vuoi usarle nel backend: $reviews = JikanCacheService::getMangaReviews($mal_id);

        return view('manga.show', compact('manga'));
    }
}