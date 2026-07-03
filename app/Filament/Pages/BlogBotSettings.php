<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\BlogGeneratorService;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BlogBotSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationLabel = 'AI Blog Yazarı';
    protected static ?string $title = 'AI Blog Otopilotu';
    protected static ?string $navigationGroup = 'Blog Yönetimi';

    protected static string $view = 'filament.pages.blog-bot-settings';

    // Form fields
    public bool $blog_bot_active = false;
    public ?string $blog_bot_frequency = 'weekly';
    public ?string $blog_bot_topics = '';
    public ?string $blog_bot_tone = '';
    public ?string $blog_bot_last_run = '';

    public function mount(): void
    {
        $this->blog_bot_active = Setting::getValue('blog_bot_active', '0') === '1';
        $this->blog_bot_frequency = Setting::getValue('blog_bot_frequency', 'weekly');
        $this->blog_bot_topics = Setting::getValue('blog_bot_topics', 'bohem Akdeniz meyhanesi lezzetleri, Kaş gezilecek yerler, meze tarifleri, rakı-meze uyumu');
        $this->blog_bot_tone = Setting::getValue('blog_bot_tone', 'samimi, bohem, gurme, hikaye anlatımı, Kaş yarımadası atmosferi');
        
        $lastRunVal = Setting::where('key', 'blog_bot_last_run')->first();
        $this->blog_bot_last_run = $lastRunVal ? (is_array($lastRunVal->value) ? ($lastRunVal->value['tr'] ?? reset($lastRunVal->value)) : $lastRunVal->value) : 'Henüz çalıştırılmadı';

        $this->form->fill([
            'blog_bot_active' => $this->blog_bot_active,
            'blog_bot_frequency' => $this->blog_bot_frequency,
            'blog_bot_topics' => $this->blog_bot_topics,
            'blog_bot_tone' => $this->blog_bot_tone,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('AI Blog Otopilot Durumu')
                    ->description('Yapay zeka yazar botunun durumunu ve paylaşım sıklığını belirleyin.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('blog_bot_active')
                                    ->label('Otopilot Aktif')
                                    ->helperText('Etkinleştirildiğinde, bot belirlediğiniz sıklığa göre arka planda otomatik yazılar yazacaktır.')
                                    ->default(false),
                                Select::make('blog_bot_frequency')
                                    ->label('Paylaşım Sıklığı')
                                    ->options([
                                        'daily' => 'Her Gün (Daily)',
                                        'three_days' => '3 Günde Bir (Every 3 Days)',
                                        'weekly' => 'Haftada Bir (Weekly)',
                                        'monthly' => 'Ayda Bir (Monthly)',
                                    ])
                                    ->required()
                                    ->default('weekly'),
                            ])
                    ]),

                Section::make('İçerik Şablonu & Yapay Zeka Ayarları')
                    ->description('Yapay zekanın ne tür içerikler üreteceğini ve hangi yazı karakterini kullanacağını tarif edin.')
                    ->schema([
                        TextInput::make('blog_bot_topics')
                            ->label('Yazı Konuları & Odak Kelimeler')
                            ->placeholder('örn: mezeler, zeytin ağaçları, Kaş gezi rehberi, Akdeniz mutfağı')
                            ->required()
                            ->helperText('Yapay zekanın hakkında yazacağı ana başlıkları virgülle ayırarak girin.'),
                        TextInput::make('blog_bot_tone')
                            ->label('Yazı Karakteri & Konuşma Tonu')
                            ->placeholder('örn: samimi, davetkar, bohem, gurme, bilgilendirici')
                            ->required()
                            ->helperText('Yazının üslubunu ve ses tonunu belirtin.'),
                    ])
            ]);
    }

    public function saveSettings(): void
    {
        $state = $this->form->getState();

        Setting::updateOrCreate(
            ['key' => 'blog_bot_active'],
            ['type' => 'boolean', 'group' => 'general', 'value' => ['tr' => $state['blog_bot_active'] ? '1' : '0', 'en' => $state['blog_bot_active'] ? '1' : '0']]
        );

        Setting::updateOrCreate(
            ['key' => 'blog_bot_frequency'],
            ['type' => 'text', 'group' => 'general', 'value' => ['tr' => $state['blog_bot_frequency'], 'en' => $state['blog_bot_frequency']]]
        );

        Setting::updateOrCreate(
            ['key' => 'blog_bot_topics'],
            ['type' => 'text', 'group' => 'general', 'value' => ['tr' => $state['blog_bot_topics'], 'en' => $state['blog_bot_topics']]]
        );

        Setting::updateOrCreate(
            ['key' => 'blog_bot_tone'],
            ['type' => 'text', 'group' => 'general', 'value' => ['tr' => $state['blog_bot_tone'], 'en' => $state['blog_bot_tone']]]
        );

        Notification::make()
            ->title('Ayarlar başarıyla kaydedildi')
            ->success()
            ->send();

        $this->mount();
    }

    public function generateNow(): void
    {
        // Force save current settings first
        $this->saveSettings();

        // Check if active API key exists
        $provider = Setting::getValue('ai_provider', 'gemini');
        $apiKey = $provider === 'openrouter' 
            ? Setting::getValue('openrouter_api_key') 
            : Setting::getValue('gemini_api_key');

        if (empty($apiKey)) {
            Notification::make()
                ->title('AI API Key Eksik!')
                ->body('Blog yazabilmek için "Dil Ekle & AI Çeviri" sayfasından geçerli bir API Key kaydetmiş olmalısınız.')
                ->danger()
                ->send();
            return;
        }

        Notification::make()
            ->title('Yapay Zeka yazmaya başladı...')
            ->body('Yazı üretiliyor ve tüm aktif dillere otomatik olarak çevriliyor. Lütfen bekleyin...')
            ->info()
            ->send();

        try {
            $generator = new BlogGeneratorService();
            $post = $generator->generateAndSavePost($this->blog_bot_topics, $this->blog_bot_tone);

            // Update last run setting
            Setting::updateOrCreate(
                ['key' => 'blog_bot_last_run'],
                [
                    'type' => 'text',
                    'group' => 'general',
                    'value' => [
                        'tr' => now()->toDateTimeString(),
                        'en' => now()->toDateTimeString()
                    ]
                ]
            );

            Notification::make()
                ->title('Blog yazısı yayınlandı ve çevrildi!')
                ->body('Yazılan Başlık: ' . $post->getTranslation('title', 'tr'))
                ->success()
                ->duration(10000)
                ->send();

            $this->mount();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('Blog yazısı üretilemedi!')
                ->body($e->getMessage())
                ->danger()
                ->duration(15000)
                ->send();
        }
    }
}
