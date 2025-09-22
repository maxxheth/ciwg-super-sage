@php(the_content())

@if ($pagination)
    <nav class="page-nav" aria-label="Page">
        @foreach ($pagination as $key => $post)
            <a href="{{ get_permalink($post) }}" class="page-nav__link">
                {{ $key === 'prev' ? 'Previous' : 'Next' }}: {{ get_the_title($post) }}
            </a>
        @endforeach
    </nav>
@endif
