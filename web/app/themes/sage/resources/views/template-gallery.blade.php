{{--
Template Name: Gallery
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

        <!-- Gallery Introduction -->
        <x-ui.section>
            <x-ui.section-header title="{{ get_post_meta(get_the_ID(), 'intro_title', true) ?? 'Our Project Gallery' }}"
                subtitle="{{ get_post_meta(get_the_ID(), 'intro_subtitle', true) ?? 'A showcase of our finest landscaping work' }}" />

            <div class="max-w-3xl mx-auto text-center mb-12 animate-on-scroll">
                {!! get_post_meta(get_the_ID(), 'intro_content', true) ??
                    '<p class="text-lg text-gray-600">Browse through our collection of completed projects to see the quality and craftsmanship we bring to every landscape we create.</p>' !!}
            </div>
        </x-ui.section>

        <!-- Main Gallery Section -->
        <x-ui.section bgColor="bg-gray-50" padding="py-16">
            <div class="container mx-auto px-4">
                @include('components.gallery', ['id' => 'main-gallery'])
            </div>
        </x-ui.section>

        <!-- Category Galleries (optional) -->
        @php
            $gallery_categories = get_post_meta(get_the_ID(), 'gallery_categories', true);
        @endphp

        @if (!empty($gallery_categories) && is_array($gallery_categories))
            @foreach ($gallery_categories as $category)
                <x-ui.section padding="py-16">
                    <x-ui.section-header title="{{ $category['title'] ?? 'Project Gallery' }}"
                        subtitle="{{ $category['subtitle'] ?? 'Explore our work' }}" />

                    <div class="container mx-auto px-4">
                        @php
                            $gallery_composer = new \App\View\Composers\Gallery(view());
                            $category_images = $gallery_composer->getGalleryImages($category['directory'] ?? null);
                        @endphp

                        <div class="pswp-gallery grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                            id="gallery--{{ $category['slug'] ?? 'category' }}" data-pswp-gallery>
                            @foreach ($category_images as $image)
                                <a href="{{ $image['url'] }}" data-pswp-width="{{ $image['width'] }}"
                                    data-pswp-height="{{ $image['height'] }}" class="gallery-item">
                                    <img src="{{ $image['thumbnailUrl'] ?? $image['url'] }}" alt="{{ $image['name'] }}"
                                        class="w-full aspect-square object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow"
                                        loading="lazy" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </x-ui.section>
            @endforeach
        @endif

        <!-- CTA Section -->


        <x-ui.button href="/contact-us" color="green" size="lg" animate="true"
            class="hero-button mx-auto just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl my-16"
            icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
            Contact Us
        </x-ui.button>
    </main>
@endsection
