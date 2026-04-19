<nav x-data="{ open: false }" class="bg-black border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- LATO SINISTRO: Logo e Link --}}
            <div class="flex items-center">
                {{-- Logo DNAnime --}}
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold tracking-tighter">
                        <span class="text-orange-500">DNA</span><span class="text-white">nime</span>
                    </a>
                </div>

                {{-- Navigation Links (Desktop) --}}
                <div class="hidden space-x-6 sm:flex text-sm font-medium">
                    <a href="{{ route('anime.index') }}" class="text-gray-300 hover:text-white transition">Anime</a>
                    
                    <a href="#" class="text-gray-300 hover:text-white transition">Novità</a>
                    <a href="#" class="text-gray-300 hover:text-white transition">Popolari</a>
                </div>
            </div>

            {{-- LATO DESTRO: Icone --}}
            <div class="hidden sm:flex items-center space-x-4">
                
                {{-- Icona Cerca --}}
                <button class="text-gray-300 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>

                {{-- Icona Preferiti (Segnalibro) - Lo colleghiamo subito alla rotta che creeremo --}}
                <a href="{{ route('favorites.index') }}" class="text-gray-300 hover:text-orange-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </a>

                {{-- Dropdown Profilo Utente --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition ml-2">
                            <img class="h-8 w-8 rounded-full object-cover border border-gray-600" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Avatar">
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profilo') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Esci') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>