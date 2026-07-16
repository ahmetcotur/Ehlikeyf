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
                            <p class="text-gray-500 font-light text-sm mt-1">{{ __('Everyday') }}: 14:00 - 00:00</p>
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

            <!-- Right Panel: Form Card -->
            <div class="gsap-slide-right lg:col-span-7">
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 md:p-10 shadow-xl border border-brand-olive/10 relative overflow-hidden">
                    
                    @if($successMessage)
                        <div class="py-12 text-center" x-data x-init="window.scrollTo({top: 0, behavior: 'smooth'})">
                            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="font-serif text-3xl font-light text-brand-dark mb-4 tracking-wide">{{ __('Reservation Submitted') }}</h3>
                            <p class="text-gray-600 font-light leading-relaxed max-w-md mx-auto">
                                {{ __('Thank you! Your booking request has been successfully registered. We will review availability and confirm your booking via call or message shortly.') }}
                            </p>
                            <div class="mt-8 flex justify-center gap-4">
                                <button type="button" wire:click="$set('successMessage', false)" class="px-8 py-3 bg-brand-olive text-white hover:bg-brand-dark font-medium rounded-xl uppercase tracking-wider text-xs transition duration-300">
                                    {{ __('Book Another Table') }}
                                </button>
                                <a href="{{ route('home') }}" class="px-8 py-3 border border-brand-olive/20 text-brand-olive hover:bg-brand-olive/5 font-medium rounded-xl uppercase tracking-wider text-xs transition duration-300">
                                    {{ __('Go to Home') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <h2 class="font-serif text-2xl font-light text-brand-dark mb-6 tracking-wide">{{ __('Table Reservation Details') }}</h2>
                        
                        <form wire:submit="submit" class="space-y-6">
                            <!-- Name & Email Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Name & Surname') }} *</label>
                                    <input wire:model="name" type="text" placeholder="{{ __('e.g. John Doe') }}" class="w-full bg-brand-light/20 border border-brand-olive/20 rounded-xl px-4 py-3.5 focus:ring-1 focus:ring-brand focus:border-brand outline-none transition-all placeholder:text-brand-dark/20 text-brand-dark">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Phone Number') }} *</label>
                                    <input wire:model="phone" type="tel" placeholder="{{ __('e.g. +90 532 123 45 67') }}" class="w-full bg-brand-light/20 border border-brand-olive/20 rounded-xl px-4 py-3.5 focus:ring-1 focus:ring-brand focus:border-brand outline-none transition-all placeholder:text-brand-dark/20 text-brand-dark">
                                    @error('phone') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Email Address') }}</label>
                                    <input wire:model="email" type="email" placeholder="{{ __('e.g. john@example.com') }}" class="w-full bg-brand-light/20 border border-brand-olive/20 rounded-xl px-4 py-3.5 focus:ring-1 focus:ring-brand focus:border-brand outline-none transition-all placeholder:text-brand-dark/20 text-brand-dark">
                                    @error('email') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Date') }} *</label>
                                    <input wire:model.live="booking_date" type="date" class="w-full bg-brand-light/20 border border-brand-olive/20 rounded-xl px-4 py-3.5 focus:ring-1 focus:ring-brand focus:border-brand outline-none transition-all text-brand-dark min-h-[48px] md:min-h-[50px] appearance-none" style="color-scheme: light;">
                                    @error('booking_date') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Seating Area selector -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-3">{{ __('Seating Preference') }} *</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" wire:click="$set('seating_area', 'garden')" class="py-3.5 px-4 rounded-xl border text-center transition-all duration-300 flex flex-col items-center gap-1.5 {{ $seating_area === 'garden' ? 'border-brand bg-brand/10 text-brand-dark font-medium shadow-sm' : 'border-brand-olive/15 hover:border-brand-olive/35 text-gray-500' }}">
                                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        <span class="text-xs uppercase tracking-wider">{{ __('Garden') }}</span>
                                    </button>
                                    <button type="button" wire:click="$set('seating_area', 'terrace')" class="py-3.5 px-4 rounded-xl border text-center transition-all duration-300 flex flex-col items-center gap-1.5 {{ $seating_area === 'terrace' ? 'border-brand bg-brand/10 text-brand-dark font-medium shadow-sm' : 'border-brand-olive/15 hover:border-brand-olive/35 text-gray-500' }}">
                                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        <span class="text-xs uppercase tracking-wider">{{ __('Terrace') ?? 'Teras' }}</span>
                                    </button>
                                </div>
                                @error('seating_area') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Party Size -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Number of Guests') }} *</label>
                                <div class="flex items-center gap-4">
                                    <button type="button" wire:click="decrementPartySize" class="w-12 h-12 rounded-xl border border-brand-olive/20 hover:border-brand flex items-center justify-center text-brand-dark transition-colors duration-200 text-lg select-none cursor-pointer">-</button>
                                    <div class="w-16 text-center font-serif text-2xl font-light text-brand-dark">{{ $party_size }}</div>
                                    <button type="button" wire:click="incrementPartySize" class="w-12 h-12 rounded-xl border border-brand-olive/20 hover:border-brand flex items-center justify-center text-brand-dark transition-colors duration-200 text-lg select-none cursor-pointer">+</button>
                                    <span class="text-xs text-gray-400 font-light ml-2">{{ __('Guests') }}</span>
                                </div>
                                @error('party_size') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Time Slots Selection -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-3">{{ __('Select Seating Time') }} *</label>
                                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                    @foreach($timeSlots as $slot)
                                        <button type="button" wire:click="$set('booking_time', '{{ $slot }}')" class="py-2.5 rounded-lg text-xs font-medium tracking-wider border transition-all duration-300 {{ $booking_time === $slot ? 'bg-brand-olive border-brand-olive text-white font-semibold shadow-sm' : 'border-brand-olive/15 hover:border-brand-olive/35 text-brand-dark/80 bg-brand-light/5' }}">
                                            {{ $slot }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('booking_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Special Notes -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-widest text-brand-olive mb-2">{{ __('Special Notes / Dietary Requirements') }}</label>
                                <textarea wire:model="notes" rows="3" placeholder="{{ __('e.g. Birthday celebration, allergic to seafood, etc.') }}" class="w-full bg-brand-light/20 border border-brand-olive/20 rounded-xl px-4 py-3 focus:ring-1 focus:ring-brand focus:border-brand outline-none transition-all placeholder:text-brand-dark/20 text-brand-dark resize-none"></textarea>
                                @error('notes') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit CTA Button -->
                            <button type="submit" class="w-full py-4.5 bg-brand text-brand-dark rounded-xl font-bold uppercase tracking-[0.2em] text-xs hover:bg-brand-dark hover:text-white hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 select-none cursor-pointer">
                                <span wire:loading.remove wire:target="submit">{{ __('Send Reservation Request') }}</span>
                                <span wire:loading wire:target="submit">{{ __('Processing...') }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
