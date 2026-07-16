<div>
    <!-- Hero Section -->
    <div class="gsap-hero-parallax relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        @php
            $heroImages = \App\Models\Setting::getValue('hero_images', [asset('storage/gallery/029A7791.webp')]);
            if (!is_array($heroImages)) $heroImages = [$heroImages];
        @endphp

        @if(count($heroImages) > 1)
            <!-- AlpineJS Crossfade Hero Slider -->
            <div class="gsap-hero-bg absolute inset-0 z-0 bg-brand-dark" x-data="{ currentSlide: 0, total: {{ count($heroImages) }} }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % total }, 5000)">
                @foreach($heroImages as $index => $imgUrl)
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                         x-show="currentSlide === {{ $index }}"
                         x-transition:enter="opacity-0"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="opacity-0"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         style="display: {{ $index === 0 ? 'block' : 'none' }}">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover origin-center scale-105" alt="Ehl-i Keyf Hero">
                    </div>
                @endforeach
                <div class="absolute inset-0 bg-brand-dark/55 z-10"></div>
                <div class="absolute inset-0 premium-hero-vignette z-20"></div>
            </div>
        @else
            <!-- Single Static Hero Background -->
            <div class="gsap-hero-bg absolute inset-0 z-0">
                <img src="{{ $heroImages[0] ?? asset('storage/gallery/DJI_0834-Edit-scaled.webp') }}" class="w-full h-full object-cover origin-center scale-105" alt="Ehl-i Keyf Hero">
                <div class="absolute inset-0 bg-brand-dark/55 z-10"></div>
                <div class="absolute inset-0 premium-hero-vignette z-20"></div>
            </div>
        @endif
        
        <!-- Hero Content -->
        <div class="relative z-10 text-center px-4 max-w-6xl mx-auto pt-28">
            <div class="gsap-fade-in premium-glass-panel inline-flex items-center gap-3 rounded-full px-5 py-2 mb-6 text-brand text-[11px] md:text-xs font-semibold uppercase tracking-[0.28em]">
                <span class="h-1.5 w-1.5 rounded-full bg-brand shadow-[0_0_20px_rgba(92,100,72,0.9)]"></span>
                {{ __('Welcome to Ehl-i Keyf') }}
            </div>
            <h1 class="gsap-fade-in text-5xl md:text-7xl lg:text-8xl font-serif font-light text-white mb-7 tracking-wide leading-[0.95] uppercase drop-shadow-[0_18px_45px_rgba(0,0,0,0.45)]">
                {!! __('UZUN SOFRALAR,<br><span class="font-accent italic text-brand font-normal lowercase">güzel muhabbetler</span>') !!}
            </h1>
            <p class="gsap-fade-in text-white/92 max-w-2xl mx-auto mb-10 text-base md:text-xl font-light tracking-wide leading-relaxed drop-shadow">
                {{ __('Kaş\'ın büyülü atmosferinde, dostlarla kurulan uzun sofraların, iyi müziğin ve lezzetin buluşma noktası.') }}
            </p>
            <div class="gsap-fade-in mt-8 flex flex-col lg:flex-row items-center justify-center gap-4">
                <x-tripadvisor-choice-badge compact on-dark class="h-16 w-64 justify-center" />
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="inline-flex h-16 w-64 items-center justify-center rounded-full bg-brand px-6 text-center text-sm font-bold uppercase tracking-widest text-white shadow-[0_18px_45px_rgba(92,100,72,0.32)] transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-olive">
                    {{ __('Discover Menu') }}
                </a>
                 <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'booking') }}" class="premium-glass-panel inline-flex h-16 w-64 items-center justify-center rounded-full border border-brand/70 px-6 text-center text-sm font-bold uppercase tracking-widest text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand hover:text-white">
                    {{ __('Book a Table') }}
                </a>
            </div>
            <div class="gsap-fade-in mt-7 flex flex-wrap justify-center gap-3 text-[10px] md:text-xs uppercase tracking-[0.22em] text-white/80">
                <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener" class="premium-glass-panel rounded-full px-4 py-2 hover:text-brand transition-colors">Google Maps</a>
                <a href="{{ App\Models\Setting::getValue('tripadvisor_link', 'https://www.tripadvisor.com.tr/Restaurant_Review-g297965-d4458801-Reviews-Ehl_i_Keyf_Meyhanesi_Kas-Kas_Turkish_Mediterranean_Coast.html') }}" target="_blank" rel="noopener" class="premium-glass-panel rounded-full px-4 py-2 hover:text-brand transition-colors">TripAdvisor</a>
                <a href="{{ App\Models\Setting::getValue('instagram_link', 'https://www.instagram.com/ehlikeyfmeyhanekas/') }}" target="_blank" rel="noopener" class="premium-glass-panel rounded-full px-4 py-2 hover:text-brand transition-colors">Instagram</a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </div>

    <!-- Brand Pillars Section -->
    <section class="py-20 md:py-24 bg-brand-dark text-brand-light px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-brand/10">
        <x-line-art-accents tone="light" />

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-14">
                <h2 class="gsap-fade-in text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-4">{{ __('Concept') }}</h2>
                <h3 class="gsap-fade-in text-3xl md:text-5xl font-serif font-light leading-tight text-brand-light">{{ __('Ehl-i Keyf Deneyimi') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-gsap-stagger>
                <!-- Pillar 1: Ambiyans -->
                <div class="group bg-brand-light/8 rounded-[2.5rem] p-10 border border-brand/25 hover:border-brand transition-all duration-500 hover:shadow-[0_24px_70px_rgba(92,100,72,0.12)] flex flex-col items-center text-center" data-gsap-item>
                    <div class="w-16 h-16 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-serif tracking-widest uppercase mb-4">{{ __('Ambiyans') }}</h4>
                    <p class="text-brand-light/70 font-light text-base leading-relaxed">{{ __('Kaş\'ın eşsiz zeytin ağaçları ve sıcak ışıkları altında, ruhu dinlendiren büyülü akşam ortamı.') }}</p>
                </div>
                
                <!-- Pillar 2: Lezzet -->
                <div class="group bg-brand-light/8 rounded-[2.5rem] p-10 border border-brand/25 hover:border-brand transition-all duration-500 hover:shadow-[0_24px_70px_rgba(92,100,72,0.12)] flex flex-col items-center text-center" data-gsap-item>
                    <div class="w-16 h-16 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-2xl font-serif tracking-widest uppercase mb-4">{{ __('Lezzet') }}</h4>
                    <p class="text-brand-light/70 font-light text-base leading-relaxed">{{ __('Taze deniz ürünleri, yerel mezeler ve usta şeflerimizin elinden çıkan özgün Akdeniz tatları.') }}</p>
                </div>
                
                <!-- Pillar 3: Muhabbet -->
                <div class="group bg-brand-light/8 rounded-[2.5rem] p-10 border border-brand/25 hover:border-brand transition-all duration-500 hover:shadow-[0_24px_70px_rgba(92,100,72,0.12)] flex flex-col items-center text-center" data-gsap-item>
                    <div class="w-16 h-16 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-serif tracking-widest uppercase mb-4">{{ __('Muhabbet') }}</h4>
                    <p class="text-brand-light/70 font-light text-base leading-relaxed">{{ __('Nostaljik arka plan müzikleri ve dostlarla paylaşılan uzun rakı sofralarında yankılanan eşsiz kahkahalar.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Culinary Excellence -->
    <section class="py-20 md:py-24 bg-[linear-gradient(180deg,#F8F1E7_0%,#FFFBF4_100%)] text-brand-dark px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <x-line-art-accents />
        
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <h2 class="gsap-fade-in text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-4">{{ __('Culinary Excellence') }}</h2>
            <h3 class="gsap-fade-in text-3xl md:text-5xl font-serif font-light leading-tight mb-12">{{ __('Crafted for the Senses') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left" data-gsap-stagger>
                @php
                    // Get top 3 top-level categories, or fallback to sensible defaults if none found
                    $topCategories = \App\Models\Category::whereNull('parent_id')
                                        ->where('is_active', true)
                                        ->orderBy('order_column')
                                        ->take(3)
                                        ->get();
                @endphp

                @forelse($topCategories as $category)
                    @php
                        $catSlug = $category->getTranslation('slug', app()->getLocale()) ?: $category->getTranslation('slug', 'en') ?: \Illuminate\Support\Str::slug($category->name);
                        
                        // 1. First choice: Use the category's uploaded image
                        if ($category->image) {
                            $catImgUrl = str_starts_with($category->image, 'http') ? $category->image : \Illuminate\Support\Facades\Storage::url($category->image);
                        } else {
                            // 2. Fallback to Setting if no custom image is uploaded
                            $catImgUrl = \App\Models\Setting::getValue('menu_snacks_image', asset('storage/gallery/029A7858.webp'));
                            if(str_contains(strtolower($category->name), 'food') || str_contains(strtolower($category->name), 'main') || str_contains(strtolower($category->name), 'yemek') || str_contains(strtolower($category->name), 'kahvaltı')) {
                                $catImgUrl = \App\Models\Setting::getValue('menu_restaurant_image', asset('storage/gallery/029A7810.webp'));
                            }
                            if(str_contains(strtolower($category->name), 'drink') || str_contains(strtolower($category->name), 'icecek') || str_contains(strtolower($category->name), 'içecek') || str_contains(strtolower($category->name), 'şarap')) {
                                $catImgUrl = \App\Models\Setting::getValue('menu_drinks_image', asset('storage/gallery/029A7909.webp'));
                            }
                        }
                    @endphp
                    <a href="{{ route('menu', ['category' => $catSlug]) }}" wire:navigate class="group w-full block relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 min-h-[160px] md:min-h-[220px]" data-gsap-item>
                        <img src="{{ $catImgUrl }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $category->name }}">
                        <div class="absolute inset-0 bg-brand-dark/40 group-hover:bg-brand-dark/20 transition-colors duration-500"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                            <h4 class="text-2xl md:text-3xl font-bold text-white tracking-widest uppercase drop-shadow-md">{{ $category->name }}</h4>
                            @if($category->description)
                                <p class="text-white/80 font-light text-sm mt-2 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-500 hidden md:block">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <!-- Fallback if database is completely empty -->
                    <div class="col-span-3 text-center py-10 text-gray-400 italic">{{ __('Menu items are being prepared.') }}</div>
                @endforelse
            </div>
            
            <div class="mt-14">
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="gsap-fade-in inline-block px-10 py-4 border border-brand-dark text-brand-dark hover:bg-brand-dark hover:text-white transition-colors duration-300 uppercase tracking-widest text-sm rounded-full">{{ __('View Full Menu') }}</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-24 md:py-32 bg-[linear-gradient(180deg,#F8F1E7_0%,#EFE2D1_100%)] text-brand-dark px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <x-line-art-accents />
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="gsap-fade-in premium-card p-3 rounded-[2rem]">
                        <div class="aspect-[4/5] overflow-hidden rounded-[1.45rem]">
                            <img src="{{ \App\Models\Setting::getValue('story_image', asset('storage/gallery/029A7798.webp')) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Restaurant Atmosphere">
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2 premium-card rounded-[2rem] p-8 md:p-12">
                    <h2 class="gsap-fade-in text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-6">{{ __('Our Story') }}</h2>
                    <h3 class="gsap-fade-in text-3xl md:text-5xl font-serif font-light leading-tight mb-8">{{ __('A premium Mediterranean tavern experience') }}<br><span class="italic text-brand-accent font-sans">{{ __('in the heart of Kaş') }}</span></h3>
                    <p class="gsap-fade-in text-gray-600 mb-6 leading-relaxed font-light text-lg">
                        {{ __('Homepage About Text 1') }}
                    </p>
                    <p class="gsap-fade-in text-gray-600 mb-10 leading-relaxed font-light text-lg">
                        {{ __('Homepage About Text 2') }}
                    </p>
                    <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'our-story') }}" class="gsap-fade-in inline-flex items-center text-brand-accent uppercase tracking-widest text-sm font-medium hover:text-brand-dark transition-colors group">
                        {{ __('Read Our Story') }}
                        <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section (Parallax visual break) -->
    <section class="relative py-40 overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 z-0 gsap-parallax" data-parallax-speed="0.25">
            @php
                $parallaxImage = \App\Models\Setting::getValue('parallax_image', asset('storage/gallery/029A8012-HDR.webp'));
            @endphp
            <img src="{{ $parallaxImage }}" class="w-full h-full object-cover" alt="Sunset Over Coast">
            <div class="absolute inset-0 bg-brand-dark/50"></div>
        </div>
        <div class="relative z-10 text-center max-w-4xl px-4">
            <h2 class="gsap-fade-in text-3xl md:text-6xl text-white font-serif font-light mb-6 uppercase tracking-wider">"{{ __('Kaş\'ta meyhanenin en güzel hali.') }}"</h2>
            <p class="gsap-fade-in text-brand text-lg md:text-2xl font-serif italic tracking-widest">{{ __('Rakının yanına muhabbet bizden.') }}</p>
        </div>
    </section>



    <!-- Reviews Section -->
    <section class="py-24 md:py-32 bg-brand-light text-brand-dark px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <x-line-art-accents />

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            @php
                $googlePlaceSummary = \App\Models\GooglePlaceSummary::query()->latest('synced_at')->first();
                $googleReviewCount = (int) ($googlePlaceSummary?->review_count ?: \App\Models\Setting::getValue('google_review_count', 5894));
                $googleRating = (float) ($googlePlaceSummary?->rating ?: \App\Models\Setting::getValue('google_rating', 5));
                $googleSyncedAt = $googlePlaceSummary?->synced_at;
            @endphp

            {{-- Google + Tripadvisor Social Proof Badges --}}
            <div class="gsap-fade-in mb-16 flex flex-col lg:flex-row items-center justify-center gap-5">
                <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener"
                   class="group inline-flex flex-col items-center gap-4 bg-white/70 backdrop-blur-md border border-white/60 rounded-3xl px-10 py-8 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1 cursor-pointer">
                    
                    {{-- Google Logo + Verified badge --}}
                    <div class="flex items-center gap-3">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-500 uppercase tracking-widest">Google Maps</span>
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border border-green-200">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Doğrulandı
                        </span>
                    </div>

                    {{-- Animated Counter --}}
                    <div class="flex items-end gap-3">
                        <span class="text-6xl md:text-7xl font-black text-brand-dark tabular-nums leading-none" id="reviews-counter" data-target="{{ $googleReviewCount }}">0</span>
                        <div class="flex flex-col items-start pb-2">
                            <div class="flex items-center gap-0.5 mb-1">
                                @for($i=0; $i<5; $i++)
                                    <svg class="w-5 h-5 text-brand-accent fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-400 font-medium tracking-wide">Google Yorumu</span>
                            @if($googleSyncedAt)
                                <span class="text-[10px] text-gray-400 font-light">Son güncelleme: {{ $googleSyncedAt->timezone(config('app.timezone'))->format('d.m.Y H:i') }}</span>
                            @endif
                        </div>
                    </div>

                    <span class="text-xs text-brand-olive font-semibold tracking-widest uppercase group-hover:underline flex items-center gap-1">
                        Tüm Yorumları Gör
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>

                <div class="group flex flex-col items-center gap-4 bg-white/80 backdrop-blur-md border border-white/70 rounded-3xl px-10 py-8 shadow-lg hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
                    <x-tripadvisor-choice-badge />
                    <div class="text-center max-w-xs">
                        <p class="text-2xl md:text-3xl font-serif font-light text-brand-dark leading-tight">Travellers’ Choice 2025</p>
                        <p class="mt-2 text-sm text-brand-dark/60 font-light leading-relaxed">Ehl-i Keyf Kaş, Tripadvisor misafir değerlendirmeleriyle 2025 Travellers’ Choice ödülüne layık görüldü.</p>
                    </div>
                </div>
            </div>

            {{-- Counter animation script --}}
            <script>
            (function() {
                var el = document.getElementById('reviews-counter');
                if (!el) return;
                var target = parseInt(el.getAttribute('data-target'));
                var started = false;
                function animateCount() {
                    if (started) return;
                    started = true;
                    var duration = 2000;
                    var startTime = null;
                    function step(timestamp) {
                        if (!startTime) startTime = timestamp;
                        var progress = Math.min((timestamp - startTime) / duration, 1);
                        var eased = 1 - Math.pow(1 - progress, 4);
                        el.textContent = Math.floor(eased * target).toLocaleString('tr-TR');
                        if (progress < 1) requestAnimationFrame(step);
                        else el.textContent = target.toLocaleString('tr-TR');
                    }
                    requestAnimationFrame(step);
                }
                var observer = new IntersectionObserver(function(entries) {
                    if (entries[0].isIntersecting) { animateCount(); observer.disconnect(); }
                }, { threshold: 0.3 });
                observer.observe(el);
            })();
            </script>

            <h2 class="gsap-fade-in text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-4">YORUMLAR</h2>
            <h3 class="gsap-fade-in text-3xl md:text-5xl font-serif font-light leading-tight mb-16 italic">Misafirlerimiz Ne Diyor?</h3>

            {{-- Premium Two-Row Review Marquee with Scroll-Velocity --}}
            @php
            $syncedReviewCards = \App\Models\GoogleReview::query()
                ->where('is_active', true)
                ->whereNotNull('text')
                ->where('text', '!=', '')
                ->orderByDesc('published_at')
                ->take(10)
                ->get()
                ->map(function ($review, $index) {
                    $colors = ['#8B7355', '#6B8E6B', '#A0845C', '#7B6B5D', '#5E4A3F'];
                    $name = trim($review->author_name ?: 'Google Kullanıcısı');
                    $initials = collect(preg_split('/\s+/', $name))
                        ->filter()
                        ->take(2)
                        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                        ->implode('');

                    return [
                        'text' => $review->text,
                        'author' => $name,
                        'date' => $review->relative_time_description ?: optional($review->published_at)->translatedFormat('F Y'),
                        'init' => $initials ?: 'G',
                        'color' => $colors[$index % count($colors)],
                        'rating' => max(1, min(5, (int) $review->rating)),
                    ];
                });

            if ($syncedReviewCards->isNotEmpty()) {
                $splitAt = max(1, (int) ceil($syncedReviewCards->count() / 2));
                $reviewsRow1 = $syncedReviewCards->take($splitAt)->values()->all();
                $reviewsRow2 = $syncedReviewCards->slice($splitAt)->values()->all();

                if (empty($reviewsRow2)) {
                    $reviewsRow2 = $reviewsRow1;
                }
            } else {
                $reviewsRow1 = [
                    ['text' => 'Tatil için 5 gün Kaş\'a gelip üç gece yemeği Ehl-i Keyf\'te yedik. Mekanın manzarası, haydari ve lakerda müthişti. Personel çok ilgili ve candan. Kesinlikle Kaş\'ın en iyisi.', 'author' => 'Yağmur D.', 'date' => 'Haziran 2025', 'init' => 'YD', 'color' => '#8B7355', 'rating' => 5],
                    ['text' => 'İçeriye girdiğiniz andan itibaren müziğin etkisi ve personelin sıcaklığıyla kendinizi tamamen bırakıyorsunuz. Mezeler son derece tazeydi, rakı sofrası tam olması gerektiği gibiydi.', 'author' => 'Ahmet K.', 'date' => 'Temmuz 2025', 'init' => 'AK', 'color' => '#6B8E6B', 'rating' => 5],
                    ['text' => 'Sakin bir atmosferde muhteşem bir meyhane deneyimi yaşadık. Atom, muhammara ve lakerda inanılmaz lezzetliydi. Servis hızlı ve güler yüzlüydü. Kaş\'a gelenler mutlaka uğrasın.', 'author' => 'Aybike B.', 'date' => 'Ağustos 2025', 'init' => 'AB', 'color' => '#A0845C', 'rating' => 5],
                    ['text' => 'Kaş\'ta onlarca yere gittik ama Ehl-i Keyf bambaşka. Gün batımında deniz manzarasıyla içilen rakı ve taze meze… Bu deneyimi tarif etmek gerçekten çok zor. Yılın en güzel akşamıydı.', 'author' => 'Zümrüt Z.', 'date' => 'Temmuz 2025', 'init' => 'ZZ', 'color' => '#7B6B5D', 'rating' => 5],
                    ['text' => 'Hizmet, lezzet ve ambiyans açısından kusursuz. Haydari ve deniz mezeleri son derece tazeydi. Personelin samimiyeti insanı eve dönmüş gibi hissettiriyor.', 'author' => 'Özlem H.', 'date' => 'Haziran 2025', 'init' => 'ÖH', 'color' => '#5E4A3F', 'rating' => 5],
                ];
                $reviewsRow2 = [
                    ['text' => 'Ehl-i Keyf\'in ambiyansı ve sunumu gerçekten çok özel. Kalamar tava ve ahtapot muhteşemdi. Sofrada hiçbir şey eksik kalmıyor, personel sürekli ilgileniyor. Tatilimizin en güzel anları burada geçti.', 'author' => 'Ridvan Y.', 'date' => 'Ağustos 2025', 'init' => 'RY', 'color' => '#6B8E6B', 'rating' => 5],
                    ['text' => 'Mükemmel bir meyhane deneyimi. Taze deniz ürünleri, özenle hazırlanmış mezeler ve sıcak servis… Kaş\'ta bu kalitede mekan bulmak gerçekten nadir. Çevremdeki herkese tavsiye ediyorum.', 'author' => 'Merve S.', 'date' => 'Temmuz 2025', 'init' => 'MS', 'color' => '#A0845C', 'rating' => 5],
                    ['text' => 'Harika atmosfer, lezzetli mezeler ve güler yüzlü personel. Balık çok tazeydi, meyhane kültürünü yaşatıyorlar. Ehl-i Keyf Kaş seyahatimin en değerli anısı oldu.', 'author' => 'Berk T.', 'date' => 'Haziran 2025', 'init' => 'BT', 'color' => '#7B6B5D', 'rating' => 5],
                    ['text' => 'Haydari, lakerda ve muhammara enfesti. Manzara inanılmaz, müzik mükemmel. Böyle bir meyhanede akşam geçirmek insanı dinlendiriyor ve ruhunu besliyor. Kesinlikle tekrar geleceğiz.', 'author' => 'Selin A.', 'date' => 'Ağustos 2025', 'init' => 'SA', 'color' => '#8B7355', 'rating' => 5],
                    ['text' => 'Kaş\'ta en doğru tercih Ehl-i Keyf. Menüdeki her şey özenle hazırlanmış, sunum çok şık. Rakı sofrasına yakışır ortam ve misafirperver personel. Gönülden tavsiye ederim.', 'author' => 'Tarık O.', 'date' => 'Temmuz 2025', 'init' => 'TO', 'color' => '#5E4A3F', 'rating' => 5],
                ];
            }
            @endphp

            <div id="reviews-marquee-container" class="space-y-6">
                {{-- Row 1 → sola kayar --}}
                <div class="relative overflow-hidden" data-marquee-row="1" data-direction="left">
                    <div class="marquee-track flex gap-6 will-change-transform" data-track="1">
                        @foreach(array_merge($reviewsRow1, $reviewsRow1) as $review)
                        <div class="review-card flex-shrink-0 w-[340px] md:w-[400px]">
                            <div class="relative h-full rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, rgba(255,255,255,0.85), rgba(255,255,255,0.55)); backdrop-filter: blur(20px); box-shadow: 0 4px 30px rgba(91,78,58,0.06), 0 1px 3px rgba(91,78,58,0.08), inset 0 1px 0 rgba(255,255,255,0.6);">
                                {{-- Accent top border --}}
                                <div class="h-[3px] w-full" style="background: linear-gradient(90deg, transparent, {{ $review['color'] }}, transparent);"></div>
                                <div class="p-7 flex flex-col gap-4 h-full">
                                    {{-- Header: stars + Google --}}
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-0.5">
                                            @for($s=0;$s<($review['rating'] ?? 5);$s++)<svg class="w-4 h-4 fill-current text-brand-accent"  viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                                        </div>
                                        <svg class="w-[52px] h-[18px] opacity-40" viewBox="0 0 272 92" xmlns="http://www.w3.org/2000/svg"><path d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#EA4335"/><path d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#FBBC05"/><path d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 7.87 11.17 7.87 7.31 0 11.84-4.51 11.84-13v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.61h9.25zm-8.56 20.92c0-7.81-5.21-13.52-11.84-13.52-6.72 0-12.35 5.71-12.35 13.52 0 7.73 5.63 13.36 12.35 13.36 6.63 0 11.84-5.63 11.84-13.36z" fill="#4285F4"/><path d="M225 3v65h-9.5V3h9.5z" fill="#34A853"/><path d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-23.27-7.98l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" fill="#EA4335"/><path d="M35.29 41.19V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91S16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.66-2.66 4.41-6.46 5.1-11.65l-22.49-.21z" fill="#4285F4"/></svg>
                                    </div>

                                    {{-- Quote + text --}}
                                    <div class="relative flex-grow">
                                        <span class="absolute -top-2 -left-1 text-4xl font-serif leading-none select-none" style="color: {{ $review['color'] }}; opacity: 0.15;">"</span>
                                        <p class="text-brand-dark/75 text-[15px] leading-[1.7] font-light pl-4">{{ $review['text'] }}</p>
                                    </div>

                                    {{-- Author --}}
                                    <div class="flex items-center gap-3 pt-4 border-t border-brand-dark/5">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-semibold tracking-wide flex-shrink-0" style="background: {{ $review['color'] }};">{{ $review['init'] }}</div>
                                        <div>
                                            <p class="text-brand-dark/90 font-medium text-sm tracking-wide">{{ $review['author'] }}</p>
                                            <p class="text-brand-dark/35 text-[11px] font-light">{{ $review['date'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="absolute left-0 top-0 bottom-0 w-24 pointer-events-none z-10" style="background:linear-gradient(to right,rgba(245,241,230,1) 0%,transparent 100%)"></div>
                    <div class="absolute right-0 top-0 bottom-0 w-24 pointer-events-none z-10" style="background:linear-gradient(to left,rgba(245,241,230,1) 0%,transparent 100%)"></div>
                </div>

                {{-- Row 2 → sağa kayar --}}
                <div class="relative overflow-hidden" data-marquee-row="2" data-direction="right">
                    <div class="marquee-track flex gap-6 will-change-transform" data-track="2">
                        @foreach(array_merge($reviewsRow2, $reviewsRow2) as $review)
                        <div class="review-card flex-shrink-0 w-[340px] md:w-[400px]">
                            <div class="relative h-full rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, rgba(255,255,255,0.85), rgba(255,255,255,0.55)); backdrop-filter: blur(20px); box-shadow: 0 4px 30px rgba(91,78,58,0.06), 0 1px 3px rgba(91,78,58,0.08), inset 0 1px 0 rgba(255,255,255,0.6);">
                                <div class="h-[3px] w-full" style="background: linear-gradient(90deg, transparent, {{ $review['color'] }}, transparent);"></div>
                                <div class="p-7 flex flex-col gap-4 h-full">
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-0.5">
                                            @for($s=0;$s<($review['rating'] ?? 5);$s++)<svg class="w-4 h-4 fill-current text-brand-accent"  viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                                        </div>
                                        <svg class="w-[52px] h-[18px] opacity-40" viewBox="0 0 272 92" xmlns="http://www.w3.org/2000/svg"><path d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#EA4335"/><path d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" fill="#FBBC05"/><path d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 7.87 11.17 7.87 7.31 0 11.84-4.51 11.84-13v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.61h9.25zm-8.56 20.92c0-7.81-5.21-13.52-11.84-13.52-6.72 0-12.35 5.71-12.35 13.52 0 7.73 5.63 13.36 12.35 13.36 6.63 0 11.84-5.63 11.84-13.36z" fill="#4285F4"/><path d="M225 3v65h-9.5V3h9.5z" fill="#34A853"/><path d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-23.27-7.98l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" fill="#EA4335"/><path d="M35.29 41.19V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91S16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.66-2.66 4.41-6.46 5.1-11.65l-22.49-.21z" fill="#4285F4"/></svg>
                                    </div>
                                    <div class="relative flex-grow">
                                        <span class="absolute -top-2 -left-1 text-4xl font-serif leading-none select-none" style="color: {{ $review['color'] }}; opacity: 0.15;">"</span>
                                        <p class="text-brand-dark/75 text-[15px] leading-[1.7] font-light pl-4">{{ $review['text'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 pt-4 border-t border-brand-dark/5">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-semibold tracking-wide flex-shrink-0" style="background: {{ $review['color'] }};">{{ $review['init'] }}</div>
                                        <div>
                                            <p class="text-brand-dark/90 font-medium text-sm tracking-wide">{{ $review['author'] }}</p>
                                            <p class="text-brand-dark/35 text-[11px] font-light">{{ $review['date'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="absolute left-0 top-0 bottom-0 w-24 pointer-events-none z-10" style="background:linear-gradient(to right,rgba(245,241,230,1) 0%,transparent 100%)"></div>
                    <div class="absolute right-0 top-0 bottom-0 w-24 pointer-events-none z-10" style="background:linear-gradient(to left,rgba(245,241,230,1) 0%,transparent 100%)"></div>
                </div>
            </div>

            {{-- Scroll-velocity driven marquee animation with inertial physics and smooth hover slowdown --}}
            <script>
            (function() {
                var tracks = [
                    { el: document.querySelector('[data-track="1"]'), dir: -1, pos: 0, baseSpeed: 0.5, currentSpeed: 0.5, isHovered: false },
                    { el: document.querySelector('[data-track="2"]'), dir: 1,  pos: 0, baseSpeed: 0.45, currentSpeed: 0.45, isHovered: false }
                ];
                if (!tracks[0].el || !tracks[1].el) return;

                // Add hover event listeners to closest relative container (the row wrapper)
                tracks.forEach(function(t) {
                    var parent = t.el.parentElement;
                    if (parent) {
                        parent.addEventListener('mouseenter', function() { t.isHovered = true; });
                        parent.addEventListener('mouseleave', function() { t.isHovered = false; });
                    }
                });

                var lastScroll = window.scrollY;
                var scrollVel = 0;
                var container = document.getElementById('reviews-marquee-container');

                window.addEventListener('scroll', function() {
                    scrollVel = Math.abs(window.scrollY - lastScroll);
                    lastScroll = window.scrollY;
                }, { passive: true });

                var initialized = false;

                function tick() {
                    if (!initialized && tracks[1].el.scrollWidth > 0) {
                        var halfW2 = tracks[1].el.scrollWidth / 2;
                        tracks[1].pos = -halfW2;
                        initialized = true;
                    }

                    // Only animate when container is in viewport
                    var rect = container.getBoundingClientRect();
                    var inView = rect.bottom > -200 && rect.top < window.innerHeight + 200;

                    if (inView && initialized) {
                        // scrollVel adds acceleration: faster scroll = faster marquee
                        var boost = Math.min(scrollVel * 0.18, 8);
                        scrollVel *= 0.90; // decay scroll velocity boost

                        for (var i = 0; i < tracks.length; i++) {
                            var t = tracks[i];
                            var halfW = t.el.scrollWidth / 2;
                            if (halfW <= 0) continue;

                            // Target speed is 0 if hovered, else baseSpeed + scroll boost
                            var targetSpeed = t.isHovered ? 0 : (t.baseSpeed + boost);
                            
                            // Interpolate current speed towards target speed for organic deceleration/acceleration
                            t.currentSpeed += (targetSpeed - t.currentSpeed) * 0.08;
                            t.pos += t.currentSpeed * t.dir;

                            // Seamless wrapping
                            if (t.dir === -1 && t.pos <= -halfW) t.pos += halfW;
                            if (t.dir === 1 && t.pos >= 0) t.pos -= halfW;

                            t.el.style.transform = 'translate3d(' + t.pos + 'px, 0, 0)';
                        }
                    }
                    requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            })();
            </script>



            <div class="mt-24 space-y-8">
                <p class="gsap-fade-in text-brand-dark/60 font-medium uppercase tracking-[0.2em] text-sm">{{ __('Have you visited us?') }}</p>
                <div class="gsap-fade-in flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener" class="px-8 py-3 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        {{ __('Review on Google') }}
                    </a>
                    <a href="{{ App\Models\Setting::getValue('tripadvisor_link', 'https://www.tripadvisor.com.tr/Restaurant_Review-g297965-d4458801-Reviews-Ehl_i_Keyf_Meyhanesi_Kas-Kas_Turkish_Mediterranean_Coast.html') }}" target="_blank" rel="noopener" class="px-8 py-3 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full flex items-center justify-center gap-3">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.006 4.295c-2.67 0-5.338.784-7.645 2.353H0l1.963 2.135a5.997 5.997 0 0 0 4.04 10.43 5.976 5.976 0 0 0 4.075-1.6L12 19.705l1.922-2.09a5.972 5.972 0 0 0 4.072 1.598 6 6 0 0 0 6-5.998 5.982 5.982 0 0 0-1.957-4.432L24 6.648h-4.35a13.573 13.573 0 0 0-7.644-2.353zM12 6.255c1.531 0 3.063.303 4.504.903C13.943 8.138 12 10.43 12 13.1c0-2.671-1.942-4.962-4.504-5.942A11.72 11.72 0 0 1 12 6.256zM6.002 9.157a4.059 4.059 0 1 1 0 8.118 4.059 4.059 0 0 1 0-8.118zm11.992.002a4.057 4.057 0 1 1 .003 8.115 4.057 4.057 0 0 1-.003-8.115zm-11.992 1.93a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256zm11.992 0a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256z"/>
                        </svg>
                        {{ __('Review on TripAdvisor') }}
                    </a>
                </div>

                <!-- Private Feedback Trigger -->
                <livewire:feedback-form />
            </div>
        </div>
    </section>

    <!-- Blog Feed Section -->
    <livewire:blog-feed />
</div>
