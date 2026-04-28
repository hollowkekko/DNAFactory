{{-- Promotional Banner (Manga) --}}
@if($promotionalManga)
<div class="w-full px-4 sm:px-6 lg:px-12 py-12 flex justify-center">
    <div class="relative rounded-lg overflow-hidden h-96 md:h-[28rem] lg:h-[32rem] max-w-[90rem] w-full group/promo"
         x-data="{ isFavorite: {{ in_array($promotionalManga->mal_id, $favoriteMangaIds) ? 'true' : 'false' }} }"
         @toggle-favorite-manga.window="if ($event.detail === {{ $promotionalManga->mal_id }}) isFavorite = !isFavorite">

        {{-- Background Image --}}
        <img src="{{ $promotionalManga->banner_url ?? $promotionalManga->image_url }}" class="absolute inset-0 w-full h-full object-cover object-center">

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent"></div>

        {{-- Content --}}
        <div class="absolute inset-0 flex items-center">
            <div class="ml-0 md:ml-8 max-w-md">
                <h2 class="text-3xl md:text-4xl font-black text-white mb-3 drop-shadow-lg">
                    {{ $promotionalManga->title }}
                </h2>
                <p class="text-gray-300 text-sm md:text-base mb-6 line-clamp-2">
                    {{ $promotionalManga->synopsis }}
                </p>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('manga.show', $promotionalManga->mal_id) }}?action=read"
                       class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-3 px-8 rounded flex items-center transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Leggi ora
                    </a>
                    <button @click="toggleFavoriteManga({{ $promotionalManga->mal_id }})"
                            class="p-3 rounded transition"
                            :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:text-white border border-gray-600'">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
