<nav x-data="{ open: false, searchOpen: false }" class="bg-black border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- LATO SINISTRO: Logo e Link --}}
            <div class="flex items-center flex-1">
                {{-- Logo DNAnime --}}
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold tracking-tighter hover:opacity-80 transition">
                        <span class="text-orange-500">DNA</span><span class="text-white">nime</span>
                    </a>
                </div>

                {{-- Navigation Links (Desktop) --}}
                <div class="hidden space-x-1 lg:flex text-sm font-medium">
                    <a href="{{ route('anime.index') }}" class="text-gray-300 hover:text-white hover:bg-gray-900 transition px-3 py-2 rounded-md">
                        🎬 Anime
                    </a>
                    <a href="{{ route('manga.index') }}" class="text-gray-300 hover:text-white hover:bg-gray-900 transition px-3 py-2 rounded-md">
                        📖 Manga
                    </a>
                </div>
            </div>

            {{-- CENTRO: Barra di Ricerca (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-xs mx-4">
                <form action="{{ route('search.index') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input
                            type="text"
                            name="q"
                            placeholder="Cerca anime o manga..."
                            class="w-full bg-gray-900 text-white text-sm rounded-full pl-4 pr-10 py-2 border border-gray-700 focus:border-orange-500 focus:outline-none transition"
                            value="{{ request('q') }}"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- LATO DESTRO: Icone e Menu --}}
            <div class="flex items-center space-x-2 sm:space-x-4">

                {{-- Ricerca Mobile --}}
                <button @click="searchOpen = !searchOpen" class="lg:hidden text-gray-300 hover:text-white transition p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                @auth
                    {{-- Icona Preferiti (Solo se loggato) --}}
                    <a href="{{ route('favorites.index') }}" class="text-gray-300 hover:text-orange-500 transition p-2" title="I miei preferiti">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </a>

                    {{-- Dropdown Profilo Utente --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition">
                                <img class="h-8 w-8 rounded-full object-cover border border-gray-600" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Avatar">
                                <span class="hidden sm:inline ml-2 text-xs">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                👤 {{ __('Profilo') }}
                            </x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 {{ __('Esci') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Login e Registrazione (Non loggato) --}}
                    <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white transition px-3 py-2">
                        Accedi
                    </a>
                    <a href="{{ route('register') }}" class="text-sm bg-orange-600 hover:bg-orange-500 text-white rounded-full px-4 py-2 transition font-medium">
                        Registrati
                    </a>
                @endauth

                {{-- Menu Mobile Toggle --}}
                <button @click="open = !open" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-gray-900 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Ricerca Mobile Dropdown --}}
    <div x-show="searchOpen" class="border-t border-gray-800 bg-gray-950 px-4 py-4 lg:hidden" style="display: none;">
        <form action="{{ route('search.index') }}" method="GET">
            <input
                type="text"
                name="q"
                placeholder="Cerca anime o manga..."
                class="w-full bg-gray-900 text-white text-sm rounded-lg pl-4 pr-4 py-2 border border-gray-700 focus:border-orange-500 focus:outline-none transition"
                value="{{ request('q') }}"
            >
        </form>
    </div>

    {{-- Mobile Navigation Menu --}}
    <div x-show="open" class="border-t border-gray-800 lg:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('anime.index') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                🎬 Anime
            </a>
            <a href="{{ route('manga.index') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                📖 Manga
            </a>

            @auth
                <div class="border-t border-gray-700 my-2"></div>
                <a href="{{ route('favorites.index') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                    ❤️ I miei preferiti
                </a>
                <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                    👤 Profilo
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                        🚪 Esci
                    </button>
                </form>
            @else
                <div class="border-t border-gray-700 my-2"></div>
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-900 transition">
                    Accedi
                </a>
                <a href="{{ route('register') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium bg-orange-600 hover:bg-orange-500 transition text-center">
                    Registrati
                </a>
            @endauth
        </div>
    </div>
</nav>
