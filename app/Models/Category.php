<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'slug', 'description'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order_column');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order_column');
    }

    public function menuCardImageSettingKey(): string
    {
        $searchText = Str::slug(collect([
            $this->getTranslation('name', app()->getLocale(), false),
            $this->getTranslation('name', 'tr', false),
            $this->getTranslation('name', 'en', false),
            $this->getTranslation('slug', app()->getLocale(), false),
            $this->getTranslation('slug', 'tr', false),
            $this->getTranslation('slug', 'en', false),
        ])->filter()->implode(' '));

        if (Str::contains($searchText, ['food', 'main', 'yemek', 'kahvalti'])) {
            return 'menu_restaurant_image';
        }

        if (Str::contains($searchText, ['drink', 'icecek', 'sarap', 'wine'])) {
            return 'menu_drinks_image';
        }

        return 'menu_snacks_image';
    }

    public function menuCardImageUrl(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'http') ? $this->image : Storage::url($this->image);
        }

        return match ($this->menuCardImageSettingKey()) {
            'menu_restaurant_image' => Setting::getValue('menu_restaurant_image', asset('storage/gallery/029A0989.webp')),
            'menu_drinks_image' => Setting::getValue('menu_drinks_image', asset('storage/gallery/029A5151.webp')),
            default => Setting::getValue('menu_snacks_image', asset('storage/gallery/029A0982.webp')),
        };
    }
}
