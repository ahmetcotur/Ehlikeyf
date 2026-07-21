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
        Setting::updateOrCreate(
            ['key' => 'phone_2'],
            [
                'value' => ['tr' => '0553 701 46 69', 'en' => '0553 701 46 69'],
                'type' => 'text',
                'group' => 'contact',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'phone_2')->delete();
    }
};
