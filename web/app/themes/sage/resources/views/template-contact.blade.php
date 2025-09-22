{{--
Template Name: Contact Template
--}}
@extends('layouts.app')

@php
    $team_photo = Vite::asset('resources/images/team-photo.webp');
@endphp

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="Contact Us" subtitle="Let's Discuss Your Commercial Landscaping Needs" :showSpinningLogos="false"
            titleContWidth="w-1/2" height="h-[35rem] md:h-[500px] lg:h-[650px]">

            @slot('button')
                <x-ui.button href="#contact-form" color="green" size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                    icon="icons.right-arrow" type="link">
                    Get in Touch
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Contact Introduction -->
        <x-ui.section>
            <x-ui.section-header title="Get In Touch With Our Team"
                subtitle="We're here to answer your questions and provide the landscaping services you need" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="animate-on-scroll">
                    <img src="{{ $team_photo }}" alt="Sandoval Landscaping team" class="rounded-md shadow-lg">
                </div>
                <div class="space-y-6 animate-on-scroll">
                    <p class="text-gray-600">
                        At Sandoval Landscaping, we pride ourselves on responsive, helpful customer service. Whether you
                        have
                        questions about our services, want to schedule a consultation, or need a quote for your project,
                        our team is ready to assist you.
                    </p>
                    <p class="text-gray-600">
                        Fill out the form below, give us a call, or visit our office. We look forward to helping you
                        transform your outdoor space into something beautiful and functional.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800">Phone</h3>
                            <p class="text-gray-600">(214) 555-1234</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-800">Email</h3>
                            <p class="text-gray-600">info@sandovallandscaping.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.section>

        <!-- Contact Form and Map Section -->
        <x-ui.section bgColor="bg-gray-50" id="contact-form">
            <x-ui.section-header title="Contact Us" subtitle="Reach out to discuss your landscaping needs" />

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="md:col-span-2 animate-on-scroll">
                    <div class="relative h-[400px] md:h-[489px] bg-gray-200 rounded-md overflow-hidden">
                        <x-map />
                    </div>
                </div>

                <div class="animate-on-scroll">
                    <div class="bg-green-800 rounded-md p-6 text-white flex flex-col justify-between h-full">
                        <div>
                            <h3 class="text-xl font-dm-serif font-semibold mb-4">Request a Consultation</h3>
                            <p class="mb-6">Fill out the form below and our team will contact you shortly.</p>

                            <form id="contact-form" class="space-y-4">
                                <input type="text" placeholder="Full Name" required
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <input type="email" placeholder="Email Address" required
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <input type="tel" placeholder="Phone Number"
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <select
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="" disabled selected>Service Interested In</option>
                                    <option value="design">Landscape Design</option>
                                    <option value="installation">Installation & Construction</option>
                                    <option value="maintenance">Maintenance Services</option>
                                    <option value="other">Other Services</option>
                                </select>
                                <textarea placeholder="Message" rows="3" required
                                    class="w-full px-4 py-2 text-gray-800 bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                            </form>
                        </div>

                        <x-ui.button type="submit" form="contact-form" color="white" size="lg"
                            class="mt-4 justify-between hero-button green-to-white font-dm-serif" icon="icons.right-arrow"
                            iconColor="#016630" secondaryIconColor="#016630">
                            Submit Request
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </x-ui.section>

        <!-- Additional Contact Information -->
        <x-ui.section>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-ui.card title="Office Hours" imageLayout="inline" layout="flex" imageUrl="@asset('images/icon-clock.svg')"
                    imageAlt="Office Hours">
                    <div class="mt-2 space-y-1">
                        <p class="text-gray-600">Monday - Friday: 8:00 AM - 5:00 PM</p>
                        <p class="text-gray-600">Saturday: Closed</p>
                        <p class="text-gray-600">Sunday: Closed</p>
                    </div>
                </x-ui.card>

                <x-ui.card title="Office Location" imageLayout="inline" layout="flex" imageUrl="@asset('images/icon-location.svg')"
                    imageAlt="Office Location">
                    <div class="mt-2">
                        <p class="text-gray-600">
                            12345 North Central Expressway<br>
                            Suite 500<br>
                            Dallas, TX 75243
                        </p>
                    </div>
                </x-ui.card>

                <x-ui.card title="Emergency Service" imageLayout="inline" layout="flex" imageUrl="@asset('images/icon-emergency.svg')"
                    imageAlt="Emergency Service">
                    <div class="mt-2">
                        <p class="text-gray-600">
                            For after-hours emergencies:<br>
                            (214) 555-5678
                        </p>
                    </div>
                </x-ui.card>
            </div>
        </x-ui.section>

        <!-- FAQ Section -->
        <x-ui.section bgColor="bg-gray-50">
            <x-ui.section-header title="Frequently Asked Questions"
                subtitle="Find quick answers to common questions about our services and process" />

            <div class="max-w-3xl mx-auto space-y-6">
                <x-ui.accordion-item title="How do I schedule a consultation?" :open="true">
                    <p class="text-gray-600">
                        You can schedule a consultation by filling out our contact form, calling our office directly,
                        or sending us an email. Our team will respond within 24 business hours to arrange a convenient time.
                    </p>
                </x-ui.accordion-item>

                <x-ui.accordion-item title="Do you provide free estimates?">
                    <p class="text-gray-600">
                        Yes, we provide free estimates for all landscaping projects. After an initial consultation and site
                        visit, we'll prepare a detailed proposal outlining the scope of work and associated costs.
                    </p>
                </x-ui.accordion-item>

                <x-ui.accordion-item title="What areas do you service?">
                    <p class="text-gray-600">
                        We service the entire Dallas-Fort Worth metroplex, including Dallas, Fort Worth, Plano, Frisco,
                        Allen, McKinney, Richardson, Garland, and surrounding communities.
                    </p>
                </x-ui.accordion-item>

                <x-ui.accordion-item title="How quickly can you start on my project?">
                    <p class="text-gray-600">
                        Our timeline depends on the current project schedule and the scope of your project. For maintenance
                        services, we can typically begin within 1-2 weeks. For design and installation projects, the
                        timeline
                        may be 2-4 weeks. We'll provide a specific timeline during your consultation.
                    </p>
                </x-ui.accordion-item>
            </div>
        </x-ui.section>

        <!-- CTA Section -->
        <x-ui.cta title="Ready to Transform Your Landscape?"
            description="Contact us today to schedule a consultation and discover how our services can enhance your outdoor space."
            buttonText="Get Started Now" buttonUrl="#contact-form" />
    </main>
@endsection
