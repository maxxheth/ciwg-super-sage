@props([
    'number' => '01',
    'title' => 'Process Step',
    'description' => null,
    'textColor' => 'text-white',
    'descriptionColor' => 'text-green-100',
    'animated' => true
])

<div {{ $attributes->merge(['class' => 'space-y-2 ' . ($animated ? 'animate-on-scroll' : '')]) }}>
    <div class="flex items-center gap-2">
        <span class="text-2xl font-bold process-number">{{ $number }}</span>
        <h3 class="text-xl font-semibold {{ $textColor }}">{{ $title }}</h3>
    </div>

    @if ($description)
        <p class="{{ $descriptionColor }}">
            {{ $description }}
        </p>
    @endif

    {{ $slot }}
</div>
