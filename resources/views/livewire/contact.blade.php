<div class="pt-32 pb-0 bg-brand-light min-h-screen flex flex-col relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235E4A3F' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235E4A3F'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235E4A3F'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 pb-24">
            <!-- Contact Info -->
            <div class="gsap-slide-left pt-10">
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
                         <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener" class="text-gray-600 font-light leading-relaxed text-lg hover:text-brand-accent transition-colors block">
                            {{ App\Models\Setting::getValue('address', 'Andifli, Hükümet Cd. No:3, 07580 Kaş/Antalya') }}
                        </a>
                    </div>
                    
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Hours') }}</h3>
                        <p class="text-gray-600 font-light text-lg">{{ __('Everyday') }}: <span class="font-medium">11:00 - 02:00</span></p>
                    </div>
                    
                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-3">{{ __('Email') }}</h3>
                         <a href="mailto:{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}" class="text-xl font-light text-brand-dark hover:text-brand-accent transition-colors border-b border-brand-accent pb-1">{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}</a>
                    </div>

                    <div>
                        <h3 class="text-brand-olive uppercase tracking-[0.2em] text-sm font-semibold mb-4">{{ __('Find Us On') }}</h3>
                        <div class="flex flex-wrap gap-3">
                            <!-- Google Maps (primary) -->
                            <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                                Google Maps
                            </a>
                            <!-- TripAdvisor -->
                            <a href="{{ App\Models\Setting::getValue('tripadvisor_link', 'https://www.tripadvisor.com.tr/Restaurant_Review-g297965-d4458801-Reviews-Ehl_i_Keyf_Meyhanesi_Kas-Kas_Turkish_Mediterranean_Coast.html') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.006 4.295c-2.67 0-5.338.784-7.645 2.353H0l1.963 2.135a5.997 5.997 0 0 0 4.04 10.43 5.976 5.976 0 0 0 4.075-1.6L12 19.705l1.922-2.09a5.972 5.972 0 0 0 4.072 1.598 6 6 0 0 0 6-5.998 5.982 5.982 0 0 0-1.957-4.432L24 6.648h-4.35a13.573 13.573 0 0 0-7.644-2.353zM12 6.255c1.531 0 3.063.303 4.504.903C13.943 8.138 12 10.43 12 13.1c0-2.671-1.942-4.962-4.504-5.942A11.72 11.72 0 0 1 12 6.256zM6.002 9.157a4.059 4.059 0 1 1 0 8.118 4.059 4.059 0 0 1 0-8.118zm11.992.002a4.057 4.057 0 1 1 .003 8.115 4.057 4.057 0 0 1-.003-8.115zm-11.992 1.93a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256zm11.992 0a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256z"/></svg>
                                TripAdvisor
                            </a>
                            <!-- Facebook -->
                            <a href="{{ App\Models\Setting::getValue('facebook_link', 'https://www.facebook.com/ehlikeyfmeyhanekas') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                            <!-- Instagram -->
                            <a href="{{ App\Models\Setting::getValue('instagram_link', 'https://www.instagram.com/ehlikeyfmeyhanekas/') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-brand-olive/20 text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-300 text-xs font-bold uppercase tracking-widest rounded-full">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                Instagram
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="gsap-slide-right relative h-[500px] lg:h-auto bg-gray-200">
                <iframe 
                    src="{{ App\Models\Setting::getValue('google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1591.956627094056!2d29.610111162153966!3d36.19835705663737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c1d1bc5b476b55%3A0xbf4bd37d9119f4b4!2sEhl-i Keyf%20Restaurant%20Ka%C5%9F!5e0!3m2!1sen!2str!4v1709068478491!5m2!1sen!2str') }}" 
                    class="absolute inset-0 w-full h-full border-0 grayscale opacity-90 contrast-125 mix-blend-multiply" 
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
