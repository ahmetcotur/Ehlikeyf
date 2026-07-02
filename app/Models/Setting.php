<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['value'];

    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) return $default;

        if ($setting->type === 'image') {
            $val = $setting->value;
            if (!$val) return $default;
            if (str_starts_with($val, 'http')) {
                return $val;
            }
            if (file_exists(public_path('storage/' . $val))) {
                return '/storage/' . $val;
            }
            if (file_exists(public_path('images/' . $val))) {
                return '/images/' . $val;
            }
            return $default;
        }

        if ($setting->type === 'images') {
            if (is_array($setting->value)) {
                return array_map(function($img) {
                    if (str_starts_with($img, 'http')) return $img;
                    if (file_exists(public_path('storage/' . $img))) return '/storage/' . $img;
                    if (file_exists(public_path('images/' . $img))) return '/images/' . $img;
                    return '/storage/' . $img;
                }, $setting->value);
            }
            return is_array($default) ? $default : [];
        }

        return $setting->value ?? $default;
    }
}
