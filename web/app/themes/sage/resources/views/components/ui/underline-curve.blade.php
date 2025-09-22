@props([
    'strokeColor' => '#67B649',
    'strokeWidth' => '0.1em',
    'strokeLinecap' => 'square',
    'strokeLinejoin' => 'bevel',
    'width' => '296px',
    'height' => '48px',
    'fontSize' => '44px',
    'dashArray' => '307',
    'dashOffset' => '614',
    'position' => 'relative',
    'top' => '5px',
    'left' => '0px',
    'right' => 'auto',
    'scale' => '1',
    'opacity' => '1',
    'widthMultiplier' => 1,
    'pathStyle' => 'default' // options: default, wide, extra-wide, ultra-wide
])

@php
    // Define path options based on width requirements
    $paths = [
        'default' =>
            'M 0,47.52 c 37,-1.32 74,-4.08 148,-5.28 c 74,-1.2 112.48,0 148,0.48 c 7.1,0.096 -5.62,1.37 -5.92,1.44',
        'wide' =>
            'M 0,47.52 c 55.5,-1.32 111,-4.08 222,-5.28 c 111,-1.2 168.72,0 222,0.48 c 10.65,0.096 -8.43,1.37 -8.88,1.44',
        'extra-wide' =>
            'M 0,47.52 c 74,-1.32 148,-4.08 296,-5.28 c 148,-1.2 224.96,0 296,0.48 c 14.2,0.096 -11.25,1.37 -11.84,1.44',
        'ultra-wide' =>
            'M 0,47.52 c 92.5,-1.32 185,-4.08 370,-5.28 c 185,-1.2 281.2,0 370,0.48 c 17.75,0.096 -14.06,1.37 -14.8,1.44'
    ];

    // Get path based on style or default
    $selectedPath = $paths[$pathStyle] ?? $paths['default'];

    // Calculate width multiplier based on path style
    $styleMultipliers = [
        'default' => 1,
        'wide' => 1.5,
        'extra-wide' => 2,
        'ultra-wide' => 2.5
    ];

    // Apply the calculated multiplier
    $calculatedMultiplier = $styleMultipliers[$pathStyle] ?? 1;
    $finalMultiplier = $widthMultiplier * $calculatedMultiplier;

    // Scale dash values for animation
    $scaledDashArray = intval($dashArray) * $finalMultiplier;
    $scaledDashOffset = intval($dashOffset) * $finalMultiplier;

    // Calculate width value (strip 'px' if present, multiply, then add 'px' back)
    $numericWidth = intval(str_replace('px', '', $width));
    $calculatedWidth = $numericWidth * $finalMultiplier . 'px';
@endphp

<div {{ $attributes->merge(['class' => 'underline-curve-container']) }}
    style="
    position: {{ $position }};
    font-size: {{ $fontSize }}; 
    --stroke: {{ $strokeColor }}; 
    --stroke-width: {{ $strokeWidth }}; 
    --stroke-linecap: {{ $strokeLinecap }}; 
    --stroke-linejoin: {{ $strokeLinejoin }}; 
    opacity: {{ $opacity }}; 
    transform: scale({{ $scale }}); 
    width: {{ $calculatedWidth }}; 
    height: {{ $height }}; 
    left: {{ $left }}; 
    right: {{ $right }};
    top: {{ $top }};
">
    <svg width="100%" height="100%" preserveAspectRatio="none">
        <path d="{{ $selectedPath }}" vector-effect="non-scaling-stroke" stroke="{{ $strokeColor }}"
            stroke-width="{{ $strokeWidth }}" stroke-linecap="{{ $strokeLinecap }}"
            stroke-linejoin="{{ $strokeLinejoin }}" fill="none" stroke-dasharray="{{ $scaledDashArray }}"
            stroke-dashoffset="{{ $scaledDashOffset }}"></path>
    </svg>
</div>
