{{--
Template Name: Terms and Conditions
--}}
@extends('layouts.app')

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero 
            title="{{ $pageData['hero']['title'] }}" 
            subtitle="{{ $pageData['hero']['subtitle'] }}"
            :showSpinningLogos="false"
            height="h-[20rem] md:h-[300px] lg:h-[400px]"
            showTitleUnderline="true"
            titleUnderlineColor="#67B649"
        />

        <!-- Terms Content Section -->
        <x-ui.section>
            <x-ui.section-header 
                title="{{ $pageData['intro']['title'] }}"
                subtitle="{{ $pageData['intro']['subtitle'] }}"
                centered="true"
                animated="true"
            />

            <div class="max-w-3xl mx-auto space-y-8">
                @foreach ($pageData['terms_sections'] as $section)
                    <div class="prose max-w-none">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $section['title'] }}</h3>
                        {!! $section['content'] !!}
                    </div>
                @endforeach

                <x-ui.divider />

                <p class="text-gray-700">
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