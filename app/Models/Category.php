<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
