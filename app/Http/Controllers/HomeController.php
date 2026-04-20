<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Manga;

class HomeController extends Controller
{
    public function index()
    {
        // HERO: Peschiamo un anime casuale
        $heroAnime = Anime::whereNotNull('synopsis')->inRandomOrder()->first();

        // CAROSELLO 1: 15 Anime casuali
        $recommendedAnime = Anime::inRandomOrder()->take(15)->get();

        // CAROSELLO 2: 15 Manga casuali
        $recommendedManga = Manga::inRandomOrder()->take(15)->get();

        // CAROSELLO 3: I 15 Anime più votati
        $top15Anime = Anime::orderByDesc('score')->take(15)->get();

        // CAROSELLO 4: I 15 Manga più votati
        $top15Manga = Manga::orderByDesc('score')->take(15)->get();

        return view('dashboard', compact('heroAnime', 'recommendedAnime', 'recommendedManga', 'top15Anime', 'top15Manga'));
    }
}