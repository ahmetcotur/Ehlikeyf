<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasTranslations;

    protected $guarded = [];
    
    public $translatable = ['name', 'slug', 'description', 'allergen_info'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_vegan' => 'boolean',
        'is_vegetarian' => 'boolean',
        'contains_alcohol' => 'boolean',
        'calories' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
