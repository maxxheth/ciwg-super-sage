@php
    $site_url = get_site_url();
@endphp
<!-- Footer -->
<footer class="py-12 bg-green-800 text-white">
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 gap-8 mb-8 md:grid-cols-3 stagger-container animate-on-scroll">
            <div class="stagger-item">
                <h3 class="mb-4 text-lg font-semibold">Sandoval Landscaping</h3>
                <p class="mb-4">
                    Providing exceptional landscaping services to the Dallas-Fort Worth area for over 30 years.
                </p>
                <div class="flex gap-4">
                    <a href="#"
                        class="hover:text-green-300 transition-colors duration-300 hover:-translate-y-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="hover:text-green-300 transition-colors duration-300 hover:-translate-y-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                            </path>
                        </svg>
                    </a>
                    <a href="#"
                        class="hover:text-green-300 transition-colors duration-300 hover:-translate-y-1 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="stagger-item">
                <h3 class="mb-4 text-lg font-semibold">Contact Us</h3>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5 text-green-300">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>706 E Kearney St, Mesquite, TX 75149</span>
                    </div>
                    <div class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5 text-green-300">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                        <span>(469) 902-4154</span>
                    </div>
                    <div class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-5 h-5 text-green-300">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>admin@sandovallandscaping.com</span>
                    </div>
                </div>
            </div>

            <div class="stagger-item">
                <h3 class="mb-4 text-lg font-semibold">Quick Links</h3>
                <ul class="space-y-2">
                    <li class="hover:translate-x-1 transition-transform duration-300">
                        <a href="{{ $site_url }}/about-us" class="hover:text-green-300">About Us</a>
                    </li>
                    <li class="hover:translate-x-1 transition-transform duration-300">
                        <a href="{{ $site_url }}/services" class="hover:text-green-300">Services</a>
                    </li>
                    <li class="hover:translate-x-1 transition-transform duration-300">
                        <a href="{{ $site_url }}/gallery" class="hover:text-green-300">Gallery</a>
                    </li>
                    <li class="hover:translate-x-1 transition-transform duration-300">
                        <a href="{{ $site_url }}/careers" class="hover:text-green-300">Careers</a>
                    </li>
                    <li class="hover:translate-x-1 transition-transform duration-300">
                        <a href="{{ $site_url }}/contact-us" class="hover:text-green-300">Contact</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 mt-8 text-center border-t border-green-700 animate-on-scroll">
            <p>&copy; {{ date('Y') }} Sandoval Landscaping. All rights reserved.</p>
        </div>
    </div>
</footer>
