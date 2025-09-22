{{-- resources/views/components/ui/accordion-item.blade.php --}}
@props([
    'title' => '',
    'open' => false,
    'id' => 'accordion-item-' . uniqid(),
    'parent' => 'accordion-group-default'
])

<div class="service-accordion">
    <input type="radio" name="{{ $parent }}" id="{{ $id }}" class="accordion-input"
        {{ $open ? 'checked' : '' }}>
    <label for="{{ $id }}"
        class="flex justify-between items-center py-4 cursor-pointer border-b border-gray-200 service-accordion__header">
        <h3 class="m-0 font-dm-serif font-semibold text-green-800 text-xl md:text-2xl">{{ $title }}</h3>
        <span class="transition-transform duration-300 ease-in-out accordion-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 6 15 12 9 18"></polyline>
            </svg>
        </span>
    </label>
    <div class="py-4 overflow-hidden transition-all duration-300 ease-out service-accordion__body">
        {{ $slot }}
    </div>
</div>
