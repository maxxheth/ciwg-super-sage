@extends('layouts.app')

@section('content')
    <x-ui.hero title="404 - Page Not Found" subtitle="Sorry, the page you are looking for does not exist."
        buttonText="Go to Homepage" buttonUrl="{{ home_url('/') }}" imageUrl="@asset('images/hero-bg.jpg')" overlay="true"
        height="h-[500px]" :showSpinningLogos="false" align="center" />


    @if (!have_posts())
        <x-alert type="warning">
            {!! __('Sorry, but the page you are trying to view does not exist.', 'sage') !!}
        </x-alert>

        {!! get_search_form(false) !!}
    @endif
@endsection
