<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Manga;

class HomeController extends Controller
{
    public function index()
    {
        // HERO: Peschiamo un anime spettacolare
        $heroAnime = Anime::whereNotNull('synopsis')->orderByDesc('score')->first();

        // CAROSELLO 1: 15 Anime casuali
        $recommendedAnime = Anime::inRandomOrder()->take(15)->get();

        // CAROSELLO 2: 15 Manga casuali
        $recommendedManga = Manga::inRandomOrder()->take(15)->get();

        // CAROSELLO 3: I 15 Anime più votati
        $top10Anime = Anime::orderByDesc('score')->take(15)->get();

        // CAROSELLO 4: I 15 Manga più votati
        $top10Manga = Manga::orderByDesc('score')->take(15)->get();

        return view('dashboard', compact('heroAnime', 'recommendedAnime', 'recommendedManga', 'top10Anime', 'top10Manga'));
    }
}