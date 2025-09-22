<div class="pswp-gallery grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="gallery--{{ $id ?? 'main' }}"
    data-pswp-gallery>
    @foreach ($galleryImages as $index => $image)
        <a href="{{ $image['url'] }}" data-pswp-width="{{ $image['width'] }}" data-pswp-height="{{ $image['height'] }}"
            data-pswp-caption="{{ $galleryCaptions[$image['name']] }}" class="gallery-item group">
            <div class="overflow-hidden rounded-lg shadow-md group-hover:shadow-lg transition-all duration-300">
                <img src="{{ $image['thumbnailUrl'] ?? $image['url'] }}" alt="{{ $image['name'] }}"
                    class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy" />
            </div>
        </a>
    @endforeach
</div>
