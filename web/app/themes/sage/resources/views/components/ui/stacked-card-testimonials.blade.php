<!-- resources/views/components/testimonials/stacked-cards.blade.php -->
@props(['testimonials' => []])

<section class="bg-white py-24 px-4 lg:px-8 grid items-center grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-4 overflow-hidden">
    <div class="p-4">
        <h3 class="text-5xl font-semibold">What our customers think</h3>
        <p class="text-slate-500 my-4">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minus
            commodi sint, similique cupiditate possimus suscipit delectus illum
            eos iure magnam!
        </p>
        <div class="flex gap-1 mt-8" id="testimonial-buttons">
            @foreach ($testimonials as $index => $testimonial)
                <button type="button" data-index="{{ $index }}" class="h-1.5 w-full bg-slate-300 relative group">
                    <span class="absolute top-0 left-0 bottom-0 bg-slate-950 transition-all duration-500 ease-linear"
                        style="width: 0%" data-progress="{{ $index }}"></span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="p-4 relative h-[450px] lg:h-[500px] shadow-xl" id="testimonial-cards">
        @foreach ($testimonials as $index => $testimonial)
            <div class="absolute top-0 left-0 w-full min-h-full p-8 lg:p-12 cursor-pointer flex flex-col justify-between transition-all duration-300 ease-out"
                data-index="{{ $index }}"
                style="
                    z-index: {{ $index }};
                    transform-origin: left bottom;
                    background: {{ $index % 2 ? 'black' : 'white' }};
                    color: {{ $index % 2 ? 'white' : 'black' }};
                    transform: scale(1) translateX(0);
                ">
                <x-dynamic-component :component="'icons.' . strtolower($testimonial['icon'])" class="text-7xl mx-auto" />
                <p class="text-lg lg:text-xl font-light italic my-8">
                    "{{ $testimonial['description'] }}"
                </p>
                <div>
                    <span class="block font-semibold text-lg">{{ $testimonial['name'] }}</span>
                    <span class="block text-sm">{{ $testimonial['title'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
</section>
