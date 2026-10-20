<x-layouts.app>
    <div class="max-w-2xl mx-auto space-y-6 bg-white p-8 rounded-2xl shadow-sm border border-amber-900/10">
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-[#d97706]">{{ __('Service voyageur') }}</span>
            <h2 class="text-3xl font-extrabold text-[#0b2847] tracking-tight mt-1">{{ __('Déclarer un objet perdu') }}</h2>
            <p class="text-sm text-gray-600 mt-1">{{ __("Vous avez perdu un effet personnel dans les gares ou les trains de Wavre ? Remplissez ce formulaire.") }}</p>
        </div>

        @if (session('success'))
            <div class="bg-green-50 text-green-800 p-4 rounded-xl text-sm font-medium border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('claims.public.store') }}" method="POST" class="space-y-4" novalidate>
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                    <p class="font-bold">{{ __('Veuillez corriger les erreurs suivantes :') }}</p>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __('Votre nom') }}</label>
                    <input type="text" name="traveler_name" value="{{ old('traveler_name') }}" required
                        class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('traveler_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __('Votre email') }}</label>
                    <input type="email" name="traveler_email" value="{{ old('traveler_email') }}" required
                        class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('traveler_email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __('Téléphone (optionnel)') }}</label>
                    <input type="text" name="traveler_phone" value="{{ old('traveler_phone') }}"
                        class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __('Date de la perte') }}</label>
                    <input type="date" name="lost_on" value="{{ old('lost_on') }}" required
                        class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('lost_on')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __("Nom de l'objet (ex: Portefeuille cuir marron)") }}</label>
                <input type="text" name="item_name" value="{{ old('item_name') }}" required
                    class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('item_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">{{ __('Description détaillée') }}</label>
                <textarea name="description" rows="4" required
                    class="w-full rounded-xl border-gray-200 border px-3.5 py-2.5 text-sm text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit"
                    class="bg-[#f97316] hover:bg-[#ea580c] text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow-sm">
                    {{ __('Soumettre ma déclaration') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
