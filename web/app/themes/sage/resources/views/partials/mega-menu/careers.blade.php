@php
    $team_photo = Vite::asset('resources/images/team-photo.webp');
@endphp
<div class="px-4 mx-auto border-t-zinc-200 border-t-2">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <!-- Left Column -->
        <div class="space-y-4 border-r-zinc-200 border-r-2 px-2">
            <h3 class="text-2xl font-bold text-primary mb-2 mt-4">Join Our Team</h3>
            <p class="text-gray-600">Discover rewarding career opportunities with a leader in the landscaping industry.
            </p>
            <a href="#"
                class="inline-block px-6 py-3 font-medium text-white bg-primary rounded-md hover:bg-primary-light no-underline">
                VIEW ALL CAREERS
            </a>
        </div>

        <!-- Middle Column -->
        <div class="space-y-6 border-r-zinc-200 border-r-2 pr-2">
            <h4 class="text-sm font-semibold tracking-wider text-primary uppercase mt-4">CAREERS</h4>
            <div class="space-y-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">💼</span>
                        <h5 class="text-lg font-semibold text-primary">CURRENT OPENINGS</h5>
                    </div>
                    <p class="text-sm text-text">Explore available positions across all departments and experience
                        levels.</p>
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
                        <h5 class="text-lg font-semibold text-primary">GROWTH & DEVELOPMENT</h5>
                    </div>
                    <p class="text-sm text-gray-600">Learn about our training programs and career advancement
                        opportunities.</p>
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
                        <span class="text-2xl">🏆</span>
                        <h5 class="text-lg font-semibold text-primary">BENEFITS & CULTURE</h5>
                    </div>
                    <p class="text-sm text-gray-600">Discover why Sandoval Landscaping is a great place to build your
                        career.</p>
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
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">CAREER PATHS</h4>
                <ul class="space-y-2">
                    @foreach (['Landscape Professionals', 'Design Team', 'Account Management', 'Operations Leadership', 'Administrative Roles'] as $path)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $path }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">EMPLOYEE BENEFITS</h4>
                <ul class="space-y-2">
                    @foreach (['Professional Development', 'Certification Programs', 'Employee Recognition', 'Work-Life Balance', 'Community Involvement'] as $benefit)
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-primary"></div>
                            <a href="#" class="text-sm hover:text-primary hover:underline">{{ $benefit }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="space-y-2">
                <h4 class="text-sm font-semibold tracking-wider text-primary uppercase">JOIN OUR TEAM</h4>
                <div class="overflow-hidden rounded-md">
                    <img src="{{ $team_photo }}" alt="Team members"
                        class="object-cover w-full h-48 transition-transform duration-300 hover:scale-105" />
                </div>
                <p class="text-sm font-semibold text-primary mb-2">BUILDING CAREERS IN LANDSCAPING</p>
            </div>
        </div>
    </div>
</div>
