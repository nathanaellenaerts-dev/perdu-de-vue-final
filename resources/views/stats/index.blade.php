<x-layouts.app>
    <div class="space-y-8 max-w-5xl mx-auto">

        <!-- En-tête -->
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-[#d97706]">{{ __('Tableau de bord') }}</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0b2847] dark:text-white tracking-tight mt-1">
                {{ __('Statistiques des objets trouvés') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1 dark:text-white">
                {{ __('Vue d\'ensemble de la répartition des objets par emplacement et par période.') }}
            </p>
        </div>

        <!-- Grille des statistiques (2 colonnes) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- 1. Répartition par Lieu -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-900/10 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="font-bold text-gray-900 text-base">{{ __('Objets par lieu') }}</h3>
                    <span class="text-xs bg-sky-50 text-sky-800 font-semibold px-2.5 py-1 rounded-full">Total : {{ $totalItems }}</span>
                </div>

                <div class="space-y-4">
                    @forelse($itemsByPlace as $place)
                        @php
                            // Calcul du pourcentage pour la largeur de la barre Tailwind
                            $percent = $totalItems > 0 ? ($place->items_count / $totalItems) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1">
                                <span>{{ $place->name }}</span>
                                <span class="text-gray-500">{{ $place->items_count }} obj. ({{ round($percent) }}%)</span>
                            </div>
                            <!-- Barre de progression Tailwind pure -->
                            <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                                <div class="bg-[#0b2847] h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">{{ __('Aucun lieu enregistré.') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- 2. Répartition par Mois -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-900/10 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="font-bold text-gray-900 text-base">{{ __('Évolution mensuelle') }}</h3>
                    <span class="text-xs bg-amber-50 text-amber-800 font-semibold px-2.5 py-1 rounded-full">{{ __('Derniers mois') }}</span>
                </div>

                @php
                    // Trouver le mois avec le plus grand nombre d'objets pour calibrer les barres proportionnellement
                    $maxMonthCount = $itemsByMonth->max('total') ?: 1;
                @endphp

                <div class="space-y-4">
                    @forelse($itemsByMonth as $stat)
                        @php
                            $percentMonth = ($stat->total / $maxMonthCount) * 100;
                            // Formatage propre du mois (ex: "2026-10" -> "Octobre 2026")
                            $formattedMonth = \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->locale(app()->getLocale())->isoFormat('MMMM YYYY');
                        @endphp
                        <div>
                            <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1 capitalize">
                                <span>{{ $formattedMonth }}</span>
                                <span class="text-gray-500">{{ $stat->total }} objets</span>
                            </div>
                            <!-- Barre de progression orange Tailwind pure -->
                            <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                                <div class="bg-[#f97316] h-full rounded-full transition-all duration-500" style="width: {{ $percentMonth }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">{{ __('Aucune donnée mensuelle disponible.') }}</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-layouts.app>
