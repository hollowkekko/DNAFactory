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


        // ========== ANIME ==========
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
        $top15Anime = Anime::orderByDesc('score')->take(10)->get();

        // Elenco espandibile
        $expandableList = Anime::inRandomOrder()->take(20)->get();

        // Sezione promozionale (banner orizzontale) - 3 anime casuali (1 grande + 2 laterali)
        $promotionalAnimes = Anime::whereNotNull('synopsis')->inRandomOrder()->take(3)->get();
        $promotionalAnime = $promotionalAnimes->get(0);
        $promotionalAnime2 = $promotionalAnimes->get(1);
        $promotionalAnime3 = $promotionalAnimes->get(2);

        // Popola banner_url dai promotional anime se mancanti
        foreach ([$promotionalAnime, $promotionalAnime2, $promotionalAnime3] as $anime) {
            if ($anime && !$anime->banner_url) {
                $aniListData = $aniListService->getAnimeByMalId($anime->mal_id);
                if ($aniListData && isset($aniListData['bannerImage'])) {
                    $anime->banner_url = $aniListData['bannerImage'];
                    $anime->save();
                }
            }
        }

        $spotlightAnime = Anime::whereNotNull('synopsis')->inRandomOrder()->take(10)->get();

        // Favoriti dell'utente (per mostrare lo stato del bookmark)
        $favoriteAnimeIds = $user->favorites()
            ->where('favoritable_type', \App\Models\Anime::class)
            ->pluck('favoritable_id')
            ->toArray();

        // ========== MANGA ==========
        // HERO: Peschiamo 5 manga casuali per il carosello hero
        $heroMangas = Manga::whereNotNull('synopsis')->inRandomOrder()->take(5)->get();

        // Assicuriamo che abbiano banner_url e logo_url
        $heroMangas = $heroMangas->map(function($manga) use ($aniListService) {
            if (!$manga->banner_url) {
                $aniListData = $aniListService->getMangaByMalId($manga->mal_id);
                if ($aniListData && isset($aniListData['bannerImage'])) {
                    $manga->banner_url = $aniListData['bannerImage'];
                }
            }

            if ($manga->isDirty()) {
                $manga->save();
            }

            return $manga;
        });

        $heroManga = $heroMangas->first(); // Fallback per il primo

        // CAROSELLO 1: 15 Manga casuali (I nostri consigli per te)
        $recommendedManga = Manga::inRandomOrder()->take(15)->get();

        // CAROSELLO 2: Continua a leggere - Manga che l'utente sta leggendo
        $continueReading = $user->readHistory()
            ->with('manga')
            ->orderByDesc('read_date')
            ->take(15)
            ->get()
            ->map(fn($h) => $h->manga)
            ->filter();  // Remove null entries

        // CAROSELLO 3: I 15 Manga più votati
        $top15Manga = Manga::orderByDesc('score')->take(10)->get();

        // Sezione promozionale - 3 manga casuali
        $promotionalMangas = Manga::whereNotNull('synopsis')->inRandomOrder()->take(3)->get();
        $promotionalManga = $promotionalMangas->get(0);
        $promotionalManga2 = $promotionalMangas->get(1);
        $promotionalManga3 = $promotionalMangas->get(2);

        // Popola banner_url dai promotional manga se mancanti
        foreach ([$promotionalManga, $promotionalManga2, $promotionalManga3] as $manga) {
            if ($manga && !$manga->banner_url) {
                $aniListData = $aniListService->getMangaByMalId($manga->mal_id);
                if ($aniListData && isset($aniListData['bannerImage'])) {
                    $manga->banner_url = $aniListData['bannerImage'];
                    $manga->save();
                }
            }
        }

        $spotlightManga = Manga::whereNotNull('synopsis')->inRandomOrder()->take(10)->get();

        // Favoriti manga dell'utente
        $favoriteMangaIds = $user->favorites()
            ->where('favoritable_type', \App\Models\Manga::class)
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
            'promotionalAnime2',
            'promotionalAnime3',
            'favoriteAnimeIds',
            'spotlightAnime',
            'heroManga',
            'heroMangas',
            'recommendedManga',
            'continueReading',
            'top15Manga',
            'promotionalManga',
            'promotionalManga2',
            'promotionalManga3',
            'favoriteMangaIds',
            'spotlightManga'
        ));
    }
}
