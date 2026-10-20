@props(['color'])

@php
    $colorValue = $color instanceof \BackedEnum ? $color->value : $color;
    $colorLabel = method_exists($color, 'label') ? $color->label() : ucfirst($colorValue);

    $classes = match($colorValue) {
        'black' => 'bg-gray-900 text-white',
        'white' => 'bg-gray-100 text-gray-800 border border-gray-300',
        'grey' => 'bg-gray-500 text-white',
        'red' => 'bg-red-600 text-white',
        'blue' => 'bg-blue-600 text-white',
        'green' => 'bg-green-600 text-white',
        'yellow' => 'bg-yellow-300 text-gray-900',
        'orange' => 'bg-orange-500 text-white',
        'brown' => 'bg-amber-800 text-white',
        'pink' => 'bg-pink-500 text-white',
        'purple' => 'bg-purple-600 text-white',
        'multicolor' => 'bg-gradient-to-r from-red-500 via-green-500 to-blue-500 text-white',
        default => 'bg-gray-200 text-gray-800',
    };
@endphp

<span class="px-2.5 py-1 rounded-full text-xs font-semibold shadow-xs {{ $classes }}">
    {{ $colorLabel }}
</span>
