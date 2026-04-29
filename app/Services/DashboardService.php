<?php

namespace App\Services;

use App\Models\Anime;
use App\Models\Manga;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardService
{
    private AniListService $aniListService;

    public function __construct()
    {
        $this->aniListService = new AniListService();
    }

    
    // carica tutti i dati per il carosello anime del dashboard
     
    public function getAnimeData(Authenticatable $user): array
    {
        // HERO: 5 anime casuali
        $heroAnimes = Anime::whereNotNull('synopsis')
            ->inRandomOrder()
            ->take(5)
            ->get();

        $heroAnimes = $this->populateBannerUrls($heroAnimes);

        return [
            'heroAnime' => $heroAnimes->first(),
            'heroAnimes' => $heroAnimes,
            'recommendedAnime' => Anime::inRandomOrder()->take(15)->get(),
            'continueWatching' => $user->watchHistory()
                ->with('anime')
                ->orderByDesc('watch_date')
                ->take(15)
                ->get()
                ->map(fn($h) => $h->anime)
                ->filter(),
            'top10Anime' => Anime::orderByDesc('score')->take(10)->get(),
            'spotlightAnime' => Anime::whereNotNull('synopsis')
                ->inRandomOrder()
                ->take(10)
                ->get(),
            'promotionalAnime' => $this->getPromotionalAnime(0),
            'promotionalAnime2' => $this->getPromotionalAnime(1),
            'promotionalAnime3' => $this->getPromotionalAnime(2),
            'favoriteAnimeIds' => $user->favorites()
                ->where('favoritable_type', \App\Models\Anime::class)
                ->pluck('favoritable_id')
                ->toArray(),
        ];
    }

    
    // carica tutti i dati per il carosello manga del dashboard
    
    public function getMangaData(Authenticatable $user): array
    {
        // HERO: 5 manga casuali (se lo uso)
        $heroMangas = Manga::whereNotNull('synopsis')
            ->inRandomOrder()
            ->take(5)
            ->get();

        $heroMangas = $this->populateBannerUrls($heroMangas, isManga: true);

        return [
            'heroManga' => $heroMangas->first(),
            'heroMangas' => $heroMangas,
            'recommendedManga' => Manga::inRandomOrder()->take(15)->get(),
            'continueReading' => $user->readHistory()
                ->with('manga')
                ->orderByDesc('read_date')
                ->take(15)
                ->get()
                ->map(fn($h) => $h->manga)
                ->filter(),
            'top10Manga' => Manga::orderByDesc('score')->take(10)->get(),
            'spotlightManga' => Manga::whereNotNull('synopsis')
                ->inRandomOrder()
                ->take(10)
                ->get(),
            'promotionalManga' => $this->getPromotionalManga(0),
            'promotionalManga2' => $this->getPromotionalManga(1),
            'promotionalManga3' => $this->getPromotionalManga(2),
            'favoriteMangaIds' => $user->favorites()
                ->where('favoritable_type', \App\Models\Manga::class)
                ->pluck('favoritable_id')
                ->toArray(),
        ];
    }

    
    // Popola banner_url per una collezione di anime/manga
    
    private function populateBannerUrls($items, bool $isManga = false)
    {
        return $items->map(function($item) use ($isManga) {
            if (!$item->banner_url) {
                $aniListData = $isManga
                    ? $this->aniListService->getMangaByMalId($item->mal_id)
                    : $this->aniListService->getAnimeByMalId($item->mal_id);

                if ($aniListData && isset($aniListData['bannerImage'])) {
                    $item->banner_url = $aniListData['bannerImage'];
                }
            }

            if ($item->isDirty()) {
                $item->save();
            }

            return $item;
        });
    }

    
    // Ottiene un anime promozionale specifico (per indice)
    
    private function getPromotionalAnime(int $index)
    {
        $promotional = Anime::whereNotNull('synopsis')
            ->inRandomOrder()
            ->take($index + 1)
            ->get()
            ->get($index);

        if ($promotional && !$promotional->banner_url) {
            $aniListData = $this->aniListService->getAnimeByMalId($promotional->mal_id);
            if ($aniListData && isset($aniListData['bannerImage'])) {
                $promotional->banner_url = $aniListData['bannerImage'];
                $promotional->save();
            }
        }

        return $promotional;
    }

    
    // Ottiene un manga promozionale specifico (per indice)
    private function getPromotionalManga(int $index)
    {
        $promotional = Manga::whereNotNull('synopsis')
            ->inRandomOrder()
            ->take($index + 1)
            ->get()
            ->get($index);

        if ($promotional && !$promotional->banner_url) {
            $aniListData = $this->aniListService->getMangaByMalId($promotional->mal_id);
            if ($aniListData && isset($aniListData['bannerImage'])) {
                $promotional->banner_url = $aniListData['bannerImage'];
                $promotional->save();
            }
        }

        return $promotional;
    }
}
