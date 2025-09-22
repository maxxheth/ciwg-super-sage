@php
    $featured_project_image = Vite::asset('resources/images/manicured-front-yard.webp');
@endphp
<div class="px-4 mx-auto border-t-zinc-200 border-t-2">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Left Column -->
        <div class="space-y-4 border-r-zinc-200 border-r-2 px-2">
            <h3 class="text-2xl font-bold text-primary mb-2 mt-4">Full-Service Commercial Landscaping</h3>
            <p class="text-gray-600">Maximize your ROI with landscaping services that meet your budget, timeline, and
                stakeholder needs.</p>
            <a href="#"
                class="inline-block px-6 py-3 font-medium text-white bg-primary rounded-md hover:bg-primary-light no-underline">
                VIEW ALL SERVICES
            </a>
        </div>

        <!-- Middle Column -->
        <div class="space-y-6 border-r-zinc-200 border-r-2 pr-2">
            <h4 class="text-sm font-semibold tracking-wider text-primary uppercase mt-4">SERVICES</h4>
            <div class="space-y-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🌿</span>
                        <h5 class="text-lg font-semibold text-primary">LANDSCAPE MAINTENANCE</h5>
                    </div>
                    <p class="text-sm text-text">Keep your lawn & landscape healthy, safe, and beautiful all year long.
                    </p>
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
                        <span class="text-2xl">✏️</span>
                        <h5 class="text-lg font-semibold text-primary">LANDSCAPE DESIGN & INSTALL</h5>
                    </div>
                    <p class="text-sm text-gray-600">Partner with a team you can trust to deliver quality results on
                        time and under budget.</p>
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
                        <span class="text-2xl">🏗️</span>
                        <h5 class="text-lg font-semibold text-primary">LANDSCAPE CONSTRUCTION</h5>
                    </div>
                    <p class="text-sm text-gray-600">Looking for local experts to join your project team? Submit your
                        RFP today.</p>
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
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">POPULAR SERVICES</h4>
                <ul class="space-y-2">
                    @foreach (['Emergency Weather Service', 'Drainage Solutions', 'Irrigation Services', 'Lawn Services', 'Plant Health Care'] as $service)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $service }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">PROPERTY TYPES</h4>
                <ul class="space-y-2">
                    @foreach (['HOAs', 'Class A Commercial', 'Corporate Facilities', 'University Campuses', 'Parks & Cemeteries', 'Retail & Hospitality', 'Luxury & Senior Living'] as $type)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $type }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-2">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">FEATURED PROJECT</h4>
                <div class="overflow-hidden rounded-md">
                    <img src="{{ $featured_project_image }}" alt="Featured project"
                        class="object-cover w-full h-48 transition-transform duration-300 hover:scale-105" />
                </div>
                <p class="text-sm font-semibold mb-2 text-primary">GOING ABOVE AND BEYOND</p>
            </div>
        </div>
    </div>
</div>
