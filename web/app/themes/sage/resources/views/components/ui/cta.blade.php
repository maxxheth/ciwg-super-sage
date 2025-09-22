@props([
    'title' => 'Call to Action',
    'description' => null,
    'buttonText' => 'Learn More',
    'buttonUrl' => '#',
    'centered' => true,
    'bgColor' => 'bg-white',
    'titleColor' => 'text-green-800',
    'descriptionColor' => 'text-gray-600',
    'buttonColor' => 'bg-green-800 hover:bg-green-700 text-white',
    'padding' => 'py-16',
    'animated' => true
])

<section {{ $attributes->merge(['class' => "$padding $bgColor"]) }}>
    <div class="container px-4 mx-auto {{ $centered ? 'text-center' : '' }}">
        <div class="{{ $animated ? 'animate-on-scroll' : '' }}">
            <h2 class="mb-4 text-2xl font-bold {{ $titleColor }}">{{ $title }}</h2>

            @if ($description)
                <p class="max-w-2xl {{ $centered ? 'mx-auto' : '' }} mb-8 {{ $descriptionColor }}">
                    {{ $description }}
                </p>
            @endif
        </div>

        <a href="{{ $buttonUrl }}"
            class="inline-block px-6 py-3 rounded-md transition-colors duration-300 hover:scale-105 {{ $buttonColor }}">
            {{ $buttonText }}
        </a>

        {{ $slot }}
    </div>
</section>
