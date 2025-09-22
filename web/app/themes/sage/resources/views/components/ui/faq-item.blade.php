@props([
    'question' => '',
    'answer' => '',
    'isOpen' => false
])

<div {{ $attributes->merge(['class' => 'border-b border-gray-200 py-4 animate-on-scroll']) }}>
    <button class="flex justify-between items-center w-full text-left focus:outline-none transition-colors"
        @click="open = !open" x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" :aria-expanded="open">
        <h3 class="text-lg font-semibold text-green-800">{{ $question }}</h3>
        <span class="ml-4 flex-shrink-0 text-green-800 transition-transform" :class="{ 'transform rotate-180': open }">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </button>
    <div class="mt-2 text-gray-600" x-show="open" x-collapse x-cloak>
        {!! $answer !!}
    </div>
</div>
