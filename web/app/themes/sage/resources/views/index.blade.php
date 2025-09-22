@extends('layouts.app')

@php
    $img_path = 'resources/images';
    $bg_image = Vite::asset("$img_path/sprinkler-system-park-min.webp");
    $contemporary_landscaping_img = Vite::asset("$img_path/contemporary-landscaping-design-dfw-min.webp");
    $commercial_landscaping_img = Vite::asset("$img_path/commercial-landscaping-min.webp");
    $landscaping_mixed_use_img = Vite::asset("$img_path/landscaping-mixed-use-min.webp");
    $boutique_landscaping_img = Vite::asset("$img_path/boutique-landscaping-min.webp");
    $hotel_landscaping_img = Vite::asset("$img_path/hotel-landscaping-min.webp");
    $airport_landscaping_img = Vite::asset("$img_path/airport-landscaping-min.webp");
    $hospital_landscaping_img = Vite::asset("$img_path/hospital-landscaping-min.webp");

    $certificationLogos = [];
    $icons = [];

    $accordionItemSet1 = [
        [
            'title' => 'Commercial Landscape Design & Installation',
            'content' =>
                'Our expert team creates custom landscape designs for commercial properties that enhance curb appeal and property value. From concept to completion, we handle every detail including plant selection, hardscaping elements, irrigation systems, and lighting design - all tailored to your property\'s unique characteristics and your specific aesthetic preferences.'
        ],
        [
            'title' => 'Landscape Maintenance Programs',
            'content' =>
                'Keep your property looking its best year-round with our comprehensive maintenance programs. We provide scheduled services including mowing, edging, pruning, fertilization, weed control, seasonal color rotations, and irrigation system checks. Our maintenance plans are customized to your property needs and Texas climate conditions.'
        ],
        [
            'title' => 'Seasonal Color & Enhancements',
            'content' =>
                'Make a statement with vibrant seasonal color displays. Our horticulture experts select flowering plants that thrive in Dallas-Fort Worth\'s unique climate conditions. We handle design, installation, and maintenance of seasonal color beds, container gardens, and accent plantings that keep your property looking fresh and inviting year-round.'
        ]
    ];

    $imageSet1 = [
        ['src' => $commercial_landscaping_img, 'alt' => 'Web Development', 'speed' => 0.5],
        ['src' => $landscaping_mixed_use_img, 'alt' => 'Custom Solutions', 'speed' => 1.2],
        ['src' => $contemporary_landscaping_img, 'alt' => 'E-commerce Solutions', 'speed' => 0.8]
    ];

    $accordionItemSet2 = [
        [
            'title' => 'Irrigation & Water Management',
            'content' =>
                'Our state-of-the-art irrigation solutions keep your landscape healthy while conserving water. We design, install, and maintain efficient irrigation systems tailored to your property\'s needs. Our services include drip irrigation, smart controllers, rain/moisture sensors, and regular system audits to ensure peak performance and compliance with local water restrictions.'
        ],
        [
            'title' => 'Hardscaping & Outdoor Features',
            'content' =>
                'Enhance your landscape with custom hardscaping elements that create functional, beautiful outdoor spaces. We design and construct walkways, patios, retaining walls, water features, outdoor kitchens, and fire features using premium materials that complement your architecture and withstand Texas weather conditions.'
        ],
        [
            'title' => 'Tree Care & Management',
            'content' =>
                'Protect your valuable landscape assets with our comprehensive tree care services. Our certified arborists provide expert pruning, disease diagnosis and treatment, fertilization, and preservation strategies for mature trees. We also offer tree selection and installation services, focusing on native species that thrive in North Texas conditions.'
        ]
    ];

    $imageSet2 = [
        ['src' => $boutique_landscaping_img, 'alt' => 'Mobile Development', 'speed' => 1.0],
        ['src' => $hotel_landscaping_img, 'alt' => 'Mobile Development', 'speed' => 1.5]
    ];

    $accordionItemSet3 = [
        [
            'title' => 'Commercial Property Enhancements',
            'content' =>
                'Elevate your commercial property with strategic landscape enhancements designed to create memorable impressions and functional outdoor spaces. Our team develops custom projects including entrance features, outdoor seating areas, privacy screening, and branded landscape elements that reinforce your company identity.'
        ],
        [
            'title' => 'Sustainable Landscaping Solutions',
            'content' =>
                'Reduce maintenance costs and environmental impact with our sustainable landscaping approaches. We specialize in xeriscaping, native plant installations, rainwater harvesting systems, and eco-friendly maintenance practices that conserve resources while creating beautiful, resilient landscapes suited to Texas conditions.'
        ],
        [
            'title' => 'Emergency Response & Storm Recovery',
            'content' =>
                'When severe weather strikes, our rapid response team is ready to address landscape emergencies and restore your property. We provide 24/7 emergency services including fallen tree removal, drainage solutions for flooding, irrigation repairs, and comprehensive cleanup to quickly return your landscape to safe, functional condition.'
        ]
    ];

    $imageSet3 = [
        ['src' => $airport_landscaping_img, 'alt' => 'UI Design', 'speed' => 1.4],
        ['src' => $hospital_landscaping_img, 'alt' => 'UX Design', 'speed' => 0.9]
    ];

    $testimonials = [
        [
            'icon' => 'nike',
            'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit...',
            'name' => 'Jane Dodson',
            'title' => 'Marketing Director, Nike'
        ],
        [
            'icon' => 'atlassian',
            'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit...',
            'name' => 'Johnathan Rodriguez',
            'title' => 'UX Research, Atlassian'
        ]
        // Add more testimonials as needed
    ];

    $logo_path = 'resources/images/logos';
    $logos = [
        'mcdonalds' => [
            'imagePath' => Vite::asset("$logo_path/mcdonalds-logo.webp"),
            'className' => 'mcdonalds-logo-class rounded-full',
        ],
        'ashton_woods' => [
            'imagePath' => Vite::asset("$logo_path/ashton-woods-logo.webp"),
            'className' => 'ashton-woods-logo-class rounded-full',
        ],
        'bridge' => [
            'imagePath' => Vite::asset("$logo_path/bridge-logo.webp"),
            'className' => 'bridge-logo-class rounded-full',
        ],
        'camden' => [
            'imagePath' => Vite::asset("$logo_path/camden-logo.webp"),
            'className' => 'camden-logo-class rounded-full',
        ],
        'drees' => [
            'imagePath' => Vite::asset("$logo_path/drees-logo.webp"),
            'className' => 'drees-logo-class rounded-full',
        ],
        'firestone' => [
            'imagePath' => Vite::asset("$logo_path/firestone-logo.webp"),
            'className' => 'firestone-logo-class rounded-full',
        ],
        'garland' => [
            'imagePath' => Vite::asset("$logo_path/garland-logo.webp"),
            'className' => 'garland-logo-class rounded-full',
        ],
        'jackson' => [
            'imagePath' => Vite::asset("$logo_path/jackson-logo.webp"),
            'className' => 'jackson-logo-class rounded-full',
        ],
        'kb_homes' => [
            'imagePath' => Vite::asset("$logo_path/kb-homes-logo.webp"),
            'className' => 'kb-homes-logo-class rounded-full',
        ],
        'keller' => [
            'imagePath' => Vite::asset("$logo_path/keller-logo.webp"),
            'className' => 'keller-logo-class rounded-full',
        ],
        'ladera' => [
            'imagePath' => Vite::asset("$logo_path/ladera-logo.webp"),
            'className' => 'ladera-logo-class rounded-full',
        ],
        'riverside' => [
            'imagePath' => Vite::asset("$logo_path/riverside-logo.webp"),
            'className' => 'riverside-logo-class rounded-full',
        ],
        'tripoint' => [
            'imagePath' => Vite::asset("$logo_path/tripoint-logo.webp"),
            'className' => 'tripoint-logo-class rounded-full',
        ],
        'trophy' => [
            'imagePath' => Vite::asset("$logo_path/trophy-logo.webp"),
            'className' => 'trophy-logo-class rounded-full',
        ],
    ];

    // Logo Marquee: use all logo imagePaths from $logos
    $marqueeLogos = array_map(fn($logo) => $logo['imagePath'], $logos);
    $marqueeLogosCopy = $marqueeLogos;
    shuffle($marqueeLogosCopy);
    $merged = array_merge($marqueeLogos, $marqueeLogosCopy);
    shuffle($merged);
@endphp

@section('content')
    <!-- <div class="flex-1"> -->
    <!-- Hero Section -->
    <x-ui.hero title="Transform Your Property With Expert Landscaping"
        subtitle="Dallas-Fort Worth's Top Commercial Landscaping Partner Since 1998" imageUrl="{{ $bg_image }}"
        titleContWidth="w-full lg:w-[55.5rem]" :showMarquee="true" :showSpinningLogos="false" class="flex flex-col"
        spinningLogoClasses="spinning-logos-container absolute left-1/2 -translate-x-1/2 lg:left-0 lg:translate-x-[32rem] lg:right-24 top-[45%] md:top-[38%] lg:top-[50%] lg:-translate-y-1/2 grid place-content-center overflow-hidden bg-transparent px-4 py-12 animate-on-scroll"
        :showForm="true" flexConf="flex flex-col justify-center lg:justify-start w-[53%]" iconColorClass="just-white"
        class="flex flex-row justify-center pt-16"
        height="h-[35rem] md:h-[500px] lg:h-[800px]">

        @slot('button')
            <x-ui.button href="https://calendly.com/maxx-heth-sandovallandscaping/30min" color="green" size="lg" animate="true"
                class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
                Book A Call!
            </x-ui.button>
        @endslot
        @slot('marquee')
            <x-ui.horizontal-marquee :logos="$marqueeLogos" class="py-4 absolute bottom-8 translate-x-[-50%] left-[50%]" maxWidth="max-w-16xl" />
        @endslot
        @slot('form')
            <div class="relative z-30 w-full max-w-[35rem] mt-8 lg:mt-0 flex-shrink-0">
                <x-forms.contact-form formId="hero-contact-form" title="Request a Quote"
                    subtitle="Fill out the form below and our team will contact you shortly." submitText="Submit Request"
                    bgColor="bg-green-800" textColor="text-white" :showDivisionOptions="false"
                     />
            </div>
        @endslot('form')
    </x-ui.hero>

    <!-- MARKETING UPDATE: Added "Why Choose Us" section to highlight competitive advantages -->
    <section class="py-12 bg-green-800">
        <div class="container px-4 mx-auto">
            <h2 class="mb-12 text-3xl md:text-4xl font-bold font-dm-serif text-center text-white animate-on-scroll">
                Why North Texas Businesses Choose Sandoval Landscaping
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 stagger-container animate-on-scroll">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 stagger-item">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 rounded-full">
                        <!-- MARKETING UPDATE: Replace with actual icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-green-800 text-center mb-2">Local Expertise</h3>
                    <p class="text-gray-700 text-center">
                        Over 30 years of experience with North Texas soil, climate, and plant species for landscapes that
                        thrive year-round.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 stagger-item">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 rounded-full">
                        <!-- MARKETING UPDATE: Replace with actual icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-green-800 text-center mb-2">Fully Insured & Licensed</h3>
                    <p class="text-gray-700 text-center">
                        Comprehensive insurance coverage and professional licensing for complete peace of mind and liability
                        protection.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 stagger-item">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 rounded-full">
                        <!-- MARKETING UPDATE: Replace with actual icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-green-800 text-center mb-2">Dedicated Teams</h3>
                    <p class="text-gray-700 text-center">
                        Specialized crews assigned to your property for consistent quality and familiarity with your
                        specific landscape needs.
                    </p>
                </div>
            </div>

            <!-- MARKETING UPDATE: Added trust badges -->
            <div class="flex flex-wrap justify-center items-center gap-6 mt-12 animate-on-scroll">
                @foreach ($certificationLogos as $logo)
                    <div class="w-24 h-24 flex items-center justify-center">
                        <img src="{{ $logo['src'] }}" alt="{{ $logo['alt'] }}"
                            class="max-w-full max-h-full grayscale hover:grayscale-0 transition-all duration-300">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Services Section -->
    <!-- MARKETING UPDATE: Moved services section up for better information hierarchy -->
    <section class="py-16 bg-gray-50">
        <div class="container px-4 mx-auto">
            <h2 class="mb-12 text-3xl md:text-4xl font-bold font-dm-serif text-center text-green-800 animate-on-scroll">
                Professional Landscaping Services
            </h2>

            <x-ui.service-layout layout="alternating" spacing="lg" class="md:w-5/6 mx-auto">
                <x-ui.service-item title="Commercial Landscape Design & Maintenance" :images="$imageSet1" :accordionItems="$accordionItemSet1"
                    :open="true">
                </x-ui.service-item>

                <x-ui.service-item title="Irrigation & Hardscaping Solutions" :images="$imageSet2" :accordionItems="$accordionItemSet2"
                    class="flex-row-reverse">
                </x-ui.service-item>

                <x-ui.service-item title="Specialized Commercial Services" :images="$imageSet3" :accordionItems="$accordionItemSet3">
                </x-ui.service-item>
            </x-ui.service-layout>
        </div>
    </section>


    <!-- Featured Projects Placeholder -->

    <section id="featured-projects" class="py-16 bg-green-800">
        <div class="container px-4 mx-auto">
            <h2 class="mb-8 font-dm-serif text-3xl md:text-5xl font-bold text-center text-white animate-on-scroll">
                Our Featured Projects
            </h2>

            <!-- MARKETING UPDATE: Added project category filters -->
            <div class="flex flex-wrap justify-center gap-4 mb-8 animate-on-scroll">
                <button
                    class="px-4 py-2 bg-white text-green-800 rounded-full hover:bg-green-100 transition-colors font-medium active">All
                    Projects</button>
                <button
                    class="px-4 py-2 bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Corporate</button>
                <button
                    class="px-4 py-2 bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Retail</button>
                <button
                    class="px-4 py-2 bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Hospitality</button>
                <button
                    class="px-4 py-2 bg-transparent text-white rounded-full hover:bg-green-700 transition-colors font-medium">Mixed-Use</button>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 stagger-container animate-on-scroll">
                <!-- MARKETING UPDATE: Enhanced project cards with more descriptive content -->
                <div
                    class="space-y-4 stagger-item overflow-hidden rounded-lg bg-white shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="relative h-64 overflow-hidden">
                        <div class="transition-transform duration-300 hover:scale-105">
                            <img src="{{ $contemporary_landscaping_img }}" alt="Corporate Campus Landscape Project"
                                class="object-cover w-full h-full" />
                        </div>
                        <div class="absolute top-4 left-4 bg-green-800 text-white text-xs px-2 py-1 rounded">Corporate</div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-800">Legacy West Corporate Campus</h3>
                        <p class="mt-2 text-gray-600">
                            Complete landscape redesign for this 15-acre corporate headquarters, featuring drought-resistant
                            native plantings, custom water features, and outdoor collaboration spaces.
                        </p>
                        <a href="#" class="inline-block mt-4 text-green-800 font-medium hover:text-green-600">View
                            Project Details →</a>
                    </div>
                </div>

                <div
                    class="space-y-4 stagger-item overflow-hidden rounded-lg bg-white shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="relative h-64 overflow-hidden">
                        <div class="transition-transform duration-300 hover:scale-105">
                            <img src="{{ $commercial_landscaping_img }}" alt="Shopping Center Landscape Enhancement"
                                class="object-cover w-full h-full" />
                        </div>
                        <div class="absolute top-4 left-4 bg-green-800 text-white text-xs px-2 py-1 rounded">Retail</div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-800">Southlake Town Square</h3>
                        <p class="mt-2 text-gray-600">
                            Comprehensive landscape maintenance and seasonal color program for this premium shopping
                            destination, enhancing visitor experience and extending dwell time.
                        </p>
                        <a href="#" class="inline-block mt-4 text-green-800 font-medium hover:text-green-600">View
                            Project Details →</a>
                    </div>
                </div>

                <div
                    class="space-y-4 stagger-item overflow-hidden rounded-lg bg-white shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="relative h-64 overflow-hidden">
                        <div class="transition-transform duration-300 hover:scale-105">
                            <img src="{{ $landscaping_mixed_use_img }}" alt="Mixed-Use Development Landscaping"
                                class="object-cover w-full h-full" />
                        </div>
                        <div class="absolute top-4 left-4 bg-green-800 text-white text-xs px-2 py-1 rounded">Mixed-Use
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-800">The Star District</h3>
                        <p class="mt-2 text-gray-600">
                            Complete landscape installation for this high-profile mixed-use development, including custom
                            irrigation systems, lighting design, and sustainable maintenance protocols.
                        </p>
                        <a href="#" class="inline-block mt-4 text-green-800 font-medium hover:text-green-600">View
                            Project Details →</a>
                    </div>
                </div>
            </div>

            <!-- MARKETING UPDATE: Added portfolio CTA -->
            <div class="text-center mt-12">
                <x-ui.button href="/portfolio" size="lg" animate="true"
                    class="md:mx-auto font-dm-serif w-[22.4rem] md:w-[30rem] hero-button white-to-light-green justify-between"
                    icon="icons.right-arrow" iconColor="#016630" secondaryIconColor="#016630">
                    View Full Portfolio
                </x-ui.button>
            </div>
        </div>
    </section>


    <!-- Service Area Map -->
    <section class="md:pt-16 mb:pb-16 py-16 bg-gray-50" id="request-consultation">
        <div class="container px-4 mx-auto">
            <h2 class="mb-8 text-2xl md:text-4xl font-bold font-dm-serif text-center text-green-800 animate-on-scroll">
                Landscaping Services in Dallas-Ft. Worth for <span class="counter-value" data-count="30"
                    data-duration="2"></span>+ Years
            </h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="md:col-span-2 animate-on-scroll">
                    <div class="relative h-[400px] md:h-[489px] bg-gray-200 rounded-md overflow-hidden">
                        <x-map />
                    </div>
                </div>

                <div class="animate-on-scroll">
                    <div
                        class="bg-green-800 rounded-md p-6 text-white flex flex-col justify-between transition-transform duration-300">
                        <div>
                            <h3 class="text-xl font-dm-serif font-semibold mb-4">Request a Quote</h3>
                            <p class="mb-6">Fill out the form below and our team will contact you shortly.</p>

                            <form id="request-quote-form" class="space-y-4">
                                <input type="text" placeholder="Name"
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <input type="email" placeholder="Email"
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <input type="tel" placeholder="Phone"
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <textarea placeholder="Message" rows="3"
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                            </form>
                        </div>

                        <x-ui.button href="/portfolio" color="white" size="lg" animate="true"
                            class="justify-between hero-button light-green-to-white font-dm-serif cursor-pointer mt-3"
                            icon="icons.right-arrow" iconColor="#016630" secondaryIconColor="#016630">
                            Submit Request
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="md:pt-12 md:pb-16 py-16 bg-green-800">
        <div class="container px-4 mx-auto">
            <h2 class="mb-8 text-3xl md:text-4xl font-dm-serif font-bold text-center text-white animate-on-scroll">What Our
                Clients Are
                Saying</h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 stagger-container animate-on-scroll">
                <div
                    class="p-6 shadow-md shadow-white bg-white rounded-md hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <p class="mb-4 italic text-green-800">
                        "Sandoval Landscaping has transformed our property into a stunning outdoor oasis. Their
                        attention
                        to
                        detail and professionalism is unmatched."
                    </p>
                    <p class="font-semibold text-green-800">— John D., Highland Park</p>
                </div>

                <div
                    class="p-6 shadow-white bg-white shadow-md rounded-md hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                    <p class="mb-4 italic text-green-800">
                        "We've been working with Sandoval Landscaping for over 5 years. Their team is reliable,
                        knowledgeable,
                        and always delivers exceptional results."
                    </p>
                    <p class="font-semibold text-green-800">— Sarah M., Commercial Property Manager</p>
                </div>
            </div>
        </div>
    </section>
    <!-- <section class="py-16 bg-gray-50" id="team">
                                                            <div class="container px-4 mx-auto">
                                                                <h2 class="mb-8 text-2xl font-bold text-center text-green-800 animate-on-scroll">Our Team</h2>

                                                                <div class="relative h-[300px] mb-8 overflow-hidden rounded-md animate-on-scroll">
                                                                    <img src="@asset('images/team.jpg')" alt="Sandoval Landscaping truck and team"
                                                                        class="object-cover w-full h-full" />
                                                                </div>

                                                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 stagger-container animate-on-scroll">
                                                                    <a href="tel:+12145551234"
                                                                        class="flex items-center justify-center p-4 text-white bg-green-800 rounded-md hover:bg-green-700 transition-colors duration-300 stagger-item">
                                                                        <span>Call</span>
                                                                    </a>
                                                                    <a href="mailto:info@southernbotanical.com"
                                                                        class="flex items-center justify-center p-4 text-white bg-green-700 rounded-md hover:bg-green-600 transition-colors duration-300 stagger-item">
                                                                        <span>Email</span>
                                                                    </a>
                                                                    <a href="#contact"
                                                                        class="flex items-center justify-center p-4 text-white bg-green-600 rounded-md hover:bg-green-500 transition-colors duration-300 stagger-item">
                                                                        <span>Get a Quote</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </section> -->

    <!-- Stats Section -->

    <!-- CTA Section -->
    <section class="py-16 bg-white" id="contact">
        <div class="container px-4 mx-auto text-center">
            <div class="animate-on-scroll">
                <h2 class="mb-4 text-2xl md:text-4xl font-dm-serif font-bold text-green-800">Let's Talk About Your
                    Landscape</h2>
                <p class="max-w-3xl mx-auto mb-8 text-gray-600">
                    Contact us today to schedule a consultation and discover how we can enhance your outdoor space.
                </p>
            </div>
            <x-ui.button href="#contact" id="contact-us" color="green" size="md" icon="icons.right-arrow"
                animate="true"
                class="mx-auto justify-between w-[32rem] just-white hero-button text-white animate-on-scroll font-dm-serif text-2xl lg:text-3xl mt-4"
                iconPosition="right">
                Contact Us Today
                </x-button>
        </div>
    </section>
    <!-- </div> -->
@endsection
