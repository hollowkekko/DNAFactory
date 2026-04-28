{{-- Hero Section Carousel --}}
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

    {{-- Immagini di Sfondo --}}
    <template x-for="(hero, index) in heroes" :key="index">
        <img :src="hero.banner_url || hero.image_url"
             :class="index === currentHero ? 'opacity-90' : 'opacity-0'"
             class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-700">
    </template>

    {{-- Gradienti --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent w-2/3"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/30"></div>

    {{-- Logo --}}
    <div class="absolute top-12 left-12 z-20 max-w-xs">
        <img x-show="heroes[currentHero].logo_url"
             :src="heroes[currentHero].logo_url"
             class="h-24 md:h-32 object-contain drop-shadow-lg transition-opacity duration-700"
             alt="Anime Logo">
    </div>

    {{-- Contenuto --}}
    <div class="relative z-10 h-full w-full px-4 sm:px-6 lg:px-12 flex flex-col justify-center">
        <div class="max-w-3xl mt-20" x-transition:enter="transition ease-in duration-500" x-transition:leave="transition ease-out duration-500">
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-white mb-4 tracking-widest drop-shadow-2xl" style="text-shadow: 3px 3px 0px #000, 6px 6px 0px rgba(0,0,0,0.5); font-style: oblique; letter-spacing: -0.02em;">
                <span x-text="heroes[currentHero].title.toUpperCase()"></span>
            </h1>

            <div class="flex items-center space-x-2 mb-4 text-[11px] font-bold text-gray-300 uppercase tracking-wider">
                <span class="bg-gray-700/80 px-1.5 py-0.5 rounded text-white">Sub</span>
                <span class="bg-gray-700/80 px-1.5 py-0.5 rounded text-white">Dub</span>
                <span>Action, Adventure, Fantasy</span>
            </div>

            <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-8 line-clamp-3 md:line-clamp-4">
                <span x-text="heroes[currentHero].synopsis"></span>
            </p>

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

            <div class="flex space-x-1 mt-12 items-center">
                <template x-for="(hero, index) in heroes" :key="index">
                    <div :class="index === currentHero ? 'w-8 h-1.5 bg-[#FF6600]' : 'w-2 h-2 bg-gray-500'" class="rounded-full mx-1 transition cursor-pointer" @click="currentHero = index"></div>
                </template>
            </div>
        </div>
    </div>

    {{-- Frecce --}}
    <button @click="prevHero()" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF6600] opacity-0 group-hover:opacity-100 transition z-30 bg-black/60 p-2 rounded-full hover:bg-black/80"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
    <button @click="nextHero()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF6600] opacity-0 group-hover:opacity-100 transition z-30 bg-black/60 p-2 rounded-full hover:bg-black/80"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
</div>
@endif
