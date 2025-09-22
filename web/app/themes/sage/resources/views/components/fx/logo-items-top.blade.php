<!-- components/logo-items-top.blade.php -->
@props(['foo' => 'bar'])
@php

    // Logo path
    $logo_path = 'resources/images/logos';

    // Logos
    $mcdonalds_logo = Vite::asset("$logo_path/mcdonalds-logo.webp");
    $ashton_woods_logo = Vite::asset("$logo_path/ashton-woods-logo.webp");
    $bridge_logo = Vite::asset("$logo_path/bridge-logo.webp");
    $camden_logo = Vite::asset("$logo_path/camden-logo.webp");
    $drees_logo = Vite::asset("$logo_path/drees-logo.webp");
    $firestone_logo = Vite::asset("$logo_path/firestone-logo.webp");
    $garland_logo = Vite::asset("$logo_path/garland-logo.webp");
    $jackson_logo = Vite::asset("$logo_path/jackson-logo.webp");

@endphp

<x-fx.logo-item :img_path="$mcdonalds_logo" />
<x-fx.logo-item :img_path="$ashton_woods_logo" />
<x-fx.logo-item :img_path="$bridge_logo" />
<x-fx.logo-item :img_path="$camden_logo" />
<x-fx.logo-item :img_path="$drees_logo" />
<x-fx.logo-item :img_path="$firestone_logo" />
<x-fx.logo-item :img_path="$garland_logo" />
<x-fx.logo-item :img_path="$jackson_logo" />
