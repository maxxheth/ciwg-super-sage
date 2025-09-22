{{--
Template Name: Portfolio Project
--}}
@extends('layouts.app')

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="{{ $project['title'] ?? 'Project Details' }}" subtitle="{{ $project['category'] ?? '' }}"
            :showSpinningLogos="false" height="h-[400px] md:h-[500px]" iconColorClass="just-white"
            height="h-[35rem] md:h-[500px] lg:h-[750px]">

            @slot('button')
                <x-ui.button href="/contact" type="link" color="green" size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                    icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
                    Request a Consultation
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Project Details -->
        <x-ui.section>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="animate-on-scroll">
                    @php
                        // Create an array with the featured image first, followed by gallery images
                        $allProjectImages = array_merge(
                            [$project['image'] ?? ''],
                            !empty($project['gallery']) ? $project['gallery'] : []
                        );
                    @endphp

                    <x-ui.project-gallery-slider :images="$allProjectImages" :title="$project['title'] ?? 'Project'" id="project-detail-gallery" />
                </div>

                <div class="space-y-6 animate-on-scroll">
                    <h2 class="text-3xl font-semibold text-green-800">{{ $project['title'] ?? 'Project Details' }}</h2>

                    <div class="flex flex-wrap gap-2">
                        @if (!empty($project['category']))
                            <span
                                class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                {{ $project['category'] }}
                            </span>
                        @endif
                        @if (!empty($project['location']))
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                {{ $project['location'] }}
                            </span>
                        @endif
                    </div>

                    <div class="prose text-gray-600">
                        {!! $project['description'] ?? '' !!}
                    </div>

                    @if (!empty($project['services']))
                        <div
                            subtitle="{{ get_post_meta(get_the_ID(), 'hero_subtitle', true) ?? 'Transforming outdoor spaces with our expert landscaping services' }}">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Services Provided:</h3>
                            <ul class="list-disc list-inside space-y-1 text-gray-600">
                                @foreach ($project['services'] as $service)
                                    <li>{{ $service }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if (!empty($project['client']))
                            <div>
                                <h3 class="text-lg font-semibold text-green-800 mb-1">Client:</h3>
                                <p class="text-gray-600">{{ $project['client'] }}</p>
                            </div>
                        @endif

                        @if (!empty($project['project_size']))
                            <div>
                                <h3 class="text-lg font-semibold text-green-800 mb-1">Project Size:</h3>
                                <p class="text-gray-600">{{ $project['project_size'] }}</p>
                            </div>
                        @endif

                        @if (!empty($project['completion_date']))
                            <div>
                                <h3 class="text-lg font-semibold text-green-800 mb-1">Completed:</h3>
                                <p class="text-gray-600">{{ $project['completion_date'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-ui.section>

        <!-- Project Challenges and Solutions -->
        @if (!empty($project['challenges']) || !empty($project['solutions']))
            <x-ui.section bgColor="bg-gray-50">
                <x-ui.section-header title="Project Challenges & Solutions"
                    subtitle="How we tackled the unique aspects of this project" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    @if (!empty($project['challenges']))
                        <div class="space-y-4 animate-on-scroll">
                            <h3 class="text-xl font-semibold text-green-800">Challenges</h3>
                            <div class="prose text-gray-600">
                                {!! $project['challenges'] !!}
                            </div>
                        </div>
                    @endif

                    @if (!empty($project['solutions']))
                        <div class="space-y-4 animate-on-scroll">
                            <h3 class="text-xl font-semibold text-green-800">Solutions</h3>
                            <div class="prose text-gray-600">
                                {!! $project['solutions'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </x-ui.section>
        @endif

        <!-- Design and Materials -->
        @if (!empty($project['design_approach']) || !empty($project['materials']))
            <x-ui.section>
                <x-ui.section-header title="Design & Implementation"
                    subtitle="The elements that brought this project to life" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    @if (!empty($project['design_approach']))
                        <div class="space-y-4 animate-on-scroll">
                            <h3 class="text-xl font-semibold text-green-800">Design Approach</h3>
                            <div class="prose text-gray-600">
                                {!! $project['design_approach'] !!}
                            </div>
                        </div>
                    @endif

                    @if (!empty($project['materials']))
                        <div class="space-y-4 animate-on-scroll">
                            <h3 class="text-xl font-semibold text-green-800">Materials & Plants</h3>
                            <div class="prose text-gray-600">
                                {!! $project['materials'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </x-ui.section>
        @endif

        <!-- Results & Client Satisfaction -->
        @if (!empty($project['results']) || !empty($project['client_testimonial']))
            <x-ui.section bgColor="bg-gray-50">
                <x-ui.section-header title="Project Outcomes" subtitle="The impact of our landscape transformation" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    @if (!empty($project['results']))
                        <div class="space-y-4 animate-on-scroll">
                            <h3 class="text-xl font-semibold text-green-800">Results</h3>
                            <div class="prose text-gray-600">
                                {!! $project['results'] !!}
                            </div>
                        </div>
                    @endif

                    @if (!empty($project['client_testimonial']))
                        <div class="animate-on-scroll">
                            <x-ui.testimonial quote="{{ $project['client_testimonial'] }}"
                                author="{{ $project['client_testimonial_author'] ?? ($project['client'] ?? '') }}"
                                position="{{ $project['client_testimonial_position'] ?? '' }}" />
                        </div>
                    @endif
                </div>
            </x-ui.section>
        @endif

        <!-- Related Projects Section -->
        @if (!empty($related_projects))
            <x-ui.section>
                <x-ui.section-header title="Similar Projects" subtitle="Explore more of our landscape transformations" />

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($related_projects as $related)
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}"
                                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                @if (!empty($related['category']))
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-green-800 text-white text-xs font-bold px-2 py-1 rounded">{{ $related['category'] }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-green-800 mb-1">{{ $related['title'] }}</h3>
                                @if (!empty($related['location']))
                                    <p class="text-sm text-gray-500 mb-3">{{ $related['location'] }}</p>
                                @endif
                                @if (!empty($related['description']))
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $related['description'] }}</p>
                                @endif
                                <a href="{{ $related['url'] }}"
                                    class="inline-block text-green-800 hover:underline font-medium">
                                    View Project Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-ui.section>
        @endif

        <!-- CTA Section -->
        <x-ui.cta title="Ready to Transform Your Landscape?"
            description="Contact us today to discuss your project and discover how we can create a stunning outdoor space tailored to your needs."
            buttonText="Request a Consultation" buttonUrl="/contact" />
    </main>
@endsection
