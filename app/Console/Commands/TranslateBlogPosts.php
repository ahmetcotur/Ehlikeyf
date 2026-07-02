<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class TranslateBlogPosts extends Command
{
    protected $signature = 'app:translate-blogs';
    protected $description = 'Translate blog posts from TR to EN placeholders';

    public function handle()
    {
        $translations = [
            'kaş en güzel meyhaneler' => [
                'title' => 'The Best Taverns in Kaş',
                'description' => 'Discover the most authentic and delicious taverns in Kaş for an unforgettable evening.'
            ],
            'kaş’ta rakı balık keyfi' => [
                'title' => 'Rakı & Fish Delight in Kaş',
                'description' => 'Experience the traditional rakı-fish culture at Ehl-i Keyf Kaş with the freshest catch.'
            ],
            'kaş yemek yenecek yerler' => [
                'title' => 'Best Places to Eat in Kaş',
                'description' => 'A guide to the most delicious stops in Kaş, from local flavors to Mediterranean cuisine.'
            ],
            'kaş meze' => [
                'title' => 'Authentic Mezes in Kaş',
                'description' => 'Explore the rich world of Mediterranean appetizers prepared with local ingredients.'
            ],
            'kaş deniz ürünleri restoranı' => [
                'title' => 'Seafood Restaurant in Kaş',
                'description' => 'The destination for seafood lovers: Fresh Mediterranean fish and creative recipes.'
            ],
            'kaş en iyi restoranlar' => [
                'title' => 'Best Restaurants in Kaş',
                'description' => 'Our curated list of top-rated restaurants for a premium dining experience in Kaş.'
            ],
            'kaş restaurant' => [
                'title' => 'Ehl-i Keyf Kaş: A Taste of Kaş',
                'description' => 'Welcome to Ehl-i Keyf, where Mediterranean tradition meets modern culinary art.'
            ],
            'kaş akşam yemeği' => [
                'title' => 'Unforgettable Dinner in Kaş',
                'description' => 'End your day with a perfect dinner accompanied by the magic of Kaş.'
            ],
            'kaş yeni nesil meyhane' => [
                'title' => 'New Generation Tavern in Kaş',
                'description' => 'A modern twist on the classic tavern experience: Music, meze, and fun.'
            ],
            'kaş rakı balık' => [
                'title' => 'Traditional Rakı & Fish',
                'description' => 'Learn about the best rakı-fish combinations and why it is a must-do in Kaş.'
            ],
        ];

        $posts = BlogPost::all();

        foreach ($posts as $post) {
            $trTitle = $post->getTranslation('title', 'tr');
            
            if (isset($translations[$trTitle])) {
                $enData = $translations[$trTitle];
                $post->setTranslation('title', 'en', $enData['title']);
                $post->setTranslation('description', 'en', $enData['description']);
                $post->setTranslation('slug', 'en', Str::slug($enData['title']));
                $post->setTranslation('content', 'en', "English content for " . $enData['title'] . " will be added soon.");
                $post->save();
                $this->info("Translated: {$trTitle}");
            } else {
                // Fallback translation if not in list
                $post->setTranslation('title', 'en', 'EN: ' . $trTitle);
                $post->setTranslation('slug', 'en', Str::slug($trTitle) . '-en');
                $post->save();
                $this->warn("Fallback translation for: {$trTitle}");
            }
        }

        $this->info('Blog posts translated successfully!');
    }
}
