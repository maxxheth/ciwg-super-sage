@props([
    'cols' => [
        'default' => 1,
        'sm' => null,
        'md' => null,
        'lg' => null,
        'xl' => null,
        '2xl' => null
    ],
    'gap' => 'gap-8',
    'animated' => true
])

@php
    $gridCols = 'grid-cols-' . ($cols['default'] ?? 1);
    $sizes = ['sm', 'md', 'lg', 'xl', '2xl'];

    foreach ($sizes as $size) {
        $col = $cols[$size] ?? null;
        if (is_null($col)) {
            continue;
        }
        switch ($size) {
            case 'sm':
                $gridCols .= ' sm:grid-cols-' . $col;
            case 'md':
                $gridCols .= ' md:grid-cols-' . $col;
            case 'lg':
                $gridCols .= ' lg:grid-cols-' . $col;
            case 'xl':
                $gridCols .= ' xl:grid-cols-' . $col;
            case '2xl':
                $gridCols .= ' 2xl:grid-cols-' . $col;
                break;
            default:
                $gridCols .= ' grid-cols-' . $col;
                break;
        }
    }
@endphp

<div
    {{ $attributes->merge([
        'class' => 'grid ' . $gridCols . ' ' . $gap . ' ' . ($animated ? 'stagger-container animate-on-scroll' : '')
    ]) }}>
    {{ $slot }}
</div>
