<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_place_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('place_id')->unique();
            $table->string('name')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->unsignedInteger('review_count')->default(0);
            $table->string('google_url')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });

        Schema::create('google_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('place_id')->index();
            $table->string('author_name');
            $table->string('author_url')->nullable();
            $table->string('profile_photo_url')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('text')->nullable();
            $table->string('relative_time_description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('language', 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('raw_payload')->nullable();
            $table->timestamps();

            $table->unique(['place_id', 'author_name', 'published_at'], 'google_reviews_unique_author_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
        Schema::dropIfExists('google_place_summaries');
    }
};
