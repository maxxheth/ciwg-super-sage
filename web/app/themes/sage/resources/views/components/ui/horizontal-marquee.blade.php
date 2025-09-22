{{-- resources/views/components/ui/horizontal-marquee.blade.php --}}
@props([
    // Array of logo image URLs (already randomized/merged as needed)
    'logos' => [],
    // Optional: max width for the marquee container
    'maxWidth' => 'max-w-4xl',
    // Optional: gap between logos
    'gap' => 'gap-12',
    // Optional: marquee animation duration (in seconds)
    'animationDuration' => 30
])
<div {{ $attributes->merge(['class' => "w-full $maxWidth overflow-hidden bg-white bg-opacity-75 py-4"]) }}>
    <div class="marquee flex items-center {{ $gap }}"
        style="will-change: transform; animation: marquee-scroll {{ $animationDuration }}s linear infinite;">
        @foreach ($logos as $logo)
            <div class="flex-shrink-0 transition-all cursor-pointer duration-500 ease-in-out hover:scale-125">
                <img src="{{ $logo }}" alt="Partner Logo" class="h-12 w-auto select-none pointer-events-auto"
                    draggable="false" />
            </div>
        @endforeach
        {{-- Duplicate for seamless loop --}}
        @foreach ($logos as $logo)
            <div class="flex-shrink-0 transition-all cursor-pointer duration-500 ease-in-out hover:scale-125">
                <img src="{{ $logo }}" alt="Partner Logo" class="h-12 w-auto select-none pointer-events-auto"
                    draggable="false" />
            </div>
        @endforeach
    </div>
</div>

{{-- Marquee CSS moved to main stylesheet --}}
