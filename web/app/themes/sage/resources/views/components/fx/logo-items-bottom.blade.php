<!-- components/logo-items-bottom.blade.php -->
@props([])
@php

    // Logo path
    $logo_path = 'resources/images/logos';

    // Logos
    $kb_homes_logo = Vite::asset("$logo_path/kb-homes-logo.webp");
    $keller_logo = Vite::asset("$logo_path/keller-logo.webp");
    $ladera_logo = Vite::asset("$logo_path/ladera-logo.webp");
    $riverside_logo = Vite::asset("$logo_path/riverside-logo.webp");
    $tripoint_logo = Vite::asset("$logo_path/tripoint-logo.webp");
    $trophy_logo = Vite::asset("$logo_path/trophy-logo.webp");

@endphp

<x-fx.logo-item :img_path="$kb_homes_logo" />
<x-fx.logo-item :img_path="$keller_logo" />
<x-fx.logo-item :img_path="$ladera_logo" />
<x-fx.logo-item :img_path="$riverside_logo" />
<x-fx.logo-item :img_path="$tripoint_logo" />
<x-fx.logo-item :img_path="$trophy_logo" />
