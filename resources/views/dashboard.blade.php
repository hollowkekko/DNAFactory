<x-app-layout>

    {{-- 1. HERO SECTION CAROUSEL --}}
    @if($heroAnimes->isNotEmpty())
    <div class="relative w-full h-[85vh] bg-black overflow-hidden group"
         x-data="{
             currentHero: 0,
             heroes: {{ $heroAnimes->toJson() }},
             nextHero() { this.currentHero = (this.currentHero + 1) % this.heroes.length; },
             prevHero() { this.currentHero = (this.currentHero - 1 + this.heroes.length) % this.heroes.length; }
         }">

        {{-- Immagini di Sfondo (stack con transizione) --}}
        <template x-for="(hero, index) in heroes" :key="index">
            <img :src="hero.banner_url || hero.image_url"
                 :class="index === currentHero ? 'opacity-90' : 'opacity-0'"
                 class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-700">
        </template>

        {{-- Gradienti (Scurissimo a sinistra, sfuma a destra e in alto) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent w-2/3"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/30"></div>

        {{-- Logo personalizzato dell'anime --}}
        <div class="absolute top-12 left-12 z-20 max-w-xs">
            <img x-show="heroes[currentHero].logo_url"
                 :src="heroes[currentHero].logo_url"
                 class="h-24 md:h-32 object-contain drop-shadow-lg transition-opacity duration-700"
                 alt="Anime Logo">
        </div>

        {{-- Contenuto allineato a sinistra --}}
        <div class="relative z-10 h-full w-full px-4 sm:px-6 lg:px-12 flex flex-col justify-center">

            <div class="max-w-3xl mt-20" x-transition:enter="transition ease-in duration-500" x-transition:leave="transition ease-out duration-500">
                {{-- Titolo renderizzato sull'immagine --}}
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-white mb-4 tracking-widest drop-shadow-2xl" style="text-shadow: 3px 3px 0px #000, 6px 6px 0px rgba(0,0,0,0.5); font-style: oblique; letter-spacing: -0.02em;">
                    <span x-text="heroes[currentHero].title.toUpperCase()"></span>
                </h1>

                {{-- Tags Stile Mockup --}}
                <div class="flex items-center space-x-2 mb-4 text-[11px] font-bold text-gray-300 uppercase tracking-wider">
                    <span class="bg-gray-700/80 px-1.5 py-0.5 rounded text-white">Sub</span>
                    <span class="bg-gray-700/80 px-1.5 py-0.5 rounded text-white">Dub</span>
                    <span>Action, Adventure, Fantasy</span>
                </div>

                {{-- Trama --}}
                <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-8 line-clamp-3 md:line-clamp-4">
                    <span x-text="heroes[currentHero].synopsis"></span>
                </p>

                {{-- Bottoni Hero --}}
                <div class="flex items-center space-x-3">
                    <a :href="`/anime/${heroes[currentHero].mal_id}`" class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-3 px-6 rounded flex items-center transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Inizia a Guardare
                    </a>

                    <button class="border-2 border-gray-600 hover:border-white text-gray-400 hover:text-white p-2.5 rounded transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </button>
                </div>

                {{-- Slider Dots --}}
                <div class="flex space-x-1 mt-12 items-center">
                    <template x-for="(hero, index) in heroes" :key="index">
                        <div :class="index === currentHero ? 'w-8 h-1.5 bg-[#FF6600]' : 'w-2 h-2 bg-gray-500'" class="rounded-full mx-1 transition cursor-pointer" @click="currentHero = index"></div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Frecce Laterali Hero - Navigazione carosello hero --}}
        <button @click="prevHero()" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF6600] opacity-0 group-hover:opacity-100 transition z-30 bg-black/60 p-2 rounded-full hover:bg-black/80"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
        <button @click="nextHero()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF6600] opacity-0 group-hover:opacity-100 transition z-30 bg-black/60 p-2 rounded-full hover:bg-black/80"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
    </div>
    @endif

    {{-- 2. CAROSELLO 1 (I NOSTRI CONSIGLI) --}}
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8 mt-8 relative z-20">
        <h2 class="text-xl font-bold mb-4 text-white">I nostri consigli per te</h2>

        <div x-data="{ scrollNext() { $refs.slider1.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider1.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group -mx-4 sm:-mx-6 lg:-mx-12">

            <button @click="scrollPrev" class="absolute left-0 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            <div x-ref="slider1" class="flex overflow-x-auto space-x-3 pb-4 hide-scrollbar snap-x snap-mandatory overflow-y-visible px-4 sm:px-6 lg:px-12 pt-8 relative">
                @foreach($recommendedAnime as $index => $anime)
                    <div class="flex-none w-[260px] snap-start group/card relative z-20"
                         x-data="{ isFavorite: {{ in_array($anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                         @toggle-favorite.window="if ($event.detail === {{ $anime->mal_id }}) isFavorite = !isFavorite">

                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="block relative rounded overflow-hidden aspect-[2/3] border border-transparent hover:border-[#FF6600] hover:scale-105 transition cursor-pointer duration-300">
                            <img src="{{ $anime->image_url }}" class="w-full h-full object-cover">

                            {{-- Overlay Sfumato inferiore --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                            {{-- Hover Overlay: Riquadro Arancione con Play --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-end justify-center pb-8">
                                <div class="bg-[#FF6600] hover:bg-[#FF8533] rounded px-6 py-3 flex items-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                    <span class="text-white font-bold text-sm">Riproduci stagione 1 ep 1</span>
                                </div>
                            </div>


                            {{-- Badge in alto a sinistra (Alternati per estetica) --}}
                            @if($index % 3 == 0)
                                <div class="absolute top-0 left-0 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-br">Nuova stagione</div>
                            @elseif($index % 4 == 0)
                                <div class="absolute top-0 left-0 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-br">Stagione finale</div>
                            @endif
                        </a>

                        {{-- Titolo sotto il riquadro con fade ai bordi --}}
                        <h3 class="text-sm font-bold text-white line-clamp-2 drop-shadow mt-2 group-hover/card:opacity-75 transition">{{ $anime->title }}</h3>

                        {{-- Bottone Preferiti (AJAX POST) --}}
                        <button @click="toggleFavorite({{ $anime->mal_id }})"
                                class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition"
                                :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-transparent text-gray-400 hover:text-white'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                        </button>
                    </div>
                @endforeach

                {{-- Overlay fade su entrambi i lati (solo carosello) --}}
                <div class="absolute left-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, transparent 100%);"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 100%);"></div>
            </div>

            {{-- Overlay fade rimosso da qui --}}

            <button @click="scrollNext" class="absolute right-0 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>

    {{-- 3. CAROSELLO 2 (CONTINUA A GUARDARE) --}}
    @if($continueWatching->isNotEmpty())
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8">
        <h2 class="text-xl font-bold mb-4 text-white">Continua a guardare</h2>

        <div x-data="{ scrollNext() { $refs.slider2.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider2.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group">

            <button @click="scrollPrev" class="absolute -left-5 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            <div x-ref="slider2" class="flex overflow-x-auto space-x-3 pb-4 hide-scrollbar snap-x snap-mandatory">
                @foreach($continueWatching as $anime)
                    <div class="flex-none w-[180px] snap-start group/card relative">
                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="block relative rounded overflow-hidden aspect-[2/3] border border-transparent hover:border-gray-500 transition cursor-pointer">
                            <img src="{{ $anime->image_url }}" class="w-full h-full object-cover">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>

                            <div class="absolute bottom-2 left-2 right-2 text-center">
                                <h3 class="text-sm font-bold text-white line-clamp-2 drop-shadow">{{ $anime->title }}</h3>
                            </div>
                        </a>

                        {{-- Bottone Preferiti (Form POST) --}}
                        <form action="{{ route('favorites.toggleAnime', $anime->mal_id) }}" method="POST" class="absolute top-0 right-0 z-10">
                            @csrf
                            <button type="submit" class="bg-[#FF6600] text-white p-1.5 rounded-bl shadow hover:bg-[#FF8533] transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <button @click="scrollNext" class="absolute -right-5 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>

            {{-- Overlay fade su entrambi i lati (solo estremita) --}}
            <div class="absolute left-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, transparent 100%);"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 100%);"></div>
        </div>
    </div>
    @endif

    {{-- 4. CAROSELLO 3 (TOP 10 PIÙ VOTATI) --}}
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8">
        <h2 class="text-xl font-bold mb-4 text-white uppercase">TOP 10</h2>

        <div x-data="{ scrollNext() { $refs.slider4.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider4.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group">

            <button @click="scrollPrev" class="absolute -left-5 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            <div x-ref="slider4" class="flex overflow-x-auto space-x-20 pb-4 hide-scrollbar snap-x snap-mandatory">
                @foreach($top15Anime as $index => $anime)
                    <div class="flex-none snap-start group/card relative flex items-stretch gap-1" style="width: auto; height: 390px;"
                         x-data="{ isFavorite: {{ in_array($anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                         @toggle-favorite.window="if ($event.detail === {{ $anime->mal_id }}) isFavorite = !isFavorite">

                        {{-- Numero posizione a sinistra --}}
                        <div class="flex items-center justify-center flex-shrink-0" style="width: 120px;">
                            <div class="font-black text-white/20 select-none" style="font-family: 'Arial Black', sans-serif; font-size: 400px; line-height: 1;">
                                {{ $index + 1 }}
                            </div>
                        </div>

                        {{-- Card della copertina --}}
                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="relative flex-shrink-0 w-[260px] rounded-lg overflow-hidden border-2 border-transparent hover:border-[#FF6600] transition cursor-pointer shadow-2xl hover:shadow-orange-500/50 duration-300 aspect-[2/3]" style="z-index: 10;">
                            <img src="{{ $anime->image_url }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                            {{-- Hover Overlay: Riquadro Arancione con Play --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-center justify-center">
                                <div class="bg-[#FF6600] rounded-full p-4">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                </div>
                            </div>

                            {{-- Testo titolo --}}
                            <div class="absolute bottom-2 left-2 right-2 text-center">
                                <h3 class="text-xs font-bold text-white line-clamp-2 drop-shadow">{{ $anime->title }}</h3>
                            </div>
                        </a>

                        {{-- Bottone Preferiti (AJAX POST) --}}
                        <button @click="toggleFavorite({{ $anime->mal_id }})"
                                class="absolute top-3 right-3 z-20 p-1.5 rounded-bl shadow transition"
                                :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:text-white'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <button @click="scrollNext" class="absolute -right-5 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>

            {{-- Overlay fade su entrambi i lati (solo estremita) --}}
            <div class="absolute left-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, transparent 100%);"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 100%);"></div>
        </div>
    </div>

    {{-- 5. SEZIONE PROMOZIONALE (BANNER ORIZZONTALE) --}}
    @if($promotionalAnime)
    <div class="w-full px-4 sm:px-6 lg:px-12 py-12">
        <div class="relative rounded-lg overflow-hidden h-64 md:h-72 group/promo"
             x-data="{ isFavorite: {{ in_array($promotionalAnime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
             @toggle-favorite.window="if ($event.detail === {{ $promotionalAnime->mal_id }}) isFavorite = !isFavorite">

            {{-- Background Image --}}
            <img src="{{ $promotionalAnime->banner_url ?? $promotionalAnime->image_url }}" class="absolute inset-0 w-full h-full object-cover object-center">

            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/60 to-transparent"></div>

            {{-- Content --}}
            <div class="absolute inset-0 flex items-center">
                <div class="ml-0 md:ml-8 max-w-md">
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-3 drop-shadow-lg">
                        {{ $promotionalAnime->title }}
                    </h2>
                    <p class="text-gray-300 text-sm md:text-base mb-6 line-clamp-2">
                        {{ $promotionalAnime->synopsis }}
                    </p>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('anime.show', $promotionalAnime->mal_id) }}"
                           class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-3 px-8 rounded flex items-center transition shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                            Guarda ora
                        </a>
                        <button @click="toggleFavorite({{ $promotionalAnime->mal_id }})"
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

    {{-- 6. ELENCO ESPANDIBILE (SCOPRI DI PIÙ) --}}
    <div class="w-full px-4 sm:px-6 lg:px-12 py-12">
        <h2 class="text-xl font-bold mb-6 text-white">Scopri di più</h2>

        <div class="space-y-3">
            @foreach($expandableList as $anime)
            <div x-data="{ expanded: false }" class="bg-gray-900 rounded overflow-hidden border border-gray-800 hover:border-gray-600 transition">
                <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-4 hover:bg-gray-800 transition">
                    <div class="flex items-center space-x-4 flex-1 text-left">
                        <img src="{{ $anime->image_url }}" class="w-16 h-24 object-cover rounded flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-white line-clamp-1">{{ $anime->title }}</h3>
                            <p class="text-sm text-gray-400">Voto: <span class="text-[#FF6600]">{{ $anime->score ?? 'N/A' }}</span> ⭐</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 ml-2 transition" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>

                <div x-show="expanded" x-transition class="bg-gray-800/50 border-t border-gray-700 p-4 space-y-3">
                    <p class="text-sm text-gray-300 line-clamp-3">{{ $anime->synopsis }}</p>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('anime.show', $anime->mal_id) }}" class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-2 px-4 rounded text-sm transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                            Guarda
                        </a>
                        <button onclick="toggleFavorite({{ $anime->mal_id }}, 'anime')" class="border border-gray-600 hover:border-white text-gray-400 hover:text-white p-2 rounded transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
        // Dispatch event to update Alpine.js state
        window.dispatchEvent(new CustomEvent('toggle-favorite', { detail: animeId }));
    });
}
</script>

</x-app-layout>
