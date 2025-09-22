@props([
    'title' => 'Section Title',
    'subtitle' => null,
    'centered' => true,
    'titleStyles' => 'mb-4 text-2xl md:text-4xl font-dm-serif font-bold',
    'titleColor' => 'text-green-800',
    'subtitleColor' => 'text-gray-600',
    'animated' => true
])

<div {{ $attributes->merge(['class' => $animated ? 'animate-on-scroll' : '']) }}>
    <h2 class="{{ $titleStyles }} {{ $centered ? 'text-center' : '' }} {{ $titleColor }}">
        {{ $title }}
    </h2>

    @if ($subtitle)
        <p class="max-w-2xl {{ $centered ? 'mx-auto text-center' : '' }} mb-8 {{ $subtitleColor }}">
            {{ $subtitle }}
        </p>
    @endif
</div>
