<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ManageTranslations extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Çeviriler';
    protected static ?string $title = 'Çeviri Yönetimi';
    protected static ?string $navigationGroup = 'Site Ayarları';

    protected static string $view = 'filament.pages.manage-translations';

    public string $search = '';
    public int $currentPage = 1;
    public int $perPage = 15;

    // Target language to edit (defaults to English 'en')
    public string $targetLocale = 'en';

    // Holds the inputs for the current page
    public array $translationsData = [];

    // Active locales in system
    public array $locales = [];

    public function mount(): void
    {
        $this->locales = config('laravellocalization.supportedLocales') ?? ['en' => [], 'tr' => []];
        $this->loadTranslationsData();
    }

    /**
     * Get all unique translation keys and values from JSON files.
     */
    public function getTranslationData(): array
    {
        $localesList = array_keys($this->locales);
        $translationsByLocale = [];
        $allKeys = [];

        foreach ($localesList as $locale) {
            $path = lang_path("{$locale}.json");
            $data = File::exists($path) ? json_decode(File::get($path), true) : [];
            $translationsByLocale[$locale] = is_array($data) ? $data : [];
            $allKeys = array_merge($allKeys, array_keys($translationsByLocale[$locale]));
        }

        $allKeys = array_unique($allKeys);
        sort($allKeys);

        $rows = [];
        foreach ($allKeys as $key) {
            // Apply search filter
            if (!empty($this->search)) {
                $match = Str::contains(strtolower($key), strtolower($this->search));
                
                // Also search in TR and target locale values
                if (!$match && isset($translationsByLocale['tr'][$key])) {
                    if (Str::contains(strtolower($translationsByLocale['tr'][$key]), strtolower($this->search))) {
                        $match = true;
                    }
                }
                if (!$match && isset($translationsByLocale[$this->targetLocale][$key])) {
                    if (Str::contains(strtolower($translationsByLocale[$this->targetLocale][$key]), strtolower($this->search))) {
                        $match = true;
                    }
                }

                if (!$match) {
                    continue;
                }
            }

            $rows[] = [
                'key' => $key,
                'tr' => $translationsByLocale['tr'][$key] ?? '',
                'target' => $translationsByLocale[$this->targetLocale][$key] ?? '',
            ];
        }

        return $rows;
    }

    /**
     * Paginate translation rows.
     */
    public function getPaginatedTranslationsProperty(): array
    {
        $allData = $this->getTranslationData();
        $totalItems = count($allData);
        $totalPages = max(1, ceil($totalItems / $this->perPage));

        // Adjust current page if out of bounds
        if ($this->currentPage > $totalPages) {
            $this->currentPage = $totalPages;
        }
        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }

        $sliced = array_slice($allData, ($this->currentPage - 1) * $this->perPage, $this->perPage);

        return [
            'items' => $sliced,
            'total' => $totalItems,
            'total_pages' => $totalPages,
        ];
    }

    /**
     * Load current page's translations into memory.
     */
    public function loadTranslationsData(): void
    {
        $paginated = $this->getPaginatedTranslationsProperty();
        $this->translationsData = [];
        foreach ($paginated['items'] as $item) {
            $this->translationsData[$item['key']] = $item['target'];
        }
    }

    /**
     * Save translations of the current page.
     */
    public function saveTranslations(): void
    {
        $path = lang_path("{$this->targetLocale}.json");
        $data = File::exists($path) ? json_decode(File::get($path), true) : [];
        if (!is_array($data)) {
            $data = [];
        }

        foreach ($this->translationsData as $key => $value) {
            $data[$key] = $value;
        }

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Save changes and update search query.
     */
    public function updatedSearch(): void
    {
        $this->saveTranslations();
        $this->currentPage = 1;
        $this->loadTranslationsData();
    }

    /**
     * Save changes and change active locale.
     */
    public function updatedTargetLocale(): void
    {
        $this->saveTranslations();
        $this->currentPage = 1;
        $this->loadTranslationsData();
    }

    /**
     * Navigation commands (with auto-save).
     */
    public function nextPage(): void
    {
        $paginated = $this->getPaginatedTranslationsProperty();
        if ($this->currentPage < $paginated['total_pages']) {
            $this->saveTranslations();
            $this->currentPage++;
            $this->loadTranslationsData();
        }
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->saveTranslations();
            $this->currentPage--;
            $this->loadTranslationsData();
        }
    }

    public function goToPage(int $page): void
    {
        $this->saveTranslations();
        $this->currentPage = $page;
        $this->loadTranslationsData();
    }

    /**
     * Save button clicked.
     */
    public function saveAll(): void
    {
        $this->saveTranslations();
        $this->loadTranslationsData();

        Notification::make()
            ->title('Değişiklikler başarıyla kaydedildi')
            ->success()
            ->send();
    }
}
