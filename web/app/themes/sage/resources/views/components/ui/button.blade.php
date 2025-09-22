{{-- components/button.blade.php --}}
@props([
    'href' => '#',
    'id' => '',
    'type' => 'link', // options: link, button, submit
    'color' => '', // options: green, blue, red, etc.
    'size' => 'lg', // options: sm, md, lg
    'icon' => null,
    'iconColor' => '#ffffff',
    'secondaryIconColor' => '',
    'iconPosition' => 'right', // options: left, right
    'animate' => false
])

@php
    $baseClasses =
        'flex items-center font-semibold shadow-black shadow-sm hover:shadow-md active:translate-y-1 transition-all duration-75 active:shadow-xs rounded-md';

    $sizeClasses =
        [
            'sm' => 'px-4 py-2 text-sm',
            'md' => 'px-5 py-2.5 text-xl',
            'lg' => 'px-6 py-3 text-2xl'
        ][$size] ?? 'px-6 py-3 text-2xl';

    $colorClasses = match ($color) {
        'white' => 'bg-white text-green-800 hover:bg-primary-light hover:text-white',
        'green' => 'bg-green-800 hover:bg-primary-light',
        'inverted-green' => 'hover:bg-green-800 bg-primary-light',
        'green-to-white' => 'bg-green-800 hover:bg-white',
        'inverted-green-to-white' => 'hover:bg-white bg-primary-light',
        'blue' => 'bg-blue-800 hover:bg-blue-700',
        'red' => 'bg-red-800 hover:bg-red-700',
        'none' => '',
        default => '' // Add more color options as needed
    };

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $colorClasses . ' ' . ($animate ? 'animate-on-scroll' : '');

    $iconClass = 'w-6 h-6' . ($iconPosition === 'right' ? ' ml-4' : ' mr-4');
@endphp

@if ($type === 'link')
    <a href="{{ $href }}" id="{{ $id }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif

        <span>{{ $slot }}</span>

        @if ($icon && $iconPosition === 'right')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif
    </a>
@else
    <button type="{{ $type === 'submit' ? 'submit' : 'button' }}" id="{{ $id }}"
        {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconClass }}" />
        @endif

        <span>{{ $slot }}</span>

        @if ($icon && $iconPosition === 'right')
            <x-icons.right-arrow fillColor="{{ $iconColor }}" class="{{ $iconClass }}" />
        @endif
    </button>
@endif
