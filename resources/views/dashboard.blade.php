<x-app-layout>

    <x-carousels.hero-carousel :heroAnimes="$heroAnimes" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-carousels.recommended-anime :recommendedAnime="$recommendedAnime" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-carousels.recommended-manga :recommendedManga="$recommendedManga" :favoriteMangaIds="$favoriteMangaIds" />

    <x-carousels.continue-watching :continueWatching="$continueWatching" />

    <x-carousels.continue-reading :continueReading="$continueReading" />

    <x-banners.promotional-side :promotionalAnime2="$promotionalAnime2" :promotionalAnime3="$promotionalAnime3" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-carousels.top-anime :top10Anime="$top10Anime" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-carousels.top-manga :top10Manga="$top10Manga" :favoriteMangaIds="$favoriteMangaIds" />

    <x-banners.promotional-anime :promotionalAnime="$promotionalAnime" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-banners.promotional-manga :promotionalManga="$promotionalManga" :favoriteMangaIds="$favoriteMangaIds" />

    <x-carousels.spotlight-anime :spotlightAnime="$spotlightAnime" :favoriteAnimeIds="$favoriteAnimeIds" />

    <x-carousels.spotlight-manga :spotlightManga="$spotlightManga" :favoriteMangaIds="$favoriteMangaIds" />

</x-app-layout>
