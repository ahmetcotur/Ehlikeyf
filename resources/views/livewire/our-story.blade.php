<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative h-[60vh] md:h-[70vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ App\Models\Setting::getValue('our_story_hero_image', asset('storage/gallery/029A8016-HDR.webp')) }}" class="w-full h-full object-cover" alt="Ehl-i Keyf Story Hero">
            <div class="absolute inset-0 bg-brand-dark/40"></div>
        </div>
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto pt-20">
            <h1 class="gsap-title text-4xl md:text-6xl lg:text-7xl font-light text-white mb-6 tracking-wide leading-tight">
                {{ __('Our Story Title') }}
            </h1>
            <p class="gsap-subtitle text-brand text-lg md:text-xl tracking-widest font-light uppercase">
                {{ __('Our Story Subtitle') }}
            </p>
        </div>
    </div>

    <!-- Background Pattern Wrapper -->
    <div class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width=\'120\' height=\'120\' viewBox=\'0 0 120 120\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' stroke=\'%235B6E4E\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\' opacity=\'0.1\'%3E%3Cpath d=\'M60 100 C 60 70 45 40 20 20\'/%3E%3Cpath d=\'M60 100 C 65 70 85 40 110 20\'/%3E%3Cellipse cx=\'35\' cy=\'45\' rx=\'10\' ry=\'5\' transform=\'rotate(-35 35 45)\' fill=\'%235B6E4E\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'45\' cy=\'75\' rx=\'8\' ry=\'4\' transform=\'rotate(-45 45 75)\' fill=\'%235B6E4E\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'85\' cy=\'45\' rx=\'10\' ry=\'5\' transform=\'rotate(35 85 45)\' fill=\'%235B6E4E\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'75\' cy=\'75\' rx=\'8\' ry=\'4\' transform=\'rotate(45 75 75)\' fill=\'%235B6E4E\' fill-opacity=\'0.2\'/%3E%3Ccircle cx=\'60\' cy=\'60\' r=\'4\' fill=\'%235B6E4E\'/%3E%3Ccircle cx=\'55\' cy=\'85\' r=\'3.5\' fill=\'%235B6E4E\'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-1000">
            <!-- Section 1: The Roots -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-32">
                <div class="gsap-left order-2 md:order-1">
                    <h2 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-6">{{ __('The Roots Title') }}</h2>
                    <p class="text-gray-600 leading-[1.8] font-light text-lg mb-0 first-letter:text-5xl first-letter:font-serif first-letter:mr-3 first-letter:float-left first-letter:text-brand-olive">
                        {{ __('The Roots Content') }}
                    </p>
                </div>
                <div class="gsap-right order-1 md:order-2">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ App\Models\Setting::getValue('our_story_roots_image', asset('storage/gallery/029A7811.webp')) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Roots Image">
                    </div>
                </div>
            </div>

            <!-- Section 2: The Sea -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-32">
                <div class="gsap-left">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ App\Models\Setting::getValue('our_story_sea_image', asset('storage/gallery/029A7905.webp')) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Sea Image">
                    </div>
                </div>
                <div class="gsap-right">
                    <h2 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-6">{{ __('The Sea Title') }}</h2>
                    <p class="text-gray-600 leading-[1.8] font-light text-lg mb-0">
                        {{ __('The Sea Content') }}
                    </p>
                </div>
            </div>

            <!-- Section 3: The Flame -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-32">
                <div class="gsap-left order-2 md:order-1">
                    <h2 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-6">{{ __('The Flame Title') }}</h2>
                    <p class="text-gray-600 leading-[1.8] font-light text-lg mb-0">
                        {{ __('The Flame Content') }}
                    </p>
                </div>
                <div class="gsap-right order-1 md:order-2">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ App\Models\Setting::getValue('our_story_flame_image', asset('storage/gallery/029A7916.webp')) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Flame Image">
                    </div>
                </div>
            </div>

            <!-- Section 4: The Gathering -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-32">
                <div class="gsap-left">
                    <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ App\Models\Setting::getValue('our_story_gathering_image', asset('storage/gallery/029A7937.webp')) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Gathering Image">
                    </div>
                </div>
                <div class="gsap-right">
                    <h2 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-6">{{ __('The Gathering Title') }}</h2>
                    <p class="text-gray-600 leading-[1.8] font-light text-lg mb-0">
                        {{ __('The Gathering Content') }}
                    </p>
                </div>
            </div>

            <!-- Conclusion Section -->
            <div class="text-center max-w-3xl mx-auto py-20 border-t border-brand-olive/20">
                <h2 class="text-3xl md:text-4xl font-light italic text-brand-olive mb-10">{{ __('Conclusion Title') }}</h2>
                <p class="text-gray-600 leading-[2] font-light text-lg italic">
                    {{ __('Conclusion Content') }}
                </p>
                
                <div class="mt-16">
                    <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="inline-block px-12 py-5 bg-brand-olive text-white hover:bg-brand-dark transition-colors duration-300 uppercase tracking-widest text-sm font-medium rounded-full shadow-lg">
                        {{ __('Discover Menu') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        gsap.from('.gsap-title', {
            y: 50,
            opacity: 0,
            duration: 1.2,
            ease: 'power3.out'
        });
        
        gsap.from('.gsap-subtitle', {
            y: 30,
            opacity: 0,
            duration: 1,
            delay: 0.3,
            ease: 'power3.out'
        });

        const revealSections = document.querySelectorAll('.grid');
        revealSections.forEach((section) => {
            gsap.from(section.querySelector('.gsap-left'), {
                scrollTrigger: {
                    trigger: section,
                    start: 'top 80%',
                },
                x: -50,
                opacity: 0,
                duration: 1,
                ease: 'power2.out'
            });
            
            gsap.from(section.querySelector('.gsap-right'), {
                scrollTrigger: {
                    trigger: section,
                    start: 'top 80%',
                },
                x: 50,
                opacity: 0,
                duration: 1,
                ease: 'power2.out'
            });
        });

        gsap.from('.text-center.max-w-3xl', {
            scrollTrigger: {
                trigger: '.text-center.max-w-3xl',
                start: 'top 80%',
            },
            y: 40,
            opacity: 0,
            duration: 1,
            ease: 'power2.out'
        });
    });
</script>
