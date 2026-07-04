<div class="space-y-6">
    <!-- Inline styles for premium Sortable drag-and-drop feedback -->
    <style>
        /* Sortable.js States */
        .sortable-ghost {
            background-color: rgba(217, 176, 74, 0.12) !important;
            border: 2px dashed #D9B04A !important;
            opacity: 0.6 !important;
        }
        .sortable-chosen {
            transform: scale(1.015) rotate(0.5deg);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04) !important;
        }
        .sortable-drag {
            opacity: 1 !important;
            transform: scale(1.025) rotate(1.5deg) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.05) !important;
            cursor: grabbing !important;
            border-color: #D9B04A !important;
        }
    </style>

    <!-- Header with Locale Switcher, Search and Main Categories -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 dark:border-gray-700 pb-4 gap-4 flex-shrink-0">
        <div class="flex flex-wrap items-center gap-4">
            <!-- Draggable Main Categories Tabs -->
            <div 
                class="flex items-center space-x-2 border border-gray-200 dark:border-gray-700/80 p-1 bg-gray-50 dark:bg-gray-900 rounded-xl"
                x-data="{
                    init() {
                        new Sortable(this.$el, {
                            animation: 150,
                            handle: '.main-category-handle',
                            ghostClass: 'sortable-ghost',
                            chosenClass: 'sortable-chosen',
                            dragClass: 'sortable-drag',
                            onEnd: (evt) => {
                                let categories = Array.from(this.$el.children)
                                    .filter(el => el.dataset.id)
                                    .map((el, index) => {
                                        return { value: el.dataset.id, order: index + 1 };
                                    });
                                $wire.updateMainCategoryOrder(categories);
                            }
                        });
                    }
                }"
            >
                @foreach($mainCategories as $mainCat)
                    <div 
                        data-id="{{ $mainCat->id }}"
                        @class([
                            'px-4 py-2 text-sm font-medium transition-all rounded-lg flex items-center gap-2',
                            'bg-white dark:bg-gray-800 text-amber-600 dark:text-amber-400 shadow-sm border border-gray-150 dark:border-gray-700' => $selectedMainCategoryId == $mainCat->id,
                            'text-gray-500 dark:text-gray-400 hover:text-gray-750 dark:hover:text-gray-200 border border-transparent' => $selectedMainCategoryId != $mainCat->id,
                        ])
                    >
                        <!-- Drag Handle -->
                        <span class="main-category-handle cursor-grab active:cursor-grabbing text-gray-300 dark:text-gray-650 hover:text-amber-500 p-0.5 transition-colors">
                            <x-heroicon-m-bars-2 class="w-3.5 h-3.5" />
                        </span>
                        
                        <!-- Toggle Button -->
                        <button 
                            wire:click="selectMainCategory({{ $mainCat->id }})"
                            class="text-left font-bold focus:outline-none flex items-center gap-1.5"
                        >
                            {{ $mainCat->getTranslation('name', $activeLocale) }}
                            @if(!$mainCat->is_active)
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-455" title="Pasif"></span>
                            @endif
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Main Category Management Actions -->
            <div class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-800/80 p-1 rounded-xl border border-gray-200/50 dark:border-gray-700/50">
                <button 
                    x-on:click="$wire.mountAction('createMainCategory')" 
                    class="p-2 text-gray-500 hover:text-amber-600 dark:text-gray-400 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition shadow-sm border border-transparent hover:border-gray-200/20"
                    title="Yeni Üst Kategori Ekle"
                >
                    <x-heroicon-o-plus class="w-4 h-4" />
                </button>
                @if($selectedMainCategoryId)
                    <button 
                        x-on:click="$wire.mountAction('editMainCategory')" 
                        class="p-2 text-gray-500 hover:text-amber-600 dark:text-gray-400 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition shadow-sm border border-transparent hover:border-gray-200/20"
                        title="Seçili Üst Kategoriyi Düzenle"
                    >
                        <x-heroicon-o-pencil-square class="w-4 h-4" />
                    </button>
                    <button 
                        x-on:click="$wire.mountAction('deleteMainCategory')" 
                        class="p-2 text-gray-500 hover:text-danger-600 dark:text-gray-400 dark:hover:text-danger-400 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition shadow-sm border border-transparent hover:border-gray-200/20"
                        title="Seçili Üst Kategoriyi Sil"
                    >
                        <x-heroicon-o-trash class="w-4 h-4" />
                    </button>
                @endif
            </div>
        </div>

        <!-- Right Controls: Live Search and Locale Switcher -->
        <div class="flex items-center gap-4">
             <!-- Live Search Bar -->
             <div class="w-64">
                 <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                     <x-filament::input 
                         type="text" 
                         wire:model.live.debounce.300ms="search" 
                         placeholder="Ürün veya açıklama ara..." 
                     />
                 </x-filament::input.wrapper>
             </div>

             <!-- Locale Switcher -->
             <div class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700">
                 <button wire:click="$set('activeLocale', 'tr')" @class(['px-3 py-1.5 text-xs font-bold rounded-lg transition-all', 'bg-white dark:bg-gray-700 text-amber-600 dark:text-white shadow-sm border border-gray-150 dark:border-gray-600' => $activeLocale == 'tr', 'text-gray-500 dark:text-gray-400 hover:text-gray-750' => $activeLocale != 'tr'])>TR</button>
                 <button wire:click="$set('activeLocale', 'en')" @class(['px-3 py-1.5 text-xs font-bold rounded-lg transition-all', 'bg-white dark:bg-gray-700 text-amber-600 dark:text-white shadow-sm border border-gray-150 dark:border-gray-600' => $activeLocale == 'en', 'text-gray-500 dark:text-gray-400 hover:text-gray-750' => $activeLocale != 'en'])>EN</button>
             </div>
        </div>
    </div>

    <!-- Responsive Grid Dashboard (No Horizontal Scrolling, Clean Vertical Flow) -->
    <div 
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        x-data="{
            init() {
                new Sortable(this.$el, {
                    animation: 150,
                    handle: '.category-handle',
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: (evt) => {
                        let categories = Array.from(this.$el.children)
                            .filter(el => el.dataset.id)
                            .map((el, index) => {
                                return { value: el.dataset.id, order: index + 1 };
                            });
                        $wire.updateCategoryOrder(categories);
                    }
                });
            }
        }"
    >
        <!-- Direct Items Card (General Items) -->
        @if($directItems->count() > 0 || $categories->count() == 0)
            <div 
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm flex flex-col h-fit transition-shadow duration-200 hover:shadow-md"
                x-data="{ open: true }"
            >
                <!-- Card Header with Accordion Toggle -->
                <div 
                    @class([
                        'p-4 flex items-center justify-between border-b border-gray-205 dark:border-gray-800 bg-gray-100/80 dark:bg-gray-900/80 rounded-t-2xl border-l-4 border-amber-500 cursor-pointer select-none'
                    ])
                    x-on:click="open = !open"
                >
                    <div class="flex items-center space-x-2">
                        <h3 class="font-extrabold text-gray-705 dark:text-gray-305 tracking-tight">
                            Genel Ürünler
                        </h3>
                        <span class="text-xs font-bold px-1.5 py-0.5 bg-gray-200 dark:bg-gray-800 rounded-full text-gray-600 dark:text-gray-400">
                            {{ $directItems->count() }}
                        </span>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <x-heroicon-o-chevron-down class="w-4 h-4 transform transition-transform duration-200" ::class="{ 'rotate-180': !open }" />
                    </button>
                </div>

                <!-- Collapsible List Body -->
                <div x-show="open" x-transition>
                    <div 
                        data-category-id="{{ $selectedMainCategoryId }}"
                        class="items-container p-3 space-y-3 min-h-[60px]"
                        x-data="{
                            init() {
                                new Sortable(this.$el, {
                                    group: 'menu-items',
                                    animation: 150,
                                    handle: '.item-handle',
                                    ghostClass: 'sortable-ghost',
                                    chosenClass: 'sortable-chosen',
                                    dragClass: 'sortable-drag',
                                    onEnd: (evt) => {
                                        let items = [];
                                        document.querySelectorAll('.items-container').forEach(container => {
                                            let cid = container.dataset.categoryId;
                                            Array.from(container.children)
                                                .filter(el => el.dataset.id)
                                                .forEach((el, index) => {
                                                    items.push({ value: el.dataset.id, order: index + 1, category_id: cid });
                                                });
                                        });
                                        $wire.updateItemOrder(items);
                                    }
                                });
                            }
                        }"
                    >
                        @forelse($directItems as $item)
                            <div 
                                wire:key="direct-item-{{ $item->id }}"
                                data-id="{{ $item->id }}"
                                @class([
                                    'p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border transition-all duration-200 cursor-pointer group relative flex flex-col justify-between min-h-[140px]',
                                    'border-gray-200 dark:border-gray-700 hover:border-amber-500/50 dark:hover:border-amber-500/50 hover:shadow-md hover:-translate-y-0.5' => $item->is_active,
                                    'border-gray-200/50 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-850/50 opacity-60 saturate-50 hover:opacity-90 hover:saturate-100 hover:shadow-sm' => !$item->is_active,
                                ])
                                x-on:click="$wire.mountAction('editItem', { id: {{ $item->id }} })"
                            >
                                <!-- Floating Hover Controls -->
                                <div class="absolute top-2 right-2 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity bg-white/95 dark:bg-gray-800/95 p-1 rounded-lg shadow-md border border-gray-100 dark:border-gray-700" x-on:click.stop>
                                    <button x-on:click="$wire.mountAction('editItem', { id: {{ $item->id }} })" class="p-1 text-gray-500 hover:text-amber-500 transition" title="Düzenle">
                                        <x-heroicon-o-pencil-square class="w-3.5 h-3.5" />
                                    </button>
                                    <button x-on:click="$wire.mountAction('deleteItem', { id: {{ $item->id }} })" class="p-1 text-gray-500 hover:text-danger-500 transition" title="Sil">
                                        <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                    </button>
                                </div>

                                <div>
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-1 mb-2 pr-12">
                                        @if(!$item->is_active)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-205 dark:bg-gray-700 text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pasif</span>
                                        @endif
                                        @if($item->is_featured)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-400 uppercase tracking-wider flex items-center gap-0.5">
                                                ★ Öne Çıkan
                                            </span>
                                        @endif
                                        @if($item->is_vegan)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-450 uppercase tracking-wider flex items-center gap-0.5" title="Vegan">
                                                🌱 Vegan
                                            </span>
                                        @endif
                                        @if($item->is_vegetarian)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-teal-100 dark:bg-teal-950/40 text-teal-800 dark:text-teal-400 uppercase tracking-wider flex items-center gap-0.5" title="Vejetaryen">
                                                🥦 Vejetaryen
                                            </span>
                                        @endif
                                        @if($item->contains_alcohol)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-rose-100 dark:bg-rose-950/40 text-rose-800 dark:text-rose-455 uppercase tracking-wider flex items-center gap-0.5" title="Alkol İçerir">
                                                🍷 Alkol İçerir
                                            </span>
                                        @endif
                                        @if($item->calories)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-sky-100 dark:bg-sky-950/40 text-sky-800 dark:text-sky-400 uppercase tracking-wider flex items-center gap-0.5" title="Kalori">
                                                🔥 {{ $item->calories }} kcal
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-start mb-1 pr-12">
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-amber-500 transition-colors">
                                            {{ $item->getTranslation('name', $activeLocale) }}
                                        </h4>
                                        <span class="text-xs font-extrabold text-amber-600 dark:text-amber-400 shrink-0 ml-2 bg-amber-500/10 dark:bg-amber-500/20 px-2 py-0.5 rounded-full">
                                            {{ $item->price }} ₺
                                        </span>
                                    </div>
                                    
                                    <p class="text-[9px] font-mono text-gray-400 mb-2 truncate">/{{ $item->getTranslation('slug', $activeLocale) }}</p>

                                    @if($item->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-405 line-clamp-2 italic mb-2 font-serif">
                                            "{{ $item->getTranslation('description', $activeLocale) }}"
                                        </p>
                                    @endif

                                    @if($item->image)
                                        <div class="mt-2 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-150 dark:border-gray-700 relative" style="height: 120px;">
                                            <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                    <div class="flex items-center space-x-1.5 text-gray-405">
                                        <span class="text-[10px]" title="Beğeni Sayısı">❤️ {{ $item->likes_count ?? 0 }}</span>
                                        @if($item->allergen_info)
                                            <span class="text-[10px] bg-red-500/10 text-red-655 dark:text-red-400 border border-red-500/20 px-1.5 py-0.5 rounded flex items-center gap-0.5" title="Alerjen: {{ $item->getTranslation('allergen_info', $activeLocale) }}">
                                                ⚠️ Alerjen: {{ $item->getTranslation('allergen_info', $activeLocale) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-[9px] text-gray-450 dark:text-gray-400 font-mono bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded border border-gray-200/50 dark:border-gray-700/50">#{{ $item->id }}</span>
                                        <span title="Sürükle Taşı" class="item-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-amber-500 p-0.5 transition-colors" x-on:click.stop>
                                            <x-heroicon-m-arrows-up-down class="w-4 h-4" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400">Ürün bulunmuyor.</div>
                        @endforelse
                    </div>
                    
                    <div class="p-3 border-t border-gray-200 dark:border-gray-805 bg-gray-100/50 dark:bg-gray-900/50 rounded-b-2xl">
                        <button 
                            x-on:click="$wire.mountAction('createItem', { categoryId: {{ $selectedMainCategoryId }} })"
                            class="w-full py-2 border-2 border-dashed border-gray-305 dark:border-gray-750 rounded-xl text-sm font-semibold text-gray-500 hover:text-amber-600 hover:border-amber-500 transition-colors bg-white dark:bg-gray-800 shadow-sm"
                        >
                            + Ürün Ekle
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Sub Categories Cards in Grid -->
        @foreach($categories as $category)
            <div 
                wire:key="cat-card-{{ $category->id }}"
                data-id="{{ $category->id }}"
                x-data="{ open: true }"
                @class([
                    'bg-white dark:bg-gray-900 border rounded-2xl shadow-sm flex flex-col h-fit transition-shadow duration-200 hover:shadow-md',
                    'border-gray-200 dark:border-gray-800/80' => $category->is_active,
                    'border-gray-250 dark:border-gray-850 opacity-90' => !$category->is_active,
                ])
            >
                <!-- Card Header with Accordion Toggle and Category Drag Handle -->
                <div @class([
                    'p-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-800 rounded-t-2xl border-l-4 cursor-pointer select-none',
                    'bg-amber-500/5 dark:bg-amber-500/10 border-amber-500' => $category->is_active,
                    'bg-rose-500/5 dark:bg-rose-500/10 border-rose-450 opacity-60' => !$category->is_active,
                ])
                    x-on:click="open = !open"
                >
                    <div class="flex items-center space-x-2">
                        <!-- Category Drag Handle -->
                        <span class="category-handle cursor-grab active:cursor-grabbing text-gray-400 hover:text-amber-500 transition-colors p-0.5" x-on:click.stop>
                            <x-heroicon-o-bars-3 class="w-5 h-5" />
                        </span>
                        <h3 class="font-extrabold text-gray-805 dark:text-gray-100 truncate max-w-[150px]" title="{{ $category->getTranslation('name', $activeLocale) }}">
                            {{ $category->getTranslation('name', $activeLocale) }}
                        </h3>
                        @if(!$category->is_active)
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-450" title="Pasif Kategori"></span>
                        @endif
                        <span class="text-xs font-bold px-1.5 py-0.5 bg-gray-150 dark:bg-gray-800 rounded-full text-gray-650 dark:text-gray-400">
                            {{ $category->menuItems->count() }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-1" x-on:click.stop>
                        <button x-on:click="$wire.mountAction('editCategory', { id: {{ $category->id }} })" class="text-gray-400 hover:text-amber-505 p-1 rounded-md transition hover:bg-gray-100 dark:hover:bg-gray-800" title="Kategoriyi Düzenle">
                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                        </button>
                        <button x-on:click="$wire.mountAction('deleteCategory', { id: {{ $category->id }} })" class="text-gray-400 hover:text-danger-550 p-1 rounded-md transition hover:bg-gray-100 dark:hover:bg-gray-800" title="Kategoriyi Sil">
                            <x-heroicon-o-trash class="w-4 h-4" />
                        </button>
                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-205 p-1 rounded-md transition" x-on:click="open = !open">
                            <x-heroicon-o-chevron-down class="w-4 h-4 transform transition-transform duration-200" ::class="{ 'rotate-180': !open }" />
                        </button>
                    </div>
                </div>

                <!-- Collapsible List Body -->
                <div x-show="open" x-transition>
                    <!-- Items List -->
                    <div 
                        data-category-id="{{ $category->id }}"
                        class="items-container p-3 space-y-3 min-h-[60px]"
                        x-data="{
                            init() {
                                new Sortable(this.$el, {
                                    group: 'menu-items',
                                    animation: 150,
                                    handle: '.item-handle',
                                    ghostClass: 'sortable-ghost',
                                    chosenClass: 'sortable-chosen',
                                    dragClass: 'sortable-drag',
                                    onEnd: (evt) => {
                                        let items = [];
                                        document.querySelectorAll('.items-container').forEach(container => {
                                            let cid = container.dataset.categoryId;
                                            Array.from(container.children)
                                                .filter(el => el.dataset.id)
                                                .forEach((el, index) => {
                                                    items.push({ value: el.dataset.id, order: index + 1, category_id: cid });
                                                });
                                        });
                                        $wire.updateItemOrder(items);
                                    }
                                });
                            }
                        }"
                    >
                        @forelse($category->menuItems as $item)
                            <div 
                                wire:key="item-desktop-{{ $item->id }}"
                                data-id="{{ $item->id }}"
                                @class([
                                    'p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border transition-all duration-200 cursor-pointer group relative flex flex-col justify-between min-h-[140px]',
                                    'border-gray-200 dark:border-gray-700 hover:border-amber-500/50 dark:hover:border-amber-500/50 hover:shadow-md hover:-translate-y-0.5' => $item->is_active,
                                    'border-gray-200/50 dark:border-gray-800 bg-gray-55/50 dark:bg-gray-855/50 opacity-60 saturate-50 hover:opacity-90 hover:saturate-100 hover:shadow-sm' => !$item->is_active,
                                ])
                                x-on:click="$wire.mountAction('editItem', { id: {{ $item->id }} })"
                            >
                                <!-- Floating Hover Controls -->
                                <div class="absolute top-2 right-2 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity bg-white/95 dark:bg-gray-800/95 p-1 rounded-lg shadow-md border border-gray-100 dark:border-gray-700" x-on:click.stop>
                                    <button x-on:click="$wire.mountAction('editItem', { id: {{ $item->id }} })" class="p-1 text-gray-500 hover:text-amber-500 transition" title="Düzenle">
                                        <x-heroicon-o-pencil-square class="w-3.5 h-3.5" />
                                    </button>
                                    <button x-on:click="$wire.mountAction('deleteItem', { id: {{ $item->id }} })" class="p-1 text-gray-500 hover:text-danger-550 transition" title="Sil">
                                        <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                    </button>
                                </div>

                                <div>
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-1 mb-2 pr-12">
                                        @if(!$item->is_active)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-gray-200 dark:bg-gray-700 text-gray-655 dark:text-gray-455 uppercase tracking-wider">Pasif</span>
                                        @endif
                                        @if($item->is_featured)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-amber-105 dark:bg-amber-900/40 text-amber-855 dark:text-amber-400 uppercase tracking-wider flex items-center gap-0.5">
                                                ★ Öne Çıkan
                                            </span>
                                        @endif
                                        @if($item->is_vegan)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-450 uppercase tracking-wider flex items-center gap-0.5" title="Vegan">
                                                🌱 Vegan
                                            </span>
                                        @endif
                                        @if($item->is_vegetarian)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-teal-100 dark:bg-teal-950/40 text-teal-800 dark:text-teal-400 uppercase tracking-wider flex items-center gap-0.5" title="Vejetaryen">
                                                🥦 Vejetaryen
                                            </span>
                                        @endif
                                        @if($item->contains_alcohol)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-rose-100 dark:bg-rose-950/40 text-rose-800 dark:text-rose-455 uppercase tracking-wider flex items-center gap-0.5" title="Alkol İçerir">
                                                🍷 Alkol İçerir
                                            </span>
                                        @endif
                                        @if($item->calories)
                                            <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-sky-100 dark:bg-sky-950/40 text-sky-800 dark:text-sky-400 uppercase tracking-wider flex items-center gap-0.5" title="Kalori">
                                                🔥 {{ $item->calories }} kcal
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-start mb-1 pr-12">
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-amber-500 transition-colors">
                                            {{ $item->getTranslation('name', $activeLocale) }}
                                        </h4>
                                        <span class="text-xs font-extrabold text-amber-600 dark:text-amber-400 shrink-0 ml-2 bg-amber-500/10 dark:bg-amber-500/20 px-2 py-0.5 rounded-full">
                                            {{ $item->price }} ₺
                                        </span>
                                    </div>
                                    
                                    <p class="text-[9px] font-mono text-gray-455 mb-2 truncate">/{{ $item->getTranslation('slug', $activeLocale) }}</p>

                                    @if($item->description)
                                        <p class="text-xs text-gray-505 dark:text-gray-400 line-clamp-2 italic mb-2 font-serif">
                                            "{{ $item->getTranslation('description', $activeLocale) }}"
                                        </p>
                                    @endif

                                    @if($item->image)
                                        <div class="mt-2 rounded-lg overflow-hidden bg-gray-105 dark:bg-gray-900 border border-gray-150 dark:border-gray-700 relative" style="height: 120px;">
                                            <img src="{{ Storage::url($item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                    <div class="flex items-center space-x-1.5 text-gray-405">
                                        <span class="text-[10px]" title="Beğeni Sayısı">❤️ {{ $item->likes_count ?? 0 }}</span>
                                        @if($item->allergen_info)
                                            <span class="text-[10px] bg-red-500/10 text-red-655 dark:text-red-400 border border-red-500/20 px-1.5 py-0.5 rounded flex items-center gap-0.5" title="Alerjen: {{ $item->getTranslation('allergen_info', $activeLocale) }}">
                                                ⚠️ Alerjen: {{ $item->getTranslation('allergen_info', $activeLocale) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-1.5">
                                        <span class="text-[9px] text-gray-455 dark:text-gray-400 font-mono bg-gray-100 dark:bg-gray-900 px-1.5 py-0.5 rounded border border-gray-200/50 dark:border-gray-700/50">#{{ $item->id }}</span>
                                        <span title="Sürükle Taşı" class="item-handle cursor-grab active:cursor-grabbing text-gray-300 hover:text-amber-500 p-0.5 transition-colors" x-on:click.stop>
                                            <x-heroicon-m-arrows-up-down class="w-4 h-4" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400">Bu kategoride henüz ürün bulunmuyor.</div>
                        @endforelse
                    </div>

                    <!-- Column Footer / Add Item button -->
                    <div class="p-3 border-t border-gray-200 dark:border-gray-800 bg-gray-105/50 dark:bg-gray-900/50 rounded-b-2xl flex-shrink-0">
                        <button 
                            x-on:click="$wire.mountAction('createItem', { categoryId: {{ $category->id }} })"
                            class="w-full py-2 border-2 border-dashed border-gray-305 dark:border-gray-750 rounded-xl text-sm font-semibold text-gray-500 hover:text-amber-600 hover:border-amber-555 transition-colors bg-white dark:bg-gray-800 shadow-sm"
                        >
                            + Ürün Ekle
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Quick Add Category Box (Appears as a grid card) -->
        <button 
            x-on:click="$wire.mountAction('createCategory')"
            class="w-full min-h-[120px] border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl flex flex-col items-center justify-center text-gray-500 hover:text-amber-500 hover:border-amber-500/80 transition-all bg-gray-50/20 hover:bg-gray-50/50 dark:hover:bg-gray-900/10 shadow-sm gap-2"
        >
            <x-heroicon-o-plus class="w-6 h-6 hover:scale-110 transition-transform" />
            <span class="text-sm font-bold">Yeni Kategori Ekle</span>
        </button>
    </div>

    <!-- Modals -->
    <x-filament-actions::modals />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
</div>
