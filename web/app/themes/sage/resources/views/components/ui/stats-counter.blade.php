@props([
    'value' => '100',
    'label' => 'Stat Label',
    'prefix' => '',
    'suffix' => '+',
    'duration' => 2,
    'textSize' => 'text-3xl',
    'animated' => true
])

<div {{ $attributes->merge(['class' => 'text-center ' . ($animated ? 'stagger-item' : '')]) }}>
    <div class="{{ $textSize }} font-bold text-green-800">
        {{ $prefix }}<span class="counter-value" data-count="{{ $value }}"
            data-duration="{{ $duration }}"></span>{{ $suffix }}
    </div>
    <p class="text-gray-600">{{ $label }}</p>

    {{ $slot }}
</div>
