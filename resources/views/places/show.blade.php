<x-layouts.app>
    <div class="space-y-6">

        <div>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition inline-flex items-center gap-1">
                {{ __('← Retour à la liste') }}
            </a>
        </div>

        <!-- En-tête du lieu -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $place->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Sorte :') }} <span class="font-medium text-gray-700">{{ $place->kind->label() }}</span>
                </p>
            </div>
            <span class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">
                {{ $place->items->count() }} objet(s) au total
            </span>
        </div>

        <!-- Liste de tous les objets du lieu (restitués compris) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <h2 class="p-4 bg-gray-50 border-b border-gray-200 font-semibold text-gray-700">
                {{ __('Objets associés à ce lieu') }}
            </h2>

            @if($place->items->isEmpty())
                <p class="p-6 text-center text-gray-500">{{ __('Aucun objet recensé dans ce lieu.') }}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">{{ __('Objet') }}</th>
                                <th class="px-6 py-3">{{ __('Statut') }}</th>
                                <th class="px-6 py-3">{{ __('Couleur') }}</th>
                                <th class="px-6 py-3">{{ __('Date de découverte') }}</th>
                                <th class="px-6 py-3">{{ __('Étiquettes') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                            @foreach($place->items as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:underline">
                                            {{ $item->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->isReturned())
                                            <x-badge type="success">{{ __('Restitué') }}</x-badge>
                                        @else
                                            <x-badge type="warning">{{ __('En attente') }}</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-color-badge :color="$item->color" />
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        {{ $item->found_on->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($item->tags as $tag)
                                                <x-badge>{{ $tag->name }}</x-badge>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-layouts.app>
