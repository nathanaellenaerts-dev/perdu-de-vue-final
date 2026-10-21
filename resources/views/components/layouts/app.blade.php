<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Gare de Wavre · Objets Trouvés') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="h-full bg-gray-50 dark:bg-[#061424] text-gray-900 dark:text-gray-100 transition-colors duration-200 flex flex-col justify-between">

    <div>
        <!-- Navigation -->
        <nav
            class="bg-[#0b2847] dark:bg-[#040e1a] text-white border-b border-blue-950/50 dark:border-blue-900/30 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo avec whitespace-nowrap pour interdire le retour à la ligne -->
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('items.index') }}"
                            class="font-extrabold text-base lg:text-lg tracking-wider text-white whitespace-nowrap">
                            {{ __('Gare de Wavre') }} <span class="text-[#f97316]">· {{ __('Objets Trouvés') }}</span>
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-1.5 flex-nowrap">
                        <a href="{{ route('items.index') }}"
                            class="px-2 py-2 rounded-xl text-xs lg:text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Objets trouvés') }}
                        </a>
                        <a href="{{ route('items.create') }}"
                            class="px-2 py-2 rounded-xl text-xs lg:text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Ajouter un objet') }}
                        </a>
                        <a href="{{ route('claims.index') }}"
                            class="px-2 py-2 rounded-xl text-xs lg:text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Déclarations de perte') }}
                        </a>
                        <a href="{{ route('stats.index') }}"
                            class="px-2 py-2 rounded-xl text-xs lg:text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Statistiques') }}
                        </a>

                        <a href="{{ route('claims.public.create') }}"
                            class="bg-[#f97316] hover:bg-[#ea580c] text-white px-3 py-2 rounded-xl text-xs lg:text-sm font-bold shadow-sm transition whitespace-nowrap">
                            {{ __('Réclamer un objet') }}
                        </a>

                        <!-- Sélecteur de Langue -->
                        <div
                            class="flex items-center gap-1 text-xs font-semibold bg-white/10 px-2 py-1.5 rounded-xl border border-white/10 whitespace-nowrap">
                            <a href="{{ route('lang.switch', 'fr') }}"
                                class="{{ app()->getLocale() == 'fr' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">FR</a>
                            <span class="text-white/40">/</span>
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="{{ app()->getLocale() == 'en' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">EN</a>
                        </div>

                        <!-- Mode Sombre -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                            class="flex items-center space-x-1 px-2 py-2 rounded-xl bg-white/10 hover:bg-white/25 transition text-white text-xs font-medium whitespace-nowrap">
                            <span x-show="!darkMode" class="flex items-center space-x-1">
                                <span>🌙</span>
                                <span>{{ __('Mode sombre') }}</span>
                            </span>
                            <span x-show="darkMode" class="flex items-center space-x-1 text-amber-300">
                                <span>☀️</span>
                                <span>{{ __('Mode clair') }}</span>
                            </span>
                        </button>
                    </div>

                    <!-- Mobile actions (Burger + Toggle Dark) -->
                    <div class="flex md:hidden items-center space-x-2" x-data="{ open: false }">
                        <!-- Sélecteur de Langue Mobile -->
                        <div class="flex items-center gap-1 text-xs font-semibold bg-white/10 px-2 py-1 rounded-lg">
                            <a href="{{ route('lang.switch', 'fr') }}"
                                class="{{ app()->getLocale() == 'fr' ? 'text-[#f97316] font-bold' : 'text-gray-300' }}">FR</a>
                            <span class="text-white/40">/</span>
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="{{ app()->getLocale() == 'en' ? 'text-[#f97316] font-bold' : 'text-gray-300' }}">EN</a>
                        </div>

                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                            class="p-2 rounded-lg text-white hover:bg-white/10 transition">
                            <span x-show="!darkMode">🌙</span>
                            <span x-show="darkMode" class="text-amber-300">☀️</span>
                        </button>

                        <button @click="open = !open" class="p-2 rounded-lg text-white hover:bg-white/10 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                            </svg>
                        </button>

                        <!-- Menu déroulant mobile -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute top-16 left-0 right-0 bg-[#061424] border-b border-blue-900/50 px-4 pt-3 pb-5 space-y-2 shadow-lg"
                            style="display: none;">
                            <a href="{{ route('items.index') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">Objets
                                trouvés</a>
                            <a href="{{ route('items.create') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">Ajouter
                                un objet</a>
                            <a href="{{ route('claims.index') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">Déclarations
                                de perte</a>
                            <a href="{{ route('stats.index') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Statistiques') }}</a>
                            <a href="{{ route('claims.public.create') }}"
                                class="block text-center mt-3 bg-[#f97316] text-white px-4 py-2.5 rounded-xl text-base font-bold">
                                {{ __('Réclamer un objet') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Messages Flash (Succès / Erreur) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if (session('success'))
                <div
                    class="bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl shadow-sm text-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove();"
                        class="text-green-600 hover:text-green-900 font-bold ml-4">×</button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm text-sm flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove();"
                        class="text-red-600 hover:text-red-900 font-bold ml-4">×</button>
                </div>
            @endif
        </div>

        <!-- Contenu principal -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    <footer
        class="bg-white dark:bg-[#040e1a] border-t border-gray-200 dark:border-blue-900/30 py-6 text-center text-xs text-gray-500 dark:text-gray-400">
        {{ __('Gare de Wavre · Service des objets trouvés') }} &copy; {{ date('Y') }}
    </footer>

</body>

</html>
