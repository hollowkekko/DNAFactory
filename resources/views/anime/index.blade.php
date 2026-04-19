<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catalogo Anime') }}
        </h2>
    </x-slot>

    <div class="py-8"> {{-- Ridotto il padding verticale della pagina --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Griglia più fitta: 2 col. su mobile, 4 su tablet, 5 su desktop --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($animes as $anime)
                    {{-- Aggiunto "group" per poter far interagire l'immagine col passaggio del mouse sulla card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col group">
                        
                        {{-- Contenitore Immagine con proporzione bloccata 2:3 --}}
                        <div class="relative overflow-hidden aspect-[2/3] bg-gray-100">
                            @if ($anime->image_url)
                                {{-- L'immagine fa un leggero zoom (scale-105) all'hover --}}
                                <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-xs text-gray-400">No Image</span>
                                </div>
                            @endif
                            
                            {{-- Badge del voto posizionato in alto a destra sull'immagine --}}
                            <div class="absolute top-2 right-2 bg-black/70 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded">
                                ⭐ {{ $anime->score ?? 'N/A' }}
                            </div>
                        </div>

                        {{-- Corpo della Card compatto --}}
                        <div class="p-3 md:p-4 flex flex-col flex-1">
                            {{-- Titolo limitato a 1 riga --}}
                            <h3 class="font-bold text-sm text-gray-900 line-clamp-1" title="{{ $anime->title }}">
                                {{ $anime->title }}
                            </h3>
                            
                            {{-- Trama limitata a 2 righe, testo più piccolo --}}
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2 flex-1">
                                {{ $anime->synopsis }}
                            </p>

                            {{-- Pulsante dettaglio --}}
                            <div class="mt-3 pt-3 border-t border-gray-100 text-center">
                                <a href="{{ route('anime.show', $anime->mal_id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-wider">
                                    Vedi Dettagli
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginazione --}}
            <div class="mt-8">
                {{ $animes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>