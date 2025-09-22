{{--
Template Name: Services
--}}
@extends('layouts.app')

@php
    $buttonText = get_post_meta(get_the_ID(), 'hero_button_text', true);
@endphp

@section('content')
    <main class="flex-1">

        <!-- Hero Section -->
        <x-ui.hero title="{{ get_the_title() }}"
            subtitle="{{ get_post_meta(get_the_ID(), 'hero_subtitle', true) ?? 'Transforming outdoor spaces with our expert landscaping services' }}"
            :showSpinningLogos="false" height="h-[400px] md:h-[500px]" titleContWidth="w-full lg:w-[46rem]">

            @slot('button')
                <x-ui.button href="{{ get_post_meta(get_the_ID(), 'hero_button_url', true) ?? '/contact' }}" color="green"
                    size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-auto md:w-auto justify-between text-white animate-on-scroll text-xl lg:text-2xl lg:mt-4"
                    icon="icons.right-arrow" type="link">
                    {{ !empty($buttonText) ? $buttonText : 'Request a Quote' }}
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Detailed Services List -->
        <x-ui.section bgColor="bg-gray-50">
            <x-ui.section-header id="services" title="Our Complete Services"
                subtitle="Discover the full range of landscaping solutions we offer" />

            <x-ui.grid :cols="['default' => 1, 'md' => 2, 'lg' => 2]" class="gap-8">
                @foreach ($detailedServices as $service)
                    <x-ui.card title="{{ $service['title'] ?? '' }}" subtitle="{{ $service['subtitle'] ?? '' }}"
                        imageUrl="{{ $service['image'] }}" imageAlt="{{ $service['title'] }}" imageLayout="hero">
                        <p class="text-gray-600 mb-0">{{ $service['description'] }}</p>
                        @if (!empty($service['url']))
                            <a href="{{ $service['url'] }}" class="inline-block text-green-800 hover:underline mt-0">Learn
                                more →</a>
                        @endif
                    </x-ui.card>
                @endforeach
            </x-ui.grid>
        </x-ui.section>

        <!-- Process Section -->
        <x-ui.section bgColor="bg-green-800" padding="py-20">
            <x-ui.section-header title="Our Service Process"
                subtitle="How we deliver exceptional landscapes from concept to completion" titleColor="text-white"
                subtitleColor="text-green-100" />

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-white">
                <x-ui.process number="01" title="Consultation"
                    description="We begin with a thorough consultation to understand your needs, preferences, and the unique characteristics of your property." />

                <x-ui.process number="02" title="Design & Planning"
                    description="Our designers create a custom plan for your landscape, incorporating your ideas with our expertise to achieve the perfect balance." />

                <x-ui.process number="03" title="Implementation"
                    description="Our skilled crews bring the design to life with precision and care, following our strict quality standards throughout the process." />

                <x-ui.process number="04" title="Maintenance"
                    description="We provide ongoing care and maintenance to ensure your landscape continues to thrive and evolve beautifully over time." />
            </div>
        </x-ui.section>

        <!-- Testimonials -->
        <x-ui.section>
            <x-ui.section-header title="What Our Clients Say About Our Services"
                subtitle="Don't just take our word for it - hear from our satisfied customers" />

            <x-ui.grid :cols="['default' => 1, 'md' => 2]">
                @foreach ($testimonials as $testimonial)
                    <x-ui.testimonial quote="{{ $testimonial['quote'] }}" author="{{ $testimonial['author'] }}"
                        position="{{ $testimonial['position'] }}" />
                @endforeach
            </x-ui.grid>
        </x-ui.section>

        <!-- FAQ Section -->
        <x-ui.section bgColor="bg-gray-50">
            <x-ui.section-header title="Frequently Asked Questions"
                subtitle="Answers to common questions about our services" />

            <div class="max-w-3xl mx-auto space-y-6">
                @foreach ($faqs as $faq)
                    <div class="animate-on-scroll">
                        <h3 class="text-lg font-semibold text-green-800 text-center">{{ $faq['question'] }}</h3>
                        <p class="mt-2 text-gray-600 text-center">{{ $faq['answer'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.section>

        <!-- CTA Section -->
        <x-ui.cta title="Ready to Transform Your Landscape?"
            description="Contact us today for a consultation and discover how our services can enhance your outdoor space."
            buttonText="Request a Quote" buttonUrl="/contact" />
    </main>
@endsection
