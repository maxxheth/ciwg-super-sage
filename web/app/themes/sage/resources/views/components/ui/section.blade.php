@props([
    'id' => null,
    'bgColor' => 'bg-white',
    'padding' => 'py-16',
    'container' => true,
    'containerClass' => 'container px-4 mx-auto'
])

<section {{ $id ? "id=$id" : '' }} {{ $attributes->merge(['class' => "$padding $bgColor"]) }}>
    @if ($container)
        <div class="{{ $containerClass }}">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</section>
