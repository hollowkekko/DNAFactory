<footer class="bg-gray-900 dark:bg-black border-t border-gray-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo & Description -->
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center">
                    <span class="text-xl font-bold">
                        <span class="text-orange-500">DNA</span><span class="text-white">nime</span>
                    </span>
                </a>
                <p class="mt-2 text-sm text-gray-400">
                    Scopri i tuoi anime e manga preferiti.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-200 mb-4">Esplora</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('anime.index') }}" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                            Anime
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manga.index') }}" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                            Manga
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('favorites.index') }}" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                            I miei Preferiti
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-sm font-semibold text-gray-200 mb-4">Account</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                            Profilo
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-400 hover:text-white hover:underline transition">
                                Esci
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-800"></div>

        <!-- Bottom Section -->
        <div class="py-8 flex flex-col md:flex-row items-center gap-4">
            <p class="text-xs text-gray-500 text-center md:text-left">
                © {{ date('Y') }} DNAnime. Dati forniti da <a href="https://jikan.moe" target="_blank" class="text-gray-400 hover:text-white underline">Jikan API</a>
            </p>
        </div>
    </div>
</footer>
