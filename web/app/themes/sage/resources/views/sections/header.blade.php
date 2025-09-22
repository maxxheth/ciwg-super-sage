@php
    $menuItems = [
        'about' => [
            'name' => 'About',
            'href' => '/about-us'
        ],
        'services' => [
            'name' => 'Services',
            'href' => '/services'
        ],
        'gallery' => [
            'name' => 'Gallery',
            'href' => '/gallery'
        ],
        /*'projects' => [
            'name' => 'Projects',
            'href' => '/portfolio'
        ],*/
        'careers' => [
            'name' => 'Careers',
            'href' => '/careers'
        ],
        'blog' => [
            'name' => 'Blog',
            'href' => '/blog'
        ],
        'contact' => [
            'name' => 'Contact Us',
            'href' => '/contact-us'
        ]
    ];
@endphp
<header class="sticky top-0 z-50 bg-white border-b header-main" data-header>
    <div class="container flex items-center justify-between px-4 py-3 mx-auto">
        <div class="flex justify-between w-full relative items-center gap-8">
            <a href="{{ home_url('/') }}" class="flex items-center gap-2">
                <!-- Uncomment the following lines if you want to use a custom logo instead of the circle -->
                <img src="{{ Vite::asset('resources/images/logos/sandoval-logo-w-text.webp') }}"
                    alt="{{ get_bloginfo('name', 'display') }}" class="w-auto h-16 hidden md:block" />
                <img src="{{ Vite::asset('resources/images/sandoval-logo-no-text.webp') }}"
                    alt="{{ get_bloginfo('name', 'display') }}" class="h-16 block md:hidden" />
            </a>
            <nav class="hidden lg:flex absolute left-1/2 -translate-1/2 top-1/2">
                <ul class="flex items-center gap-6 text-sm">
                    @foreach ($menuItems as $menuKey => $menuItem)
                        <li class="relative menu-item" data-menu="{{ $menuKey }}">
                            <a href="{{ $menuItem['href'] }}"
                                class="hover:text-green-700 menu-link font-figtree tracking-wider text-base">
                                {{ $menuItem['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <h3 class="text-green-800 font-semibold text-base font-dm-serif relative right-10 md:right-0">
                <div>Sandoval Landscaping</div>
                <div>706 E Kearney St</div>
                <div>Mesquite, TX 75149</div>
                <div>(469) 902-4154</div>
            </h3>
        </div>
        <div class="flex items-center gap-4">
            <!-- <a href="#contact" class="px-4 py-2 text-sm font-medium text-white bg-green-800 rounded hover:bg-green-700 quote-button">
        Get a Quote
      </a> -->
            <x-slider></x-slider>
            <!-- <button class="p-2 lg:hidden mobile-menu-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button> -->
        </div>
    </div>

    <!-- Mobile Mega Menu -->
    <div class="mobile-nav-container">
        <div class="container mx-auto px-4 mt-2">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ home_url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-green-800 rounded-full logo-circle"></div>
                    <span class="text-lg font-semibold text-green-800">{{ get_bloginfo('name', 'display') }}</span>
                </a>
                <!-- Close button could be added here if needed -->
            </div>

            <nav>
                <ul class="space-y-4">
                    @foreach ($menuItems as $menuKey => $menuItem)
                        <li class="py-2 border-b border-gray-200">
                            <a href="{{ $menuItem['href'] }}"
                                class="flex justify-between items-center text-lg font-medium hover:text-green-700 mobile-menu-link"
                                data-menu="{{ $menuKey }}">
                                {{ $menuItem['name'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</header>
