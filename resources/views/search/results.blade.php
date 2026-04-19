<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Risultati per: <span class="text-orange-500">"{{ $query }}"</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($query === '')
                <div class="text-center py-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Inserisci un termine di ricerca</h3>
                    <p class="text-gray-600">Cerca anime e manga per titolo</p>
                </div>
            @elseif($animes->isEmpty() && $mangas->isEmpty())
                <div class="text-center py-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nessun risultato trovato</h3>
                    <p class="text-gray-600">Prova con un altro termine di ricerca</p>
                </div>
            @else
                @if($animes->isNotEmpty())
                    <div class="mb-12">
                        <h3 class="text-2xl font-bold mb-6">Anime</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                            @foreach($animes as $anime)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col group">
                                    <div class="relative overflow-hidden aspect-[2/3] bg-gray-100">
                                        @if($anime->image_url)
                                            <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                        <div class="absolute top-2 right-2 bg-black/70 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded">
                                            ⭐ {{ $anime->score ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="p-3 md:p-4 flex flex-col flex-1">
                                        <h3 class="font-bold text-sm text-gray-900 line-clamp-1" title="{{ $anime->title }}">
                                            {{ $anime->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2 flex-1">
                                            {{ $anime->synopsis }}
                                        </p>
                                        <div class="mt-3 pt-3 border-t border-gray-100 text-center">
                                            <a href="{{ route('anime.show', $anime->mal_id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-wider">
                                                Vedi Dettagli
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($mangas->isNotEmpty())
                    <div>
                        <h3 class="text-2xl font-bold mb-6">Manga</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                            @foreach($mangas as $manga)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col group">
                                    <div class="relative overflow-hidden aspect-[2/3] bg-gray-100">
                                        @if($manga->image_url)
                                            <img src="{{ $manga->image_url }}" alt="{{ $manga->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                        <div class="absolute top-2 right-2 bg-black/70 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded">
                                            ⭐ {{ $manga->score ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="p-3 md:p-4 flex flex-col flex-1">
                                        <h3 class="font-bold text-sm text-gray-900 line-clamp-1" title="{{ $manga->title }}">
                                            {{ $manga->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2 flex-1">
                                            {{ $manga->synopsis }}
                                        </p>
                                        <div class="mt-3 pt-3 border-t border-gray-100 text-center">
                                            <a href="{{ route('manga.show', $manga->mal_id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-wider">
                                                Vedi Dettagli
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
