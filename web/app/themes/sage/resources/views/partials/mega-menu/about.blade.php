@php
    $featured_project_image = Vite::asset('resources/images/manicured-front-yard.webp');
@endphp
<div class="px-4 mx-auto border-t-zinc-200 border-t-2">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Left Column -->
        <div class="space-y-4 border-r-zinc-200 border-r-2 px-2">
            <h3 class="text-2xl font-bold text-primary mb-2 mt-4">About Sandoval Landscaping</h3>
            <p class="text-gray-600">Learn about our history, mission, and commitment to excellence in landscaping.</p>
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
                        <span class="text-2xl">🏢</span>
                        <h5 class="text-lg font-semibold text-primary">OUR COMPANY</h5>
                    </div>
                    <p class="text-sm text-text">Founded with a passion for creating beautiful outdoor spaces that
                        enhance property value.</p>
                    <div class="flex items-center text-green-700">
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
                        <span class="text-2xl">👥</span>
                        <h5 class="text-lg font-semibold text-primary">OUR TEAM</h5>
                    </div>
                    <p class="text-sm text-gray-600">Meet our experienced professionals dedicated to exceptional
                        landscape services.</p>
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
                        <span class="text-2xl">🌱</span>
                        <h5 class="text-lg font-semibold text-green-800">OUR APPROACH</h5>
                    </div>
                    <p class="text-sm text-gray-600">Discover our sustainable practices and commitment to environmental
                        stewardship.</p>
                    <div class="flex items-center text-green-700">
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
                <h4 class="text-sm font-semibold tracking-wider text-green-600 uppercase">POPULAR LINKS</h4>
                <ul class="space-y-2">
                    @foreach (['Company History', 'Leadership Team', 'Awards & Recognition', 'Careers', 'Community Involvement'] as $link)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-green-800"></div>
                            <a href="#"
                                class="text-sm hover:text-green-700 hover:underline">{{ $link }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="text-sm font-semibold tracking-wider text-green-600 uppercase">CATEGORIES</h4>
                <ul class="space-y-2">
                    @foreach (['Sustainability Initiatives', 'Industry Partnerships', 'Certifications', 'Press Releases', 'Client Testimonials'] as $category)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-green-800"></div>
                            <a href="#"
                                class="text-sm hover:text-green-700 hover:underline">{{ $category }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-2 space-x-2">
                <h4 class="text-sm font-semibold tracking-wider text-green-600 uppercase">FEATURED PROJECT</h4>
                <div class="overflow-hidden rounded-md">
                    <img src="{{ $featured_project_image }}" alt="Featured project"
                        class="border-2 object-cover w-full h-48 transition-transform duration-300 hover:scale-105" />
                </div>
                <p class="text-sm font-semibold text-green-800 mb-2">CELEBRATING 30 YEARS OF EXCELLENCE</p>
            </div>
        </div>
    </div>
</div>
