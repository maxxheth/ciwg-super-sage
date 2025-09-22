@props([
    'title' => null,
    'subtitle' => null,
    'imageUrl' => null,
    'imageAlt' => 'Card image',
    'imageWidth' => 'w-20', // 80px
    'imageHeight' => 'h-20', // 80px
    'centerTitle' => false,
    'centerContent' => false,
    'titleSize' => 'text-2xl',
    'hover' => true,
    'bordered' => false,
    'rounded' => true,
    'padding' => 'p-6',
    'animated' => true,
    'shadow' => 'shadow-sm shadow-primary',
    'layout' => 'flex', // 'flex' for horizontal layout, null for default vertical layout
    'imageLayout' => 'inline', // 'inline' for side-by-side, 'hero' for top image
    'iconContainer' => false, // Whether to show a circular icon container
    'iconBg' => 'bg-green-100', // Background color for icon container
    'iconContainerSize' => 'w-16 h-16', // Size of the icon container
    'iconTextColor' => 'text-green-800', // Color of the icon
    'iconSize' => 'h-8 w-8', // Size of the icon
    'bgColor' => null, // Background color of the card
    'textColor' => 'text-gray-700' // Text color
])

<div
    {{ $attributes->merge([
        'class' =>
            ($animated ? 'stagger-item ' : '') .
            ($shadow ? $shadow . ' ' : '') .
            ($bordered ? 'border ' : '') .
            ($rounded ? 'rounded-lg ' : '') .
            ($imageLayout === 'hero' ? 'overflow-hidden' : $padding) .
            ($hover ? ' hover:shadow-md hover:-translate-y-1 transition-all duration-300' : '') .
            ($bgColor ? ' ' . $bgColor : '')
    ]) }}>
    @if ($imageUrl && $imageLayout === 'hero')
        <div class="relative h-48 w-full overflow-hidden">
            <div class="transition-transform duration-300 hover:scale-105 h-full">
                <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="object-cover w-full h-full" />
            </div>
        </div>
    @endif

    <div class="{{ $imageLayout === 'hero' ? $padding : '' }}">
        @if ($iconContainer)
            <div
                class="{{ $iconContainerSize }} mx-auto mb-4 flex items-center justify-center {{ $iconBg }} rounded-full">
                @if (isset($icon))
                    {{ $icon }}
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSize }} {{ $iconTextColor }}" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                @endif
            </div>
        @endif

        <div
            class="{{ $layout === 'flex' && $imageLayout !== 'hero' && !$iconContainer ? 'flex items-center gap-4' : 'block' }}">
            @if ($imageUrl && $imageLayout === 'inline' && !$iconContainer)
                @if ($layout === 'flex')
                    <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}"
                        class="object-cover {{ $imageWidth }} {{ $imageHeight }} {{ $rounded ? 'rounded-md' : '' }}" />
                @else
                    <div class="relative {{ $imageHeight }} overflow-hidden {{ $rounded ? 'rounded-md' : '' }} mb-4">
                        <div class="transition-transform duration-300 hover:scale-105 h-full">
                            <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                @endif
            @endif

            <div class="{{ $centerContent ? 'text-center' : 'text-left' }}">
                @if ($title)
                    <h3
                        class="{{ $centerTitle || $centerContent ? 'text-center' : '' }} {{ $titleSize }} font-semibold text-green-800 mb-2">
                        {{ $title }}
                    </h3>
                @endif

                @if ($subtitle)
                    <p class="{{ $centerContent ? 'text-center' : '' }} {{ $textColor }}">{{ $subtitle }}</p>
                @endif

                <div class="{{ $centerContent ? 'text-center' : '' }} {{ $textColor }}">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
