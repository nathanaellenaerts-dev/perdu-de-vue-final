<x-layouts.app>
    <div class="max-w-2xl mx-auto">
        <x-card class="space-y-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-black">
                {{ __('Ajouter un objet') }}
            </h1>

            <form action="{{ route('items.store') }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                @csrf

                <!-- Nom de l'objet -->
                <div>
                    <x-label for="name">{{ __('Nom de l’objet') }}</x-label>
                    <x-input name="name" id="name" :value="old('name')" maxlength="60" />
                    @error('name')
                        <p id="name-error" class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lieu de découverte -->
                <div>
                    <x-label for="place_id">{{ __('Lieu de découverte') }}</x-label>
                    <x-select name="place_id" id="place_id">
                        <option value="">{{ __('Sélectionnez un lieu') }}</option>
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}" @selected(old('place_id') == $place->id)>
                                {{ $place->name }} ({{ $place->kind->label() }})
                            </option>
                        @endforeach
                    </x-select>
                    @error('place_id')
                        <p id="place_id-error" class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Couleur -->
                <div>
                    <x-label for="color">{{ __('Couleur') }}</x-label>
                    <x-select name="color" id="color">
                        <option value="">{{ __('Sélectionnez une couleur') }}</option>
                        @foreach (\App\Enums\Color::cases() as $color)
                            <option value="{{ $color->value }}" @selected(old('color') === $color->value)>
                                {{ $color->label() }}
                            </option>
                        @endforeach
                    </x-select>
                    @error('color')
                        <p id="color-error" class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de découverte -->
                <div>
                    <x-label for="found_on">{{ __('Date de découverte') }}</x-label>
                    <x-input name="found_on" type="date" id="found_on" :value="old('found_on')" />
                    @error('found_on')
                        <p id="found_on-error" class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Photos de l'objet -->
                <div>
                    <label for="photos" class="block text-sm font-semibold text-gray-900 dark:text-black mb-1.5">
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
                            bg-blue-50 text-blue-700 hover:bg-blue-100 cursor-pointer transition">
                            {{ __('Choisir des fichiers') }}
                        </label>

                        <span id="photos-label" class="text-sm font-medium text-gray-900">
                            {{ __('Aucun fichier sélectionné') }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-900 font-medium">
                        {{ __('Vous pouvez sélectionner plusieurs photos en même temps.') }}
                        {{ __('Formats acceptés : JPG, PNG, WEBP (Max 2 Mo par photo).') }}
                    </p>
                    @error('photos')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror

                    @error('photos.*')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Description -->
                <div>
                    <x-label for="description">{{ __('Description') }}</x-label>
                    <x-textarea name="description" id="description"
                        rows="4">{{ old('description') }}</x-textarea>
                    @error('description')
                        <p id="description-error" class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Étiquettes (Cases à cocher) -->
                <div>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-black mb-2">
                        {{ __('Étiquettes') }}
                    </span>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($tags as $tag)
                            <label
                                class="flex items-center space-x-2 text-sm text-gray-900 dark:text-black font-medium cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{ session()->hasOldInput() && in_array($tag->id, (array) old('tags', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span>{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('items.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-900 hover:bg-gray-50 transition text-sm font-medium">
                        {{ __('Annuler') }}
                    </a>

                    <x-button variant="primary">
                        {{ __('Ajouter l\'objet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
