@props(['color' => null, 'kind' => null, 'type' => 'default'])

@php
    // Si un enum Color ou PlaceKind est passé directement
    $enumBadgeClasses = null;
    if ($color instanceof \BackedEnum && method_exists($color, 'badgeClasses')) {
        $enumBadgeClasses = $color->badgeClasses();
    } elseif ($kind instanceof \BackedEnum && method_exists($kind, 'badgeClasses')) {
        $enumBadgeClasses = $kind->badgeClasses();
    }
@endphp

<span @class([
    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
    $enumBadgeClasses => $enumBadgeClasses,
    'bg-gray-100 text-gray-800 border border-gray-200' => !$enumBadgeClasses && $type === 'default',
    'bg-green-100 text-green-800 border border-green-200' => !$enumBadgeClasses && $type === 'success',
    'bg-amber-100 text-amber-800 border border-amber-200' => !$enumBadgeClasses && $type === 'warning',
    'bg-red-100 text-red-800 border border-red-200' => !$enumBadgeClasses && $type === 'danger',
])>
    {{ $slot }}
</span>
