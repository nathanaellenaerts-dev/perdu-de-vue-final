<x-layouts.app>
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Navigation retour -->
        <div>
            <a href="{{ route('items.index') }}"
                class="text-sm text-gray-500 hover:text-blue-600 transition inline-flex items-center gap-1">
                {{ __('← Retour à la liste des objets') }}
            </a>
        </div>

        <!-- Layout principal en grille 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- COLONNE GAUCHE : Informations de l'objet (7 cols) -->
            <div class="lg:col-span-7 bg-white p-8 rounded-xl shadow-sm border border-gray-200 space-y-6">

                <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $item->name }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ __('Date de découverte') }} {{ $item->found_on->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <x-color-badge :color="$item->color" />
                    </div>
                </div>

                <!-- Statut de restitution -->
                <div>
                    <h2 class="text-xs font-semibold uppercase text-gray-400 tracking-wider mb-2">{{ __('Statut') }}</h2>
                    @if ($item->isReturned())
                        <x-badge type="success">
                            {{ __('Restitué le') }} {{ $item->returned_at->format('d/m/Y') }}
                        </x-badge>
                    @else
                        <x-badge type="warning">{{ __('En attente de restitution') }}</x-badge>
                    @endif
                </div>

                <!-- Lieu de découverte -->
                <div>
                    <h2 class="text-xs font-semibold uppercase text-gray-400 tracking-wider mb-1">{{ __('Lieu de découverte') }}
                    </h2>
                    <a href="{{ route('places.show', $item->place) }}"
                        class="text-lg font-medium text-blue-600 hover:underline">
                        {{ $item->place->name }} ({{ $item->place->kind->label() }})
                    </a>
                </div>

                <!-- Description -->
                <div>
                    <h2 class="text-xs font-semibold uppercase text-gray-400 tracking-wider mb-1">{{ __('Description') }}</h2>
                    <p class="text-gray-700 whitespace-pre-line">
                        {{ $item->description ?? 'Aucune description fournie.' }}
                    </p>
                </div>

                <!-- Étiquettes -->
                <div>
                    <h2 class="text-xs font-semibold uppercase text-gray-400 tracking-wider mb-2">{{ __('Étiquettes') }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($item->tags as $tag)
                            <x-badge>{{ $tag->name }}</x-badge>
                        @empty
                            <span class="text-sm text-gray-400">{{ __('Aucune étiquette') }}</span>
                        @endforelse
                    </div>
                </div>

                <!-- Actions (Restituer, Modifier, Supprimer) -->
                <div class="pt-6 border-t border-gray-100 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex gap-2 items-center">
                        @if (!$item->isReturned())
                            <form action="{{ route('items.return', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    {{ __('Restituer l\'objet') }}
                                </button>
                            </form>
                        @else
                            <span
                                class="text-sm text-green-700 font-medium bg-green-50 px-3 py-1.5 rounded-lg border border-green-200">
                                {{ __('Déjà restitué le') }} {{ $item->returned_at->format('d/m/Y') }}
                            </span>
                        @endif

                        <a href="{{ route('items.edit', $item) }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            {{ __('Modifier') }}
                        </a>
                    </div>

                    <!-- Suppression avec confirmation -->
                    <form action="{{ route('items.destroy', $item) }}" method="POST"
                        onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet objet ?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-600 hover:text-red-800 text-sm font-medium px-3 py-2 rounded hover:bg-red-50 transition">
                            {{ __('Supprimer l\'objet') }}
                        </button>
                    </form>
                </div>

            </div>

            <!-- COLONNE DROITE : Galerie de Photos (5 cols) -->
            <div class="lg:col-span-5 bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <h2 class="text-xs font-semibold uppercase text-gray-400 tracking-wider">
                    Photos ({{ $item->photos->count() }})
                </h2>

                @if ($item->photos->count() > 0)
                    <div class="space-y-3">
                        @foreach ($item->photos as $photo)
                            <div
                                class="relative w-full h-64 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm group">

                                <!-- Image -->
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                <!-- Badge de couverture -->
                                @if ($photo->is_cover)
                                    <span
                                        class="absolute top-3 left-3 bg-amber-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow">
                                        {{ __('Couverture') }}
                                    </span>
                                @endif

                                <!-- Bouton de suppression (apparaît au survol) -->
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST"
                                    onsubmit="return confirm('{{ __('Voulez-vous vraiment supprimer cette photo ?') }}');"
                                    class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-md transition flex items-center justify-center"
                                        title="Supprimer cette photo">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="w-full h-64 rounded-lg bg-gray-50 border border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 p-4">
                        <span class="text-3xl mb-2">📷</span>
                        <span class="text-sm">{{ __('Aucune photo disponible') }}</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layouts.app>
