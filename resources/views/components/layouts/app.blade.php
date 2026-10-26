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
        <nav class="bg-[#0b2847] dark:bg-[#040e1a] text-white border-b border-blue-950/50 dark:border-blue-900/30 sticky top-0 z-50"
            x-data="{ open: false }" @keydown.escape.window="open = false">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center w-full">

                    <!-- Côté Gauche : Burger + Logo -->
                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                        <!-- Bouton burger (mobile + tablette uniquement) -->
                        <button @click="open = !open" :aria-expanded="open" aria-label="Menu"
                            class="xl:hidden shrink-0 p-1 rounded-md text-white hover:opacity-75 transition focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                            </svg>
                        </button>

                        <!-- Logo : sur 2 lignes sur petit écran, sur 1 ligne dès sm -->
                        <a href="{{ route('items.index') }}"
                            class="min-w-0 font-extrabold text-xs sm:text-base xl:text-lg leading-tight tracking-wide text-white">
                            <span class="block sm:inline">{{ __('Gare de Wavre') }}</span>
                            <span class="block sm:inline text-[#f97316]">· {{ __('Objets Trouvés') }}</span>
                        </a>
                    </div>

                    <!-- Côté Droit : Sélecteur de Langue & Mode Sombre (Mobile + Tablette avec texte) -->
                    <div class="xl:hidden flex items-center gap-1.5 shrink-0">
                        <!-- Langue -->
                        <div
                            class="flex items-center gap-1 text-[11px] font-semibold bg-white/10 px-2 py-1.5 rounded-xl border border-white/10">
                            <a href="{{ route('lang.switch', 'fr') }}"
                                class="{{ app()->getLocale() == 'fr' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">FR</a>
                            <span class="text-white/40">/</span>
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="{{ app()->getLocale() == 'en' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">EN</a>
                        </div>

                        <!-- Mode Sombre (avec texte visible sur mobile et tablette) -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                            class="flex items-center space-x-1 px-2 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 transition text-white text-xs font-medium whitespace-nowrap">
                            <span x-show="!darkMode" class="flex items-center space-x-1">
                                <span>🌙</span>
                                <span>{{ __('Mode sombre') }}</span>
                            </span>
                            <span x-show="darkMode" class="flex items-center space-x-1 text-amber-300"
                                style="display: none;">
                                <span>☀️</span>
                                <span>{{ __('Mode clair') }}</span>
                            </span>
                        </button>

                    </div>

                    <!-- Menu desktop (grands écrans uniquement) -->
                    <div class="hidden xl:flex items-center space-x-1.5 flex-nowrap">
                        <a href="{{ route('items.index') }}"
                            class="px-2 py-2 rounded-xl text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Objets trouvés') }}
                        </a>
                        <a href="{{ route('items.create') }}"
                            class="px-2 py-2 rounded-xl text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Ajouter un objet') }}
                        </a>
                        <a href="{{ route('claims.index') }}"
                            class="px-2 py-2 rounded-xl text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Déclarations de perte') }}
                        </a>
                        <a href="{{ route('stats.index') }}"
                            class="px-2 py-2 rounded-xl text-sm font-medium hover:bg-white/10 transition whitespace-nowrap">
                            {{ __('Statistiques') }}
                        </a>

                        <a href="{{ route('claims.public.create') }}"
                            class="bg-[#f97316] hover:bg-[#ea580c] text-white px-3 py-2 rounded-xl text-sm font-bold shadow-sm transition whitespace-nowrap">
                            {{ __('Réclamer un objet') }}
                        </a>

                        <!-- Sélecteur de Langue (Desktop) -->
                        <div
                            class="flex items-center gap-1 text-xs font-semibold bg-white/10 px-2 py-1.5 rounded-xl border border-white/10 whitespace-nowrap">
                            <a href="{{ route('lang.switch', 'fr') }}"
                                class="{{ app()->getLocale() == 'fr' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">FR</a>
                            <span class="text-white/40">/</span>
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="{{ app()->getLocale() == 'en' ? 'text-[#f97316] font-bold underline' : 'text-gray-300 hover:text-white' }}">EN</a>
                        </div>

                        <!-- Mode Sombre (Desktop) -->
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
                        <a href="{{ url('/composants') }}"
                            class="px-2 py-2 rounded-xl bg-white/10 hover:bg-white/25 transition text-white text-xs font-medium whitespace-nowrap">
                            {{ __('Composants') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menu déroulant (mobile + tablette - liens uniquement) -->
            <div x-show="open" @click.outside="open = false" x-transition.opacity style="display: none;"
                class="xl:hidden absolute top-16 inset-x-0 max-h-[calc(100vh-4rem)] overflow-y-auto bg-[#0b2847] dark:bg-[#040e1a] border-b border-blue-900/50 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-3 pb-5 space-y-1">
                    <a href="{{ route('items.index') }}"
                        class="block px-3 py-2.5 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Objets trouvés') }}</a>
                    <a href="{{ route('items.create') }}"
                        class="block px-3 py-2.5 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Ajouter un objet') }}</a>
                    <a href="{{ route('claims.index') }}"
                        class="block px-3 py-2.5 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Déclarations de perte') }}</a>
                    <a href="{{ route('stats.index') }}"
                        class="block px-3 py-2.5 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Statistiques') }}</a>

                    <a href="{{ route('claims.public.create') }}"
                        class="block text-center mt-3 bg-[#f97316] hover:bg-[#ea580c] text-white px-4 py-2.5 rounded-xl text-base font-bold transition">
                        {{ __('Réclamer un objet') }}
                    </a>
                    <a href="{{ url('/composants') }}"
                        class="block px-3 py-2.5 rounded-lg text-base font-medium text-blue-100 hover:bg-white/10">{{ __('Composants') }}
                    </a>
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
