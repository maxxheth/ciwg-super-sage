@props([
    'title' => 'Experience the Green Difference',
    'subtitle' => 'Landscaping & Landscape Services Company in Dallas, TX',
    'titleContWidth' => 'w-full md:w-2/3',
    'showButton' => true,
    'buttonText' => 'Request a Consultation',
    'buttonUrl' => '#contact',
    'buttonId' => '#button',
    'imageUrl' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
    'overlay' => false,
    'height' => 'sm:h-[800px] md:h-[250px] lg:h-[750px]',
    'defaultClasses' => 'relative z-20',
    'align' => 'left', // left, center, right
    'titleBackground' => true,
    'buttonColor' => 'green',
    'buttonSize' => 'lg',
    'iconColor' => '#ffffff',
    'iconSecondaryColor' => '#016630',
    'iconColorClass' => 'white-to-green',
    'showSpinningLogos' => true,
    'spinningLogoClasses' =>
        'spinning-logos-container absolute right-1/2 lg:right-24 lg:top-[50%] lg:-translate-y-1/2 grid place-content-center overflow-hidden bg-transparent px-4 py-12 animate-on-scroll',
    'showTitleUnderline' => false,
    'showSubtitleUnderline' => false,
    'titleUnderlineColor' => '#67B649',
    'subtitleUnderlineColor' => '#67B649',
    'titleUnderlineHeight' => '48px',
    'titleUnderlineWidth' => '100%',
    'titleUnderlinePathStyle' => 'wide',
    'titleUnderlineWidthMultiplier' => '2.8',
    'titleUnderlinePosition' => 'absolute',
    'titleUnderlineTop' => '1rem',
    'showMarquee' => false,
    'showForm' => false,
    'heroContainerHeight' => 'h-full',
    'flexConf' => 'flex flex-col justify-start lg:justify-center'
])

@if ($height && $defaultClasses)
    <section {{ $attributes->merge(['class' => "$defaultClasses $height"]) }}>
    @elseif($defaultClasses && !$height)
        <section {{ $attributes->merge(['class' => "$defaultClasses"]) }}>
        @elseif(!$defaultClasses && $height)
            <section {{ $attributes->merge(['class' => "$height"]) }}>
            @elseif(!$defaultClasses && !$height)
                <section {{ $attributes }}>
@endif
<div class="absolute inset-0">
    @if (isset($imageUrl))
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="object-cover w-full h-full" />
    @elseif (isset($bg_image))
        <div class="absolute w-full h-full" style="background-image: url('{{ $bg_image }}'); background-size: cover;">
        </div>
    @endif

    @if ($overlay)
        <div class="absolute inset-0 bg-black/30"></div>
    @endif
</div>

<div
    class="container relative z-20 {{ $flexConf }} items-{{ $align === 'center' ? 'center' : ($align === 'right' ? 'end' : 'start') }} {{ $heroContainerHeight }} px-4">

    <div class="flex flex-col">

    @if ($titleBackground)
        <div class="{{ $titleContWidth }} p-6 bg-green-800 rounded-md my-4 md:mb-4 lg:mt-0 shadow-sm shadow-black animate-on-scroll">
    @endif

    <div class="relative flex flex-col lg:flex-row gap-8 items-start">
        <div class="flex-1 min-w-0">
            <h1
                class="font-dm-serif mb-4 text-2xl md:text-3xl font-bold text-white lg:text-6xl animate-on-scroll {{ $align === 'center' ? 'text-center' : ($align === 'right' ? 'text-right' : 'text-left') }}">
                {!! $title !!}
            </h1>

            @if ($showTitleUnderline)
                <x-ui.underline-curve strokeColor="{{ $titleUnderlineColor }}" height="{{ $titleUnderlineHeight }}"
                    width="{{ $titleUnderlineWidth }}" pathStyle="{{ $titleUnderlinePathStyle }}"
                    widthMultiplier="{{ $titleUnderlineWidthMultiplier }}"
                    left="{{ $align === 'center' ? '10%' : ($align === 'right' ? 'auto' : '0') }}"
                    right="{{ $align === 'right' ? '0' : 'auto' }}" position="{{ $titleUnderlinePosition }}"
                    top="{{ $titleUnderlineTop }}" />
            @endif

            @if ($subtitle)
                <div class="relative">
                    <p
                        class="text-base lg:text-2xl font-bold text-white text-figtree animate-on-scroll {{ $align === 'center' ? 'text-center' : ($align === 'right' ? 'text-right' : 'text-left') }}">
                        {{ $subtitle }}
                    </p>

                    @if ($showSubtitleUnderline)
                        <x-ui.underline-curve class="absolute -bottom-2 left-0"
                            strokeColor="{{ $subtitleUnderlineColor }}"
                            width="{{ $align === 'center' ? '60%' : '70%' }}" height="36px"
                            left="{{ $align === 'center' ? '20%' : ($align === 'right' ? 'auto' : '0') }}"
                            right="{{ $align === 'right' ? '0' : 'auto' }}" scale="0.8" />
                    @endif
                </div>
            @endif

        </div>
    </div>

    @if ($titleBackground)
        </div>
    @endif

</div>
@if ($showButton)
    @isset($button)
        {{ $button }}
    @else
        <x-ui.button href="{{ $buttonUrl }}" iconColor="{{ $iconColor }}" id="{{ $buttonId }}"
            color="{{ $buttonColor }}" size="{{ $buttonSize }}" icon="icons.right-arrow" animate="true"
            class="{{ $iconColorClass . ' text-white animate-on-scroll font-dm-serif text-2xl lg:text-3xl lg:mt-4' }}">
            {{ $buttonText }}
        </x-ui.button>
    @endisset
@endif
</div>
@if ($showForm && $form)
    {{ $form }}
@endif

@if ($showSpinningLogos)
    <x-fx.spinning-logos className="{{ $spinningLogoClasses }}" />
@endif

@if (isset($showMarquee) && $showMarquee)
    {{ $marquee }}
@endif
</section>
