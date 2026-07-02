<x-filament-panels::page>
    <div class="space-y-6">
        
        <!-- Controls Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
            
            <!-- Left Side: Select Target Language -->
            <div class="flex items-center gap-3">
                <label class="text-sm font-semibold text-gray-500 dark:text-gray-400 whitespace-nowrap">Düzenlenecek Hedef Dil:</label>
                <div class="w-56">
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="targetLocale">
                            @foreach($this->locales as $code => $properties)
                                <option value="{{ $code }}">{{ $properties['native'] ?? $properties['name'] }} ({{ strtoupper($code) }})</option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>
            </div>

            <!-- Center/Right Side: Live Search -->
            <div class="flex items-center gap-4 flex-grow md:max-w-md">
                <div class="w-full">
                    <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                        <x-filament::input type="text" 
                                           wire:model.live.debounce.300ms="search" 
                                           placeholder="Anahtar veya çevirilerde ara..." />
                    </x-filament::input.wrapper>
                </div>
            </div>
            
            <!-- Save Button -->
            <div>
                <x-filament::button wire:click="saveAll" size="lg" color="primary">
                    Değişiklikleri Kaydet
                </x-filament::button>
            </div>
        </div>

        <!-- Cards List -->
        <div class="space-y-4">
            @forelse($this->paginatedTranslations['items'] as $item)
                <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-2xl p-6 shadow-sm space-y-4">
                    
                    <!-- Card Header: Key Name -->
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                        <span class="font-mono text-xs text-gray-500 dark:text-gray-400 font-semibold bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-md select-all">
                            {{ $item['key'] }}
                        </span>
                        
                        <span class="text-[10px] uppercase font-bold text-gray-450 dark:text-gray-500 tracking-wider">
                            TR ➔ {{ strtoupper($targetLocale) }}
                        </span>
                    </div>
                    
                    <!-- Card Body: 50/50 Split Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Left Column: Turkish Base Text -->
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">Türkçe (Temel Dil)</span>
                            <div class="p-4 bg-gray-50/50 dark:bg-gray-950/50 border border-gray-100 dark:border-gray-800/80 rounded-xl text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line font-medium min-h-[46px]">
                                {{ $item['tr'] ?: '-' }}
                            </div>
                        </div>
                        
                        <!-- Right Column: Target Translation Input -->
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest block">{{ strtoupper($targetLocale) }} Çevirisi</span>
                            
                            @if(strlen((string)($item['tr'] ?? '')) > 70)
                                <!-- Show textarea for longer values like stories -->
                                <x-filament::input.wrapper>
                                    <textarea wire:model="translationsData.{{ $item['key'] }}" 
                                              rows="4" 
                                              class="block w-full border-0 bg-transparent py-1.5 text-gray-950 dark:text-white focus:ring-0 sm:text-sm sm:leading-6 focus:outline-none focus:ring-transparent border-transparent focus:border-transparent"></textarea>
                                </x-filament::input.wrapper>
                            @else
                                <!-- Show input for shorter titles/buttons -->
                                <x-filament::input.wrapper>
                                    <x-filament::input type="text" 
                                                       wire:model="translationsData.{{ $item['key'] }}" />
                                </x-filament::input.wrapper>
                            @endif
                        </div>
                        
                    </div>
                    
                </div>
            @empty
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-12 text-center text-gray-400 dark:text-gray-500 italic shadow-sm">
                    Aranan kriterlere uygun çeviri kaydı bulunamadı.
                </div>
            @endforelse
        </div>

        <!-- Pagination Footer -->
        @if($this->paginatedTranslations['total_pages'] > 1)
            <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-2xl px-6 py-4 shadow-sm flex items-center justify-between">
                <button wire:click="previousPage" 
                        type="button"
                        @disabled($currentPage === 1)
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:pointer-events-none">
                    Önceki Sayfa
                </button>
                
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    Sayfa <b>{{ $currentPage }}</b> / {{ $this->paginatedTranslations['total_pages'] }}
                </span>

                <button wire:click="nextPage" 
                        type="button"
                        @disabled($currentPage === $this->paginatedTranslations['total_pages'])
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:pointer-events-none">
                    Sonraki Sayfa
                </button>
            </div>
        @endif
        
        <!-- Bottom Save Button -->
        <div class="flex justify-end mt-4">
            <x-filament::button wire:click="saveAll" size="lg" color="primary">
                Değişiklikleri Kaydet
            </x-filament::button>
        </div>

    </div>
</x-filament-panels::page>
