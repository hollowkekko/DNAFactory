{{-- Promotional Side Banners --}}
<div class="w-full px-4 sm:px-6 lg:px-12 py-8 flex gap-4">

    {{-- Banner Sinistro --}}
    @if($promotionalAnime2)
    <div class="w-1/2 relative rounded-lg overflow-hidden h-48 md:h-64 lg:h-80 group/promo2"
         x-data="{ isFavorite: {{ in_array($promotionalAnime2->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
         @toggle-favorite.window="if ($event.detail === {{ $promotionalAnime2->mal_id }}) isFavorite = !isFavorite">

        {{-- Background Image --}}
        <img src="{{ $promotionalAnime2->banner_url ?? $promotionalAnime2->image_url }}" class="absolute inset-0 w-full h-full object-cover object-center">

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent"></div>

        {{-- Content --}}
        <div class="absolute inset-0 flex flex-col justify-between p-4 md:p-6">
            <h3 class="text-lg md:text-xl font-black text-white drop-shadow-lg line-clamp-2">
                {{ $promotionalAnime2->title }}
            </h3>

            <div>
                <p class="text-gray-300 text-xs md:text-sm mb-4 line-clamp-2">
                    {{ $promotionalAnime2->synopsis }}
                </p>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('anime.show', $promotionalAnime2->mal_id) }}?action=play"
                       class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-2 px-4 rounded text-sm transition shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Guarda
                    </a>
                    <button @click="toggleFavorite({{ $promotionalAnime2->mal_id }})"
                            class="p-2 rounded transition"
                            :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:text-white border border-gray-600'">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Banner Destro --}}
    @if($promotionalAnime3)
    <div class="w-1/2 relative rounded-lg overflow-hidden h-48 md:h-64 lg:h-80 group/promo3"
         x-data="{ isFavorite: {{ in_array($promotionalAnime3->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
         @toggle-favorite.window="if ($event.detail === {{ $promotionalAnime3->mal_id }}) isFavorite = !isFavorite">

        {{-- Background Image --}}
        <img src="{{ $promotionalAnime3->banner_url ?? $promotionalAnime3->image_url }}" class="absolute inset-0 w-full h-full object-cover object-center">

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent"></div>

        {{-- Content --}}
        <div class="absolute inset-0 flex flex-col justify-between p-4 md:p-6">
            <h3 class="text-lg md:text-xl font-black text-white drop-shadow-lg line-clamp-2">
                {{ $promotionalAnime3->title }}
            </h3>

            <div>
                <p class="text-gray-300 text-xs md:text-sm mb-4 line-clamp-2">
                    {{ $promotionalAnime3->synopsis }}
                </p>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('anime.show', $promotionalAnime3->mal_id) }}?action=play"
                       class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-2 px-4 rounded text-sm transition shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Guarda
                    </a>
                    <button @click="toggleFavorite({{ $promotionalAnime3->mal_id }})"
                            class="p-2 rounded transition"
                            :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:text-white border border-gray-600'">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
