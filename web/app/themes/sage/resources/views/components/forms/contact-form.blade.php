@props([
    'formId' => 'contact-form',
    'title' => 'Contact Form',
    'subtitle' => 'Fill out the form below and our team will contact you shortly.',
    'submitText' => 'Submit',
    'bgColor' => 'bg-green-800',
    'textColor' => 'text-white',
    'showDivisionOptions' => true,
    'divisionLabel' => 'Which division are you interested in?',
    'divisionOptions' => [
        ['value' => 'landscaping', 'label' => 'Landscaping Services | Servicios de Paisajismo'],
        ['value' => 'sod', 'label' => 'Sod Farming | Cultivo de Césped'],
        ['value' => 'corporate', 'label' => 'Corporate | Corporativo'],
        ['value' => 'other', 'label' => 'Other | Otro']
    ],
    'recipient' => null,
    'testMode' => false
])

<div class="{{ $bgColor }} rounded-md p-8 {{ $textColor }}">
    @if ($title)
        <h3 class="text-xl font-dm-serif font-semibold mb-4">{{ $title }}</h3>
    @endif

    @if ($subtitle)
        <p class="mb-6">{{ $subtitle }}</p>
    @endif

    <form id="{{ $formId }}" class="space-y-6" data-recipient="{{ $recipient }}"
        @if ($testMode) data-test="true" @endif>
        @php wp_nonce_field('wp_rest', '_wpnonce'); @endphp {{-- Add this line --}}
        <!-- Name Fields (First and Last on same row) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="first_name" placeholder="First Name" required
                class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
            <input type="text" name="last_name" placeholder="Last Name" required
                class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
        </div>

        <!-- Email Field -->
        <input type="email" name="email" placeholder="Email" required
            class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />

        <!-- Phone Field -->
        <input type="tel" name="phone" placeholder="Phone"
            class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />

        @if ($showDivisionOptions && count($divisionOptions) > 0)
            <!-- Division Selection (Radio Buttons) -->
            <div class="space-y-3">
                <p class="font-medium">{{ $divisionLabel }}</p>
                <div class="space-y-2">
                    @foreach ($divisionOptions as $option)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="division" value="{{ $option['value'] }}"
                                class="h-4 w-4 text-green-500 focus:ring-green-500">
                            <span>{{ $option['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Message Field -->
        <textarea name="message" placeholder="Your message" rows="4" required
            class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>

        <!-- Honeypot field for spam detection -->
        <div class="hidden" aria-hidden="true" style="position: absolute; left: -9999px;">
            <input type="text" name="honeypot" tabindex="-1" autocomplete="off" />
        </div>

        <!-- Additional content slot -->
        {{ $slot ?? '' }}

        <!-- Submit Button -->
        <div class="pt-4">
            <x-ui.button type="submit" form="{{ $formId }}" size="lg"
                class="justify-between hero-button light-green-to-white font-dm-serif cursor-pointer"
                icon="icons.right-arrow" iconColor="#016630" secondaryIconColor="#016630">
                {{ $submitText }}
            </x-ui.button>
        </div>
    </form>
</div>
