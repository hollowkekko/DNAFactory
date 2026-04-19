<x-app-layout>
    
    {{-- 1. HERO SECTION GIGANTE --}}
    @if($heroAnime)
    <div class="relative w-full h-[70vh] lg:h-[80vh] bg-black overflow-hidden border-b border-gray-800">
        
        {{-- Sfondo Immagine Anime (Sfocato e ingrandito per fare da fondale) --}}
        <img src="{{ $heroAnime->image_url }}" class="absolute inset-0 w-full h-full object-cover opacity-30 blur-sm scale-110">
        
        {{-- Gradiente Nero per far leggere il testo --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/50 to-transparent"></div>

        {{-- Contenuto Hero --}}
        <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-end pb-16 lg:pb-24">
            
            <div class="max-w-2xl">
                {{-- Tags --}}
                <div class="flex items-center space-x-3 mb-4 text-xs font-bold uppercase tracking-wider">
                    <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded">Sub</span>
                    <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded">Dub</span>
                    <span class="text-orange-500">⭐ Voto: {{ $heroAnime->score }}</span>
                </div>

                {{-- Titolo Enorme --}}
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 drop-shadow-2xl leading-tight">
                    {{ $heroAnime->title }}
                </h1>
                
                {{-- Trama --}}
                <p class="text-gray-300 text-lg mb-8 line-clamp-3">
                    {{ $heroAnime->synopsis }}
                </p>

                {{-- Bottoni --}}
                <div class="flex space-x-4">
                    <a href="{{ route('anime.show', $heroAnime->mal_id) }}" class="bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 px-8 rounded flex items-center transition shadow-lg shadow-orange-600/30">
                        {{-- Icona Play --}}
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Inizia a Guardare
                    </a>

                    {{-- Bottone Segnalibro Preferiti (Funzionante) --}}
                    @auth
                        @php
                            $isFavorite = Auth::user()->favorites()
                                ->where('favoritable_id', $heroAnime->mal_id)
                                ->where('favoritable_type', 'App\Models\Anime')
                                ->exists();
                        @endphp
                        <form action="{{ route('favorites.toggleAnime', $heroAnime->mal_id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="border border-gray-600 hover:border-orange-500 text-white hover:text-orange-500 p-3 rounded transition">
                                <svg class="w-6 h-6" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 2. CAROSELLO: I NOSTRI CONSIGLI --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold mb-6 text-white">I nostri consigli per te</h2>
        
        {{-- Contenitore Principale con AlpineJS --}}
        <div x-data="{ 
                scrollNext() { $refs.slider1.scrollBy({ left: 600, behavior: 'smooth' }); },
                scrollPrev() { $refs.slider1.scrollBy({ left: -600, behavior: 'smooth' }); }
            }" 
            class="relative group">
            
            {{-- Freccia Sinistra --}}
            <button @click="scrollPrev" class="absolute left-0 top-[40%] -translate-y-1/2 -ml-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            {{-- Contenitore scorrevole --}}
            <div x-ref="slider1" class="flex overflow-x-auto space-x-4 pb-6 hide-scrollbar snap-x snap-mandatory">
                @foreach($recommendedAnime as $anime)
                    <div class="flex-none w-40 md:w-52 snap-start group/card">
                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="block relative rounded-lg overflow-hidden aspect-[2/3] border border-gray-800 hover:border-orange-500 transition-colors shadow-lg">
                            <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-300">
                        </a>
                        <h3 class="mt-3 text-sm font-semibold text-gray-200 line-clamp-2" title="{{ $anime->title }}">
                            {{ $anime->title }}
                        </h3>
                    </div>
                @endforeach
            </div>

            {{-- Freccia Destra --}}
            <button @click="scrollNext" class="absolute right-0 top-[40%] -translate-y-1/2 -mr-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- CAROSELLO: MANGA CONSIGLIATI --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-gray-900">
        <h2 class="text-2xl font-bold mb-6 text-white flex items-center">
            Manga Consigliati
            <span class="ml-3 text-[10px] font-bold bg-orange-600 text-white px-2 py-1 rounded uppercase tracking-widest">Letture</span>
        </h2>
        
        <div x-data="{ 
                scrollNext() { $refs.sliderManga.scrollBy({ left: 600, behavior: 'smooth' }); },
                scrollPrev() { $refs.sliderManga.scrollBy({ left: -600, behavior: 'smooth' }); }
            }" 
            class="relative group">
            
            <button @click="scrollPrev" class="absolute left-0 top-[40%] -translate-y-1/2 -ml-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div x-ref="sliderManga" class="flex overflow-x-auto space-x-4 pb-6 hide-scrollbar snap-x snap-mandatory">
                {{-- Attenzione: usiamo $recommendedManga e la rotta manga.show --}}
                @foreach($recommendedManga as $manga)
                    <div class="flex-none w-40 md:w-52 snap-start group/card">
                        <a href="{{ route('manga.show', $manga->mal_id) }}" class="block relative rounded-lg overflow-hidden aspect-[2/3] border border-gray-800 hover:border-orange-500 transition-colors shadow-lg">
                            <img src="{{ $manga->image_url }}" alt="{{ $manga->title }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-300">
                        </a>
                        <h3 class="mt-3 text-sm font-semibold text-gray-200 line-clamp-2" title="{{ $manga->title }}">
                            {{ $manga->title }}
                        </h3>
                    </div>
                @endforeach
            </div>

            <button @click="scrollNext" class="absolute right-0 top-[40%] -translate-y-1/2 -mr-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- 3. CAROSELLO: TOP 10 ANIME --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 border-t border-gray-900">
        <h2 class="text-2xl font-bold mb-6 text-white uppercase tracking-wider">TOP 10 Anime Più Votati</h2>

        <div x-data="{
                scrollNext() { $refs.slider2.scrollBy({ left: 600, behavior: 'smooth' }); },
                scrollPrev() { $refs.slider2.scrollBy({ left: -600, behavior: 'smooth' }); }
            }"
            class="relative group">

            {{-- Freccia Sinistra --}}
            <button @click="scrollPrev" class="absolute left-0 top-[40%] -translate-y-1/2 -ml-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div x-ref="slider2" class="flex overflow-x-auto space-x-4 pb-6 hide-scrollbar snap-x snap-mandatory">
                @foreach($top10Anime as $anime)
                    <div class="flex-none w-40 md:w-52 snap-start group/card">
                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="block relative rounded-lg overflow-hidden aspect-[2/3] border border-gray-800 hover:border-orange-500 transition-colors shadow-lg">
                            <img src="{{ $anime->image_url }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-300">
                            <div class="absolute top-0 left-0 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-br-lg">
                                ⭐ {{ $anime->score }}
                            </div>
                        </a>
                        <h3 class="mt-3 text-sm font-semibold text-gray-200 line-clamp-2">
                            {{ $anime->title }}
                        </h3>
                    </div>
                @endforeach
            </div>

            {{-- Freccia Destra --}}
            <button @click="scrollNext" class="absolute right-0 top-[40%] -translate-y-1/2 -mr-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- 4. CAROSELLO: TOP 10 MANGA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 border-t border-gray-900">
        <h2 class="text-2xl font-bold mb-6 text-white uppercase tracking-wider">TOP 10 Manga Più Votati</h2>

        <div x-data="{
                scrollNext() { $refs.slider3.scrollBy({ left: 600, behavior: 'smooth' }); },
                scrollPrev() { $refs.slider3.scrollBy({ left: -600, behavior: 'smooth' }); }
            }"
            class="relative group">

            {{-- Freccia Sinistra --}}
            <button @click="scrollPrev" class="absolute left-0 top-[40%] -translate-y-1/2 -ml-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div x-ref="slider3" class="flex overflow-x-auto space-x-4 pb-6 hide-scrollbar snap-x snap-mandatory">
                @foreach($top10Manga as $manga)
                    <div class="flex-none w-40 md:w-52 snap-start group/card">
                        <a href="{{ route('manga.show', $manga->mal_id) }}" class="block relative rounded-lg overflow-hidden aspect-[2/3] border border-gray-800 hover:border-orange-500 transition-colors shadow-lg">
                            <img src="{{ $manga->image_url }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-300">
                            <div class="absolute top-0 left-0 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-br-lg">
                                ⭐ {{ $manga->score }}
                            </div>
                        </a>
                        <h3 class="mt-3 text-sm font-semibold text-gray-200 line-clamp-2">
                            {{ $manga->title }}
                        </h3>
                    </div>
                @endforeach
            </div>

            {{-- Freccia Destra --}}
            <button @click="scrollNext" class="absolute right-0 top-[40%] -translate-y-1/2 -mr-4 z-20 bg-black/80 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-orange-600 shadow-xl hidden md:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

</x-app-layout>