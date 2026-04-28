{{-- Continue Watching Carousel --}}
@if($continueWatching->isNotEmpty())
<div class="w-full py-8 relative z-20 overflow-hidden group">

    {{-- Intestazione con Titolo e Link Cronologia --}}
    <div class="flex justify-between items-end mb-4 px-4 sm:px-6 lg:px-12">
        <h2 class="text-xl font-bold text-white">Continua a guardare</h2>
        <a href="{{ route('watch-history.index') }}" class="text-sm font-medium text-gray-400 hover:text-white transition flex items-center group">
            Visualizza la cronologia
            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <div x-data="{ scrollNext() { $refs.slider2.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider2.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative">

        {{-- Freccia Sinistra --}}
        <button @click="scrollPrev" class="absolute left-4 -translate-y-1/2 z-40 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl" style="top: 98px;">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        {{-- Contenitore Slider --}}
        <div x-ref="slider2" class="flex overflow-x-auto space-x-4 pb-4 pt-4 -mt-2 hide-scrollbar snap-x snap-mandatory overflow-y-visible relative pl-4 sm:pl-6 lg:pl-12 pr-4 sm:pr-6 lg:pr-12">

            @foreach($continueWatching as $anime)
                {{-- Card Orizzontale --}}
                <div class="flex-none w-[280px] md:w-[320px] snap-start group/card relative scroll-ml-4 sm:scroll-ml-6 lg:scroll-ml-12 cursor-pointer hover:z-30">

                    {{-- CORNICE IMMAGINE --}}
                    <a href="{{ route('anime.show', $anime->mal_id) }}?action=play" class="block relative rounded-md overflow-hidden aspect-video border-2 border-transparent group-hover/card:border-[#FF6600] group-hover/card:shadow-orange-500/50 group-hover/card:scale-105 transform origin-center transition-all duration-300 shadow-lg bg-gray-900">

                        <img src="{{ $anime->image_url }}" class="w-full h-full object-cover object-top">

                        {{-- Overlay Scuro --}}
                        <div class="absolute inset-0 bg-black/20 group-hover/card:bg-black/50 transition-colors duration-300"></div>

                        {{-- Badge Tempo Rimanente --}}
                        <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm text-gray-200 text-[10px] font-bold px-2 py-0.5 rounded border border-white/10">
                            25min rimanenti
                        </div>

                        {{-- Tasto Play Centrale --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-black/60 backdrop-blur-md text-white rounded-full p-3 group-hover/card:bg-[#FF6600] group-hover/card:scale-110 transition-all duration-300 shadow-xl border border-white/20 group-hover/card:border-transparent">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-600/80">
                            <div class="h-full bg-[#FF6600]" style="width: 75%;"></div>
                        </div>
                    </a>

                    {{-- TESTI SOTTO L'IMMAGINE --}}
                    <div class="mt-4 px-1">
                        <div class="flex items-center space-x-2 text-[11px] text-gray-400 font-medium mb-1 line-clamp-1">
                            <span class="bg-gray-800 text-gray-300 px-1.5 py-0.5 rounded uppercase font-bold border border-gray-700 text-[9px]">Sub</span>
                            <span class="bg-gray-800 text-gray-300 px-1.5 py-0.5 rounded uppercase font-bold border border-gray-700 text-[9px]">Dub</span>
                            <span class="truncate">{{ $anime->title }}</span>
                        </div>

                        <h3 class="text-sm font-bold text-white line-clamp-1 group-hover/card:text-[#FF6600] transition" title="{{ $anime->title }}">
                            E1 - Episodio Iniziale
                        </h3>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Freccia Destra --}}
        <button @click="scrollNext" class="absolute right-4 -translate-y-1/2 z-40 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl" style="top: 98px;">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>
@endif
