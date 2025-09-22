@php
    $team_photo = Vite::asset('resources/images/team-photo.webp');
    $contemporary_landscaping_design = Vite::asset('resources/images/contemporary-landscaping-design-dfw-min.webp');
@endphp
<div class="px-4 mx-auto border-t-zinc-200 border-t-2">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Left Column -->
        <div class="space-y-4 border-r-zinc-200 border-r-2 px-2">
            <h3 class="text-2xl font-bold text-primary mb-2 mt-4">Get In Touch</h3>
            <p class="text-gray-600">Connect with our team to discuss your landscaping needs and request a consultation.
            </p>
            <a href="#"
                class="inline-block px-6 py-3 font-medium text-white bg-primary rounded-md hover:bg-primary-light no-underline">
                CONTACT US
            </a>
        </div>

        <!-- Middle Column -->
        <div class="space-y-6 border-r-zinc-200 border-r-2 pr-2">
            <h4 class="text-sm font-semibold tracking-wider text-primary uppercase mt-4">CONTACT OPTIONS</h4>
            <div class="space-y-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">📞</span>
                        <h5 class="text-lg font-semibold text-primary">CONTACT INFORMATION</h5>
                    </div>
                    <p class="text-sm text-text">Find the best way to reach our team for your specific needs.</p>
                    <div class="flex items-center text-primary">
                        <a href="#" class="flex items-center text-sm font-medium hover:underline">
                            LEARN MORE
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 ml-1">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">📝</span>
                        <h5 class="text-lg font-semibold text-primary">REQUEST A QUOTE</h5>
                    </div>
                    <p class="text-sm text-gray-600">Fill out our form to get a detailed proposal for your project.</p>
                    <div class="flex items-center text-primary">
                        <a href="#" class="flex items-center text-sm font-medium hover:underline">
                            LEARN MORE
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 ml-1">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🗺️</span>
                        <h5 class="text-lg font-semibold text-primary">SERVICE AREAS</h5>
                    </div>
                    <p class="text-sm text-gray-600">Check if your location is within our service coverage area.</p>
                    <div class="flex items-center text-primary">
                        <a href="#" class="flex items-center text-sm font-medium hover:underline">
                            LEARN MORE
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 ml-1">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <div class="space-y-4 mt-4">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">CONTACT DEPARTMENTS</h4>
                <ul class="space-y-2">
                    @foreach (['General Inquiries', 'Customer Support', 'Emergency Services', 'Media Relations', 'Career Information'] as $department)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $department }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">SERVICE LOCATIONS</h4>
                <ul class="space-y-2">
                    @foreach (['Dallas', 'Fort Worth', 'Plano', 'Arlington', 'Irving', 'Frisco', 'McKinney'] as $location)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $location }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-2">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">OUR LOCATION</h4>
                <div class="overflow-hidden rounded-md">
                    <img src="{{ $contemporary_landscaping_design }}" alt="Office location"
                        class="object-cover w-full h-48 transition-transform duration-300 hover:scale-105" />
                </div>
                <p class="text-sm font-semibold text-primary mb-2">OUR DALLAS HEADQUARTERS</p>
            </div>
        </div>
    </div>
</div>
