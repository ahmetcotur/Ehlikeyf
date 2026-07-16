<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['title', 'slug', 'description', 'content'];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', '/'])) {
            return $this->image;
        }

        if (file_exists(public_path('images/'.$this->image))) {
            return asset('images/'.$this->image);
        }

        return Storage::disk('public')->url($this->image);
    }
}
