{{-- Top 10 Manga Carousel --}}
<div class="w-full px-4 sm:px-6 lg:px-12 py-8">
    <h2 class="text-xl font-bold mb-4 text-white uppercase">TOP MANGA</h2>

    <div x-data="{ scrollNext() { $refs.slider4manga.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider4manga.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group -mx-4 sm:-mx-6 lg:-mx-12">

        {{-- Freccia Sinistra --}}
        <button @click="scrollPrev" class="absolute left-4 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block shadow-xl border border-gray-700" style="top: 211px;"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

        <div x-ref="slider4manga" class="flex overflow-x-auto overflow-y-visible space-x-20 pb-16 pt-4 hide-scrollbar snap-x snap-mandatory px-4 sm:px-6 lg:px-12">
            @foreach($top10Manga as $index => $manga)
                <div class="flex-none snap-start group/card relative {{ $index === 0 ? 'ml-16' : '' }}" style="width: auto;"
                     x-data="{ isFavorite: {{ in_array($manga->mal_id, $favoriteMangaIds) ? 'true' : 'false' }} }"
                     @toggle-favorite-manga.window="if ($event.detail === {{ $manga->mal_id }}) isFavorite = !isFavorite">

                    {{-- Contenitore flex per numero e copertina --}}
                    <div class="flex items-stretch gap-1" style="height: 390px;">
                        {{-- Numero posizione --}}
                        <div class="flex items-center justify-center flex-shrink-0 {{ $index === 0 ? 'ml-16' : '' }}" style="width: 120px;">
                            <div class="font-black text-white/20 group-hover/card:text-white/30 select-none transition-colors duration-500" style="font-family: 'Arial Black', sans-serif; font-size: 400px; line-height: 1;">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        {{-- Card della copertina --}}
                        <a href="{{ route('manga.show', $manga->mal_id) }}?action=read" class="relative flex-shrink-0 w-[260px] rounded-lg overflow-hidden border-2 border-transparent hover:border-[#FF6600] hover:scale-105 transition cursor-pointer shadow-2xl hover:shadow-orange-500/50 duration-300 aspect-[2/3]" style="z-index: 10;">
                            <img src="{{ $manga->image_url }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-end justify-center pb-8">
                                <div class="bg-[#FF6600] hover:bg-[#FF8533] rounded px-6 py-3 flex items-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                    <span class="text-white font-bold text-sm">Inizia lettura</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Titolo sotto il riquadro --}}
                    <div class="w-[260px]" style="margin-left: {{ $index === 0 ? '188px' : '124px' }};">
                        <div class="flex items-center justify-between mt-3 mb-1 px-1">
                            <div class="flex items-center space-x-2 text-[10px] text-gray-400 font-medium">
                                <span>Cap. 1</span>
                            </div>
                            <div class="flex items-center text-[11px] font-bold text-gray-300">
                                <svg class="w-3 h-3 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ $manga->score ?? 'N/A' }}
                            </div>
                        </div>

                        {{-- Titolo --}}
                        <h3 class="text-sm font-bold text-white line-clamp-1 drop-shadow group-hover/card:text-[#FF6600] transition px-1" title="{{ $manga->title }}">{{ $manga->title }}</h3>
                    </div>

                    {{-- Bottone Preferiti --}}
                    <button @click="toggleFavoriteManga({{ $manga->mal_id }})"
                            class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition group-hover/card:opacity-100 group-hover/card:scale-105 origin-top-right"
                            :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:bg-black/80 hover:text-white group-hover/card:bg-black/80 group-hover/card:text-white'">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Freccia Destra --}}
        <button @click="scrollNext" class="absolute right-4 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block shadow-xl border border-gray-700" style="top: 211px;"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>

        {{-- Overlay fade --}}
        <div class="absolute left-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, transparent 100%);"></div>
        <div class="absolute right-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 100%);"></div>
    </div>
</div>
