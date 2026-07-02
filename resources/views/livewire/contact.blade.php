<div class="pt-32 pb-0 bg-brand-light min-h-screen flex flex-col relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235B6E4E' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235B6E4E'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235B6E4E'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 pb-24">
            <!-- Contact Info -->
            <div class="gsap-fade-in pt-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-brand-dark mb-12 tracking-wide">
                    {{ __('Get in Touch') }}
                </h1>
                
                <div class="space-y-10">
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Reservations') }}</h3>
                        <p class="text-gray-600 font-light mb-2">{{ __('Book your table for an unforgettable Mediterranean evening.') }}</p>
                         <a href="tel:{{ str_replace(' ', '', App\Models\Setting::getValue('phone', '905367292218')) }}" class="text-2xl font-medium text-brand-dark hover:text-brand-accent transition-colors">{{ App\Models\Setting::getValue('phone', '+90 536 729 22 18') }}</a>
                    </div>
                    
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Location') }}</h3>
                         <address class="not-italic text-gray-600 font-light leading-relaxed text-lg">
                            {{ App\Models\Setting::getValue('address', 'Andifli, Hükümet Cd. No:3, 07580 Kaş/Antalya') }}
                        </address>
                    </div>
                    
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Hours') }}</h3>
                        <p class="text-gray-600 font-light text-lg">{{ __('Everyday') }}: <span class="font-medium">14:00 - 00:00</span></p>
                    </div>
                    
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Email') }}</h3>
                         <a href="mailto:{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}" class="text-xl font-light text-brand-dark hover:text-brand-accent transition-colors border-b border-brand-accent pb-1">{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}</a>
                    </div>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="gsap-fade-in relative h-[500px] lg:h-auto bg-gray-200">
                <iframe 
                    src="{{ App\Models\Setting::getValue('google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1591.956627094056!2d29.610111162153966!3d36.19835705663737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c1d1bc5b476b55%3A0xbf4bd37d9119f4b4!2sEhl-i Keyf%20Restaurant%20Ka%C5%9F!5e0!3m2!1sen!2str!4v1709068478491!5m2!1sen!2str') }}" 
                    class="absolute inset-0 w-full h-full border-0 grayscale opacity-90 contrast-125 mix-blend-multiply" 
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
