
{{-- Zone de texte avec gestion des erreurs --}}
@props(['name'])

@php
    $invalid = $errors->has($name);
@endphp

<textarea
    name="{{ $name }}"
    @if ($invalid) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
    {{ $attributes->merge(['id' => $name, 'rows' => 4])->class([
        'mt-2 block w-full rounded-lg border bg-white px-3 py-2 text-black shadow-xs focus:ring-3 focus:outline-hidden dark:bg-white dark:text-black',
        'border-zinc-300 placeholder:text-zinc-400 focus:border-brand-600 focus:ring-brand-600/20 dark:border-zinc-400' => ! $invalid,
        'border-red-500 focus:border-red-600 focus:ring-red-600/20 dark:border-red-500' => $invalid,
    ]) }}
>{{ $slot }}</textarea>
