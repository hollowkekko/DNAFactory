<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8 border-b border-gray-800 pb-4">
            <h1 class="text-3xl font-bold text-white flex items-center">
                <svg class="w-8 h-8 text-orange-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                I Miei Preferiti
            </h1>
        </div>

        @if($favorites->isEmpty())
            {{-- Messaggio se non ci sono preferiti --}}
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h3 class="text-xl font-medium text-gray-400">La tua lista è vuota</h3>
                <p class="text-gray-500 mt-2">Esplora il catalogo e salva i tuoi titoli preferiti!</p>
                <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-orange-600 hover:bg-orange-500 text-white font-bold py-2 px-6 rounded transition">
                    Torna alla Home
                </a>
            </div>
        @else
            {{-- Griglia dei preferiti --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                @foreach($favorites as $favorite)
                    @php
                        // Estraiamo l'oggetto vero e proprio (Anime o Manga)
                        $item = $favorite->favoritable;
                        
                        // Creiamo l'URL giusto in base al tipo (se è Anime o Manga)
                        $isAnime = $favorite->favoritable_type === 'App\Models\Anime';
                        $url = $isAnime ? route('anime.show', $item->mal_id) : route('manga.show', $item->mal_id);
                    @endphp

                    <div class="relative group">
                        <a href="{{ $url }}" class="block relative rounded-lg overflow-hidden aspect-[2/3] border border-gray-800 hover:border-orange-500 transition-colors shadow-lg">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            {{-- Etichetta tipo (Anime/Manga) --}}
                            <div class="absolute top-0 left-0 bg-black/80 text-gray-300 text-[10px] font-bold px-2 py-1 rounded-br-lg uppercase tracking-wider">
                                {{ $isAnime ? 'Anime' : 'Manga' }}
                            </div>
                        </a>
                        <h3 class="mt-3 text-sm font-semibold text-gray-200 line-clamp-2">
                            {{ $item->title }}
                        </h3>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>