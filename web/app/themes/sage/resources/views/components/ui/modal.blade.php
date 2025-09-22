{{-- resources/views/components/ui/modal.blade.php --}}
@props([
    'id' => 'modal-' . uniqid(),
    'title' => null,
    'maxWidth' => 'max-w-2xl',
    'closeButton' => true,
    'useCard' => false,
    'cardProps' => [],
    'showBackdrop' => false
])

<div id="{{ $id }}" class="modal-container fixed inset-0 z-50 items-center justify-center hidden" role="dialog"
    aria-modal="true" aria-labelledby="{{ $id }}-title">
    @if ($showBackdrop)
        <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50"></div>
    @endif

    <div class="modal-content-wrapper relative z-10 flex items-center justify-center p-4 sm:p-6 h-full">
        <div class="modal-content {{ $maxWidth }} w-full bg-white rounded-lg overflow-hidden">
            @if ($closeButton)
                <button type="button"
                    class="modal-close absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors"
                    aria-label="Close modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            @endif

            @if ($useCard)
                <x-ui.card :title="$title" :hover="false" :animated="false" :shadow="''" :padding="'p-6'"
                    {{ $attributes->merge($cardProps) }}>
                    {{ $slot }}
                </x-ui.card>
            @else
                @if ($title)
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 id="{{ $id }}-title" class="text-lg font-semibold text-green-800">
                            {{ $title }}</h3>
                    </div>
                @endif

                <div class="p-6">
                    {{ $slot }}
                </div>
            @endif

            @if (isset($footer))
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
