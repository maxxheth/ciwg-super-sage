@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'iconUrl' => null,
    'iconSize' => 'w-20 h-20',
    'hover' => true,
    'bordered' => false,
    'rounded' => true,
    'padding' => 'p-6',
    'animated' => true,
    'shadow' => 'shadow-sm shadow-primary'
])

<div
    {{ $attributes->merge([
        'class' =>
            ($animated ? 'stagger-item ' : '') .
            $shadow .
            ' ' .
            ($bordered ? 'border ' : '') .
            ($rounded ? 'rounded-md ' : '') .
            $padding .
            ($hover ? ' hover:-translate-y-1 hover:shadow-md transition-all duration-300' : '')
    ]) }}>
    <div class="flex items-center gap-4 pl-4">
        @if ($iconUrl)
            <img src="{{ $iconUrl }}" alt="{{ $title }}" class="object-cover rounded-md {{ $iconSize }}" />
        @elseif($icon)
            <span class="text-2xl">{{ $icon }}</span>
        @endif

        <div>
            @if ($title)
                <h3 class="text-lg font-semibold text-green-800">{{ $title }}</h3>
            @endif

            @if ($description)
                <p class="text-gray-600">{{ $description }}</p>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
