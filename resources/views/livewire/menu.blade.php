<div class="pt-32 pb-24 bg-brand-light min-h-screen relative" x-data="{ isImageModalOpen: false, modalImageSrc: '', modalImageAlt: '' }">
    <style>
    @keyframes heart-pop {
        0% { transform: scale(0.7); opacity: 0.7; }
        45% { transform: scale(1.35); }
        80% { transform: scale(0.95); }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-heart-pop {
        animation: heart-pop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    
    /* Premium Menu Item Card Styles */
    .menu-item-card {
        background: #FFFFFF;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(91, 110, 78, 0.12);
        border-left: 5px solid #D9B04A; /* Brand Gold vertical accent line */
        box-shadow: 0 8px 24px -6px rgba(91, 110, 78, 0.06);
        position: relative;
        display: flex;
        flex-direction: row;
        min-height: 148px;
        width: 100%;
    }
    .menu-item-card:hover {
        box-shadow: 0 16px 36px -8px rgba(91, 110, 78, 0.12);
        transform: translateY(-4px) scale(1.005);
        border-color: rgba(217, 176, 74, 0.4);
        border-left-color: #5b6e4e; /* Change left accent to brand olive on hover */
    }
    
    .menu-item-img-frame {
        width: 110px;
        height: 110px;
        margin: 14px;
        border-radius: 24px 6px 24px 6px; /* Elegant organic leaf shape */
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        background: #F3E6D0;
        border: 1px solid rgba(91, 110, 78, 0.15);
    }
    .menu-item-card:hover .menu-item-img {
        transform: scale(1.08);
    }
    .menu-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .menu-item-content {
        padding: 16px 20px 16px 4px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        min-width: 0;
        justify-content: space-between;
    }
    
    .menu-item-title {
        font-size: 15px;
        font-weight: 700;
        color: #2c2a26;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        line-height: 1.3;
        margin: 0;
        font-family: 'Outfit', system-ui, sans-serif;
    }
    
    .menu-item-price {
        font-size: 18px;
        font-weight: 800;
        color: #D9B04A; /* Premium brand gold */
        font-family: 'Outfit', system-ui, sans-serif;
        display: inline-flex;
        align-items: baseline;
        gap: 1px;
        line-height: 1;
        white-space: nowrap;
    }
    
    .menu-item-price-symbol {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 600;
        margin-left: 1px;
    }
    
    .menu-item-desc {
        font-size: 11.5px;
        color: #606d57; /* Organic warm green-gray tint */
        line-height: 1.5;
        margin-top: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-weight: 350;
        font-family: 'Outfit', system-ui, sans-serif;
    }

    /* Responsive adjustments for mobile */
    @media (max-width: 500px) {
        .menu-item-card {
            flex-direction: column;
            min-height: auto;
            border-left: none;
            border-top: 5px solid #D9B04A; /* Move accent line to top on mobile */
        }
        .menu-item-img-frame {
            width: calc(100% - 28px);
            height: 180px;
            margin: 14px 14px 0 14px;
            border-radius: 20px 20px 4px 4px; /* Flatter bottom on mobile */
        }
        .menu-item-content {
            padding: 16px;
        }
    }
    </style>
    
    <!-- SVG Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none mix-blend-multiply" style="background-image: url('data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%235B6E4E' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.1'%3E%3Cpath d='M60 100 C 60 70 45 40 20 20'/%3E%3Cpath d='M60 100 C 65 70 85 40 110 20'/%3E%3Cellipse cx='35' cy='45' rx='10' ry='5' transform='rotate(-35 35 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='45' cy='75' rx='8' ry='4' transform='rotate(-45 45 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='85' cy='45' rx='10' ry='5' transform='rotate(35 85 45)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Cellipse cx='75' cy='75' rx='8' ry='4' transform='rotate(45 75 75)' fill='%235B6E4E' fill-opacity='0.2'/%3E%3Ccircle cx='60' cy='60' r='4' fill='%235B6E4E'/%3E%3Ccircle cx='55' cy='85' r='3.5' fill='%235B6E4E'/%3E%3C/g%3E%3C/svg%3E'); background-size: 120px 120px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Currency Toggle (Fixed) -->
        <div class="fixed bottom-6 right-6 z-50">
            <div class="inline-flex items-center p-1 bg-white/90 backdrop-blur-md shadow-lg border border-brand-olive/20 rounded-full hover:shadow-xl transition-shadow cursor-pointer">
                <button type="button" wire:click="setCurrency('TRY')" class="px-4 py-2 text-[11px] font-bold tracking-widest uppercase rounded-full transition-all {{ $currency === 'TRY' ? 'bg-brand-olive text-white shadow-md' : 'text-brand-dark hover:text-brand-olive' }}">TRY</button>
                <div class="w-px h-4 bg-brand-olive/20 mx-1"></div>
                <button type="button" wire:click="setCurrency('USD')" class="px-4 py-2 text-[11px] font-bold tracking-widest uppercase rounded-full transition-all {{ $currency === 'USD' ? 'bg-brand-olive text-white shadow-md' : 'text-brand-dark hover:text-brand-olive' }}">USD</button>
            </div>
        </div>

        @if(!$activeCategory)
            <h1 class="gsap-fade-in text-4xl md:text-5xl lg:text-6xl text-center font-light text-brand-dark mb-20 tracking-wide">
                {{ __('Our Menu') }}
            </h1>
        @endif
        
        @if($categories->count() > 0)
            <div class="space-y-12">
                <!-- Heart System Storytelling Area -->
                <div class="mb-16 mt-8 p-8 md:p-12 rounded-2xl bg-[#5c6448]/5 border border-[#5c6448]/10 text-center max-w-4xl mx-auto relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 left-0 w-24 h-24 bg-[#5c6448]/5 rounded-br-full"></div>
                    <div class="absolute bottom-0 right-0 w-24 h-24 bg-[#5c6448]/5 rounded-tl-full"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-6 text-brand-accent">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-light text-brand-dark mb-4 tracking-wide">{{ __('Menu Heart Story Title') }}</h3>
                        <p class="text-lg text-gray-600 font-light leading-relaxed max-w-2xl mx-auto italic">
                            "{{ __('Menu Heart Story Text') }}"
                        </p>
                    </div>
                </div>

                @if(!$activeCategory)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        @foreach($categories as $category)
                            @php
                                $catSlug = $category->getTranslation('slug', app()->getLocale()) ?: $category->getTranslation('slug', 'en');
                            @endphp
                            <a href="{{ route('menu', ['category' => $catSlug]) }}" wire:navigate
                               class="gsap-fade-in group w-full block relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 min-h-[160px] md:min-h-[200px]">
                                @php
                                    // 1. First choice: Use the category's uploaded image
                                    if ($category->image) {
                                        $catImgUrl = str_starts_with($category->image, 'http') ? $category->image : \Illuminate\Support\Facades\Storage::url($category->image);
                                    } else {
                                        // 2. Fallback to Setting if no custom image is uploaded
                                        $catImgUrl = \App\Models\Setting::getValue('menu_snacks_image', asset('storage/gallery/029A0982.webp'));
                                        if(str_contains(strtolower($category->name), 'food') || str_contains(strtolower($category->name), 'main') || str_contains(strtolower($category->name), 'yemek') || str_contains(strtolower($category->name), 'kahvaltı')) {
                                            $catImgUrl = \App\Models\Setting::getValue('menu_restaurant_image', asset('storage/gallery/029A0989.webp'));
                                        }
                                        if(str_contains(strtolower($category->name), 'drink') || str_contains(strtolower($category->name), 'icecek') || str_contains(strtolower($category->name), 'içecek') || str_contains(strtolower($category->name), 'şarap')) {
                                            $catImgUrl = \App\Models\Setting::getValue('menu_drinks_image', asset('storage/gallery/029A5151.webp'));
                                        }
                                    }
                                @endphp
                                <img src="{{ $catImgUrl }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $category->name }}">
                                <div class="absolute inset-0 bg-brand-dark/40 group-hover:bg-brand-dark/20 transition-colors duration-500"></div>
                                <div class="absolute inset-0 flex items-center justify-center p-4">
                                    <h4 class="text-2xl md:text-3xl font-bold text-white tracking-wide drop-shadow-md">{{ $category->name }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Menu Experience Area -->
                    <div class="mt-24 text-center max-w-4xl mx-auto px-4 bg-white/50 backdrop-blur-md rounded-3xl p-12 shadow-sm border border-brand-olive/5">
                        <h3 class="gsap-fade-in text-brand-olive font-semibold tracking-[0.2em] uppercase text-sm mb-6">{{ __('A Culinary Journey') }}</h3>
                        <p class="gsap-fade-in text-2xl md:text-3xl font-light text-brand-dark leading-relaxed italic opacity-90 mb-10">
                            "{{ __('Every plate at Ehl-i Keyf tells a story. From the freshest catches of the Mediterranean to our hand-crafted mezze, we invite you to savor the harmony of tradition and modern gastronomy.') }}"
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center border-t border-brand-olive/10 pt-10 mt-10">
                            <div>
                                <h4 class="text-brand-dark font-bold tracking-widest uppercase text-xs mb-3">{{ __('Daily Fresh Catch') }}</h4>
                                <div class="w-8 h-px bg-brand-olive/30 mx-auto mb-3"></div>
                                <p class="text-gray-500 font-light text-sm">{{ __('Local fishermen to your table') }}</p>
                            </div>
                            <div>
                                <h4 class="text-brand-dark font-bold tracking-widest uppercase text-xs mb-3">{{ __('Signature Mezze') }}</h4>
                                <div class="w-8 h-px bg-brand-accent/50 mx-auto mb-3"></div>
                                <p class="text-gray-500 font-light text-sm">{{ __('Classic flavors, modern touch') }}</p>
                            </div>
                            <div>
                                <h4 class="text-brand-dark font-bold tracking-widest uppercase text-xs mb-3">{{ __('Curated Pairings') }}</h4>
                                <div class="w-8 h-px bg-brand-olive/30 mx-auto mb-3"></div>
                                <p class="text-gray-500 font-light text-sm">{{ __('Fine wines & crafted cocktails') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $activeCatData = $categories->firstWhere('id', $activeCategory);
                        $activeCatSlug = $activeCatData ? ($activeCatData->getTranslation('slug', app()->getLocale()) ?: $activeCatData->getTranslation('slug', 'en')) : '';
                    @endphp
                    
                    <div class="flex justify-center mb-8">
                        <a href="{{ route('menu') }}" wire:navigate
                           class="group inline-flex items-center px-6 py-2.5 rounded-full border border-brand-olive/20 bg-white/50 backdrop-blur-sm text-xs font-medium text-brand-olive hover:bg-brand-olive hover:text-white transition-all duration-500 uppercase tracking-[0.2em]">
                            <svg class="w-4 h-4 mr-2.5 transform group-hover:-translate-x-1 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            {{ __('Back to Menu List') }}
                        </a>
                    </div>

                    <div class="gsap-fade-in mb-24">
                        <div class="text-center mb-20">
                            <h2 class="text-3xl md:text-5xl font-light text-brand-dark tracking-[0.15em] uppercase inline-block relative px-8">
                                {{ $activeCatData->name }}
                                <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-[1px] bg-brand-olive/30"></div>
                            </h2>
                            @if($activeCatData->description)
                                <p class="mt-10 text-gray-500 font-light max-w-2xl mx-auto leading-relaxed text-lg italic opacity-80">{{ $activeCatData->description }}</p>
                            @endif
                        </div>
                        
                        <!-- Subcategory Navigation -->
                        @if($activeCatData->children->count() > 0)
                            <!-- Mobile: Text-only sticky pill bar -->
                            <div class="md:hidden sticky z-[60] bg-brand-light/95 backdrop-blur-md border-b border-brand-olive/10" 
                                 style="top: 89px; margin-left: -1rem; margin-right: -1rem; padding: 0.5rem 1rem 0.75rem 1rem;" 
                                 id="subcatNavMobile">
                                <div class="flex gap-2 overflow-x-auto scrollbar-hide snap-x snap-mandatory" style="-webkit-overflow-scrolling: touch;">
                                    @foreach($activeCatData->children as $subcat)
                                        @php
                                            $subcatSlug = $subcat->getTranslation('slug', app()->getLocale()) ?: $subcat->getTranslation('slug', 'en') ?: Str::slug($subcat->name);
                                        @endphp
                                        <button onclick="smoothScrollTo('subcat-{{ $subcatSlug }}')"
                                                data-subcat="{{ $subcatSlug }}"
                                                class="subcat-pill snap-start flex-shrink-0 px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider whitespace-nowrap transition-all duration-300 border border-brand-olive/15 text-brand-olive/70 hover:bg-brand-olive hover:text-white hover:border-brand-olive">
                                            {{ $subcat->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Desktop: Image grid, standard positioning -->
                            <div class="hidden md:block bg-brand-light/95 backdrop-blur-md rounded-2xl mb-16" 
                                 style="padding: 1rem; margin-left: -1rem; margin-right: -1rem;" 
                                 id="subcatNavDesktop">
                                <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                                    @foreach($activeCatData->children as $subcat)
                                        @php
                                            $subcatSlug = $subcat->getTranslation('slug', app()->getLocale()) ?: $subcat->getTranslation('slug', 'en') ?: Str::slug($subcat->name);
                                        @endphp
                                        <a href="#subcat-{{ $subcatSlug }}"
                                           data-subcat="{{ $subcatSlug }}"
                                           onclick="event.preventDefault(); smoothScrollTo('subcat-{{ $subcatSlug }}')"
                                           class="subcat-pill group block relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 aspect-[4/3]">
                                            @php
                                                $bgImg = $subcat->image ? Storage::url($subcat->image) : '/logo.png';
                                                $isLogo = !$subcat->image;
                                            @endphp
                                            <img src="{{ $bgImg }}" class="absolute inset-0 w-full h-full group-hover:scale-110 transition-transform duration-1000 {{ $isLogo ? 'object-contain p-6 opacity-40 grayscale filter' : 'object-cover blur-[0.5px] group-hover:blur-0' }}" alt="{{ $subcat->name }}">
                                            <div class="absolute inset-0 bg-brand-dark/40 group-hover:bg-brand-dark/20 transition-colors duration-500"></div>
                                            <div class="absolute inset-0 flex items-center justify-center p-3">
                                                <h4 class="text-sm lg:text-base font-bold text-white tracking-[0.15em] uppercase text-center drop-shadow-lg">{{ $subcat->name }}</h4>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @php
                            $renderItemCard = function($item) {
                                $hasDescription = !empty(strip_tags((string)$item->description));
                                $imageUrl = $item->image ? Storage::url($item->image) : null;
                                
                                $name = e($item->name);
                                $formattedPriceHtml = $this->formatPrice($item->price);
                                $description = $hasDescription ? e($item->description) : '';
                                
                                // Image & Modal Trigger
                                $imageHtml = $imageUrl 
                                    ? "<img src=\"{$imageUrl}\" alt=\"{$name}\" loading=\"lazy\" class=\"menu-item-img\" @click=\"isImageModalOpen = true; modalImageSrc = '{$imageUrl}'; modalImageAlt = '{$name}'\">"
                                    : '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, #F3E6D0 0%, #ebe5d6 100%);padding:1rem;">
                                          <img src="/logo.png" alt="Ehl-i Keyf" style="width:100%;height:100%;object-fit:contain;opacity:0.25;filter:grayscale(100%);">
                                       </div>';

                                // Description
                                $descHtml = $hasDescription 
                                    ? "<p class=\"menu-item-desc\">{$description}</p>"
                                    : '';

                                // Vegan badge
                                $veganBadge = $item->is_vegan 
                                    ? '<span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;background:#eefdf6;font-size:9px;color:#0f766e;font-weight:600;letter-spacing:0.04em;gap:4px;border:1px solid #ccfbf1;" title="Vegan">🌱 Vegan</span>'
                                    : '';

                                // Vegetarian badge
                                $vegetarianBadge = $item->is_vegetarian 
                                    ? '<span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;background:#f0fdf4;font-size:9px;color:#166534;font-weight:600;letter-spacing:0.04em;gap:4px;border:1px solid #dcfce7;" title="Vejetaryen">🥦 Vejetaryen</span>'
                                    : '';

                                // Alcohol badge
                                $alcoholBadge = $item->contains_alcohol 
                                    ? '<span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;background:#fff5f5;font-size:9px;color:#991b1b;font-weight:600;letter-spacing:0.04em;gap:4px;border:1px solid #fee2e2;" title="Alkol İçerir">🍷 Alkol İçerir</span>'
                                    : '';

                                // Calories badge
                                $caloriesBadge = $item->calories 
                                    ? '<span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;background:#fffaf0;font-size:9px;color:#c2410c;font-weight:600;letter-spacing:0.04em;gap:4px;border:1px solid #ffedd5;" title="Kalori">🔥 ' . $item->calories . ' kcal</span>'
                                    : '';

                                // Allergen
                                $allergenRaw = '';
                                if (!empty($item->allergen_info)) {
                                    if (is_array($item->allergen_info)) {
                                        $allergenRaw = $item->allergen_info[app()->getLocale()] ?? collect($item->allergen_info)->first() ?? '';
                                    } else {
                                        $allergenRaw = (string)$item->allergen_info;
                                    }
                                    $allergenRaw = strip_tags(trim($allergenRaw));
                                }
                                
                                $allergenBadge = $allergenRaw
                                    ? '<span style="display:inline-flex;align-items:center;padding:2px 8px;border-radius:6px;background:#fffbeb;font-size:9px;color:#92400e;font-weight:600;letter-spacing:0.04em;gap:4px;border:1px solid #fef3c7;max-width:180px;" title="Alerjen: ' . e($allergenRaw) . '">
                                        <svg style="width:10px;height:10px;flex-shrink:0;color:#d97706;" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . e($allergenRaw) . '</span>
                                       </span>'
                                    : '';

                                // Badges row
                                $badges = trim("{$veganBadge}{$vegetarianBadge}{$alcoholBadge}{$caloriesBadge}{$allergenBadge}");
                                $badgesRow = $badges 
                                    ? "<div style=\"display:flex;flex-wrap:wrap;align-items:center;gap:6px;margin-top:auto;padding-top:8px;\">{$badges}</div>"
                                    : '';

                                // Heart / Like Icon logic via Alpine.js & LocalStorage
                                $heartButton = "
                                <button 
                                    x-data=\"{ 
                                        liked: JSON.parse(localStorage.getItem('liked_items') || '[]').includes({$item->id}), 
                                        likesCount: {$item->likes_count}, 
                                        pop: false,
                                        toggleLike() {
                                            let items = JSON.parse(localStorage.getItem('liked_items') || '[]');
                                            const action = this.liked ? 'unlike' : 'like';
                                            
                                            if (this.liked) {
                                                items = items.filter(i => i !== {$item->id});
                                                this.likesCount = Math.max(0, this.likesCount - 1);
                                            } else {
                                                items.push({$item->id});
                                                this.likesCount++;
                                                this.pop = true;
                                                setTimeout(() => this.pop = false, 300);
                                            }
                                            this.liked = !this.liked;
                                            localStorage.setItem('liked_items', JSON.stringify(items));
                                            
                                            fetch('/api/menu/like/{$item->id}', {
                                                method: 'POST',
                                                headers: { 'Content-Type': 'application/json' },
                                                body: JSON.stringify({ action: action })
                                            }).then(res => res.json()).then(data => {
                                                if(data.success) { this.likesCount = data.likes_count; }
                                            });
                                        }
                                    }\" 
                                    @click.prevent=\"toggleLike()\" 
                                    :class=\"pop ? 'scale-125' : 'scale-100'\" 
                                    class=\"absolute top-2 right-2 px-2 py-2 rounded-full bg-white/70 hover:bg-white/90 backdrop-blur-md transition-colors duration-300 z-10 flex items-center justify-center border border-brand-olive/10 shadow-sm\"
                                >
                                    <svg x-show=\"!liked\" class=\"w-3.5 h-3.5 text-[#5b6e4e] transition-transform hover:scale-110\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\"></path></svg>
                                    <svg x-show=\"liked\" x-cloak class=\"w-3.5 h-3.5 text-brand-accent fill-current animate-heart-pop\" viewBox=\"0 0 24 24\"><path d=\"M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z\"/></svg>
                                    <span x-show=\"likesCount > 0\" x-text=\"likesCount\" x-cloak class=\"text-[#5b6e4e] text-[10px] font-bold ml-1 mt-px inline-block transition-all\" :class=\"pop ? 'animate-heart-pop' : ''\"></span>
                                </button>";

                                return "
                                <div wire:key=\"menu-item-{$item->id}\" class=\"gsap-fade-in menu-item-card\">
                                    <!-- Floating Image Frame -->
                                    <div class=\"menu-item-img-frame\">
                                        {$imageHtml}
                                        <div wire:ignore>
                                            {$heartButton}
                                        </div>
                                    </div>
                                    <!-- Content Block -->
                                    <div class=\"menu-item-content\">
                                        <div>
                                            <div style=\"display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:4px;\">
                                                <h3 class=\"menu-item-title\">{$name}</h3>
                                                <div wire:key=\"price-{$item->id}-{$this->currency}\" style=\"display:flex;align-items:baseline;gap:2px;flex-shrink:0;\">
                                                    {$formattedPriceHtml}
                                                </div>
                                            </div>
                                            {$descHtml}
                                        </div>
                                        {$badgesRow}
                                    </div>
                                </div>";
                            };
                        @endphp

                        <!-- Direct Menu Items -->
                        @if($activeCatData->menuItems->count() > 0)
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5 mb-16">
                                @foreach($activeCatData->menuItems as $item)
                                    {!! $renderItemCard($item) !!}
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Categorized Menu Items (Subcategories) -->
                        @foreach($activeCatData->children as $subcat)
                            @if($subcat->menuItems->count() > 0)
                                @php
                                    $subcatSlugAnchor = $subcat->getTranslation('slug', app()->getLocale()) ?: $subcat->getTranslation('slug', 'en') ?: Str::slug($subcat->name);
                                @endphp
                                <div id="subcat-{{ $subcatSlugAnchor }}" style="scroll-margin-top: 200px; margin-top: 48px; margin-bottom: 24px;">
                                    <h3 class="text-2xl md:text-3xl font-light text-brand-dark uppercase tracking-[0.25em] flex items-center gap-4">
                                        {{ $subcat->name }}
                                        <span class="flex-grow h-[1px] bg-brand-olive/10"></span>
                                    </h3>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5 mb-16">
                                    @foreach($subcat->menuItems as $item)
                                        {!! $renderItemCard($item) !!}
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="text-center text-gray-500 py-20 font-light italic">
                {{ __('Menu is currently being curated. Please check back later.') }}
            </div>
        @endif
    </div>

    <!-- Fullscreen Image Modal -->
    <div x-show="isImageModalOpen" style="display: none;" class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="absolute inset-0 z-0" @click="isImageModalOpen = false"></div>
        <div class="relative z-10 max-w-4xl w-full max-h-[90vh] flex flex-col items-center">
            <button @click="isImageModalOpen = false" class="absolute -top-12 right-0 p-2 text-white hover:text-brand-accent transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img :src="modalImageSrc" :alt="modalImageAlt" class="w-full h-auto max-h-[80vh] object-contain rounded-xl shadow-2xl">
            <h3 x-text="modalImageAlt" class="text-white text-xl md:text-2xl font-light tracking-widest uppercase mt-6 drop-shadow-lg text-center"></h3>
        </div>
    </div>

    <!-- Smooth scroll + active pill highlighting -->
    <script>
        function smoothScrollTo(id) {
            const el = document.getElementById(id);
            if (el) {
                const offset = 180;
                const y = el.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: y, behavior: 'smooth' });
                history.replaceState(null, '', '#' + id);
                setActivePill(id.replace('subcat-', ''));
            }
        }

        function setActivePill(slug) {
            document.querySelectorAll('.subcat-pill').forEach(function(pill) {
                if (pill.dataset.subcat === slug) {
                    pill.style.background = '#5c6448';
                    pill.style.color = '#fff';
                    pill.style.borderColor = '#5c6448';
                    if (pill.tagName === 'A') {
                        pill.style.boxShadow = '0 0 0 3px rgba(92,100,72,0.3)';
                    }
                } else {
                    pill.style.background = '';
                    pill.style.color = '';
                    pill.style.borderColor = '';
                    pill.style.boxShadow = '';
                }
            });
        }

        function initSubcatObserver() {
            var sections = document.querySelectorAll('[id^="subcat-"]');
            if (!sections.length) return;
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var slug = entry.target.id.replace('subcat-', '');
                        setActivePill(slug);
                    }
                });
            }, { rootMargin: '-200px 0px -50% 0px', threshold: 0 });
            sections.forEach(function(s) { observer.observe(s); });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initSubcatObserver();
            if (window.location.hash) {
                setTimeout(function() { smoothScrollTo(window.location.hash.substring(1)); }, 500);
            }
        });
        document.addEventListener('livewire:navigated', function() {
            setTimeout(function() {
                initSubcatObserver();
                if (window.location.hash) {
                    smoothScrollTo(window.location.hash.substring(1));
                }
            }, 300);
        });
    </script>
</div>
