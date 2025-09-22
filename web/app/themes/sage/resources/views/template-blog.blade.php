{{--
Template Name: Blog
--}}
@extends('layouts.app')

@php
    $bg_image = Vite::asset('resources/images/sprinklers-business-park.webp');

    $waterImage = '';
    $outdoorImage = '';
    $nativeImage = '';

    $categories = [
        'All Posts',
        'Landscape Design',
        'Plant Selection',
        'Maintenance',
        'Irrigation',
        'Hardscaping',
        'Native Plants',
        'Seasonal Tips'
    ];
@endphp

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="Landscaping Insights & Inspiration"
            subtitle="Expert tips, trends, and ideas to enhance your outdoor spaces" :showButton="false" buttonText="Subscribe"
            buttonUrl="/subscribe" :showSpinningLogos="false" height="h-[350px] md:h-[400px]" />

        <!-- Featured Post Section -->
        @if ($featured_post)
            <x-ui.section padding="py-12">
                <x-ui.section-header title="Featured Article" titleStyles="mb-12 text-2xl md:text-5xl font-dm-serif font-bold"
                    centered="true" />

                @php
                    get_the_excerpt($featured_post);
                    $excerpt = get_the_excerpt($featured_post);
                    $excerpt = preg_replace('/<a[^>]*>(.*?)<\/a>/i', '', $excerpt);
                    $excerpt = wp_trim_words($excerpt, 50, '...'); // Limit to 20 words
                    $excerpt = str_replace('Continue', '', $excerpt); // Remove "Read more" text
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 animate-on-scroll">
                    <div class="lg:col-span-3 rounded-md overflow-hidden shadow-md">
                        <img src="{{ get_the_post_thumbnail_url($featured_post->ID, 'large') }}"
                            alt="{{ $featured_post->post_title }}" class="w-full h-[300px] md:h-[400px] object-cover">
                    </div>
                    <div class="lg:col-span-2 flex flex-col justify-start">
                        <div class="mb-2 text-sm text-gray-500">
                            {{ get_the_date('', $featured_post->ID) }} • By
                            {{ get_the_author_meta('display_name', $featured_post->post_author) }}
                        </div>
                        <h2 class="text-2xl font-bold text-green-800 mb-4">{{ $featured_post->post_title }}</h2>
                        <p class="text-gray-600 mb-6">{!! $excerpt !!}</p>
                        <x-ui.button href="{{ get_permalink($featured_post->ID) }}" color="green" size="xs"
                            animate="true"
                            class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:mt-2"
                            icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
                            Read Full Article
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.section>
        @endif

        <!-- Blog Categories -->
        <x-ui.section bgColor="bg-gray-50" padding="py-8">
            <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                @foreach ($categories as $category)
                    <a href="#"
                        class="px-4 py-2 rounded-full {{ $category === 'All Posts' ? 'bg-green-800 text-white' : 'bg-white text-gray-600 hover:bg-green-100' }} transition-colors duration-300">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </x-ui.section>

        <!-- Blog Posts Grid -->
        <x-ui.section padding="py-12" containerClass="container px-4 mx-auto">
            <x-ui.section-header title="Latest Articles" subtitle="Stay up to date with our latest landscaping insights" />

            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-container animate-on-scroll bg-800-green">
                {{-- Check if the query has posts --}}
                @if ($posts->have_posts())
                    {{-- Start the loop --}}
                    @while ($posts->have_posts())
                        @php $posts->the_post(); @endphp
                        @php
                            // Prepare data using standard WP functions inside the loop
                            $post_id = get_the_ID();
                            $post_url = get_permalink($post_id);
                            $post_title = get_the_title($post_id);
                            $post_excerpt = get_the_excerpt($post_id);

                            // Strip all links from post excerpt.

                            $post_excerpt = preg_replace('/<a[^>]*>(.*?)<\/a>/i', '', $post_excerpt);
                            $post_excerpt = wp_trim_words($post_excerpt, 50, '...'); // Limit to 20 words
                            $post_excerpt = str_replace('Continue', '', $post_excerpt); // Remove "Read more" text

                            $post_date = get_the_date('', $post_id); // Format as needed
                            $post_image = has_post_thumbnail($post_id)
                                ? get_the_post_thumbnail_url($post_id, 'medium_large')
                                : \Roots\asset('images/placeholder-card.jpg')->uri(); // Adjust size and placeholder
                            $categories = get_the_category($post_id);
                            $post_category = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized'; // Get first category name
                        @endphp
                        <div
                            class="shadow-primary shadow-sm hover:shadow-md rounded-lg overflow-hidden hover:-translate-y-1 transition-all duration-300 stagger-item">
                            <a href="{{ $post_url }}" class="block overflow-hidden">
                                <img src="{{ $post_image }}" alt="{{ $post_title }}"
                                    class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                            </a>
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-green-800 font-medium">{!! $post_category !!}</span>
                                    <span class="text-sm text-gray-500">{{ $post_date }}</span>
                                </div>
                                <h3 class="text-xl font-semibold text-green-800 mb-2">
                                    <a href="{{ $post_url }}" class="hover:underline">{!! $post_title !!}</a>
                                </h3>
                                <p class="text-gray-600 mb-4">{!! $post_excerpt !!}</p>
                                <a href="{{ $post_url }}" class="inline-block text-green-800 hover:underline">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    @endwhile
                    {{-- Reset post data after the loop --}}
                    @php wp_reset_postdata(); @endphp
                @else
                    <p class="col-span-full text-center text-gray-500">No posts found.</p>
                @endif
            </div>

        </x-ui.section>

        <!-- Newsletter Section -->
        <!--- <x-ui.section bgColor="bg-green-800" padding="py-16">
                            <div class="max-w-2xl mx-auto text-center animate-on-scroll">
                                <h2 class="text-2xl font-bold text-white mb-4">Subscribe to Our Newsletter</h2>
                                <p class="text-green-100 mb-8">Get seasonal landscaping tips, design inspiration, and exclusive offers
                                    delivered to your inbox.</p>

                                <form class="max-w-md mx-auto">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="email" placeholder="Your email address"
                                            class="bg-white flex-grow px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300">

                                        <x-ui.button type="submit" color="light-green" size="md">
                                            Subscribe
                                        </x-ui.button>
                                    </div>
                                    <p class="mt-4 text-sm text-green-100">We respect your privacy and will never share your information.
                                    </p>
                                </form>
                            </div>
                        </x-ui.section> -->

        <!-- Popular Topics -->
        <x-ui.section bgColor="bg-gray-50" padding="py-12">
            <x-ui.section-header title="Popular Topics" subtitle="Explore our most-read landscaping subjects" />

            <x-ui.grid :cols="['default' => 1, 'md' => 3]">
                <x-ui.card title="Water Conservation" subtitle="Strategies for beautiful landscapes that use less water"
                    :imageUrl="$bg_image" imageAlt="Water Conservation">
                    <div class="mt-4">
                        <a href="/blog/category/water-conservation" class="inline-block text-green-800 hover:underline">View
                            articles →</a>
                    </div>
                </x-ui.card>

                <x-ui.card title="Outdoor Living"
                    subtitle="Creating functional, beautiful spaces for relaxation and entertainment" :imageUrl="$bg_image"
                    imageAlt="Outdoor Living">
                    <div class="mt-4">
                        <a href="/blog/category/outdoor-living" class="inline-block text-green-800 hover:underline">View
                            articles →</a>
                    </div>
                </x-ui.card>

                <x-ui.card title="Native Landscaping"
                    subtitle="Using Texas native plants for sustainable, low-maintenance gardens" :imageUrl="$bg_image"
                    imageAlt="Native Landscaping">
                    <div class="mt-4">
                        <a href="/blog/category/native-landscaping" class="inline-block text-green-800 hover:underline">View
                            articles →</a>
                    </div>
                </x-ui.card>
            </x-ui.grid>
        </x-ui.section>

        <!-- CTA Section -->
        <x-ui.cta title="Have Questions About Your Landscape?"
            description="Our experts are ready to help with personalized advice for your specific needs."
            buttonText="Contact Us" buttonUrl="/contact" />
    </main>
@endsection
