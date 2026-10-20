@props(['variant' => 'primary'])

@php
    $baseClasses = 'px-4 py-2 rounded-lg font-medium text-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2';

    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        'success' => 'bg-green-600 text-white hover:bg-green-700 shadow-sm',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
