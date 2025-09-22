@props([
    'title' => '',
    'images' => [],
    'open' => false,
    'id' => 'service-' . uniqid(),
    'parallaxReverseOverride' => false,
    'accordionItems' => []
])

<div {{ $attributes->merge(['class' => 'flex w-full flex-wrap relative md:mb-16 overflow-hidden md:flex-nowrap service-item']) }}
    data-id="{{ $id }}">
    <div class="flex-1 min-w-[300px] p-8 z-10 service-item__content">
        <x-ui.accordion>
            @foreach ($accordionItems as $item)
                <x-ui.accordion-item :title="$item['title']" :open="false">
                    <p>{{ $item['content'] }}</p>
                </x-ui.accordion-item>
            @endforeach
        </x-ui.accordion>
    </div>

    <div
        class="flex-1 min-w-[300px] p-6 h-[500px] relative block lg:h-[500px] md:h-[450px] sm:h-[400px] sm:max-w-full sm:mx-auto service-item__images">
        @foreach ($images as $index => $image)
            <div class="absolute overflow-hidden rounded-lg shadow-md will-change-transform parallax-image-wrapper">
                <img src="{{ $image['src'] }}" alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover parallax-image"
                    data-parallax-speed="{{ $image['speed'] ?? $index * 0.1 + 0.2 }}"
                    data-parallax-reverse="{{ $parallaxReverseOverride ?? $index % 2 == 0 ? 'false' : 'true' }}">
            </div>
        @endforeach
    </div>
</div>
