<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class JikanCacheService
{
    
    // Durata del cache in minuti (24 ore = 1440 minuti)
    
    private const CACHE_DURATION = 1440;

    
    // Fetcha anime reviews con cache di 24 ore
    
    public static function getAnimeReviews($mal_id)
    {
        $cacheKey = "anime_reviews_{$mal_id}";

        return Cache::remember($cacheKey, self::CACHE_DURATION * 60, function () use ($mal_id) {
            $response = Http::get("https://api.jikan.moe/v4/anime/{$mal_id}/reviews");

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        });
    }

    
    // Fetcha manga reviews con cache di 24 ore
    
    public static function getMangaReviews($mal_id)
    {
        $cacheKey = "manga_reviews_{$mal_id}";

        return Cache::remember($cacheKey, self::CACHE_DURATION * 60, function () use ($mal_id) {
            $response = Http::get("https://api.jikan.moe/v4/manga/{$mal_id}/reviews");

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        });
    }

    
    // Pulisce il cache per un anime specifico
    
    public static function clearAnimeCache($mal_id)
    {
        Cache::forget("anime_reviews_{$mal_id}");
    }

    
    // Pulisce il cache per un manga specifico
    public static function clearMangaCache($mal_id)
    {
        Cache::forget("manga_reviews_{$mal_id}");
    }
}
