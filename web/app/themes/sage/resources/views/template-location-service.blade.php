{{--
Template Name: Location Service
--}}
@extends('layouts.app')

@php
    $relatedServices = $service['related_services'] ?? [];
@endphp

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero :title="$service['title']" :subtitle="$service['description']" :showSpinningLogos="false" titleContWidth="w-full lg:w-[53rem]"
            iconColorClass="just-white" height="h-[35rem] md:h-[500px] lg:h-[750px]" imageUrl="{{ $service['hero_image'] }}">
            @slot('button')
                <x-ui.button href="/contact" type="link" color="green" size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                    icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
                    Request a Quote
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <x-ui.section>
            <div class="grid grid-cols-1 gap-12 items-center justify-center">
                <div class="space-y-6 animate-on-scroll">
                    <x-ui.section-header :title="$service['title']" :subtitle="'Serving ' . ($location->post_title ?? 'Your Area')" centered="false" animated="false" />
                    <div class="text-gray-800 font-figtree service-content">
                        {!! $service['content'] !!}
                    </div>
                </div>
            </div>
        </x-ui.section>

        <!-- Service Features -->
        @if (!empty($service['features']))
            <x-ui.section bgColor="bg-gray-50">
                <x-ui.section-header title="Service Features"
                    subtitle="What's included in our {{ $service['title'] }} service" />

                <x-ui.grid :cols="['default' => 1, 'md' => 2]">
                    @foreach ($service['features'] as $feature)
                        <x-ui.card class="flex justify-center items-center" :centerTitle="true" titleSize="text-xl md:text-2xl"
                            :title="$feature['title']" :subtitle="$feature['description']" iconContainer="true" iconBg="bg-green-100">
                            <x-slot:icon>
                                <x-ui.feature-icon :type="$feature['type'] ?? $feature['title']" class="mx-auto text-green-800 feature-icon" />
                            </x-slot:icon>
                        </x-ui.card>
                    @endforeach
                </x-ui.grid>
            </x-ui.section>
        @endif

        <!-- Process Section -->
        @if (!empty($service['process']['steps']))
            <x-ui.section>
                <x-ui.section-header title="{{ $service['process']['section_title'] ?? 'Our Process' }}"
                    subtitle="{{ $service['process']['section_subtitle'] ?? 'How we deliver exceptional results' }}" />

                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-8">
                        @foreach ($service['process']['steps'] as $index => $step)
                            <div class="flex gap-4 animate-on-scroll">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-800 text-white">
                                    @if (isset($step['icon_type']) && $step['icon_type'] != 'default')
                                        <x-ui.feature-icon :type="$step['icon_type']" class="text-green-800 h-6 w-6 feature-icon" />
                                    @else
                                        <span class="text-xl font-bold">{{ $step['step_number'] ?? $index + 1 }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-green-800">{{ $step['title'] }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $step['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-ui.section>
        @endif

        <!-- Related Services -->
        @if ($relatedServices && is_array($relatedServices) && count($relatedServices) > 0)
            <x-ui.section bgColor="bg-gray-50">
                <x-ui.section-header title="Related Services"
                    subtitle="Complete your project with these complementary services" />

                <x-ui.grid :cols="['default' => 1, 'md' => 3]">
                    @foreach ($relatedServices as $related)
                        <x-ui.card :title="$related['title']" :imageUrl="$related['image']" :imageAlt="$related['title']">
                            <div class="mt-4">
                                <a href="{{ $related['url'] }}" class="inline-block text-green-800 hover:underline">Learn
                                    more
                                    →</a>
                            </div>
                        </x-ui.card>
                    @endforeach
                </x-ui.grid>
            </x-ui.section>
        @endif

        <!-- CTA Section -->
        <x-ui.cta title="Ready to Start Your Project in {{ $location->post_title ?? 'Your Area' }}?"
            description="Contact us today to schedule a consultation with one of our expert designers."
            buttonText="Get Started" buttonUrl="/contact" />
    </main>
@endsection