<div x-data="{ open: false }">
    <!-- Trigger text -->
    <div class="mt-8 text-center text-sm">
        <button 
            @click="open = true" 
            class="text-brand-dark/50 hover:text-brand-olive transition-colors underline underline-offset-4 decoration-brand-dark/20 hover:decoration-brand-olive cursor-pointer bg-transparent border-0"
        >
            {{ __('If you had a bad experience, let\'s keep it between us so we can improve.') }}
        </button>
    </div>

    <!-- Modal Background overlay -->
    <div 
        x-show="open" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] bg-brand-dark/60 backdrop-blur-sm flex items-center justify-center p-4"
        @keydown.escape.window="open = false"
    >
        <!-- Modal Content -->
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95"
            @click.away="open = false"
            class="bg-[#F8F9FA] rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-brand-olive/10"
        >
            <!-- Close Button -->
            <button @click="open = false" class="absolute top-6 right-6 text-brand-dark/40 hover:text-brand-olive transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            @if($isSuccess)
                <div class="py-12 text-center text-brand-dark">
                    <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-light mb-4">{{ __('Thank you for your valuable time. We are getting better thanks to you!') }}</h3>
                    <button @click="open = false; $wire.set('isSuccess', false)" class="mt-6 px-8 py-3 bg-brand-olive text-white rounded-full font-bold uppercase tracking-widest text-xs hover:bg-brand-dark transition-colors">
                        {{ __('Close window') }}
                    </button>
                </div>
            @else
                <h3 class="font-serif text-3xl font-light text-brand-dark mb-2">{{ __('Share Your Feedback') }}</h3>
                <p class="text-brand-dark/60 text-sm mb-6">{{ __('If you had a bad experience, let\'s keep it between us so we can improve.') }}</p>

                <form wire:submit="submit" class="space-y-4">
                    <div>
                        <input wire:model="name" type="text" placeholder="{{ __('Name (Optional)') }}" class="w-full bg-white border border-brand-olive/10 rounded-xl px-4 py-3 focus:ring-1 focus:ring-brand-olive focus:border-brand-olive outline-none transition-all placeholder:text-brand-dark/30 text-brand-dark">
                        @error('name') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <input wire:model="contact" type="text" placeholder="{{ __('Email or Phone (Optional)') }}" class="w-full bg-white border border-brand-olive/10 rounded-xl px-4 py-3 focus:ring-1 focus:ring-brand-olive focus:border-brand-olive outline-none transition-all placeholder:text-brand-dark/30 text-brand-dark">
                        @error('contact') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <textarea wire:model="message" rows="4" placeholder="{{ __('Your Message') }} *" class="w-full bg-white border border-brand-olive/10 rounded-xl px-4 py-3 focus:ring-1 focus:ring-brand-olive focus:border-brand-olive outline-none transition-all placeholder:text-brand-dark/30 text-brand-dark resize-none"></textarea>
                        @error('message') <span class="text-red-500 text-xs mt-1 block px-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-brand-olive text-white rounded-xl font-bold uppercase tracking-widest text-sm hover:shadow-lg hover:shadow-brand-olive/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="submit">{{ __('Send Feedback') }}</span>
                        <span wire:loading wire:target="submit">{{ __('Sending...') }}</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
