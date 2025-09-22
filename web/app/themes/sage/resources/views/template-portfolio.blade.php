{{--
Template Name: Portfolio
--}}
@extends('layouts.app')

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="{{ $pageData['hero']['title'] }}" subtitle="{{ $pageData['hero']['subtitle'] }}" :showSpinningLogos="false"
            height="h-[400px] md:h-[500px]">

            @slot('button')
                <x-ui.button href="{{ $pageData['hero']['button_url'] }}" color="green" size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-auto md:w-auto justify-between text-white animate-on-scroll text-xl lg:text-2xl lg:mt-4"
                    icon="icons.right-arrow" type="link">
                    {{ $pageData['hero']['button_text'] }}
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Portfolio Introduction -->
        <x-ui.section>
            <x-ui.section-header title="{{ $pageData['intro']['title'] }}"
                subtitle="{{ $pageData['intro']['subtitle'] }}" />

            <div class="prose max-w-4xl mx-auto text-center animate-on-scroll">
                {!! $pageData['intro']['content'] !!}
            </div>

            <!-- Project Category Filters -->
            <div class="flex flex-wrap justify-center gap-4 mb-12 animate-on-scroll hidden">
                @foreach ($categories as $key => $category)
                    <button
                        class="px-4 py-2 rounded-full {{ $key === 'all' ? 'bg-green-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors"
                        data-filter="{{ $key }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </x-ui.section>

        <!-- Featured Project -->
        <x-ui.section bgColor="bg-gray-50">
            <x-ui.section-header title="Featured Project" subtitle="A closer look at one of our signature landscapes" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-on-scroll self-start">
                    @php
                        // Create an array with the featured image first, followed by gallery images
                        $allImages = array_merge([$featuredProject['image']], $featuredProject['gallery']);
                    @endphp

                    <x-ui.project-gallery-slider :images="$allImages" :title="$featuredProject['title']" id="featured-project-gallery" />
                </div>

                <div class="space-y-6 animate-on-scroll self-start pt-0">
                    <h3 class="text-3xl font-semibold text-green-800 -mt-[7px]">{{ $featuredProject['title'] }}</h3>

                    <div class="flex flex-wrap gap-2">
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            {{ $featuredProject['category'] }}
                        </span>
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                            {{ $featuredProject['location'] }}
                        </span>
                    </div>

                    <p class="text-gray-600">{{ strip_tags($featuredProject['description']) }}</p>

                    @if (!empty($featuredProject['services']))
                        <div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Services Provided:</h4>
                            <ul class="list-disc list-inside space-y-1 text-gray-600">
                                @foreach ($featuredProject['services'] as $service)
                                    <li>{{ $service }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($featuredProject['client']))
                        <div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Client:</h4>
                            <p class="text-gray-600">{{ $featuredProject['client'] }}</p>
                        </div>
                    @endif

                    @if (!empty($featuredProject['project_size']))
                        <div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Project Size:</h4>
                            <p class="text-gray-600">{{ $featuredProject['project_size'] }}</p>
                        </div>
                    @endif

                    @if (!empty($featuredProject['completion_date']))
                        <div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Completed:</h4>
                            <p class="text-gray-600">{{ $featuredProject['completion_date'] }}</p>
                        </div>
                    @endif

                    <x-ui.button href="{{ $featuredProject['url'] }}"
                        class="hero-button just-white bg-green-800 hover:bg-primary-light font-dm-serif w-auto md:w-auto justify-between text-white animate-on-scroll text-xl lg:text-2xl lg:mt-4"
                        icon="icons.right-arrow" size="md">
                        View Project Details
                    </x-ui.button>
                </div>
            </div>
        </x-ui.section>

        <!-- Project Gallery -->
        <x-ui.section>
            <x-ui.section-header title="Project Gallery" subtitle="Explore our diverse portfolio of landscape projects" />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-container animate-on-scroll">
                @foreach ($projects as $project)
                    <div class="project-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 stagger-item"
                        data-category="{{ $project['category_slug'] }}">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-green-800 text-white text-xs font-bold px-2 py-1 rounded">{{ $project['category'] }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-green-800 mb-1">{{ $project['title'] }}</h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $project['location'] }}</p>
                            <p class="text-gray-600 mb-4">{{ $project['description'] }}</p>
                            <a href="{{ $project['url'] }}"
                                class="inline-block text-green-800 hover:underline font-medium">
                                View Project Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <x-ui.button href="/contact" color="green" size="md" animate="true"
                    class="hero-button just-white font-dm-serif w-auto md:w-[30rem] mx-auto justify-between text-white animate-on-scroll text-xl lg:text-2xl lg:mt-4"
                    icon="icons.right-arrow" type="link">
                    Request Your Custom Landscape
                </x-ui.button>
            </div>
        </x-ui.section>

        <!-- Process Section -->
        <x-ui.section bgColor="bg-green-800" padding="py-20">
            <x-ui.section-header title="Our Project Process" subtitle="How we bring exceptional landscapes to life"
                titleColor="text-white" subtitleColor="text-green-100" />

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-white">
                <x-ui.process number="01" title="Consultation"
                    description="We begin by understanding your vision, needs, and the unique characteristics of your property." />

                <x-ui.process number="02" title="Design"
                    description="Our expert designers create custom landscape plans tailored to your aesthetic preferences and practical requirements." />

                <x-ui.process number="03" title="Installation"
                    description="Our skilled crews bring the design to life with precision and attention to detail." />

                <x-ui.process number="04" title="Maintenance"
                    description="We provide ongoing care to ensure your landscape continues to thrive and evolve beautifully over time." />
            </div>
        </x-ui.section>

        <!-- Testimonials -->
        <x-ui.section>
            <x-ui.section-header title="Client Testimonials" subtitle="What our clients say about our landscape projects" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($testimonials as $testimonial)
                    <x-ui.testimonial quote="{{ $testimonial['quote'] }}" author="{{ $testimonial['author'] }}"
                        position="{{ $testimonial['position'] }}" />
                @endforeach
            </div>
        </x-ui.section>

        <!-- CTA Section -->
        <x-ui.cta title="Ready to Transform Your Landscape?"
            description="Contact us today to discuss your project and discover how we can enhance your outdoor space."
            buttonText="Request a Consultation" buttonUrl="/contact" />
    </main>
@endsection
