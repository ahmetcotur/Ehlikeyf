<?php

namespace App\Console\Commands;

use App\Services\GooglePlacesReviewSyncService;
use Illuminate\Console\Command;
use Throwable;

class SyncGoogleReviews extends Command
{
    protected $signature = 'google-reviews:sync {--place-id= : Override the configured Google Place ID for this run}';

    protected $description = 'Sync Google Maps rating, review count, and latest available reviews from Google Places API.';

    public function handle(GooglePlacesReviewSyncService $syncService): int
    {
        $this->info('Syncing Google Maps reviews...');

        try {
            $summary = $syncService->sync($this->option('place-id'));

            $this->info(sprintf(
                'Google reviews synced: %.1f rating, %s reviews, synced at %s',
                $summary->rating ?? 0,
                number_format($summary->review_count),
                optional($summary->synced_at)->toDateTimeString()
            ));

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);
            $this->error($exception->getMessage());
            $this->warn('Existing cached Google review data was left untouched.');

            return self::FAILURE;
        }
    }
}
