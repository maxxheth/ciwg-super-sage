@props([
    'featured_projects' => [] // Default to an empty array if not provided
])

<section id="featured-projects" class="py-16 bg-green-800">
    <div class="container px-4 mx-auto">
        <h2 class="mb-8 font-dm-serif text-3xl md:text-5xl font-bold text-center text-white animate-on-scroll">
            Our Featured Projects
        </h2>

        {{-- Project category filters --}}
        <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-8 animate-on-scroll" id="featured-projects-filters">
            {{-- Keep the "All" button --}}
            <button data-filter="All"
                class="px-4 py-2 text-sm md:text-base bg-white text-green-800 rounded-full hover:bg-green-100 transition-colors font-medium active">All
                Projects</button>
            {{-- Replace existing buttons with categories from create-featured-projects.php --}}
            <button data-filter="Residential"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Residential</button>
            <button data-filter="Commercial"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Commercial</button>
            <button data-filter="Public Spaces"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Public
                Spaces</button>
            <button data-filter="Water Conservation"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Water
                Conservation</button>
            <button data-filter="Ecological Restoration"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Ecological
                Restoration</button>
            <button data-filter="Urban Gardens"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Urban
                Gardens</button>
            <button data-filter="Edible Landscapes"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Edible
                Landscapes</button>
            <button data-filter="Stormwater Management"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Stormwater
                Management</button>
            <button data-filter="Therapeutic Gardens"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Therapeutic
                Gardens</button>
            <button data-filter="Vertical Landscaping"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Vertical
                Landscaping</button>
            <button data-filter="Historic Preservation"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Historic
                Preservation</button>
            <button data-filter="Smart Irrigation"
                class="px-4 py-2 text-sm md:text-base bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Smart
                Irrigation</button>
        </div>

        @if (!empty($featured_projects))
            {{-- Add ID to the grid container for easier selection --}}
            <div id="featured-projects-grid"
                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 stagger-container animate-on-scroll">
                @foreach ($featured_projects as $project)
                    {{-- Add data-category attribute --}}
                    <div data-category="{{ $project['category'] ?? '' }}"
                        class="project-item space-y-4 stagger-item overflow-hidden rounded-lg bg-white shadow-md hover:shadow-lg transition-all duration-300"
                        style="display: none;" {{-- Initially hide all items via style --}}>
                        <div class="relative h-64 overflow-hidden">
                            <a href="{{ $project['link'] ?? '#' }}" class="block w-full h-full">
                                <div class="transition-transform duration-300 hover:scale-105">
                                    {{-- Ensure alt attribute is populated --}}
                                    <img src="{{ $project['image'] ?? '' }}"
                                        alt="{{ $project['title'] ?? 'Featured Project' }}"
                                        class="object-cover w-full h-full" loading="lazy" />
                                </div>
                            </a>
                            @if (!empty($project['category']))
                                <div class="absolute top-4 left-4 bg-green-800 text-white text-xs px-2 py-1 rounded">
                                    {{ $project['category'] }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-green-800">
                                <a href="{{ $project['link'] ?? '#' }}">{{ $project['title'] ?? 'Project Title' }}</a>
                            </h3>
                            @if (!empty($project['description']))
                                <p class="mt-2 text-gray-600">
                                    {{ Str::limit($project['description'], 120) }} {{-- Limit description length --}}
                                </p>
                            @endif
                            <a href="{{ $project['link'] ?? '#' }}"
                                class="inline-block mt-4 text-green-800 font-medium hover:text-green-600">
                                View Project Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-white">No featured projects found.</p>
        @endif

        {{-- Portfolio CTA --}}
        <div class="text-center mt-12">
            <x-ui.button href="/portfolio" size="lg" animate="true"
                class="md:mx-auto font-dm-serif w-[22.4rem] md:w-[30rem] hero-button white-to-light-green justify-between"
                icon="icons.right-arrow" iconColor="#016630" secondaryIconColor="#016630">
                View Full Portfolio
            </x-ui.button>
        </div>
    </div>
</section>
