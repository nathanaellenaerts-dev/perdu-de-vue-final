
{{-- Libellé d'un champ --}}
@props(['for'])

<label
    for="{{ $for }}"
    {{ $attributes->class(['block text-sm font-medium text-black dark:text-black']) }}
>
    {{ $slot }}
</label>
