<div class="pt-32 pb-24 bg-brand-light min-h-screen relative overflow-hidden" 
     x-data="{ 
        modalOpen: false, 
        currentImage: '', 
        openModal(url) {
            this.currentImage = url;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.modalOpen = false;
            document.body.style.overflow = 'auto';
        }
     }">
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235E4A3F' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235E4A3F' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235E4A3F'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235E4A3F'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="gsap-fade-in text-4xl md:text-5xl lg:text-6xl font-light text-brand-dark mb-6 tracking-wide">
            {{ __('Gallery') }}
        </h1>
        <p class="gsap-fade-in text-gray-500 max-w-2xl mx-auto mb-16 font-light">
            {{ __('Step into the Ehl-i Keyf experience. Moments of joy, exquisite dishes, and Golden Hour coastlines.') }}
        </p>
        
        @if($images->count() > 0)
            <div class="columns-2 sm:columns-3 lg:columns-4 xl:columns-5 gap-4 space-y-4" data-gsap-stagger>
                @foreach($images as $img)
                    @php 
                        // Fallback to images/ if the file doesn't start with gallery (legacy) or directly use storage for new uploads
                        $imgUrl = str_starts_with($img->image, 'gallery/') ? asset('storage/' . $img->image) : asset('images/' . $img->image); 
                    @endphp
                    <div class="break-inside-avoid relative group overflow-hidden cursor-pointer rounded-2xl"
                         data-gsap-item
                         @click="openModal('{{ $imgUrl }}')">
                        <img src="{{ $imgUrl }}" alt="{{ $img->alt_text ?? $img->title }}" class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white scale-0 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Placeholder Gallery -->
            <div class="columns-2 sm:columns-3 lg:columns-4 xl:columns-5 gap-4 space-y-4" data-gsap-stagger>
                @php
                    $placeholders = [
                        '029A0916.jpg', '029A0973.jpg', '029A0975.jpg',
                        '029A0982.jpg', '029A0989.jpg', '029A0992.jpg',
                        '029A1007.jpg', '029A1008.jpg', '029A5151.jpg',
                        '029A5160.jpg', '029A5168.jpg', '029A5245.jpg',
                        '029A5379.jpg', '029A5380.jpg', 'DJI_0795-scaled.jpg',
                        'DJI_0801-scaled.jpg', 'DJI_0803-scaled.jpg', 'DJI_0834-Edit-scaled.jpg'
                    ];
                @endphp
                @foreach($placeholders as $ph)
                    @php $phUrl = asset('images/gallery/' . $ph); @endphp
                    <div class="break-inside-avoid relative group overflow-hidden cursor-pointer rounded-2xl"
                         data-gsap-item
                         @click="openModal('{{ $phUrl }}')">
                        <img src="{{ $phUrl }}" alt="Gallery Image" class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-brand-dark/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white scale-0 group-hover:scale-100 transition-transform duration-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Lightbox Modal -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-brand-dark/95 backdrop-blur-xl px-4 py-10"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         @keydown.escape.window="closeModal()">
        
        <!-- Close Button -->
        <button @click="closeModal()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors p-2 z-[110]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Modal Content -->
        <div class="relative max-w-5xl w-full h-full flex items-center justify-center" @click.away="closeModal()">
            <img :src="currentImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl scale-95" 
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="scale-90 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100">
        </div>
    </div>
</div>
