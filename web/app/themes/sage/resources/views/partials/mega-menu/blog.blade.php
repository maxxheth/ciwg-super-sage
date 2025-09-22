<div class="px-6 mx-auto border-t-zinc-200 border-t-2 overflow-y-scroll h-[800px]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Header Section -->
        <div class="col-span-1 md:col-span-2 space-y-2 mt-4">
            <h3 class="text-2xl font-bold text-primary">From Our Blog</h3>
            <p class="text-gray-600">Explore landscaping insights, trends, and expertise from our team of professionals.
            </p>
        </div>

        <!-- 3x2 Blog Grid -->
        @php
            $blogPosts = [
                [
                    'title' => 'Sustainable Landscaping Practices for Commercial Properties',
                    'excerpt' =>
                        'Discover eco-friendly approaches that enhance both aesthetics and environmental responsibility.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Sustainability'
                ],
                [
                    'title' => 'Seasonal Maintenance Guide: Preparing Your Landscape for Fall',
                    'excerpt' => 'Essential tips to protect your investment and ensure vibrant growth in the spring.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Maintenance'
                ],
                [
                    'title' => 'Water Conservation Strategies for Texas Landscapes',
                    'excerpt' =>
                        'Smart irrigation solutions that reduce water usage while maintaining beautiful grounds.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Water Management'
                ],
                [
                    'title' => 'Enhancing Property Value Through Strategic Landscaping',
                    'excerpt' =>
                        'How the right landscape design can significantly impact your property\'s market value.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Design'
                ],
                [
                    'title' => 'Native Plants of North Texas: Benefits for Commercial Landscapes',
                    'excerpt' => 'Why choosing native species creates more resilient and cost-effective environments.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Plant Selection'
                ],
                [
                    'title' => 'Commercial Landscape Trends for 2023',
                    'excerpt' => 'Stay ahead of the curve with these emerging trends in commercial landscaping.',
                    'image' => Vite::asset('resources/images/landscape-design/corporate-business-park.webp'),
                    'category' => 'Industry Trends'
                ]
            ];
        @endphp

        @foreach ($blogPosts as $post)
            <div
                class="space-y-3 bg-white rounded-lg overflow-hidden shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
                    <div class="absolute top-3 left-3">
                        <span
                            class="bg-primary text-white text-xs font-bold px-2 py-1 rounded">{{ $post['category'] }}</span>
                    </div>
                </div>
                <div class="px-4 space-y-3 relative flex flex-col justify-between">
                    <div class="flex flex-col">
                        <h4 class="text-lg font-semibold text-primary line-clamp-2 mb-2">{{ $post['title'] }}</h4>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $post['excerpt'] }}</p>
                    </div>
                    <div class="my-4">
                        <a href="#" class="flex items-center text-sm font-medium text-primary hover:underline">
                            READ ARTICLE
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 ml-1">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- View All Blog Posts Button -->
        <div class="col-span-1 md:col-span-2 flex justify-center mb-12 mt-4">
            <a href="#"
                class="inline-block px-6 py-3 font-medium text-white bg-primary rounded-md hover:bg-primary-light no-underline">
                VIEW ALL BLOG POSTS
            </a>
        </div>
    </div>
</div>
