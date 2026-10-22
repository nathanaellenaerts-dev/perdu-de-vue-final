@props(['item'])

<div class="relative bg-white dark:bg-[#091d32] rounded-2xl p-5 border border-amber-900/10 dark:border-blue-900/40 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">

    <!-- Pastille de couleur (en absolute par rapport à la carte) -->
    @if ($item->color)
        <div class="absolute top-4 right-4 z-10">
            <x-color-badge :color="$item->color" />
        </div>
    @endif

    <!-- Image ou Placeholder -->
    <div class="relative h-48 w-full rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 shrink-0">
        @php
            $coverPhoto = $item->photos->where('is_cover', true)->first() ?? $item->photos->first();
        @endphp

        @if ($coverPhoto)
            <img src="{{ asset('storage/' . $coverPhoto->path) }}" alt="{{ $item->name }}"
                class="w-full h-full object-cover">
        @else
            <div class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500 text-sm">
                {{ __('Pas d\'image') }}
            </div>
        @endif
    </div>

    <!-- Informations -->
    <div class="space-y-1">
        <div class="text-xs text-gray-400 dark:text-gray-400 flex items-center justify-between">
            <span>N° {{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
            <span>{{ $item->found_on->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}</span>
        </div>

        <h3 class="font-extrabold text-[#0b2847] dark:text-white text-lg leading-snug">
            {{ $item->name }}
        </h3>

        @if ($item->place)
            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                <span>📍</span> {{ $item->place->name }}
            </p>
        @endif

        <!-- Étiquettes -->
        @if ($item->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 pt-1">
                @foreach ($item->tags as $tag)
                    <x-badge>{{ $tag->name }}</x-badge>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Action -->
    <div class="pt-2 border-t border-gray-100 dark:border-blue-900/40 flex items-center justify-between">
        <a href="{{ route('items.show', $item) }}" class="text-xs font-bold text-[#f97316] hover:underline">
            {{ __('Voir les détails →') }}
        </a>
    </div>

</div>
