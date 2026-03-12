<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 bg-gradient-to-b from-slate-900 to-slate-800 border-r border-slate-700" x-data="{ openAppearance: false, openBlog: false, openNewsletter: false }">
    <div class="h-full px-3 pb-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center justify-center py-6 mb-4 border-b border-slate-700">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-white">MitraCom</h2>
                <p class="text-xs text-slate-400">Admin Panel</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('backend.dashboard') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.dashboard') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Complete Count -->
            <li>
                <a href="{{ route('backend.complete-count.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.complete-count.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Complete Count
                </a>
            </li>

            <!-- Brands -->
            <li>
                <a href="{{ route('backend.brands.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.brands.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Brands
                </a>
            </li>

            <!-- Product Categories -->
            <li>
                <a href="{{ route('backend.product-categories.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.product-categories.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Product Categories
                </a>
            </li>

            <!-- Products -->
            <li>
                <a href="{{ route('backend.products.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.products.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('backend.users.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.users.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>
            </li>

            <!-- Contacts -->
            <li>
                <a href="{{ route('backend.contacts.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.contacts.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Contacts
                </a>
            </li>

            <!-- Pages -->
            <li>
                <a href="{{ route('backend.pages.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Pages
                </a>
            </li>

            <!-- Blog with Dropdown -->
            <li>
                <button 
                    @click="openBlog = !openBlog"
                    class="flex items-center justify-between w-full p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        Blog
                    </div>
                    <svg 
                        class="w-4 h-4 transition-transform duration-200" 
                        :class="{ 'rotate-180': openBlog }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Submenu -->
                <ul 
                    x-show="openBlog" 
                    x-transition
                    class="mt-2 ml-6 space-y-2"
                >
                    <li>
                        <a href="{{ route('backend.blogs.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.blogs.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Blog Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.blog-categories.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.blog-categories.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Blog Categories
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Appearance with Dropdown -->
            <li>
                <button 
                    @click="openAppearance = !openAppearance"
                    class="flex items-center justify-between w-full p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                        Appearance
                    </div>
                    <svg 
                        class="w-4 h-4 transition-transform duration-200" 
                        :class="{ 'rotate-180': openAppearance }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Submenu -->
                <ul 
                    x-show="openAppearance" 
                    x-transition
                    class="mt-2 ml-6 space-y-2"
                >
                    <li>
                        <a href="{{ route('backend.social-links.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.social-links.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Social Links
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.footer.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.footer.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Footer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.header.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.header.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Header / Navbar
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="{{ route('backend.whatsapp-button.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.whatsapp-button.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            WhatsApp Button
                        </a>
                    </li>
                    
                    @if(Auth::check() && Auth::user()->role && Auth::user()->role->name === 'superadmin')
                    <li>
                        <a href="{{ route('backend.theme-editor.index') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.theme-editor.*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Theme Editor
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            <!-- Testimonials -->
            <li>
                <a href="{{ route('backend.testimonials.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.testimonials.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Testimonials
                </a>
            </li>
            <!-- Services -->
            <li>
                <a href="{{ route('backend.services.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.services.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Services
                </a>
            </li>

            <!-- Newsletter with Dropdown -->
            <li>
                <button 
                    @click="openNewsletter = !openNewsletter"
                    class="flex items-center justify-between w-full p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200"
                >
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Newsletter
                    </div>
                    <svg 
                        class="w-4 h-4 transition-transform duration-200" 
                        :class="{ 'rotate-180': openNewsletter }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Submenu -->
                <ul 
                    x-show="openNewsletter" 
                    x-transition
                    class="mt-2 ml-6 space-y-2"
                >
                    <li>
                        <a href="{{ route('backend.newsletter.settings') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.newsletter.settings*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Form Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('backend.newsletter.subscribers') }}" class="flex items-center p-2 text-sm text-slate-400 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.newsletter.subscribers*') ? 'bg-slate-700 text-white' : '' }}">
                            <span class="w-2 h-2 mr-2 bg-slate-500 rounded-full"></span>
                            Subscribers
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Media -->
            <li>
                <a href="{{ route('backend.media.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.media.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Media
                </a>
            </li>

            <!-- Settings -->
            <li>
                <a href="{{ route('backend.settings.index') }}" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200 {{ request()->routeIs('backend.settings.*') ? 'bg-slate-700 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </li>

            <!-- Users -->
            {{-- <li>
                <a href="#" class="flex items-center p-3 text-slate-300 rounded-lg hover:bg-slate-700 hover:text-white transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
