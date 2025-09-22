@props([
    'direction' => 'horizontal', // horizontal, vertical
    'color' => 'border-gray-200',
    'spacing' => 'my-8'
])

@if ($direction === 'horizontal')
    <hr {{ $attributes->merge(['class' => "$color $spacing"]) }}>
@else
    <div {{ $attributes->merge(['class' => "h-full border-l $color"]) }}></div>
@endif
