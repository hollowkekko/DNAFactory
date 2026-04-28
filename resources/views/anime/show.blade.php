<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('anime.index') }}" class="text-indigo-600 hover:underline">&larr; Torna al Catalogo</a> / {{ $anime->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
            {{-- Sezione Superiore: Immagine e Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row mb-8">
                {{-- Immagine Locandina --}}
                <div class="w-full md:w-1/3 bg-gray-100">
                    @if ($anime->image_url)
                        <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-auto object-cover">
                    @endif
                </div>

                {{-- Dettagli Anime --}}
                <div class="p-8 w-full md:w-2/3 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-4 text-[#FF6600]">{{ $anime->title }}</h1>
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span class="inline-block bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full">
                                ⭐ Voto: {{ $anime->score ?? 'N/A' }} / 10
                            </span>
                            @if($anime->episodes)
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">
                                    📺 {{ $anime->episodes }} episodi
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold mb-2">Trama</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $anime->synopsis }}
                        </p>
                    </div>

                    {{-- Pulsante Preferiti (Per ora visivo, lo attiveremo al prossimo step) --}}
                    <div class="mt-8">
                        @php
                            // Controlliamo se è già nei preferiti per cambiare il colore e il testo del bottone
                            $isFavorite = Auth::user()->favorites()
                                ->where('favoritable_id', $anime->mal_id)
                                ->where('favoritable_type', App\Models\Anime::class)
                                ->exists();
                        @endphp

                        <form action="{{ route('favorites.toggleAnime', $anime->mal_id) }}" method="POST">
                            @csrf {{-- Misura di sicurezza obbligatoria in Laravel --}}
                            
                            @if($isFavorite)
                                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                                    ❌ Rimuovi dai Preferiti
                                </button>
                            @else
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow transition-colors">
                                    ❤️ Aggiungi ai Preferiti
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sezione Inferiore: Recensioni in Tempo Reale con AlpineJS --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8" 
                 x-data="{ reviews: [], loading: true, error: false }" 
                 x-init="
                    fetch('https://api.jikan.moe/v4/anime/{{ $anime->mal_id }}/reviews')
                        .then(response => response.json())
                        .then(data => { 
                            reviews = data.data.slice(0, 3); // Prendiamo solo le prime 3 recensioni
                            loading = false; 
                        })
                        .catch(() => { 
                            error = true; 
                            loading = false; 
                        })
                 ">
                
                <h3 class="text-2xl font-bold mb-6 border-b pb-2">Recensioni degli Utenti (Live)</h3>

                {{-- Stato di caricamento --}}
                <div x-show="loading" class="text-gray-500 animate-pulse">
                    Sto scaricando le recensioni da MyAnimeList...
                </div>

                {{-- Stato di errore --}}
                <div x-show="error" class="text-red-500" style="display: none;">
                    Impossibile caricare le recensioni al momento.
                </div>

                {{-- Lista Recensioni --}}
                <div x-show="!loading && !error" style="display: none;">
                    <template x-if="reviews.length === 0">
                        <p class="text-gray-500">Nessuna recensione disponibile per questo anime.</p>
                    </template>

                    <div class="space-y-6">
                        <template x-for="review in reviews" :key="review.mal_id">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <span class="font-bold text-indigo-600" x-text="review.user.username"></span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-sm text-gray-500">Voto: <span x-text="review.score" class="font-bold"></span>/10</span>
                                </div>
                                <p class="text-sm text-gray-700 italic line-clamp-4" x-text="review.review"></p>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>