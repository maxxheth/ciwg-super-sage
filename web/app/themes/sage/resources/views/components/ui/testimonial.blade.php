@props([
    'quote' => 'This is a testimonial quote.',
    'author' => 'John Doe',
    'position' => null,
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
    <p class="mb-4 italic text-gray-600">
        "{{ $quote }}"
    </p>
    <p class="font-semibold text-green-800">
        — {{ $author }}{{ $position ? ", $position" : '' }}
    </p>

    {{ $slot }}
</div>
