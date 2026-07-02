<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\BlogPost;
use App\Models\GalleryImage;
use App\Services\AiTranslationService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LanguageManagement extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationLabel = 'Dil Ekle & AI Çeviri';
    protected static ?string $title = 'AI Dil Yönetimi';
    protected static ?string $navigationGroup = 'Site Ayarları';

    protected static string $view = 'filament.pages.language-management';

    public array $activeLocales = [];
    
    // Form fields
    public ?string $preset = 'de';
    public ?string $code = '';
    public ?string $name = '';
    public ?string $native = '';
    public ?string $regional = '';
    public ?string $gemini_api_key = '';
    public bool $translate_database = true;
    public bool $translate_json = true;

    // Presets
    public static array $presets = [
        'de' => ['name' => 'German', 'native' => 'Deutsch', 'regional' => 'de_DE', 'label' => 'Almanca (Deutsch)'],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'regional' => 'ru_RU', 'label' => 'Rusça (Русский)'],
        'fr' => ['name' => 'French', 'native' => 'Français', 'regional' => 'fr_FR', 'label' => 'Fransızca (Français)'],
        'es' => ['name' => 'Spanish', 'native' => 'Español', 'regional' => 'es_ES', 'label' => 'İspanyolca (Español)'],
        'it' => ['name' => 'Italian', 'native' => 'Italiano', 'regional' => 'it_IT', 'label' => 'İtalyanca (Italiano)'],
        'ar' => ['name' => 'Arabic', 'native' => 'العربية', 'regional' => 'ar_AE', 'label' => 'Arapça (العربية)'],
        'nl' => ['name' => 'Dutch', 'native' => 'Nederlands', 'regional' => 'nl_NL', 'label' => 'Flemenkçe (Nederlands)'],
        'el' => ['name' => 'Greek', 'native' => 'Ελληνικά', 'regional' => 'el_GR', 'label' => 'Yunanca (Ελληνικά)'],
    ];

    public function mount(): void
    {
        $this->activeLocales = config('laravellocalization.supportedLocales') ?? [];

        // Pre-fill with German preset on mount
        $defaultPreset = static::$presets['de'];
        $this->code = 'de';
        $this->name = $defaultPreset['name'];
        $this->native = $defaultPreset['native'];
        $this->regional = $defaultPreset['regional'];

        // Load Gemini API key from Settings if available
        $savedKey = Setting::where('key', 'gemini_api_key')->first();
        if ($savedKey) {
            $translations = $savedKey->getTranslations('value');
            $this->gemini_api_key = $translations['en'] ?? $translations['tr'] ?? $savedKey->value ?? '';
        }

        $this->form->fill([
            'preset' => 'de',
            'code' => $this->code,
            'name' => $this->name,
            'native' => $this->native,
            'regional' => $this->regional,
            'gemini_api_key' => $this->gemini_api_key,
            'translate_database' => true,
            'translate_json' => true,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dil Seçimi')
                    ->description('Eklemek istediğiniz dili listeden seçin. Dil bilgileri otomatik doldurulacaktır.')
                    ->schema([
                        Select::make('preset')
                            ->label('Eklenecek Dil')
                            ->options(
                                collect(static::$presets)->map(fn ($p) => $p['label'])
                                    ->put('custom', 'Kendim Tanımlayacağım (Özel Dil)')
                                    ->toArray()
                            )
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                                if ($state && $state !== 'custom' && isset(static::$presets[$state])) {
                                    $preset = static::$presets[$state];
                                    $set('code', $state);
                                    $set('name', $preset['name']);
                                    $set('native', $preset['native']);
                                    $set('regional', $preset['regional']);
                                } else if ($state === 'custom') {
                                    $set('code', '');
                                    $set('name', '');
                                    $set('native', '');
                                    $set('regional', '');
                                }
                            }),
                        
                        Grid::make(4)
                            ->schema([
                                TextInput::make('code')
                                    ->label('Dil Kodu (ISO)')
                                    ->required()
                                    ->maxLength(2)
                                    ->alpha()
                                    ->disabled(fn (\Filament\Forms\Get $get) => $get('preset') !== 'custom')
                                    ->dehydrated(),
                                TextInput::make('name')
                                    ->label('Dil Adı (İngilizce)')
                                    ->required()
                                    ->disabled(fn (\Filament\Forms\Get $get) => $get('preset') !== 'custom')
                                    ->dehydrated(),
                                TextInput::make('native')
                                    ->label('Dil Adı (Kendi Dilinde)')
                                    ->required()
                                    ->disabled(fn (\Filament\Forms\Get $get) => $get('preset') !== 'custom')
                                    ->dehydrated(),
                                TextInput::make('regional')
                                    ->label('Bölgesel Kod')
                                    ->required()
                                    ->disabled(fn (\Filament\Forms\Get $get) => $get('preset') !== 'custom')
                                    ->dehydrated(),
                            ])
                    ]),

                Section::make('Yapay Zeka (AI) Çeviri Seçenekleri')
                    ->description('Yeni dil eklendiğinde yapılacak otomatik çeviri işlemlerini seçin.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Checkbox::make('translate_database')
                                    ->label('Veritabanı İçeriklerini Çevir (Kategoriler, Menü Yemekleri, Blog Yazıları, Galeri Başlıkları)')
                                    ->default(true),
                                Checkbox::make('translate_json')
                                    ->label('Sabit Arayüz Metinlerini Çevir (Giriş Butonları, İletişim Formları, Çerez Uyarıları vb.)')
                                    ->default(true),
                            ]),
                        TextInput::make('gemini_api_key')
                            ->label('Gemini API Key')
                            ->placeholder('Yapay Zeka çevirisi için Gemini API Key gereklidir')
                            ->password()
                            ->required(fn () => $this->translate_database || $this->translate_json)
                            ->helperText('Gemini API Key ayarlar veritabanına güvenli şekilde kaydedilecektir.')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public function addLanguage(): void
    {
        $state = $this->form->getState();
        $code = strtolower(trim($state['code']));
        $name = trim($state['name']);
        $native = trim($state['native']);
        $regional = trim($state['regional']);
        $apiKey = trim($state['gemini_api_key'] ?? '');

        // Check if language already exists
        if (array_key_exists($code, $this->activeLocales)) {
            Notification::make()
                ->title('Bu dil zaten aktif!')
                ->danger()
                ->send();
            return;
        }

        // Save Gemini API key
        if (!empty($apiKey)) {
            Setting::updateOrCreate(
                ['key' => 'gemini_api_key'],
                [
                    'type' => 'text',
                    'group' => 'general',
                    'value' => [
                        'tr' => $apiKey,
                        'en' => $apiKey,
                    ]
                ]
            );
        }

        // 1. Add to active_locales.json
        $dynamicPath = storage_path('app/active_locales.json');
        $locales = [];
        if (File::exists($dynamicPath)) {
            $locales = json_decode(File::get($dynamicPath), true) ?? [];
        }
        $locales[$code] = [
            'name' => $name,
            'script' => 'Latn',
            'native' => $native,
            'regional' => $regional
        ];
        File::put($dynamicPath, json_encode($locales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Clear caches so the new locale is instantly registered
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        // 2. Perform AI translations
        if ($state['translate_database'] || $state['translate_json']) {
            if (empty($apiKey)) {
                Notification::make()
                    ->title('Gemini API Key eksik!')
                    ->danger()
                    ->send();
                return;
            }

            try {
                $translator = new AiTranslationService($apiKey);

                // --- ARAYÜZ METİNLERİ (JSON) ÇEVİRİSİ ---
                if ($state['translate_json']) {
                    $enPath = lang_path('en.json');
                    $trPath = lang_path('tr.json');
                    $targetPath = lang_path("{$code}.json");

                    $baseTranslations = File::exists($enPath) 
                        ? json_decode(File::get($enPath), true) 
                        : (File::exists($trPath) ? json_decode(File::get($trPath), true) : []);

                    if (!empty($baseTranslations)) {
                        $translatedJson = $translator->translateLargeBatch($baseTranslations, $name, 40);
                        File::put($targetPath, json_encode($translatedJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    }
                }

                // --- VERİTABANI MODEL ÇEVİRİLERİ ---
                if ($state['translate_database']) {
                    
                    // A. Categories
                    $categories = Category::all();
                    $catTexts = [];
                    foreach ($categories as $cat) {
                        $sourceName = $cat->getTranslation('name', 'tr') ?: $cat->getTranslation('name', 'en') ?: $cat->name;
                        $sourceDesc = $cat->getTranslation('description', 'tr') ?: $cat->getTranslation('description', 'en') ?: $cat->description;
                        
                        if ($sourceName) {
                            $catTexts["cat_{$cat->id}_name"] = $sourceName;
                        }
                        if ($sourceDesc) {
                            $catTexts["cat_{$cat->id}_desc"] = $sourceDesc;
                        }
                    }
                    if (!empty($catTexts)) {
                        $translatedCats = $translator->translateLargeBatch($catTexts, $name, 30);
                        foreach ($categories as $cat) {
                            $tName = $translatedCats["cat_{$cat->id}_name"] ?? null;
                            $tDesc = $translatedCats["cat_{$cat->id}_desc"] ?? null;
                            if ($tName) {
                                $cat->setTranslation('name', $code, $tName);
                                $cat->setTranslation('slug', $code, Str::slug($tName));
                            }
                            if ($tDesc) {
                                $cat->setTranslation('description', $code, $tDesc);
                            }
                            $cat->save();
                        }
                    }

                    // B. MenuItems
                    $menuItems = MenuItem::all();
                    $itemTexts = [];
                    foreach ($menuItems as $item) {
                        $sourceName = $item->getTranslation('name', 'tr') ?: $item->getTranslation('name', 'en') ?: $item->name;
                        $sourceDesc = $item->getTranslation('description', 'tr') ?: $item->getTranslation('description', 'en') ?: $item->description;
                        $sourceAllergen = $item->getTranslation('allergen_info', 'tr') ?: $item->getTranslation('allergen_info', 'en') ?: $item->allergen_info;
                        
                        if ($sourceName) {
                            $itemTexts["item_{$item->id}_name"] = $sourceName;
                        }
                        if ($sourceDesc) {
                            $itemTexts["item_{$item->id}_desc"] = $sourceDesc;
                        }
                        if ($sourceAllergen) {
                            $itemTexts["item_{$item->id}_allergen"] = $sourceAllergen;
                        }
                    }
                    if (!empty($itemTexts)) {
                        $translatedItems = $translator->translateLargeBatch($itemTexts, $name, 35);
                        foreach ($menuItems as $item) {
                            $tName = $translatedItems["item_{$item->id}_name"] ?? null;
                            $tDesc = $translatedItems["item_{$item->id}_desc"] ?? null;
                            $tAllergen = $translatedItems["item_{$item->id}_allergen"] ?? null;
                            
                            if ($tName) {
                                $item->setTranslation('name', $code, $tName);
                                $item->setTranslation('slug', $code, Str::slug($tName));
                            }
                            if ($tDesc) {
                                $item->setTranslation('description', $code, $tDesc);
                            }
                            if ($tAllergen) {
                                $item->setTranslation('allergen_info', $code, $tAllergen);
                            }
                            $item->save();
                        }
                    }

                    // C. BlogPosts
                    $posts = BlogPost::all();
                    $postTexts = [];
                    foreach ($posts as $post) {
                        $sourceTitle = $post->getTranslation('title', 'tr') ?: $post->getTranslation('title', 'en') ?: $post->title;
                        $sourceDesc = $post->getTranslation('description', 'tr') ?: $post->getTranslation('description', 'en') ?: $post->description;
                        $sourceContent = $post->getTranslation('content', 'tr') ?: $post->getTranslation('content', 'en') ?: $post->content;
                        
                        if ($sourceTitle) {
                            $postTexts["post_{$post->id}_title"] = $sourceTitle;
                        }
                        if ($sourceDesc) {
                            $postTexts["post_{$post->id}_desc"] = $sourceDesc;
                        }
                        if ($sourceContent) {
                            $postTexts["post_{$post->id}_content"] = $sourceContent;
                        }
                    }
                    if (!empty($postTexts)) {
                        $translatedPosts = $translator->translateLargeBatch($postTexts, $name, 10);
                        foreach ($posts as $post) {
                            $tTitle = $translatedPosts["post_{$post->id}_title"] ?? null;
                            $tDesc = $translatedPosts["post_{$post->id}_desc"] ?? null;
                            $tContent = $translatedPosts["post_{$post->id}_content"] ?? null;
                            
                            if ($tTitle) {
                                $post->setTranslation('title', $code, $tTitle);
                                $post->setTranslation('slug', $code, Str::slug($tTitle));
                            }
                            if ($tDesc) {
                                $post->setTranslation('description', $code, $tDesc);
                            }
                            if ($tContent) {
                                $post->setTranslation('content', $code, $tContent);
                            }
                            $post->save();
                        }
                    }

                    // D. GalleryImages
                    $images = GalleryImage::all();
                    $imageTexts = [];
                    foreach ($images as $img) {
                        $sourceTitle = $img->getTranslation('title', 'tr') ?: $img->getTranslation('title', 'en') ?: $img->title;
                        $sourceAlt = $img->getTranslation('alt_text', 'tr') ?: $img->getTranslation('alt_text', 'en') ?: $img->alt_text;
                        
                        if ($sourceTitle) {
                            $imageTexts["img_{$img->id}_title"] = $sourceTitle;
                        }
                        if ($sourceAlt) {
                            $imageTexts["img_{$img->id}_alt"] = $sourceAlt;
                        }
                    }
                    if (!empty($imageTexts)) {
                        $translatedImages = $translator->translateLargeBatch($imageTexts, $name, 35);
                        foreach ($images as $img) {
                            $tTitle = $translatedImages["img_{$img->id}_title"] ?? null;
                            $tAlt = $translatedImages["img_{$img->id}_alt"] ?? null;
                            
                            if ($tTitle) {
                                $img->setTranslation('title', $code, $tTitle);
                            }
                            if ($tAlt) {
                                $img->setTranslation('alt_text', $code, $tAlt);
                            }
                            $img->save();
                        }
                    }

                    // E. Settings
                    $settings = Setting::all();
                    $settingTexts = [];
                    foreach ($settings as $setting) {
                        $isTranslatable = $setting->group === 'seo' || in_array($setting->key, ['site_name', 'address']);
                        $sourceVal = $setting->getTranslation('value', 'tr') ?: $setting->getTranslation('value', 'en') ?: $setting->value;
                        
                        if ($isTranslatable && $sourceVal && is_string($sourceVal)) {
                            $settingTexts["set_{$setting->id}_val"] = $sourceVal;
                        }
                    }
                    if (!empty($settingTexts)) {
                        $translatedSettings = $translator->translateLargeBatch($settingTexts, $name, 25);
                        foreach ($settings as $setting) {
                            $isTranslatable = $setting->group === 'seo' || in_array($setting->key, ['site_name', 'address']);
                            if ($isTranslatable) {
                                $tVal = $translatedSettings["set_{$setting->id}_val"] ?? null;
                                if ($tVal) {
                                    $setting->setTranslation('value', $code, $tVal);
                                }
                            } else {
                                $sourceVal = $setting->getTranslation('value', 'tr') ?: $setting->getTranslation('value', 'en') ?: $setting->value;
                                $setting->setTranslation('value', $code, $sourceVal);
                            }
                            $setting->save();
                        }
                    }
                }

            } catch (\Throwable $e) {
                Notification::make()
                    ->title('Çeviri sırasında hata oluştu!')
                    ->body($e->getMessage())
                    ->danger()
                    ->send();
                return;
            }
        }

        // Re-mount to update state
        $this->mount();

        Notification::make()
            ->title("{$name} dili başarıyla eklendi ve tüm içerikler AI ile çevrildi!")
            ->success()
            ->send();
    }
}
