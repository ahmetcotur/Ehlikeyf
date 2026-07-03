<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Branding
            [
                'key' => 'site_name',
                'value' => ['tr' => 'Ehl-i Keyf Meyhane Kaş', 'en' => 'Ehl-i Keyf Meyhane Kaş'],
                'type' => 'text',
                'group' => 'branding',
            ],
            [
                'key' => 'logo',
                'value' => ['tr' => 'logo.png', 'en' => 'logo.png'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'brand_olive',
                'value' => ['tr' => '#5c6448', 'en' => '#5c6448'],
                'type' => 'color',
                'group' => 'branding',
            ],
            [
                'key' => 'brand_light',
                'value' => ['tr' => '#f5f1e6', 'en' => '#f5f1e6'],
                'type' => 'color',
                'group' => 'branding',
            ],
            [
                'key' => 'brand_dark',
                'value' => ['tr' => '#2c2e27', 'en' => '#2c2e27'],
                'type' => 'color',
                'group' => 'branding',
            ],

            // Contact
            [
                'key' => 'phone',
                'value' => ['tr' => '+90 536 729 22 18', 'en' => '+90 536 729 22 18'],
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'whatsapp',
                'value' => ['tr' => '905367292218', 'en' => '905367292218'],
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'address',
                'value' => [
                    'tr' => 'Andifli, Hükümet Cd. No:3, 07580 Kaş/Antalya',
                    'en' => 'Andifli, Hükümet Cd. No:3, 07580 Kaş/Antalya'
                ],
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'google_maps_link',
                'value' => ['tr' => 'https://maps.app.goo.gl/xxx', 'en' => 'https://maps.app.goo.gl/xxx'],
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'google_maps_embed',
                'value' => [
                    'tr' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1591.956627094056!2d29.610111162153966!3d36.19835705663737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c1d1bc5b476b55%3A0xbf4bd37d9119f4b4!2sEhl-i Keyf%20Restaurant%20Ka%C5%9F!5e0!3m2!1sen!2str!4v1709068478491!5m2!1sen!2str',
                    'en' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1591.956627094056!2d29.610111162153966!3d36.19835705663737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c1d1bc5b476b55%3A0xbf4bd37d9119f4b4!2sEhl-i Keyf%20Restaurant%20Ka%C5%9F!5e0!3m2!1sen!2str!4v1709068478491!5m2!1sen!2str'
                ],
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'email',
                'value' => ['tr' => 'info@ehlikeyfkas.com', 'en' => 'info@ehlikeyfkas.com'],
                'type' => 'text',
                'group' => 'contact',
            ],

            // SEO
            [
                'key' => 'meta_title',
                'value' => [
                    'tr' => 'Ehl-i Keyf Meyhane Kaş | Ehl-i biziz. Keyfini siz sürün.',
                    'en' => 'Ehl-i Keyf Meyhane Kaş | The Experts of Pleasure. You Just Enjoy It.'
                ],
                'type' => 'text',
                'group' => 'seo',
            ],
            [
                'key' => 'meta_description',
                'value' => [
                    'tr' => 'Kaş\'ın kalbinde, zeytin ağaçlarının altında, nostaljik meyhane ezgileri ve enfes mezeler eşliğinde unutulmaz Akdeniz akşamları.',
                    'en' => 'Unforgettable Mediterranean evenings in the heart of Kaş under olive trees, accompanied by nostalgic tavern melodies and delicious mezzes.'
                ],
                'type' => 'text',
                'group' => 'seo',
            ],
            [
                'key' => 'favicon',
                'value' => ['tr' => 'favicon.png', 'en' => 'favicon.png'],
                'type' => 'image',
                'group' => 'branding',
            ],
            // Dynamic Page Images
            [
                'key' => 'hero_images',
                'value' => [
                    'tr' => ['gallery/029A7791.webp', 'gallery/029A7813.webp', 'gallery/029A8076.webp'],
                    'en' => ['gallery/029A7791.webp', 'gallery/029A7813.webp', 'gallery/029A8076.webp']
                ],
                'type' => 'images',
                'group' => 'branding',
            ],
            [
                'key' => 'story_image',
                'value' => ['tr' => 'gallery/029A7798.webp', 'en' => 'gallery/029A7798.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'menu_restaurant_image',
                'value' => ['tr' => 'gallery/029A7810.webp', 'en' => 'gallery/029A7810.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'menu_snacks_image',
                'value' => ['tr' => 'gallery/029A7858.webp', 'en' => 'gallery/029A7858.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'menu_drinks_image',
                'value' => ['tr' => 'gallery/029A7909.webp', 'en' => 'gallery/029A7909.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'parallax_image',
                'value' => ['tr' => 'gallery/029A8012-HDR.webp', 'en' => 'gallery/029A8012-HDR.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'our_story_hero_image',
                'value' => ['tr' => 'gallery/029A8016-HDR.webp', 'en' => 'gallery/029A8016-HDR.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'our_story_roots_image',
                'value' => ['tr' => 'gallery/029A7811.webp', 'en' => 'gallery/029A7811.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'our_story_sea_image',
                'value' => ['tr' => 'gallery/029A7905.webp', 'en' => 'gallery/029A7905.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'our_story_flame_image',
                'value' => ['tr' => 'gallery/029A7916.webp', 'en' => 'gallery/029A7916.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'our_story_gathering_image',
                'value' => ['tr' => 'gallery/029A7937.webp', 'en' => 'gallery/029A7937.webp'],
                'type' => 'image',
                'group' => 'branding',
            ],
            [
                'key' => 'ai_provider',
                'value' => ['tr' => 'gemini', 'en' => 'gemini'],
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'gemini_api_key',
                'value' => ['tr' => '', 'en' => ''],
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'openrouter_api_key',
                'value' => ['tr' => '', 'en' => ''],
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'openrouter_model',
                'value' => ['tr' => 'google/gemini-2.5-flash', 'en' => 'google/gemini-2.5-flash'],
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
