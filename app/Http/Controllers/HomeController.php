<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Manga;
use App\Services\AniListService;
use App\Services\TmdbService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $aniListService = new AniListService();
        

        // HERO: Peschiamo 5 anime casuali per il carosello hero
        $heroAnimes = Anime::whereNotNull('synopsis')->inRandomOrder()->take(5)->get();

        // Assicuriamo che abbiano banner_url e logo_url da AniList/TMDB
        $heroAnimes = $heroAnimes->map(function($anime) use ($aniListService) {
            if (!$anime->banner_url) {
                $aniListData = $aniListService->getAnimeByMalId($anime->mal_id);
                if ($aniListData && isset($aniListData['bannerImage'])) {
                    $anime->banner_url = $aniListData['bannerImage'];
                }
            }

            if ($anime->isDirty()) {
                $anime->save();
            }

            return $anime;
        });

        $heroAnime = $heroAnimes->first(); // Fallback per il primo

        // CAROSELLO 1: 15 Anime casuali (I nostri consigli per te)
        $recommendedAnime = Anime::inRandomOrder()->take(15)->get();

        // CAROSELLO 2: Continua a guardare - Anime che l'utente sta guardando
        $continueWatching = $user->watchHistory()
            ->with('anime')
            ->orderByDesc('watch_date')
            ->take(15)
            ->get()
            ->map(fn($h) => $h->anime)
            ->filter();  // Remove null entries

        // CAROSELLO 3: I 15 Anime più votati (TOP 10)
        $top15Anime = Anime::orderByDesc('score')->take(15)->get();

        // Elenco espandibile
        $expandableList = Anime::inRandomOrder()->take(20)->get();

        // Sezione promozionale (banner orizzontale) - anime casuale
        $promotionalAnime = Anime::whereNotNull('synopsis')->inRandomOrder()->first();

        // Popola banner_url dal promotional anime se mancante
        if ($promotionalAnime && !$promotionalAnime->banner_url) {
            $aniListData = $aniListService->getAnimeByMalId($promotionalAnime->mal_id);
            if ($aniListData && isset($aniListData['bannerImage'])) {
                $promotionalAnime->banner_url = $aniListData['bannerImage'];
                $promotionalAnime->save();
            }
        }

        $spotlightAnime = Anime::whereNotNull('synopsis')->inRandomOrder()->take(10)->get();

        // Favoriti dell'utente (per mostrare lo stato del bookmark)
        $favoriteAnimeIds = $user->favorites()
            ->where('favoritable_type', \App\Models\Anime::class)
            ->pluck('favoritable_id')
            ->toArray();

        return view('dashboard', compact(
            'heroAnime',
            'heroAnimes',
            'recommendedAnime',
            'continueWatching',
            'top15Anime',
            'expandableList',
            'promotionalAnime',
            'favoriteAnimeIds',
            'spotlightAnime'
        ));
    }
}
