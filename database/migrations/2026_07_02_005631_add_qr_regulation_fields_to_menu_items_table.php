<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->boolean('is_vegetarian')->default(false)->after('is_vegan');
            $table->boolean('contains_alcohol')->default(false)->after('is_vegetarian');
            $table->integer('calories')->nullable()->after('contains_alcohol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['is_vegetarian', 'contains_alcohol', 'calories']);
        });
    }
};
