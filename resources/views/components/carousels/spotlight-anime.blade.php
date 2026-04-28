{{-- Spotlight Anime Carousel --}}
@php
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
        favoriteIds: {{ \Illuminate\Support\Js::from($favoriteAnimeIds) }},
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
        },
        isFavorite(animeId) {
            return this.favoriteIds.includes(animeId);
        },
        toggleFavoriteClick(animeId) {
            this.toggleFavorite(animeId);
        }
     }"
     @toggle-favorite.window="if ($event.detail === animes[activeIndex]?.mal_id) favoriteIds.includes($event.detail) ? favoriteIds = favoriteIds.filter(id => id !== $event.detail) : favoriteIds.push($event.detail)">

    <div class="relative group -mx-4 sm:-mx-6 lg:-mx-12 px-4 sm:px-6 lg:px-12 pt-8">

        {{-- Freccia Sinistra --}}
        <button @click="prevSpotlight()"
                class="absolute left-4 -translate-y-1/2 z-50 bg-black/90 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 hover:bg-[#FF6600] hidden md:block border border-gray-800 shadow-xl" style="top: 182px;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        {{-- Contenitore Slider --}}
        <div x-ref="spotlightSlider" class="flex overflow-x-auto space-x-4 pb-12 pt-4 -mt-4 hide-scrollbar items-start snap-x snap-mandatory overflow-y-visible">
            <div style="width: 16px; flex-shrink: 0;"></div>

            <template x-for="(anime, index) in animes" :key="anime.mal_id">

                {{-- Gruppo Item --}}
                <div class="flex-none snap-start transition-all duration-500 ease-in-out cursor-pointer relative group/spot"
                     :class="activeIndex === index ? 'w-[320px] md:w-[500px] lg:w-[650px] z-40' : 'w-[140px] md:w-[180px] lg:w-[200px] hover:z-30'"
                     @click="activeIndex = index; setTimeout(() => $el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' }), 100)">

                    {{-- Cornice Visiva --}}
                    <div class="w-full overflow-hidden rounded-lg bg-gray-900 transition-all duration-300 ease-out relative border-2 transform origin-left group-hover/spot:scale-[1.02] group-hover/spot:border-[#FF6600] group-hover/spot:shadow-orange-500/50"
                         :class="activeIndex === index ? 'aspect-[16/9] border-gray-600 shadow-2xl' : 'aspect-[2/3] border-transparent opacity-60 group-hover/spot:opacity-100'">

                        <img :src="anime.image_url" :alt="anime.title" class="w-full h-full object-cover object-top">

                        {{-- Sfumatura nera in basso --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent transition-opacity duration-500 pointer-events-none"
                             :class="activeIndex === index ? 'opacity-100' : 'opacity-0'"></div>
                    </div>

                    {{-- Dettagli Sotto --}}
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
                            <button @click="toggleFavoriteClick(anime.mal_id)"
                                    class="border border-gray-600 text-gray-400 hover:text-white p-2.5 rounded transition"
                                    :class="isFavorite(anime.mal_id) ? 'bg-[#FF6600] text-white border-[#FF6600]' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        {{-- Freccia Destra --}}
        <button @click="nextSpotlight()"
                class="absolute right-4 -translate-y-1/2 z-40 bg-black/90 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 hover:bg-[#FF6600] hidden md:block border border-gray-800 shadow-xl" style="top: 182px;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>
