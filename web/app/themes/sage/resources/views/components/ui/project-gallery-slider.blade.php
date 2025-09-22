@props(['images' => [], 'title' => '', 'id' => 'project-gallery'])

<div {{ $attributes->merge(['class' => 'project-gallery-container animate-on-scroll']) }} id="{{ $id }}">
    <!-- Main Swiper -->
    <div id="{{ $id }}-main" class="swiper project-gallery-swiper project-gallery-swiper-main">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Thumbs Swiper -->
    <div id="{{ $id }}-thumbs" class="swiper project-gallery-swiper project-gallery-swiper-thumbs">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    </div>
</div>
