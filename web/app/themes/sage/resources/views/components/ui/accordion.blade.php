{{-- resources/views/components/accordion.blade.php --}}
@props(['id' => 'accordion-' . uniqid()])

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'accordion-container']) }}>
    {{ $slot }}
</div>
