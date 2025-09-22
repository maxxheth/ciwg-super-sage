@extends('layouts.app')

@section('content')
    @php
        // You might fetch additional data via a Composer or directly here
        $featured_image_url = has_post_thumbnail()
            ? get_the_post_thumbnail_url(get_the_ID(), 'large')
            : \Roots\asset('images/placeholder-hero.jpg')->uri();
        $post_date = get_the_date();

        // Get all post meta

        $titleWFallback = $title ?? get_the_title();

        $authorWFallback = $author ?? get_the_author_meta('display_name');

        // Example: Fetch related posts if you have a function/logic for it
        // $related_posts = get_related_posts(get_the_ID(), 3);

    @endphp

    <main class="flex-1 article-content">
        {{-- Optional Hero Section --}}
        <x-ui.hero :title="$titleWFallback" :showButton="false" :subtitle="'Published on ' . $post_date . ' by ' . $authorWFallback" :imageUrl="$featured_image_url"
            height="h-[30rem] md:h-[400px] lg:h-[500px]" :showSpinningLogos="false" titleContWidth="w-full lg:w-[60rem]"
            iconColorClass="just-white" />

        {{-- Post Content Section --}}
        <x-ui.section>
            <div class="prose lg:prose-xl mx-auto font-figtree"> {{-- Adjust prose classes as needed --}}
                {!! get_the_content() !!}
            </div>
        </x-ui.section>

        {{-- Post Meta/Info Section --}}
        <x-ui.section bgColor="bg-gray-50">
            <div class="text-center text-gray-600">
                <p>
                    <strong>Categories:</strong> {!! get_the_category_list(', ') !!}
                </p>
                @if (get_the_tags())
                    <p class="mt-2">
                        <strong>Tags:</strong> {!! get_the_tag_list('', ', ') !!}
                    </p>
                @endif
            </div>
        </x-ui.section>

        {{-- Optional Related Posts Section --}}
        {{--
    @if (!empty($related_posts))
      <x-ui.section>
        <x-ui.section-header title="Related Articles" subtitle="Read more on similar topics" />
        <x-ui.grid :cols="['default' => 1, 'md' => 3]">
          @foreach ($related_posts as $related_post)
            @php
              $related_image = has_post_thumbnail($related_post->ID) ? get_the_post_thumbnail_url($related_post->ID, 'medium') : \Roots\asset('images/placeholder-card.jpg')->uri();
            @endphp
            <x-ui.card
              :title="$related_post->post_title"
              :imageUrl="$related_image"
              :imageAlt="$related_post->post_title"
            >
              <div class="mt-4">
                <a href="{{ get_permalink($related_post->ID) }}" class="inline-block text-green-800 hover:underline">Read more →</a>
              </div>
            </x-ui.card>
          @endforeach
        </x-ui.grid>
      </x-ui.section>
    @endif
    --}}

        {{-- Comments Section --}}
        @if (comments_open() || get_comments_number())
            <x-ui.section>
                <div class="max-w-3xl mx-auto">
                    @php comments_template('/partials/comments.blade.php') @endphp
                </div>
            </x-ui.section>
        @endif

    </main>
@endsection
