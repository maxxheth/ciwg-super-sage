{{--
Template Name: Privacy Policy
--}}
@extends('layouts.app')

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="{{ get_the_title() }}"
            subtitle="{{ get_post_meta(get_the_ID(), 'hero_subtitle', true) ?? 'Explore our portfolio of landscaping projects' }}"
            :showSpinningLogos="false" titleContWidth="w-full md:w-2/3" height="h-[400px] md:h-[500px]">

            @slot('button')
                <x-ui.button href="{{ get_post_meta(get_the_ID(), 'hero_button_url', true) ?? '/contact' }}" color="green"
                    size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-auto md:w-auto justify-between text-white animate-on-scroll text-xl lg:text-2xl lg:mt-4"
                    icon="icons.right-arrow" type="link">
                    {{ get_post_meta(get_the_ID(), 'hero_button_text', true) ?? 'Contact Us' }}
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Privacy Policy Content Section -->
        <x-ui.section>
            <x-ui.section-header 
                title="{{ $pageData['intro']['title'] }}"
                subtitle="{{ $pageData['intro']['subtitle'] }}"
                centered="true"
                animated="true"
            />

            <div class="max-w-3xl mx-auto space-y-8 text-gray-700 prose">
                @foreach ($pageData['policy_sections'] as $section)
                    <x-ui.card :title="$section['title']" iconContainer="true" iconBg="bg-green-100" iconTextColor="text-green-800">
                        <div class="mt-2">
                            {!! $section['content'] !!}
                        </div>
                    </x-ui.card>
                @endforeach

                <x-ui.divider />

                <p>
                    {{ $pageData['contact_info']['text'] }}
                    <a href="mailto:{{ $pageData['contact_info']['email'] }}" class="text-green-800 underline">{{ $pageData['contact_info']['email'] }}</a>.
                </p>
            </div>
        </x-ui.section>

        <!-- CTA Section -->
        <x-ui.cta 
            title="{{ $pageData['cta']['title'] }}"
            description="{{ $pageData['cta']['description'] }}"
            buttonText="{{ $pageData['cta']['buttonText'] }}"
            buttonUrl="{{ $pageData['cta']['buttonUrl'] }}"
        />
    </main>
@endsection