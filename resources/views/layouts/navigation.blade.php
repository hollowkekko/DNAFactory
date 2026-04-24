<nav x-data="{ mobileMenuOpen: false, searchOpen: false, profileMenuOpen: false }" 
     class="bg-black/40 backdrop-blur-lg border-b border-white/5 sticky top-0 z-50 transition-all duration-300">    <div class="w-full px-4 sm:px-6 lg:px-12">
        <div class="flex justify-between h-16 items-center">

            {{-- LATO SINISTRO: Logo e Link Principali --}}
            <div class="flex items-center space-x-8">
                
                {{-- Logo DNAnime --}}
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-1.5 shrink-0 hover:opacity-80 transition group">
                    {{-- Icona astratta DNA/Cross --}}
                    <svg class="w-6 h-6 text-[#FF6600] transform group-hover:rotate-90 transition-transform duration-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L15 8H9L12 2Z" />
                        <path d="M22 12L16 15V9L22 12Z" />
                        <path d="M12 22L9 16H15L12 22Z" />
                        <path d="M2 12L8 9V15L2 12Z" />
                    </svg>
                    <span class="text-xl font-black tracking-tight"><span class="text-[#FF6600]">DNA</span><span class="text-white">nime</span></span>
                </a>

                {{-- Navigation Links (Desktop) --}}
                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-gray-300">
                    <a href="#" class="hover:text-white transition">Novità</a>
                    <a href="#" class="hover:text-white transition">Popolari</a>
                    
                    {{-- Dropdown Categorie (Gestito con Alpine per animazioni fluide) --}}
                    <div class="relative" x-data="{ catOpen: false }" @mouseenter="catOpen = true" @mouseleave="catOpen = false">
                        
                        <button class="flex items-center hover:text-white transition focus:outline-none py-4">
                            Categorie
                            <svg class="w-4 h-4 ml-1 opacity-70 transition-transform duration-300" :class="catOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Il Pannello Dropdown Categorie (Glassmorphism + Griglia) --}}
                        <div x-show="catOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute left-0 top-full mt-[-8px] w-[380px] bg-[#141414]/90 backdrop-blur-xl border border-gray-700/60 rounded-2xl shadow-2xl overflow-hidden font-medium text-sm text-gray-300 z-50 p-5" style="display: none;">
                            
                            {{-- Titolo sezione --}}
                            <div class="mb-4 pb-2 border-b border-gray-700/60 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Sfoglia per Genere
                            </div>

                            {{-- Griglia a 2 colonne --}}
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Azione</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Avventura</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Commedia</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Drammatico</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Fantasy</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Fantascienza</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Horror</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Romantico</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Thriller</a>
                                <a href="#" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white transition flex items-center"> Slice of Life</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LATO DESTRO: Icone e Profilo Utente --}}
            <div class="flex items-center space-x-5 text-gray-300">
                
                {{-- Cerca (Solo Icona) --}}
                <button class="hover:text-white transition p-1 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>

                @auth
                    {{-- Segnalibri / Preferiti --}}
                    <a href="{{ route('favorites.index') }}" class="hover:text-white transition p-1 hidden sm:block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </a>

                    {{-- Menu Utente Dropdown (Stile Mockup) --}}
                    <div class="relative pl-2">
                        <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="flex items-center space-x-2 focus:outline-none group">
                            
                            {{-- Avatar con Pallino Rosso Notifica --}}
                            <div class="relative">
                                <img class="h-8 w-8 rounded-full object-cover border border-gray-700 group-hover:border-[#FF6600] transition" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=111111" alt="Avatar">
                                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-red-600 rounded-full border border-black"></span>
                            </div>
                            
                            {{-- Freccina Giù --}}
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-white transition transform" :class="profileMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Il Pannello Dropdown Glassmorphism --}}
                        <div x-show="profileMenuOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-4 w-64 bg-[#141414]/85 backdrop-blur-xl border border-gray-700/60 rounded-2xl shadow-2xl overflow-hidden font-medium text-sm text-gray-300 z-50" style="display: none;">
                            
                            {{-- Header Profilo --}}
                            <div class="px-5 py-4 flex items-center justify-between bg-white/5">
                                <div class="flex items-center space-x-3">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-600" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=111111" alt="Avatar">
                                    <div class="flex flex-col">
                                        <span class="text-white font-bold tracking-wide">{{ Auth::user()->name }}</span>
                                        <span class="text-yellow-500 text-[10px] uppercase font-bold flex items-center mt-0.5">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-.966.744H8a1 1 0 01-.967-.744l-1.18-4.455-3.354-1.935a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 018 2h4zm-1.288 2.502L9.828 7.64l-3.081 1.778 2.112 2.64-1.077 4.062h4.436l-1.077-4.062 2.112-2.64-3.081-1.778-1.288-3.138z" clip-rule="evenodd"></path></svg>
                                            Premium
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="text-gray-400 hover:text-white p-1 rounded transition hover:bg-white/10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>

                            <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>

                            {{-- Lista Link --}}
                            <div class="py-2">
                                <a href="#" class="flex items-center px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    Cambia profilo
                                </a>
                                <a href="#" class="flex items-center px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Impostazioni
                                </a>
                                <a href="{{ route('favorites.index') }}" class="flex items-center px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                    Salvati per dopo
                                </a>
                                <a href="#" class="flex items-center px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Cronologia
                                </a>
                                
                                {{-- Link Notifiche con Badge --}}
                                <a href="#" class="flex items-center justify-between px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        Notifiche
                                    </div>
                                    <span class="bg-red-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-md leading-none">99</span>
                                </a>

                                <a href="#" class="flex items-center px-5 py-2.5 hover:bg-white/10 hover:text-white transition">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                    Gift Card
                                </a>
                            </div>

                            <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>

                            {{-- Esci --}}
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-5 py-3 hover:bg-white/10 hover:text-white transition text-gray-400">
                                        <svg class="w-4 h-4 mr-3 opacity-70 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Esci
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Non Loggato --}}
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-white transition">Accedi</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-[#FF6600] hover:bg-[#FF8533] text-white rounded-md px-4 py-1.5 transition ml-4">Registrati</a>
                @endauth

                {{-- Hamburger Menu (Mobile) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-400 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Mobile Espanso --}}
    <div x-show="mobileMenuOpen" class="lg:hidden border-t border-white/10 bg-black/95 backdrop-blur-md" style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-white/10">Novità</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5 transition">Popolari</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5 transition">Categorie</a>
            
            @auth
                <div class="border-t border-gray-800 my-2"></div>
                <a href="{{ route('favorites.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5 transition">Salvati per dopo</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5 transition">Impostazioni Profilo</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-500 hover:text-red-400 hover:bg-white/5 transition">Esci</button>
                </form>
            @endauth
        </div>
    </div>
</nav>