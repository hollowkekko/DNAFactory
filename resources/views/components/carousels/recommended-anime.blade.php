{{-- Recommended Anime Carousel --}}
<div class="w-full py-8 mt-8 relative z-20 overflow-hidden">
    <h2 class="text-xl font-bold mb-4 text-white px-4 sm:px-6 lg:px-12">I nostri consigli per te</h2>

    <div x-data="{ scrollNext() { $refs.slider1.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider1.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group">

        {{-- Sfumatura Sinistra --}}
        <div class="absolute left-0 top-0 bottom-0 w-4 sm:w-6 lg:w-12 bg-gradient-to-r from-black to-transparent z-30 pointer-events-none"></div>

        {{-- Freccia Sinistra --}}
        <button @click="scrollPrev" class="absolute left-4 -translate-y-1/2 z-40 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl" style="top: 211px;">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        {{-- Contenitore Slider --}}
        <div x-ref="slider1" class="flex overflow-x-auto space-x-3 hide-scrollbar snap-x snap-mandatory overflow-y-visible pt-4 pb-4 relative pl-4 sm:pl-6 lg:pl-12 pr-4 sm:pr-6 lg:pr-12">

            @foreach($recommendedAnime as $index => $anime)
                <div class="flex-none w-[260px] snap-start group/card relative z-20 scroll-ml-4 sm:scroll-ml-6 lg:scroll-ml-12"
                     x-data="{ isFavorite: {{ in_array($anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                     @toggle-favorite.window="if ($event.detail === {{ $anime->mal_id }}) isFavorite = !isFavorite">

                    <a href="{{ route('anime.show', $anime->mal_id) }}?action=play" class="block relative rounded-lg overflow-hidden aspect-[2/3] border-2 border-transparent hover:border-[#FF6600] hover:scale-105 transition-all cursor-pointer duration-300 shadow-2xl hover:shadow-orange-500/50">
                        <img src="{{ $anime->image_url }}" class="w-full h-full object-cover">

                        {{-- Overlay Sfumato inferiore --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                        {{-- Hover Overlay --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-end justify-center pb-8">
                            <div class="bg-[#FF6600] hover:bg-[#FF8533] rounded px-6 py-3 flex items-center gap-2 cursor-pointer shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                <span class="text-white font-bold text-sm">Riproduci S1 E1</span>
                            </div>
                        </div>

                        {{-- Badge --}}
                        @if($index % 3 == 0)
                            <div class="absolute top-0 left-0 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-br shadow">Nuova stagione</div>
                        @elseif($index % 4 == 0)
                            <div class="absolute top-0 left-0 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-br shadow">Stagione finale</div>
                        @endif
                    </a>

                    {{-- Dettagli --}}
                    <div class="flex items-center justify-between mt-3 mb-1 px-1">
                        <div class="flex items-center space-x-2 text-[10px] text-gray-400 font-medium">
                            <div class="flex items-center space-x-1">
                                <span class="bg-gray-800 text-gray-300 px-1 py-0.5 rounded text-[9px] font-bold uppercase border border-gray-700">Sub</span>
                                <span class="bg-gray-800 text-gray-300 px-1 py-0.5 rounded text-[9px] font-bold uppercase border border-gray-700">Dub</span>
                            </div>
                            <span>S1 E1</span>
                        </div>
                        <div class="flex items-center text-[11px] font-bold text-gray-300">
                            <svg class="w-3 h-3 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ $anime->score ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- Titolo --}}
                    <h3 class="text-sm font-bold text-white line-clamp-1 drop-shadow group-hover/card:text-[#FF6600] transition px-1" title="{{ $anime->title }}">{{ $anime->title }}</h3>

                    {{-- Bottone Preferiti --}}
                    <button @click="toggleFavorite({{ $anime->mal_id }})"
                            class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition group-hover/card:opacity-100 group-hover/card:scale-105 origin-top-right"
                            :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:bg-black/80 hover:text-white group-hover/card:bg-black/80 group-hover/card:text-white'">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Sfumatura Destra --}}
        <div class="absolute right-0 top-0 bottom-0 w-4 sm:w-6 lg:w-12 bg-gradient-to-l from-black to-transparent z-30 pointer-events-none"></div>

        {{-- Freccia Destra --}}
        <button @click="scrollNext" class="absolute right-4 -translate-y-1/2 z-40 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl" style="top: 211px;">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>
