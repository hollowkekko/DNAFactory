<x-app-layout>
    <div class="w-full px-4 sm:px-6 lg:px-12 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-white mb-2">Cronologia di Visione</h1>
            <p class="text-gray-400">Tutti gli anime che hai iniziato a guardare</p>
        </div>

        @if($watchHistory->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-400 text-lg">Nessun anime nella cronologia</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($watchHistory as $history)
                    @if($history->anime)
                        <div class="group/card relative cursor-pointer"
                             x-data="{ isFavorite: {{ in_array($history->anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                             @toggle-favorite.window="if ($event.detail === {{ $history->anime->mal_id }}) isFavorite = !isFavorite">

                            <a href="{{ route('anime.show', $history->anime->mal_id) }}?action=play" class="block relative rounded-lg overflow-hidden aspect-[2/3] border-2 border-transparent hover:border-[#FF6600] hover:scale-105 transition cursor-pointer duration-300 shadow-2xl hover:shadow-orange-500/50">
                                <img src="{{ $history->anime->image_url }}" class="w-full h-full object-cover">

                                {{-- Overlay Sfumato inferiore --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                                {{-- Hover Overlay --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-end justify-center pb-8">
                                    <div class="bg-[#FF6600] hover:bg-[#FF8533] rounded px-6 py-3 flex items-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                        <span class="text-white font-bold text-sm">Continua</span>
                                    </div>
                                </div>

                                {{-- Badge Data --}}
                                <div class="absolute top-2 left-2 bg-black/80 text-white text-[10px] font-bold px-2 py-1 rounded">
                                    {{ $history->watch_date->format('d M') }}
                                </div>
                            </a>

                            {{-- Titolo --}}
                            <h3 class="text-sm font-bold text-white line-clamp-2 mt-3 group-hover/card:text-[#FF6600] transition px-1" title="{{ $history->anime->title }}">
                                {{ $history->anime->title }}
                            </h3>

                            {{-- Bottone Preferiti --}}
                            <button @click="toggleFavorite({{ $history->anime->mal_id }})"
                                    class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition group-hover/card:opacity-100 group-hover/card:scale-105 origin-top-right"
                                    :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:bg-black/80 hover:text-white group-hover/card:bg-black/80 group-hover/card:text-white'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Paginazione --}}
            <div class="mt-12">
                {{ $watchHistory->links() }}
            </div>
        @endif
    </div>

    <script>
    function toggleFavorite(animeId) {
        fetch(`/favorites/anime/${animeId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .finally(() => {
            window.dispatchEvent(new CustomEvent('toggle-favorite', { detail: animeId }));
        });
    }
    </script>
</x-app-layout>
