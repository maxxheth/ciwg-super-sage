{{--
Template Name: About Template
--}}
@extends('layouts.app')

@php
    $team_photo = Vite::asset('resources/images/team-photo.webp');
@endphp

@section('content')
    <x-ui.hero title="About Sandoval Landscaping" subtitle="Serving the Dallas-Fort Worth Area Since 1998"
        height="h-[35rem] md:h-[500px] lg:h-[750px]" titleContWidth="w-full md:w-[55rem]">

        @slot('button')
            <x-ui.button href="#our-story" color="green" size="lg" animate="true"
                class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                icon="icons.right-arrow" type="link">
                Our Story
            </x-ui.button>
        @endslot
    </x-ui.hero>

    <!-- Our Story Section -->
    <x-ui.section id="our-story">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="animate-on-scroll">
                <img src="{{ $team_photo }}" alt="Sandoval Landscaping team" class="rounded-md shadow-lg">
            </div>
            <div class="space-y-6 animate-on-scroll">
                <x-ui.section-header title="Our Story" centered="false" animated="false" />
                <p class="text-gray-600">
                    Founded in 1990, Sandoval Landscaping began as a small family operation with a passion for creating
                    beautiful outdoor spaces. For over three decades, we've grown to become one of Dallas's premier
                    landscaping companies while maintaining our commitment to personalized service and exceptional
                    quality.
                </p>
                <p class="text-gray-600">
                    Our team of dedicated professionals combines years of experience with innovative techniques to
                    deliver landscaping solutions that enhance the beauty, functionality, and value of your property.
                </p>
                <p class="text-gray-600">
                    What sets us apart is our commitment to sustainable practices, attention to detail, and our ability
                    to bring our clients' visions to life. We don't just create landscapes – we craft outdoor
                    experiences that stand the test of time.
                </p>
            </div>
        </div>
    </x-ui.section>

    <!-- Values Section -->
    <x-ui.section bgColor="bg-gray-50">
        <x-ui.section-header title="Our Core Values" subtitle="The principles that guide our work and relationships" />

        <x-ui.grid :cols="['default' => 1, 'md' => 3]">
            <x-ui.card title="Excellence"
                subtitle="We strive for excellence in every project, no matter how big or small. Our team is committed to delivering results that exceed expectations.">
                <div class="mt-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="mx-auto text-green-800">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                        </polygon>
                    </svg>
                </div>
            </x-ui.card>

            <x-ui.card title="Integrity"
                subtitle="We conduct our business with honesty, transparency, and respect. Our clients can trust us to keep our promises and stand behind our work.">
                <div class="mt-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="mx-auto text-green-800">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
            </x-ui.card>

            <x-ui.card title="Sustainability"
                subtitle="We're committed to environmentally responsible practices that conserve resources and protect the natural beauty of our Texas landscapes.">
                <div class="mt-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="mx-auto text-green-800">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line>
                        <line x1="10" y1="1" x2="10" y2="4"></line>
                        <line x1="14" y1="1" x2="14" y2="4"></line>
                    </svg>
                </div>
            </x-ui.card>
        </x-ui.grid>
    </x-ui.section>

    <!-- Team Section -->
    <x-ui.section>
        <x-ui.section-header title="Meet Our Leadership Team" subtitle="The dedicated professionals behind our success" />

        <x-ui.grid :cols="['default' => 1, 'md' => 2, 'lg' => 3]">
            <x-ui.card title="Javier Sandoval" subtitle="Founder & CEO"
                imageUrl="{{ Vite::asset('resources/images/staff/javier-sandoval.webp') }}" imageAlt="Javier Sandoval">
                <p class="mt-4 text-gray-600">
                    Javier founded the company in 1998 along with his father. He has a passion for not only growing our
                    business, but also the employees who work hard everyday helping us reach our goal. He enjoys spending
                    time with his family and loves traveling!
                </p>
            </x-ui.card>

            <x-ui.card title="Jaime Sandoval" subtitle="Operations Director"
                imageUrl="{{ Vite::asset('resources/images/staff/jaime-sandoval.webp') }}" imageAlt="Jaime Sandoval">
                <p class="mt-4 text-gray-600">
                    Jaime assists the CEO/President with the day to day functions of Operations, both internally and in the
                    field. He loves spending time with his family and friends and loves local Sports teams (Dallas). His
                    ultimate goal is to own a beach home and retire in Cancun. (John 3:16)
                </p>
            </x-ui.card>

            <x-ui.card title="Darryl Chevis" subtitle="Lead Landscape Architect"
                imageUrl="{{ Vite::asset('resources/images/staff/darryl-chevis.webp') }}" imageAlt="Darryl Chevis">
                <p class="mt-4 text-gray-600">
                    Darryl has been with us for over 2 years. He's a UNT alumnus and has been in charge of our recruitment,
                    HR, and Operations. Outside of work he likes following his favorite sports teams (Dallas) and attending
                    his daughters basketball games.
                </p>
            </x-ui.card>
        </x-ui.grid>
    </x-ui.section>

    <!-- Stats Section -->
    <x-ui.section bgColor="bg-green-800" padding="py-20">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4 stagger-container animate-on-scroll">
            <x-ui.stats-counter value="30" label="Years Experience" textSize="text-3xl font-bold text-white">
                <p class="text-green-100">Years Experience</p>
            </x-ui.stats-counter>

            <x-ui.stats-counter value="500" label="Happy Clients" textSize="text-3xl font-bold text-white">
                <p class="text-green-100">Happy Clients</p>
            </x-ui.stats-counter>

            <x-ui.stats-counter value="50" label="Team Members" textSize="text-3xl font-bold text-white">
                <p class="text-green-100">Team Members</p>
            </x-ui.stats-counter>

            <x-ui.stats-counter value="98" label="Client Satisfaction" suffix="%"
                textSize="text-3xl font-bold text-white">
                <p class="text-green-100">Client Satisfaction</p>
            </x-ui.stats-counter>
        </div>
    </x-ui.section>

    <!-- Testimonials -->
    <x-ui.section>
        <x-ui.section-header title="What Our Clients Say"
            subtitle="We're proud of the relationships we've built with our clients" />

        <x-ui.grid :cols="['default' => 1, 'md' => 2]">
            <x-ui.testimonial
                quote="Sandoval Landscaping transformed our property into a stunning outdoor oasis. Their attention to detail and professionalism is unmatched."
                author="John Davis" position="Highland Park" />

            <x-ui.testimonial
                quote="We've been working with Sandoval Landscaping for over 5 years. Their team is reliable, knowledgeable, and always delivers exceptional results."
                author="Sarah Miller" position="Commercial Property Manager" />

            <x-ui.testimonial
                quote="The team at Sandoval Landscaping took our vague ideas and turned them into a beautiful reality. They were professional, on time, and on budget."
                author="Michael Johnson" position="Plano Homeowner" />

            <x-ui.testimonial
                quote="As a property developer, I need reliable partners. Sandoval Landscaping has proven time and again that they're the best in the business."
                author="Lisa Rodriguez" position="Real Estate Developer" />
        </x-ui.grid>
    </x-ui.section>

    <!-- Certifications & Affiliations -->
    <!-- <x-ui.section bgColor="bg-gray-50">
                        <x-ui.section-header title="Our Certifications & Affiliations"
                            subtitle="We maintain the highest standards in the industry" />

                        <div class="flex flex-wrap justify-center gap-8 mt-8">
                            <div class="p-4 bg-white rounded-md shadow-md animate-on-scroll">
                                <img src="@asset('images/certification-1.png')" alt="Texas Nursery & Landscape Association" class="h-20">
                            </div>
                            <div class="p-4 bg-white rounded-md shadow-md animate-on-scroll">
                                <img src="@asset('images/certification-2.png')" alt="Irrigation Association" class="h-20">
                            </div>
                            <div class="p-4 bg-white rounded-md shadow-md animate-on-scroll">
                                <img src="@asset('images/certification-3.png')" alt="Texas Landscape Contractors Association" class="h-20">
                            </div>
                            <div class="p-4 bg-white rounded-md shadow-md animate-on-scroll">
                                <img src="@asset('images/certification-4.png')" alt="BBB Accredited Business" class="h-20">
                            </div>
                        </div>
                    </x-ui.section> -->

    <!-- CTA Section -->
    <x-ui.cta title="Ready to Transform Your Landscape?"
        description="Contact us today to schedule a consultation and discover how we can enhance your outdoor space."
        buttonText="Get In Touch" buttonUrl="/contact" />
@endsection
