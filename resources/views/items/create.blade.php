<x-layouts.app>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- En-tête de la page -->
        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-[#d97706]">{{ __('Nouvelle fiche') }}</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#0b2847] tracking-tight mt-1 dark:text-white">
                {{ __('Ajouter un objet') }}
            </h1>
            <p class="text-sm text-gray-600 mt-1 dark:text-white">
                {{ __('L\'objet apparaît dans la liste dès l\'enregistrement.') }}
            </p>
        </div>

        <!-- Carte du formulaire -->
        <x-card class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-amber-900/10 space-y-6">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                novalidate>
                @csrf

                <!-- Nom de l'objet -->
                <div>
                    <label for="name"
                        class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Nom de l\'objet') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        @class([
                            'w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition',
                            'border-red-600 bg-red-50/30' => $errors->has('name'),
                            'border-gray-300' => !$errors->has('name'),
                        ]) maxlength="60">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ligne Couleur + Trouvé le (2 colonnes sur tablette/PC) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Couleur -->
                    <div>
                        <label for="color"
                            class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Couleur') }}</label>
                        <select name="color" id="color" @class([
                            'w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white transition',
                            'border-red-600 bg-red-50/30 text-red-900' => $errors->has('color'),
                            'border-gray-300' => !$errors->has('color'),
                        ])>
                            <option value="">{{ __('Choisir une couleur') }}</option>
                            @foreach (\App\Enums\Color::cases() as $color)
                                <option value="{{ $color->value }}"
                                    {{ old('color') === $color->value ? 'selected' : '' }}>
                                    {{ $color->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('color')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trouvé le -->
                    <div>
                        <label for="found_on"
                            class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Trouvé le') }}</label>
                        <input type="date" name="found_on" id="found_on" value="{{ old('found_on') }}"
                            @class([
                                'w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition',
                                'border-red-600 bg-red-50/30 text-red-900' => $errors->has('found_on'),
                                'border-gray-300' => !$errors->has('found_on'),
                            ])>
                        @error('found_on')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lieu -->
                <div>
                    <label for="place_id"
                        class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Lieu') }}</label>
                    <select name="place_id" id="place_id" @class([
                        'w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white transition',
                        'border-red-600 bg-red-50/30 text-red-900' => $errors->has('place_id'),
                        'border-gray-300' => !$errors->has('place_id'),
                    ])>
                        <option value="">{{ __('Choisir un lieu') }}</option>
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}" {{ old('place_id') == $place->id ? 'selected' : '' }}>
                                {{ $place->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('place_id')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Photos de l'objet -->
                <div>
                    <label for="photos" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1.5">
                        {{ __('Photos de l\'objet') }}
                    </label>

                    <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="hidden"
                        onchange="document.getElementById('photos-label').textContent = this.files.length
            ? Array.from(this.files).map(file => file.name).join(', ')
            : @js(__('Aucun fichier sélectionné'))"
                        @if ($errors->has('photos') || $errors->has('photos.*'))
                    aria-invalid="true"
                    @endif
                    >

                    <div class="flex flex-wrap items-center gap-3">
                        <label for="photos"
                            class="inline-flex items-center px-4 py-2 rounded-xl font-semibold text-sm
                   bg-blue-50 text-blue-700 hover:bg-blue-100
                   dark:bg-blue-950/50 dark:text-blue-300 dark:hover:bg-blue-900/50
                   cursor-pointer transition">
                            {{ __('Choisir des fichiers') }}
                        </label>

                        <span id="photos-label" class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Aucun fichier sélectionné') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Vous pouvez sélectionner plusieurs photos en même temps.') }}
                        {{ __('Formats acceptés : JPG, PNG, WEBP (Max 2 Mo par photo).') }}
                    </p>
                </div>



                {{-- Affichage des erreurs de validation (sur le tableau 'photos' ou un fichier spécifique 'photos.0', etc.) --}}
                @error('photos')
                    <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                @enderror
                @error('photos.*')
                    <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description"
            class="block text-sm font-semibold text-gray-800 mb-1.5">{{ __('Description') }}</label>
        <textarea name="description" id="description" rows="4" @class([
            'w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition',
            'border-red-600 bg-red-50/30' => $errors->has('description'),
            'border-gray-300' => !$errors->has('description'),
        ])>{{ old('description') }}</textarea>
        <p class="mt-1 text-xs text-gray-500">{{ __('Facultatif. Ce qui aidera le propriétaire à le reconnaître.') }}
        </p>
        @error('description')
            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Étiquettes en blocs/cases -->
    <div>
        <span class="block text-sm font-semibold text-gray-800 mb-2">{{ __('Étiquettes') }}</span>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
            @foreach ($tags as $tag)
                <label
                    class="flex items-center gap-2 p-3 bg-[#fbf8f3] hover:bg-amber-100/50 border border-amber-900/10 rounded-xl cursor-pointer transition text-xs font-medium text-gray-700">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                        {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                    <span>{{ $tag->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Actions / Boutons en bas -->
    <div class="flex items-center justify-end gap-4 pt-4">
        <a href="{{ route('items.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 transition">
            {{ __('Annuler') }}
        </a>
        <button type="submit"
            class="bg-[#0b2847] hover:bg-slate-900 text-white font-semibold text-sm px-6 py-2.5 rounded-xl shadow-sm transition">
            {{ __('Ajouter l\'objet') }}
        </button>
    </div>
    </form>
    </x-card>
    </div>
</x-layouts.app>
