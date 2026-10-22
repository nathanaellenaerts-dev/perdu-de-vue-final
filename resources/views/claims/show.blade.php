<x-layouts.app>
    <div class="max-w-4xl mx-auto space-y-6">

        <a href="{{ route('claims.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition inline-flex items-center gap-1">
            {{ __('← Retour à la liste des déclarations') }}
        </a>

        <!-- Carte principale blanche -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200 space-y-6">

            <!-- Déclaration du voyageur -->
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-orange-500">{{ __('Déclaration de perte voyageur') }}</span>
                <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $claim->item_name }}</h1>

                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 mt-1">
                    <span>{{ __('Reçue le') }} {{ $claim->created_at->format('d/m/Y H:i') }}</span>

                    @if($claim->lost_on)
                        <span>•</span>
                        <span>{{ __('Objet perdu le') }} {{ \Carbon\Carbon::parse($claim->lost_on)->format('d/m/Y') }}</span>
                    @endif

                    @if($claim->traveler_name)
                        <span>•</span>
                        <span>{{ __('Par') }} <strong class="text-gray-800">{{ $claim->traveler_name }}</strong></span>
                    @endif
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded-xl text-sm text-gray-800 border border-gray-100">
                    {{ $claim->description }}
                </div>

                @if($claim->traveler_email || $claim->traveler_phone)
                    <div class="mt-3 text-xs text-gray-600 flex flex-wrap gap-4">
                        @if($claim->traveler_email)
                            <a href="mailto:{{ $claim->traveler_email }}" class="hover:underline text-blue-600">
                                📧 {{ $claim->traveler_email }}
                            </a>
                        @endif
                        @if($claim->traveler_phone)
                            <a href="tel:{{ $claim->traveler_phone }}" class="hover:underline text-blue-600">
                                📞 {{ $claim->traveler_phone }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Bloc de Rapprochement / Match -->
            <div class="pt-6 border-t border-gray-100">
                <h2 class="text-sm font-bold text-gray-900 mb-3">{{ __('Rapprochement avec un objet trouvé en stock') }}</h2>

                @if($claim->item)
                    <!-- Déjà matché -->
                    <div class="p-4 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase text-green-700">{{ __('Objet Matché !') }}</span>
                            <h3 class="font-bold text-gray-900 mt-1">
                                {{ $claim->item->name }} (N° {{ str_pad($claim->item->id, 4, '0', STR_PAD_LEFT) }})
                            </h3>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('items.show', $claim->item) }}" class="text-sm text-blue-600 hover:underline font-medium">
                                {{ __('Voir la fiche objet →') }}
                            </a>

                            <form action="{{ route('claims.unlink', $claim) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium px-3 py-1.5 bg-white border border-red-200 rounded-lg">
                                    {{ __('Défaire le match') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Choisir l'objet à matcher (style identique à la capture d'écran) -->
                    <form action="{{ route('claims.link', $claim) }}" method="POST" class="flex items-end gap-3 p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                        @csrf
                        @method('PATCH')

                        <div class="flex-1">
                            <label for="item_id" class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Nom de l\'objet / Sélectionner un objet') }}</label>
                            <select name="item_id" id="item_id" class="w-full rounded-xl border-gray-300 bg-white text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 shadow-sm" required>
                                <option value="" class="text-gray-500">{{ __(' Choisir un objet ') }}</option>
                                @foreach($availableItems as $item)
                                    <option value="{{ $item->id }}" class="text-gray-900 bg-white">
                                        N° {{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }} - {{ $item->name }} (Trouvé le {{ $item->found_on?->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-[#f97316] hover:bg-[#ea580c] text-white font-bold px-4 py-2 rounded-xl text-sm transition shadow-sm h-[38px]">
                            {{ __('Faire le match') }}
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-layouts.app>
