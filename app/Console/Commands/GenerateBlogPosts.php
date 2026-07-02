<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\BlogGeneratorService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:generate {--force : Force generation regardless of frequency setting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an AI blog post based on topics, tone, and frequency settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Checking AI Blog Autopilot Settings...");

        // Load settings
        $isActive = Setting::getValue('blog_bot_active', '0') === '1';
        $frequency = Setting::getValue('blog_bot_frequency', 'weekly');
        $topics = Setting::getValue('blog_bot_topics', 'bohem Akdeniz meyhanesi lezzetleri, Kaş gezilecek yerler');
        $tone = Setting::getValue('blog_bot_tone', 'samimi, bohem, gurme hikaye anlatımı');
        
        $lastRunVal = Setting::where('key', 'blog_bot_last_run')->first();
        $lastRunStr = $lastRunVal ? (is_array($lastRunVal->value) ? ($lastRunVal->value['tr'] ?? reset($lastRunVal->value)) : $lastRunVal->value) : null;
        $lastRun = $lastRunStr ? Carbon::parse($lastRunStr) : null;

        if (!$isActive && !$this->option('force')) {
            $this->warn("AI Blog Writer Bot is currently disabled in Settings.");
            return;
        }

        // Determine if it is time to write based on frequency
        $shouldRun = false;
        if ($this->option('force') || !$lastRun) {
            $shouldRun = true;
        } else {
            $hoursSinceLastRun = $lastRun->diffInHours(now());
            
            switch ($frequency) {
                case 'daily':
                    $shouldRun = $hoursSinceLastRun >= 24;
                    break;
                case 'three_days':
                    $shouldRun = $hoursSinceLastRun >= 72;
                    break;
                case 'weekly':
                    $shouldRun = $hoursSinceLastRun >= 168; // 7 days
                    break;
                case 'monthly':
                    $shouldRun = $hoursSinceLastRun >= 720; // 30 days
                    break;
                default:
                    $shouldRun = false;
                    break;
            }
        }

        if (!$shouldRun) {
            $this->info("It is not time to write a post yet. Last run was on: " . ($lastRun ? $lastRun->toDateTimeString() : 'Never') . " (Frequency: {$frequency})");
            return;
        }

        $this->info("Triggering AI Blog Generator...");
        try {
            $generator = new BlogGeneratorService();
            $post = $generator->generateAndSavePost($topics, $tone);

            // Update last run time in settings
            Setting::updateOrCreate(
                ['key' => 'blog_bot_last_run'],
                [
                    'type' => 'text',
                    'group' => 'general',
                    'value' => [
                        'tr' => now()->toDateTimeString(),
                        'en' => now()->toDateTimeString()
                    ]
                ]
            );

            $this->info("AI Blog Post generated successfully! Title: " . $post->getTranslation('title', 'tr'));
            Log::info("Console command blog:generate successfully completed. Post ID: {$post->id}");

        } catch (\Throwable $e) {
            $this->error("Failed to generate blog post: " . $e->getMessage());
            Log::error("Console command blog:generate failed: " . $e->getMessage());
        }
    }
}
