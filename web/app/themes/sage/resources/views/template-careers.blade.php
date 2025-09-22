{{--
Template Name: Careers
--}}
@extends('layouts.app')

@section('content')
    <main class="flex-1">
        <!-- Hero Section -->
        <x-ui.hero title="Join Our Team" subtitle="Build your career with Dallas's premier landscaping company"
            :showSpinningLogos="false" buttonUrl="#application-form" iconColorClass="just-white"
            height="h-[35rem] md:h-[500px] lg:h-[750px]" showTitleUnderline="true" titleUnderlineColor="#67B649">

            @slot('button')
                <x-ui.button href="#application-form" color="green" size="lg" animate="true"
                    class="hero-button just-white font-dm-serif w-[22.4rem] md:w-[30rem] justify-between text-white animate-on-scroll text-2xl lg:text-3xl lg:mt-4"
                    icon="icons.right-arrow" iconColor="#ffffff" secondaryIconColor="#016630">
                    Apply Now
                </x-ui.button>
            @endslot
        </x-ui.hero>

        <!-- Application Form Section -->
        <section class="py-16 bg-white" id="application-form">
            <div class="container px-4 mx-auto">
                <x-ui.section-header title="Career Opportunities"
                    subtitle="Join our team and grow your career with Sandoval Landscaping" centered="true"
                    animated="true" />

                <div class="max-w-3xl mx-auto mt-12">
                    <x-forms.contact-form formId="careers-form" title="Employment Application"
                        subtitle="Fill out the form below to apply for a position with our team."
                        submitText="Submit Application" bgColor="bg-green-800" textColor="text-white" :showDivisionOptions="true"
                        testMode="true" divisionLabel="Which division are you interested in?" :divisionOptions="[
                            ['value' => 'landscaping', 'label' => 'Landscaping Services | Servicios de Paisajismo'],
                            ['value' => 'sod', 'label' => 'Sod Farming | Cultivo de Césped'],
                            ['value' => 'corporate', 'label' => 'Corporate | Corporativo'],
                            ['value' => 'other', 'label' => 'Other | Otro']
                        ]">
                        <!-- Optional additional fields can be added here as a slot -->
                    </x-forms.contact-form>
                </div>
            </div>
        </section>
    </main>
@endsection
