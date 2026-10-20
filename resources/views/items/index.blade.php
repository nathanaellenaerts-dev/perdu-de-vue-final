<x-layouts.app>
    <div class="space-y-6">

        <!-- En-tête de section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span
                    class="text-xs font-bold uppercase tracking-widest text-[#d97706]">{{ __('Bureau des objets trouvés') }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0b2847] tracking-tight mt-1 dark:text-white">
                    {{ __('Ils attendent leur propriétaire') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1 dark:text-white">
                    {{ __('Les objets ramassés dans le hall, sur les quais et dans les trains, du plus récent au plus ancien.') }}
                </p>
            </div>

            <!-- Compteur et bouton d'ajout -->
            <div class="flex items-center gap-3">
                <div class="bg-[#0b2847] text-white px-5 py-2.5 rounded-xl shadow-sm text-center">
                    <span class="block text-xl font-black">{{ $items->total() }}</span>
                    <span
                        class="block text-[10px] uppercase tracking-wider text-blue-200">{{ __('Objets en attente') }}</span>
                </div>
                <a href="{{ route('items.create') }}"
                    class="bg-[#f97316] hover:bg-[#ea580c] text-white px-4 py-3 rounded-xl font-bold text-sm shadow-sm transition flex items-center gap-1.5">
                    <span>+</span> {{ __('Ajouter un objet') }}
                </a>
            </div>
        </div>

        <!-- Formulaire de filtres, recherche et tri -->
        <form method="GET" action="{{ route('items.index') }}"
            class="bg-white p-5 rounded-2xl shadow-sm border border-amber-900/10 space-y-4">

            <!-- Champ de recherche textuel -->
            <div>
                <label for="q"
                    class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">{{ __('Rechercher un objet') }}</label>
                <input type="text" name="q" id="q" value="{{ request('q') }}"
                    placeholder="{{ __('Ex: Clés, portefeuille, écharpe...') }}"
                    class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-gray-50/50">
            </div>
            <!-- Grille des filtres (Lieu + Couleur + Tri + Boutons) -->
            <div class="flex flex-wrap gap-4 items-end">
                <!-- Lieu -->
                <div class="flex-1 min-w-[200px]">
                    <label for="lieu"
                        class="block text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1.5">{{ __('Lieu') }}</label>
                    <select name="lieu" id="lieu"
                        class="w-full rounded-xl border border-gray-200 dark:border-slate-700 bg-white text-gray-900 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="" class="bg-white text-gray-900">
                            {{ __('Tous les lieux') }}</option>
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}" {{ request('lieu') == $place->id ? 'selected' : '' }}
                                class="bg-white text-gray-900">
                                {{ $place->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Couleur -->
                <div class="flex-1 min-w-[200px]">
                    <label for="couleur"
                        class="block text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1.5">{{ __('Couleur') }}</label>
                    <select name="couleur" id="couleur"
                        class="w-full rounded-xl border border-gray-200 dark:border-slate-700 bg-white text-gray-900 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="" class="bg-white text-gray-900">
                            {{ __('Toutes les couleurs') }}</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->value }}"
                                {{ request('couleur') === $color->value ? 'selected' : '' }}
                                class="bg-white text-gray-900">
                                {{ $color->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sélecteur de Tri -->
                <div class="flex-1 min-w-[200px]">
                    <label for="tri"
                        class="block text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-1.5">{{ __('Trier par') }}</label>
                    <select name="tri" id="tri"
                        class="w-full rounded-xl border border-gray-200 dark:border-slate-700 bg-white text-gray-900 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="date-desc" {{ request('tri') === 'date-desc' ? 'selected' : '' }}
                            class="bg-white text-gray-900">
                            {{ __('Plus récents d\'abord') }}</option>
                        <option value="date-asc" {{ request('tri') === 'date-asc' ? 'selected' : '' }}
                            class="bg-white text-gray-900">
                            {{ __('Plus anciens d\'abord') }}</option>
                        <option value="name-asc" {{ request('tri') === 'name-asc' ? 'selected' : '' }}
                            class="bg-white text-gray-900">{{ __('Nom (A - Z)') }}
                        </option>
                        <option value="name-desc" {{ request('tri') === 'name-desc' ? 'selected' : '' }}
                            class="bg-white text-gray-900">{{ __('Nom (Z - A)') }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-[#0b2847] hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">
                    {{ __('Filtrer') }}
                </button>

                <!-- LE CODE DE RÉINITIALISATION SE PLACE ICI -->
                @if (request()->anyFilled(['q', 'lieu', 'couleur', 'tri']))
                    <a href="{{ route('items.index') }}"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition flex items-center">
                        {{ __('Réinitialiser') }}
                    </a>
                @endif
            </div>
    </div>
    </form>

    <!-- Grille des cartes d'objets -->
    @if ($items->isEmpty())
        <p class="p-8 text-center text-gray-500 bg-white rounded-2xl border border-amber-900/10">
            {{ __('Aucun objet trouvé avec ces critères.') }}</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($items as $item)
                <x-item-card :item="$item" />
            @endforeach
        </div>

        <!-- Liens de pagination -->
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    @endif

    </div>
</x-layouts.app>
