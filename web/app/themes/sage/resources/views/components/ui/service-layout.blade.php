@props([
    'layout' => 'alternating',
    'spacingClass' => 'space-y-8 md:space-y-16 lg:space-y-24'
])

<section {{ $attributes->merge(['class' => 'w-full relative', 'data-layout' => $layout]) }}>
    <!-- Wrap service items in a container with a known class -->
    <div class="services-container mx-auto {{ $spacingClass }}">
        {{ $slot }}
    </div>
</section>
