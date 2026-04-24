<x-app-layout>

    {{-- 1. HERO SECTION CAROUSEL --}}
    @if($heroAnimes->isNotEmpty())
    <div class="relative w-full h-[85vh] bg-black overflow-hidden group"
         x-data="{
             currentHero: 0,
             heroes: {{ $heroAnimes->toJson() }},
             favoriteIds: {{ json_encode($favoriteAnimeIds) }},
             heroProgress: 0,
             heroAutoPlayDuration: 5000,
             heroInterval: null,
             isFavoriteCurrent() {
                 return this.favoriteIds.includes(this.heroes[this.currentHero].mal_id);
             },
             nextHero() {
                 this.currentHero = (this.currentHero + 1) % this.heroes.length;
                 this.heroProgress = 0;
                 this.startAutoPlay();
             },
             prevHero() {
                 this.currentHero = (this.currentHero - 1 + this.heroes.length) % this.heroes.length;
                 this.heroProgress = 0;
                 this.startAutoPlay();
             },
             startAutoPlay() {
                 if (this.heroInterval) clearInterval(this.heroInterval);
                 let startTime = Date.now();
                 this.heroInterval = setInterval(() => {
                     let elapsed = Date.now() - startTime;
                     this.heroProgress = Math.min(100, (elapsed / this.heroAutoPlayDuration) * 100);
                     if (this.heroProgress >= 100) {
                         this.nextHero();
                     }
                 }, 50);
             }
         }"
         x-init="startAutoPlay()"
         @mouseenter="if (heroInterval) clearInterval(heroInterval)"
         @mouseleave="startAutoPlay()"
         @toggle-favorite.window="if ($event.detail === heroes[currentHero].mal_id) favoriteIds.includes($event.detail) ? favoriteIds = favoriteIds.filter(id => id !== $event.detail) : favoriteIds.push($event.detail)">

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
                    <a :href="`/anime/${heroes[currentHero].mal_id}?action=play`" class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-3 px-6 rounded flex items-center transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        Inizia a Guardare
                    </a>

                    <button @click="toggleFavorite(heroes[currentHero].mal_id)"
                            class="p-2.5 rounded transition"
                            :class="isFavoriteCurrent() ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'border-2 border-gray-600 hover:border-white text-gray-400 hover:text-white'">
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
    {{-- Rimosso px-4 sm:px-6 lg:px-12 da qui, lo gestiremo diversamente --}}
    <div class="w-full py-8 mt-8 relative z-20 overflow-hidden">
        
        {{-- Manteniamo il padding sul titolo per allinearlo al resto del layout --}}
        <h2 class="text-xl font-bold mb-4 text-white px-4 sm:px-6 lg:px-12">I nostri consigli per te</h2>

        {{-- Rimosso i margini negativi -mx-* --}}
        <div x-data="{ scrollNext() { $refs.slider1.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider1.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group">

            {{-- Frecce (posizionate con un po' di margine per non coprire il bordo estremo) --}}
            <button @click="scrollPrev" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            {{-- 
                IL SEGRETO È QUI: 
                - pl-4 sm:pl-6 lg:pl-12 dà lo spazio iniziale al primo elemento.
                - pr-4 sm:pr-6 lg:pr-12 dà lo spazio finale all'ultimo.
                - Quando scorri, gli elementi intermedi andranno "sotto" il bordo sinistro coprendo quel padding!
            --}}
            <div x-ref="slider1" class="flex overflow-x-auto space-x-3 pb-4 hide-scrollbar snap-x snap-mandatory overflow-y-visible pt-8 relative pl-4 sm:pl-6 lg:pl-12 pr-4 sm:pr-6 lg:pr-12">
                
                @foreach($recommendedAnime as $index => $anime)
                    <div class="flex-none w-[260px] snap-start group/card relative z-20 scroll-ml-4 sm:scroll-ml-6 lg:scroll-ml-12"
                         x-data="{ isFavorite: {{ in_array($anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                         @toggle-favorite.window="if ($event.detail === {{ $anime->mal_id }}) isFavorite = !isFavorite">

                        <a href="{{ route('anime.show', $anime->mal_id) }}?action=play" class="block relative rounded-lg overflow-hidden aspect-[2/3] border-2 border-transparent hover:border-[#FF6600] hover:scale-105 transition cursor-pointer duration-300 shadow-2xl hover:shadow-orange-500/50">
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
                        {{-- Dettagli: Sub, Dub, Episodi e Voto --}}
                        <div class="flex items-center justify-between mt-3 mb-1 px-1">
                            <div class="flex items-center space-x-2 text-[10px] text-gray-400 font-medium">
                                <div class="flex items-center space-x-1">
                                    <span class="bg-gray-800 text-gray-300 px-1 py-0.5 rounded text-[9px] font-bold uppercase border border-gray-700">Sub</span>
                                    <span class="bg-gray-800 text-gray-300 px-1 py-0.5 rounded text-[9px] font-bold uppercase border border-gray-700">Dub</span>
                                </div>
                                <span>S1 E1</span> {{-- Placeholder episodi --}}
                            </div>
                            <div class="flex items-center text-[11px] font-bold text-gray-300">
                                <svg class="w-3 h-3 text-gray-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ $anime->score ?? 'N/A' }}
                            </div>
                        </div>

                        {{-- Titolo sotto i dettagli --}}
                        <h3 class="text-sm font-bold text-white line-clamp-1 drop-shadow group-hover/card:text-[#FF6600] transition px-1" title="{{ $anime->title }}">{{ $anime->title }}</h3>

                        {{-- Bottone Preferiti (AJAX POST) --}}
                        <button @click="toggleFavorite({{ $anime->mal_id }})"
                                class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition group-hover/card:opacity-100 group-hover/card:scale-105 origin-top-right"
                                :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:bg-black/80 hover:text-white group-hover/card:bg-black/80 group-hover/card:text-white'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                        </button>
                    </div>
                @endforeach

                {{-- Overlay fade - Posizionati in modo assoluto ma ancorati allo scroll --}}
                {{-- Attenzione: questi fade potrebbero sembrare strani se il padding è alto, valuta se tenerli --}}
                <div class="fixed left-0 top-0 bottom-0 w-8 md:w-16 pointer-events-none z-10 bg-gradient-to-r from-black to-transparent opacity-80"></div>
                <div class="fixed right-0 top-0 bottom-0 w-8 md:w-16 pointer-events-none z-10 bg-gradient-to-l from-black to-transparent opacity-80"></div>
            </div>

            <button @click="scrollNext" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>
    
 {{-- 3. CAROSELLO 2 (CONTINUA A GUARDARE) --}}
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
            <button @click="scrollPrev" class="absolute left-4 top-[35%] -translate-y-1/2 z-40 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            {{-- Contenitore Slider (Aggiunto pt-4, -mt-2 e pb-8 per dare spazio allo zoom del riquadro) --}}
            <div x-ref="slider2" class="flex overflow-x-auto space-x-4 pb-8 pt-4 -mt-2 hide-scrollbar snap-x snap-mandatory overflow-y-visible relative pl-4 sm:pl-6 lg:pl-12 pr-4 sm:pr-6 lg:pr-12">
                
                @foreach($continueWatching as $anime)
                    {{-- Card Orizzontale --}}
                    <div class="flex-none w-[280px] md:w-[320px] snap-start group/card relative scroll-ml-4 sm:scroll-ml-6 lg:scroll-ml-12 cursor-pointer hover:z-30">
                        
                        {{-- 1. CORNICE IMMAGINE (Lo zoom group-hover/card:scale-105 ora è applicato a tutto questo tag <a>) --}}
                        <a href="{{ route('anime.show', $anime->mal_id) }}?action=play" class="block relative rounded-md overflow-hidden aspect-video border-2 border-transparent group-hover/card:border-[#FF6600] group-hover/card:shadow-orange-500/50 group-hover/card:scale-105 transform origin-center transition-all duration-300 shadow-lg bg-gray-900">
                            
                            {{-- L'immagine ora segue semplicemente le dimensioni del riquadro genitore, senza zoomare da sola --}}
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

                        {{-- 2. TESTI SOTTO L'IMMAGINE --}}
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
            <button @click="scrollNext" class="absolute right-4 top-[35%] -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block border border-gray-700 shadow-xl"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>
    @endif

    {{-- DUE BANNER PROMOZIONALI LATERALI (sotto Continua a guardare) --}}
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8 flex gap-4">

        {{-- Banner Promozionale Sinistro --}}
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

        {{-- Banner Promozionale Destro --}}
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


    <div class="w-full px-4 sm:px-6 lg:px-12 py-8">
        <h2 class="text-xl font-bold mb-4 text-white uppercase">TOP 10</h2>

        <div x-data="{ scrollNext() { $refs.slider4.scrollBy({ left: 800, behavior: 'smooth' }); }, scrollPrev() { $refs.slider4.scrollBy({ left: -800, behavior: 'smooth' }); } }" class="relative group -mx-4 sm:-mx-6 lg:-mx-12">

            <button @click="scrollPrev" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>

            <div x-ref="slider4" class="flex overflow-x-auto overflow-y-visible space-x-20 pb-16 pt-4 hide-scrollbar snap-x snap-mandatory px-4 sm:px-6 lg:px-12">
                @foreach($top15Anime as $index => $anime)
                    <div class="flex-none snap-start group/card relative {{ $index === 0 ? 'ml-16' : '' }}" style="width: auto;"
                         x-data="{ isFavorite: {{ in_array($anime->mal_id, $favoriteAnimeIds) ? 'true' : 'false' }} }"
                         @toggle-favorite.window="if ($event.detail === {{ $anime->mal_id }}) isFavorite = !isFavorite">

                        {{-- Contenitore flex per numero e copertina --}}
                        <div class="flex items-stretch gap-1" style="height: 390px;">
                            {{-- Numero posizione a sinistra --}}
                            <div class="flex items-center justify-center flex-shrink-0 {{ $index === 0 ? 'ml-16' : '' }}" style="width: 120px;">
                                <div class="font-black text-white/20 group-hover/card:text-white/30 select-none transition-colors duration-500" style="font-family: 'Arial Black', sans-serif; font-size: 400px; line-height: 1;">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            {{-- Card della copertina --}}
                            <a href="{{ route('anime.show', $anime->mal_id) }}?action=play" class="relative flex-shrink-0 w-[260px] rounded-lg overflow-hidden border-2 border-transparent hover:border-[#FF6600] hover:scale-105 transition cursor-pointer shadow-2xl hover:shadow-orange-500/50 duration-300 aspect-[2/3]" style="z-index: 10;">
                                <img src="{{ $anime->image_url }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                                {{-- Hover Overlay: Riquadro Arancione con Play --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/card:opacity-100 transition flex items-end justify-center pb-8">
                                    <div class="bg-[#FF6600] hover:bg-[#FF8533] rounded px-6 py-3 flex items-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                        <span class="text-white font-bold text-sm">Riproduci stagione 1 ep 1</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Titolo sotto il riquadro --}}
                        {{-- Contenitore Dettagli e Titolo (aggiunge 64px di margine solo al primo anime per allinearlo) --}}
                        <div class="w-[260px]" style="margin-left: {{ $index === 0 ? '188px' : '124px' }};">                            {{-- Dettagli: Sub, Dub, Episodi e Voto --}}
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
                            
                            {{-- Titolo sotto i dettagli --}}
                            <h3 class="text-sm font-bold text-white line-clamp-1 drop-shadow group-hover/card:text-[#FF6600] transition px-1" title="{{ $anime->title }}">{{ $anime->title }}</h3>
                        </div>

                        {{-- Bottone Preferiti (AJAX POST) --}}
                        <button @click="toggleFavorite({{ $anime->mal_id }})"
                                class="absolute top-0 right-0 z-10 p-1.5 rounded-bl shadow transition group-hover/card:opacity-100 group-hover/card:scale-105 origin-top-right"
                                :class="isFavorite ? 'bg-[#FF6600] text-white hover:bg-[#FF8533]' : 'bg-black/60 text-gray-400 hover:bg-black/80 hover:text-white group-hover/card:bg-black/80 group-hover/card:text-white'">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <button @click="scrollNext" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-black/80 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition hover:text-[#FF6600] hidden md:block"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>

            {{-- Overlay fade su entrambi i lati (solo estremita) --}}
            <div class="absolute left-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, transparent 100%);"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 pointer-events-none z-10" style="background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 100%);"></div>
        </div>
    </div>

    {{-- 5. SEZIONE PROMOZIONALE (BANNER ORIZZONTALE) --}}
    @if($promotionalAnime)
    <div class="w-full px-4 sm:px-6 lg:px-12 py-12 flex justify-center">
        <div class="relative rounded-lg overflow-hidden h-96 md:h-[28rem] lg:h-[32rem] max-w-[90rem] w-full group/promo"
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
                        <a href="{{ route('anime.show', $promotionalAnime->mal_id) }}?action=play"
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

{{-- 5. SPOTLIGHT CAROUSEL (Singola riga con espansione in-place) --}}
    @php
        // Rendiamo i dati sicuri per JSON
        $safeSpotlightData = $spotlightAnime->map(fn($a) => [
            'mal_id' => $a->mal_id,
            'title' => $a->title,
            'image_url' => $a->image_url,
            'score' => $a->score,
            'synopsis' => $a->synopsis
        ]);
    @endphp

    <div class="w-full px-4 sm:px-6 lg:px-12 py-16 mb-20 relative"
         x-data="{
            animes: {{ \Illuminate\Support\Js::from($safeSpotlightData) }},
            activeIndex: 0,
            nextSpotlight() {
                this.activeIndex = (this.activeIndex + 1) % this.animes.length;
                this.$nextTick(() => {
                    const slider = this.$refs.spotlightSlider;
                    const element = slider.children[this.activeIndex];
                    if (element) {
                        slider.scrollTo({ left: element.offsetLeft - 50, behavior: 'smooth' });
                    }
                });
            },
            prevSpotlight() {
                this.activeIndex = (this.activeIndex - 1 + this.animes.length) % this.animes.length;
                this.$nextTick(() => {
                    const slider = this.$refs.spotlightSlider;
                    const element = slider.children[this.activeIndex];
                    if (element) {
                        slider.scrollTo({ left: element.offsetLeft - 50, behavior: 'smooth' });
                    }
                });
            }
         }">

        

        <div class="relative group -mx-4 sm:-mx-6 lg:-mx-12 px-4 sm:px-6 lg:px-12 pt-8">
            
            {{-- Freccia Sinistra (Centrata rispetto all'altezza delle immagini) --}}
            <button @click="prevSpotlight()"
                    class="absolute left-4 top-[120px] z-40 bg-black/90 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 hover:bg-[#FF6600] hidden md:block border border-gray-800 shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            {{-- Contenitore Slider Singolo (Aggiunto pt-4 e -mt-4 per far respirare lo zoom in alto senza rovinare l'allineamento) --}}
            <div x-ref="spotlightSlider" class="flex overflow-x-auto space-x-4 pb-12 pt-4 -mt-4 hide-scrollbar items-start snap-x snap-mandatory overflow-y-visible">
                <div style="width: 16px; flex-shrink: 0;"></div>

                <template x-for="(anime, index) in animes" :key="anime.mal_id">
                    
                    {{-- 1. GRUPPO NOMINATO --}}
                    <div class="flex-none snap-start transition-all duration-500 ease-in-out cursor-pointer relative group/spot"
                         :class="activeIndex === index ? 'w-[320px] md:w-[500px] lg:w-[650px] z-40' : 'w-[140px] md:w-[180px] lg:w-[200px] hover:z-30'"
                         @click="activeIndex = index; setTimeout(() => $el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' }), 100)">

                        {{-- 2. CORNICE VISIVA: Qui ho cambiato group-hover/spot:scale-105 in group-hover/spot:scale-[1.02] --}}
                        <div class="w-full overflow-hidden rounded-lg bg-gray-900 transition-all duration-300 ease-out relative border-2 transform origin-left group-hover/spot:scale-[1.02] group-hover/spot:border-[#FF6600] group-hover/spot:shadow-orange-500/50"
                             :class="activeIndex === index ? 'aspect-[16/9] border-gray-600 shadow-2xl' : 'aspect-[2/3] border-transparent opacity-60 group-hover/spot:opacity-100'">
                            
                            <img :src="anime.image_url" :alt="anime.title" class="w-full h-full object-cover object-top">
                            
                            {{-- Sfumatura nera in basso --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent transition-opacity duration-500 pointer-events-none"
                                 :class="activeIndex === index ? 'opacity-100' : 'opacity-0'"></div>
                        </div>

                        {{-- 3. DETTAGLI SOTTO L'IMMAGINE --}}
                        <div class="transition-all duration-500 ease-in-out overflow-hidden"
                             :class="activeIndex === index ? 'opacity-100 max-h-[400px] mt-4 pointer-events-auto' : 'opacity-0 max-h-0 mt-0 pointer-events-none'">
                            
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-2 line-clamp-1" x-text="anime.title"></h3>
                            
                            <div class="flex items-center text-xs md:text-sm text-gray-400 mb-3 space-x-2">
                                <span class="bg-gray-800 text-gray-300 px-1.5 py-0.5 rounded uppercase font-bold border border-gray-700">Sub</span>
                                <span class="bg-gray-800 text-gray-300 px-1.5 py-0.5 rounded uppercase font-bold border border-gray-700">Dub</span>
                                <span class="font-medium">• S1 E1</span>
                                <span class="text-[#FF6600] font-bold ml-2">⭐ <span x-text="anime.score || 'N/A'" class="text-white"></span></span>
                            </div>
                            
                            <p class="text-sm text-gray-400 line-clamp-3 mb-5 leading-relaxed" x-text="anime.synopsis"></p>
                            
                            <div class="flex space-x-3">
                                <a :href="'/anime/' + anime.mal_id + '?action=play'" class="bg-[#FF6600] hover:bg-[#FF8533] text-white font-bold py-2.5 px-6 rounded flex items-center transition shadow-lg text-sm md:text-base">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                    Riproduci Ora
                                </a>
                                <button class="border border-gray-600 text-gray-400 hover:text-white p-2.5 rounded transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            {{-- Freccia Destra --}}
            <button @click="nextSpotlight()"
                    class="absolute right-4 top-[120px] z-40 bg-black/90 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 hover:bg-[#FF6600] hidden md:block border border-gray-800 shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
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
