<x-layouts.app>
    <div class="mx-auto max-w-6xl space-y-8">
        <header>
            <p class="text-sm font-semibold uppercase tracking-widest text-amber-600">
                {{ __('Guide de style') }}
            </p>
            <h1 class="mt-1 text-3xl font-extrabold text-slate-900 dark:text-white">
                {{ __('Composants de l’application') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">
                {{ __('Palette de couleurs et composants Blade réutilisables.') }}
            </p>
        </header>

        <!-- Palette de couleurs -->
        <x-card>
            <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-black">
                {{ __('Palette de couleurs') }}
            </h2>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                @php
                    $palette = [
                        ['Bleu principal', '#0b2847', 'bg-[#0b2847]'],
                        ['Ambre', '#d97706', 'bg-[#d97706]'],
                        ['Blanc', '#ffffff', 'bg-[#ffffff]'],
                    ];
                @endphp

                @foreach ($palette as [$label, $hex, $class])
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="h-16 {{ $class }}"></div>
                        <div class="bg-white p-3">
                            <p class="text-sm font-semibold text-black">
                                {{ __($label) }}
                            </p>
                            <code class="text-xs text-black">{{ $hex }}</code>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        <!-- Badges -->
        <x-card>
            <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-black">
                {{ __('Badges') }}
            </h2>

            <div class="flex flex-wrap items-center gap-3">
                <x-badge>{{ __('Par défaut') }}</x-badge>
                <x-badge type="success">{{ __('Succès') }}</x-badge>
                <x-badge type="warning">{{ __('Attention') }}</x-badge>
                <x-badge type="danger">{{ __('Erreur') }}</x-badge>

                @foreach (\App\Enums\Color::cases() as $color)
                    <x-color-badge :color="$color" />
                @endforeach
            </div>
        </x-card>

        <!-- Champs de formulaire -->
        <x-card>
            <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-black">
                {{ __('Champs de formulaire') }}
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <x-label for="styleguide-name" class="dark:text-black">
                        {{ __('Nom de l’objet') }}
                    </x-label>
                    <x-input name="styleguide-name" id="styleguide-name" value="Sac à dos" />
                </div>

                <div>
                    <x-label for="styleguide-color" class="dark:text-black">
                        {{ __('Couleur') }}
                    </x-label>
                    <x-select name="styleguide-color" id="styleguide-color">
                        <option>{{ __('Choisir une couleur') }}</option>
                        <option>{{ __('Bleu') }}</option>
                    </x-select>
                </div>

                <div class="md:col-span-2">
                    <x-label for="styleguide-description" class="dark:text-black">
                        {{ __('Description') }}
                    </x-label>
                    <x-textarea name="styleguide-description" id="styleguide-description">Un exemple de
                        description.</x-textarea>
                </div>
            </div>
        </x-card>

        <!-- Carte et boutons -->
        <x-card>
            <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-black">
                {{ __('Carte et bouton') }}
            </h2>

            <div class="flex flex-wrap items-center gap-3">
                <x-button>{{ __('Bouton principal') }}</x-button>
                <x-button type="button" variant="secondary">
                    {{ __('Bouton secondaire') }}
                </x-button>
            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-black">
                {{ __('Les cartes utilisent le composant x-card et les objets de la liste utilisent x-item-card.') }}
            </p>
        </x-card>
    </div>
</x-layouts.app>
