<!-- components/logo-item.blade.php -->
@props([
    'alt' => 'img description',
    'img_path' => '/path/to/logo-img/',
    'href' => 'https://google.com'
])

<a href="/" rel="nofollow" target="_blank"
    class="w-16 md:w-24 h-16 md:h-24 flex justify-center items-center hover:bg-slate-200 text-black transition-colors">
    <img src="{{ $img_path }}" alt="{{ $alt }}" class="w-10 md:w-16 h-auto" />
</a>
