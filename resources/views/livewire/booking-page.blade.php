<div class="pt-32 pb-24 bg-brand-light min-h-screen relative overflow-hidden">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width=\'120\' height=\'120\' viewBox=\'0 0 120 120\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' stroke=\'%235E4A3F\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\' opacity=\'0.1\'%3E%3Cpath d=\'M60 100 C 60 70 45 40 20 20\'/%3E%3Cpath d=\'M60 100 C 65 70 85 40 110 20\'/%3E%3Cellipse cx=\'35\' cy=\'45\' rx=\'10\' ry=\'5\' transform=\'rotate(-35 35 45)\' fill=\'%235E4A3F\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'45\' cy=\'75\' rx=\'8\' ry=\'4\' transform=\'rotate(-45 45 75)\' fill=\'%235E4A3F\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'85\' cy=\'45\' rx=\'10\' ry=\'5\' transform=\'rotate(35 85 45)\' fill=\'%235E4A3F\' fill-opacity=\'0.2\'/%3E%3Cellipse cx=\'75\' cy=\'75\' rx=\'8\' ry=\'4\' transform=\'rotate(45 75 75)\' fill=\'%235E4A3F\' fill-opacity=\'0.2\'/%3E%3Ccircle cx=\'60\' cy=\'60\' r=\'4\' fill=\'%235E4A3F\'/%3E%3Ccircle cx=\'55\' cy=\'85\' r=\'3.5\' fill=\'%235E4A3F\'/%3E%3C/g%3E%3C/svg%3E\'); background-size: 120px 120px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- Left Panel: Text & Visuals -->
            <div class="gsap-slide-left lg:col-span-5 space-y-8 pt-6">
                <div>
                    <span class="text-brand font-semibold tracking-[0.25em] uppercase text-xs block mb-4">Ehl-i Keyf Kaş</span>
                    <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-light text-brand-dark tracking-wide leading-tight">
                        {{ __('Table Booking') }}
                    </h1>
                    <div class="w-20 h-0.5 bg-brand mt-6"></div>
                </div>

                <p class="text-gray-600 font-light text-lg leading-relaxed">
                    {{ __('Enjoy an unforgettable Mediterranean tavern evening filled with warm lights, a rich meze buffet, and nostalgic background music under our olive trees. Reserve your spot for a premium culinary journey.') }}
                </p>

                <div class="space-y-6 pt-4 border-t border-brand-olive/10">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-brand-dark text-sm tracking-wide uppercase">{{ __('Operating Hours') }}</h4>
                            <p class="text-gray-500 font-light text-sm mt-1">{{ __('Everyday') }}: 11:00 - 02:00</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-brand-dark text-sm tracking-wide uppercase">{{ __('Direct Line') }}</h4>
                            <p class="text-gray-500 font-light text-sm mt-1">
                                <a href="tel:{{ str_replace(' ', '', App\Models\Setting::getValue('phone', '905367292218')) }}" class="hover:text-brand-accent transition-colors font-medium">
                                    {{ App\Models\Setting::getValue('phone', '+90 536 729 22 18') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-brand-dark/5 rounded-2xl border border-brand-olive/10">
                    <h4 class="font-medium text-brand-dark text-sm uppercase tracking-wider mb-2">{{ __('Reservation Policy') }}</h4>
                    <p class="text-xs text-gray-500 leading-relaxed font-light">
                        {{ __('Reservations are kept for up to 15 minutes past the scheduled time. For groups larger than 30 guests, please contact us directly via telephone. We look forward to hosting you!') }}
                    </p>
                </div>
            </div>

            <!-- Right Panel: Reservation Info -->
            <div class="gsap-slide-right lg:col-span-7">
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 md:p-10 shadow-xl border border-brand-olive/10 relative overflow-hidden">
                    <div class="w-16 h-16 rounded-full bg-brand-olive/10 flex items-center justify-center text-brand-olive mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h2 class="font-serif text-2xl md:text-3xl font-light text-brand-dark mb-4 tracking-wide">{{ __('How to Make a Reservation') }}</h2>
                    <p class="text-gray-600 font-light text-lg leading-relaxed mb-8">
                        {{ __('Hello! We take reservations on the same day you would like to visit. Simply reach us between 10:00 and 17:00 on the day of your visit, and we will prepare your table for you.') }}
                    </p>
                    <a href="tel:{{ str_replace(' ', '', App\Models\Setting::getValue('phone', '905367292218')) }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-brand text-white rounded-xl font-bold uppercase tracking-[0.2em] text-xs hover:bg-brand-dark hover:shadow-lg transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ __('Call Now') }}
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
