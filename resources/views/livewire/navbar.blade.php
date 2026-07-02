<nav x-data="{ mobileMenuOpen: false }"
     class="fixed w-full z-50 top-0 left-0 bg-brand-light/95 backdrop-blur-md border-b border-brand-dark/5 text-brand-dark">
    
    <!-- Desktop Layout -->
    <div class="hidden md:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24 relative">
            
            <!-- Left Side: Languages + Home, Menu, Gallery -->
            <div class="flex items-center space-x-6 lg:space-x-8 text-xs lg:text-[11px] tracking-[0.15em] font-semibold uppercase text-brand-dark z-20">
                <!-- Language Switcher -->
                <div class="flex items-center space-x-2 mr-4">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}" 
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                           class="transition-colors duration-300 {{ app()->getLocale() == $localeCode ? 'text-brand-olive font-bold' : 'text-brand-dark/40 hover:text-brand-olive' }}">
                            {{ strtoupper($localeCode) }}
                        </a>
                        @if(!$loop->last)
                            <span class="text-brand-dark/10">|</span>
                        @endif
                    @endforeach
                </div>
                
                <!-- Left Links -->
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="relative py-2 hover:text-brand-olive transition duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-brand hover:after:w-full after:transition-all after:duration-300">{{ __('Home') }}</a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="relative py-2 hover:text-brand-olive transition duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-brand hover:after:w-full after:transition-all after:duration-300">{{ __('Menu') }}</a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'gallery') }}" class="relative py-2 hover:text-brand-olive transition duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-brand hover:after:w-full after:transition-all after:duration-300">{{ __('Gallery') }}</a>
            </div>

            <!-- Centered Logo -->
            <div class="absolute inset-0 flex justify-center items-center pointer-events-none z-10">
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="pointer-events-auto flex items-center group">
                    <img src="/logo.png" alt="{{ App\Models\Setting::getValue('site_name', 'Ehl-i Keyf Logo') }}" 
                         class="transition-transform duration-500 group-hover:scale-105" 
                         style="height: 68px; width: auto; object-fit: contain;">
                </a>
            </div>

            <!-- Right Side: Blog, Contact + WhatsApp + Reservation Button -->
            <div class="flex items-center space-x-6 lg:space-x-8 text-xs lg:text-[11px] tracking-[0.15em] font-semibold uppercase text-brand-dark z-20">
                <!-- Right Links -->
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'blog') }}" class="relative py-2 hover:text-brand-olive transition duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-brand hover:after:w-full after:transition-all after:duration-300">{{ __('Blog') }}</a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'contact') }}" class="relative py-2 hover:text-brand-olive transition duration-300 after:absolute after:bottom-0 after:left-0 after:w-0 after:h-[1.5px] after:bg-brand hover:after:w-full after:transition-all after:duration-300">{{ __('Contact') }}</a>
                
                <!-- WhatsApp Link -->
                <a href="https://wa.me/{{ App\Models\Setting::getValue('whatsapp', '905059878900') }}" target="_blank" class="w-9 h-9 bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366]/20 transition-all duration-300 rounded-lg flex items-center justify-center group ml-2" title="WhatsApp">
                    <svg class="w-5.5 h-5.5 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
                
                <!-- Reservation Button -->
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'booking') }}" class="h-10 px-5 bg-brand text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 tracking-[0.15em] text-[10px] font-bold rounded-lg flex items-center justify-center shadow-sm">
                    {{ __('RESERVATION') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Header Layout (Visible only on mobile) -->
    <div class="md:hidden flex justify-between items-center h-20 px-4 relative">
        <!-- Left: Toggle Hamburger -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="hover:text-brand-olive focus:outline-none transition-colors p-2 z-20">
            <svg class="h-7 w-7" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="h-7 w-7" x-show="mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <!-- Center: Centered Logo -->
        <div class="absolute inset-0 flex justify-center items-center pointer-events-none z-10">
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="pointer-events-auto flex items-center">
                <img src="/logo.png" alt="{{ App\Models\Setting::getValue('site_name', 'Ehl-i Keyf Logo') }}" 
                     style="height: 64px; width: auto; object-fit: contain;">
            </a>
        </div>
        
        <!-- Right: Mobile Actions -->
        <div class="flex items-center space-x-2 z-20">
            <!-- Mobile Language Dropdown -->
            <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                <button @click="langOpen = !langOpen" class="flex items-center space-x-1 text-brand-dark/80 font-bold text-[13px] py-1 px-2 rounded-md hover:bg-brand-dark/5 transition-colors">
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <svg class="w-3 h-3 transition-transform duration-200" :class="{'rotate-180': langOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="langOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-24 bg-brand-light shadow-xl border border-brand-dark/10 rounded-md py-1 z-50 flex flex-col"
                     style="display: none;">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}" 
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                           class="px-4 py-2 text-[12px] font-bold transition-colors hover:bg-brand-olive/5 {{ app()->getLocale() == $localeCode ? 'text-brand-olive' : 'text-brand-dark/70' }}">
                            {{ strtoupper($localeCode) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Contact Dropdown -->
            <div class="relative" x-data="{ contactOpen: false }" @click.away="contactOpen = false">
                <button @click="contactOpen = !contactOpen" class="text-brand-light p-2.5 bg-brand-olive hover:bg-brand-dark active:scale-95 transition-all duration-300 rounded-full flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </button>
                
                <div x-show="contactOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute right-0 mt-3 w-40 max-w-[calc(100vw-2rem)] bg-brand-light shadow-2xl border border-brand-dark/10 rounded-xl py-2 z-50 overflow-hidden flex flex-col"
                     style="display: none;">
                      <a href="tel:{{ str_replace(' ', '', App\Models\Setting::getValue('phone', '905367292218')) }}" class="flex items-center px-4 py-3 hover:bg-brand-olive/5 transition-colors group">
                        <span class="p-1.5 rounded-full bg-brand-olive/10 group-hover:bg-brand-olive/20 text-brand-olive mr-3 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <span class="text-xs font-semibold tracking-wider text-brand-dark">{{ __('Call Us') }}</span>
                    </a>
                    <div class="h-px w-full bg-brand-dark/5"></div>
                    <a href="https://wa.me/{{ App\Models\Setting::getValue('whatsapp', '905367292218') }}" target="_blank" class="flex items-center px-4 py-3 hover:bg-[#25D366]/5 transition-colors group">
                        <span class="p-1.5 rounded-full bg-[#25D366]/10 group-hover:bg-[#25D366]/20 text-[#25D366] mr-3 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </span>
                        <span class="text-xs font-semibold tracking-wider text-brand-dark">WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-brand-light shadow-2xl absolute w-full top-full left-0 border-t border-brand-dark/10 text-brand-dark"
         @click.away="mobileMenuOpen = false"
         style="display: none;">
        <div class="px-6 py-8 space-y-4 text-center flex flex-col uppercase tracking-[0.15em] text-sm font-medium">
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="block py-3 hover:text-brand-olive transition">Home</a>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="block py-3 hover:text-brand-olive transition">Menu</a>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'blog') }}" class="block py-3 hover:text-brand-olive transition">Blog</a>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'gallery') }}" class="block py-3 hover:text-brand-olive transition">Gallery</a>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'contact') }}" class="block py-3 hover:text-brand-olive transition">Contact</a>
            
            <!-- Language Switcher Mobile -->
            <div class="flex justify-center space-x-6 py-4 border-y border-brand-dark/5 my-2">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}" 
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                       class="text-xs transition-colors duration-300 {{ app()->getLocale() == $localeCode ? 'text-brand-olive font-bold border-b border-brand-olive pb-1' : 'text-brand-dark/50 hover:text-brand-olive' }}">
                        {{ strtoupper($properties['native']) }}
                    </a>
                @endforeach
            </div>
            <div class="pt-6">
                 <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'booking') }}" class="inline-block px-8 py-4 bg-brand text-brand-olive hover:bg-brand-olive hover:text-white transition duration-300 w-full tracking-[0.2em] text-xs rounded-full">{{ __('RESERVATION') }}</a>
            </div>
        </div>
    </div>
</nav>
