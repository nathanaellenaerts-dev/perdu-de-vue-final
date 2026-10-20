<x-layouts.app>
    <div class="max-w-4xl mx-auto space-y-6">

        <a href="{{ route('claims.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition inline-flex items-center gap-1">
            {{ __('← Retour à la liste des déclarations') }}
        </a>

        <div class="bg-white dark:bg-[#0b2847] p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-blue-900/30 space-y-6">

            <!-- Déclaration du voyageur -->
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-orange-500">{{ __('Déclaration de perte voyageur') }}</span>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $claim->title }}</h1>
                <p class="text-xs text-gray-400 mt-1">{{ __('Reçue le') }} {{ $claim->created_at->format('d/m/Y H:i') }}</p>

                <div class="mt-4 p-4 bg-gray-50 dark:bg-[#040e1a] rounded-xl text-sm text-gray-700 dark:text-gray-300">
                    {{ $claim->description }}
                </div>

                @if($claim->email || $claim->phone)
                    <div class="mt-3 text-xs text-gray-500 flex gap-4">
                        @if($claim->email) <span>📧 {{ $claim->email }}</span> @endif
                        @if($claim->phone) <span>📞 {{ $claim->phone }}</span> @endif
                    </div>
                @endif
            </div>

            <!-- Bloc de Rapprochement / Match -->
            <div class="pt-6 border-t border-gray-100 dark:border-blue-900/30">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white mb-3">{{ __('Rapprochement avec un objet trouvé en stock') }}</h2>

                @if($claim->item)
                    <!-- Déjà matché -->
                    <div class="p-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase text-green-600 dark:text-green-400">{{ __('Objet Matché !') }}</span>
                            <h3 class="font-bold text-gray-900 dark:text-white mt-1">
                                {{ $claim->item->name }} (N° {{ str_pad($claim->item->id, 4, '0', STR_PAD_LEFT) }})
                            </h3>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('items.show', $claim->item) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                {{ __('Voir la fiche objet →') }}
                            </a>

                            <form action="{{ route('claims.unlink', $claim) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium px-3 py-1.5 bg-white dark:bg-[#040e1a] border border-red-200 dark:border-red-900 rounded-lg">
                                    {{ __('Défaire le match') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Choisir l'objet à matcher -->
                    <form action="{{ route('claims.link', $claim) }}" method="POST" class="flex items-end gap-3 p-4 bg-gray-50 dark:bg-[#040e1a] rounded-xl border border-dashed border-gray-300 dark:border-blue-900/50">
                        @csrf
                        @method('PATCH')

                        <div class="flex-1">
                            <label for="item_id" class="block text-xs font-semibold text-gray-500 mb-1">{{ __('Sélectionner un objet trouvé dans le stock :') }}</label>
                            <select name="item_id" id="item_id" class="w-full rounded-xl border-gray-300 dark:border-blue-900/50 dark:bg-[#061424] text-sm" required>
                                <option value="">{{ __('-- Choisir un objet --') }}</option>
                                @foreach($availableItems as $item)
                                    <option value="{{ $item->id }}">
                                        N° {{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }} - {{ $item->name }} (Trouvé le {{ $item->found_on?->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-[#f97316] hover:bg-[#ea580c] text-white font-bold px-4 py-2 rounded-xl text-sm transition">
                            {{ __('Faire le match') }}
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-layouts.app>
