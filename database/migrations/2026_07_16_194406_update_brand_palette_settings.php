<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $palette = [
            'brand_olive' => '#5E4A3F',
            'brand_light' => '#F8F1E7',
            'brand_dark' => '#211A16',
        ];

        foreach ($palette as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => ['tr' => $value, 'en' => $value],
                    'type' => 'color',
                    'group' => 'branding',
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $palette = [
            'brand_olive' => '#5C6448',
            'brand_light' => '#F5F1E6',
            'brand_dark' => '#2C2E27',
        ];

        foreach ($palette as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => ['tr' => $value, 'en' => $value],
                    'type' => 'color',
                    'group' => 'branding',
                ]
            );
        }
    }
};
