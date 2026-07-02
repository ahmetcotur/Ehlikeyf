<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Active Languages List -->
        <x-filament::section>
            <x-slot name="heading">
                Aktif Diller
            </x-slot>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($this->activeLocales as $code => $properties)
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col items-center text-center">
                        <span class="text-xs font-bold text-gray-400 uppercase">{{ $code }}</span>
                        <span class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $properties['native'] ?? $properties['name'] }}</span>
                        <span class="text-xs text-gray-500 mt-1">{{ $properties['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </x-filament::section>

        <!-- Add Language Form -->
        <form wire:submit="addLanguage">
            {{ $this->form }}

            <div class="mt-6 flex items-center justify-end gap-3">
                <x-filament::button type="submit" size="lg" color="primary">
                    Yeni Dili Ekle & AI Çeviriyi Başlat
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
