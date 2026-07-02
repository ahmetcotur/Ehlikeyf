<x-filament-panels::page>
    <div class="space-y-6">
        
        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Last Run Card -->
            <div class="p-5 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Son Otomatik Çalışma</span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $this->blog_bot_last_run }}</h3>
                </div>
                <div class="p-3 bg-primary-50 dark:bg-primary-950/30 rounded-xl text-primary-600 dark:text-primary-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Gemini Status -->
            <div class="p-5 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">AI Dil Dağıtımı</span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mt-1">
                        {{ count(config('laravellocalization.supportedLocales') ?? []) }} Aktif Dil Destekleniyor
                    </h3>
                </div>
                <div class="p-3 bg-success-50 dark:bg-success-950/30 rounded-xl text-success-600 dark:text-success-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2a2.5 2.5 0 002.5-2.5V10a2 2 0 00-2-2h-1a2 2 0 00-2-2v-1a2 2 0 00-2-2H9.236M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit="saveSettings">
            {{ $this->form }}

            <!-- Actions Footer -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                
                <!-- Manual Trigger Button -->
                <div>
                    <x-filament::button type="button" 
                                        wire:click="generateNow" 
                                        color="warning" 
                                        icon="heroicon-m-sparkles" 
                                        size="lg">
                        Şimdi Blog Yazısı Üret & Yayınla
                    </x-filament::button>
                </div>

                <!-- Save Settings Button -->
                <div class="flex items-center gap-3">
                    <x-filament::button type="submit" size="lg" color="primary">
                        Ayarları Kaydet
                    </x-filament::button>
                </div>
                
            </div>
        </form>
    </div>
</x-filament-panels::page>
