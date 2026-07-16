<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class CategoryMenuCardImageTest extends TestCase
{
    public function test_meze_and_drink_menu_fallback_images_use_distinct_setting_keys_in_turkish_locale(): void
    {
        App::setLocale('tr');

        $meze = new Category([
            'name' => ['en' => 'Meze Menu', 'tr' => 'Meze Menüsü'],
            'slug' => ['en' => 'meze-menu', 'tr' => 'meze-menusu'],
        ]);

        $drink = new Category([
            'name' => ['en' => 'Drink Menu', 'tr' => 'İçecek Menüsü'],
            'slug' => ['en' => 'drink-menu', 'tr' => 'icecek-menusu'],
        ]);

        $this->assertSame('menu_snacks_image', $meze->menuCardImageSettingKey());
        $this->assertSame('menu_drinks_image', $drink->menuCardImageSettingKey());
        $this->assertNotSame($meze->menuCardImageSettingKey(), $drink->menuCardImageSettingKey());
    }
}
