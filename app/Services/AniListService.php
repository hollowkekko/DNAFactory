<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AniListService
{
    private $endpoint = 'https://graphql.anilist.co';

    public function getAnimeByMalId($malId)
    {
        $query = <<<'GRAPHQL'
        query ($malId: Int) {
            Media(idMal: $malId, type: ANIME) {
                id
                title {
                    romaji
                }
                coverImage {
                    large
                }
                bannerImage
            }
        }
        GRAPHQL;

        $response = Http::post($this->endpoint, [
            'query' => $query,
            'variables' => ['malId' => $malId]
        ]);

        if ($response->successful()) {
            return $response->json()['data']['Media'] ?? null;
        }

        return null;
    }
}
