<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Services\JikanCacheService;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index()
    {
        $mangas = Manga::paginate(12);
        return view('manga.index', compact('mangas'));
    }

    public function show($mal_id)
    {
        $manga = Manga::findOrFail($mal_id);

        // Prendi le reviews cacheate (opzionale, le view può comunque farle con AlpineJS)
        // Se vuoi usarle nel backend: $reviews = JikanCacheService::getMangaReviews($mal_id);

        return view('manga.show', compact('manga'));
    }
}