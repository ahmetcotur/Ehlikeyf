<footer class="bg-brand-light text-brand-dark pt-20 pb-10 border-t border-brand-dark/10 relative overflow-hidden">
    <!-- Decorative subtle background -->
    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d8ccb6\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-16 text-center md:text-left">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-1 flex flex-col items-center md:items-start">
                 <img src="{{ App\Models\Setting::getValue('logo', asset('images/logo.png')) }}" alt="{{ App\Models\Setting::getValue('site_name', 'Ehl-i Keyf Logo') }}" class="h-16 mb-8 transition-transform hover:scale-105 duration-500">
                <p class="text-sm text-gray-600 leading-relaxed max-w-xs font-light">
                    {{ App\Models\Setting::getValue('meta_description', __('Unique Mediterranean flavors, fresh seafood and unforgettable atmosphere in the heart of Kaş.')) }}
                </p>
                <div class="mt-8 flex space-x-3">
                    <!-- Google Maps (primary) -->
                    <a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:text-brand-olive hover:border-brand-olive transition-colors" title="Google Maps">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z" fill="currentColor"/></svg>
                    </a>
                    <!-- TripAdvisor -->
                    <a href="{{ App\Models\Setting::getValue('tripadvisor_link', 'https://www.tripadvisor.com.tr/Restaurant_Review-g297965-d4458801-Reviews-Ehl_i_Keyf_Meyhanesi_Kas-Kas_Turkish_Mediterranean_Coast.html') }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:text-brand-olive hover:border-brand-olive transition-colors" title="TripAdvisor">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.006 4.295c-2.67 0-5.338.784-7.645 2.353H0l1.963 2.135a5.997 5.997 0 0 0 4.04 10.43 5.976 5.976 0 0 0 4.075-1.6L12 19.705l1.922-2.09a5.972 5.972 0 0 0 4.072 1.598 6 6 0 0 0 6-5.998 5.982 5.982 0 0 0-1.957-4.432L24 6.648h-4.35a13.573 13.573 0 0 0-7.644-2.353zM12 6.255c1.531 0 3.063.303 4.504.903C13.943 8.138 12 10.43 12 13.1c0-2.671-1.942-4.962-4.504-5.942A11.72 11.72 0 0 1 12 6.256zM6.002 9.157a4.059 4.059 0 1 1 0 8.118 4.059 4.059 0 0 1 0-8.118zm11.992.002a4.057 4.057 0 1 1 .003 8.115 4.057 4.057 0 0 1-.003-8.115zm-11.992 1.93a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256zm11.992 0a2.128 2.128 0 0 0 0 4.256 2.128 2.128 0 0 0 0-4.256z"/></svg>
                    </a>
                    <!-- Facebook -->
                    <a href="{{ App\Models\Setting::getValue('facebook_link', 'https://www.facebook.com/ehlikeyfmeyhanekas') }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:text-brand-olive hover:border-brand-olive transition-colors" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="{{ App\Models\Setting::getValue('instagram_link', 'https://www.instagram.com/ehlikeyfmeyhanekas/') }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:text-brand-olive hover:border-brand-olive transition-colors" title="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Explore Links -->
            <div class="col-span-1">
                <h3 class="text-brand-olive uppercase tracking-widest text-sm font-semibold mb-6">{{ __('Explore') }}</h3>
                <ul class="space-y-4 text-gray-600 font-light text-sm">
                    <li><a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="hover:text-brand-dark transition duration-300">{{ __('Home') }}</a></li>
                    <li><a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'menu') }}" class="hover:text-brand-dark transition duration-300">{{ __('Menu') }}</a></li>
                    <li><a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'blog') }}" class="hover:text-brand-dark transition duration-300">{{ __('Journal') }}</a></li>
                    <li><a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'gallery') }}" class="hover:text-brand-dark transition duration-300">{{ __('Gallery') }}</a></li>
                    <li><a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'contact') }}" class="hover:text-brand-dark transition duration-300">{{ __('Contact') }}</a></li>
                </ul>
            </div>

            <div class="col-span-1">
                <h3 class="text-brand-olive uppercase tracking-widest text-sm font-semibold mb-6">{{ __('Visit Us') }}</h3>
                 <address class="not-italic text-sm text-gray-600 font-light space-y-4 leading-relaxed">
                    <p class="hover:text-brand-dark transition"><a href="{{ App\Models\Setting::getValue('google_maps_link', 'https://maps.app.goo.gl/qaEZ8ucy3BTa4GGK6') }}" target="_blank" rel="noopener">{{ App\Models\Setting::getValue('address', 'Andifli, Hükümet Cd. No:3, 07580 Kaş/Antalya') }}</a></p>
                    <p class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-brand-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <a href="tel:{{ str_replace(' ', '', App\Models\Setting::getValue('phone', '905367292218')) }}" class="hover:text-brand-olive transition underline decoration-brand-olive/30 underline-offset-4">{{ App\Models\Setting::getValue('phone', '+90 536 729 22 18') }}</a>
                    </p>
                    <p class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <a href="https://wa.me/{{ App\Models\Setting::getValue('whatsapp', '905367292218') }}" target="_blank" class="hover:text-[#25D366] transition underline decoration-[#25D366]/30 underline-offset-4">WhatsApp</a>
                    </p>
                    <p class="flex items-center space-x-2 mt-4">
                        <svg class="w-4 h-4 text-brand-dark/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}" class="hover:text-brand-dark transition block">{{ App\Models\Setting::getValue('email', 'info@ehlikeyfkas.com') }}</a>
                    </p>
                </address>
            </div>

            <!-- Hours -->
            <div class="col-span-1">
                <h3 class="text-brand-olive uppercase tracking-widest text-sm font-semibold mb-6">{{ __('Hours') }}</h3>
                <div class="text-sm text-gray-600 font-light space-y-2">
                    <p>{{ __('Everyday') }}</p>
                    <p class="text-brand-olive text-lg font-normal tracking-wider mt-1">14:00 &mdash; 00:00</p>
                </div>
            </div>
        </div>

        <div class="mt-20 pt-8 border-t border-brand-dark/10 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-500 tracking-widest uppercase">
            <p class="order-2 md:order-1 mt-4 md:mt-0 font-light">&copy; {{ date('Y') }} Ehl-i Keyf Kaş. {{ __('All rights reserved.') }}</p>
            
            <div class="order-1 md:order-2 flex items-center group relative cursor-help">
                <a href="https://voyn.tr" target="_blank" class="opacity-40 hover:opacity-100 transition-opacity duration-300">
                    <img src="https://voyn.tr/storage/logos/GsuNpCCi4zTxXOjaq6JNdf3XMo022t2bVgnBSp3k.png" alt="voyn.tr" class="h-3.5 invert grayscale">
                </a>
                <!-- Tooltip -->
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-4 py-2 bg-brand-dark text-[9px] text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none whitespace-nowrap z-50 shadow-2xl border border-white/10 transform translate-y-2 group-hover:translate-y-0">
                    {{ __('This website and all services of Ehl-i Keyf are provided by socialkas.com and voyn.tr.') }}
                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-brand-dark"></div>
                </div>
            </div>

            <div class="order-3 flex space-x-6 mt-4 md:mt-0 font-medium">
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'privacy-policy') }}" class="hover:text-brand-olive transition">{{ __('Privacy Policy') }}</a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), 'terms-of-service') }}" class="hover:text-brand-olive transition">{{ __('Terms of Service') }}</a>
            </div>
        </div>
    </div>
</footer>
