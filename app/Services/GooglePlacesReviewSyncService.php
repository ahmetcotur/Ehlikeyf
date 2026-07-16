<?php

namespace App\Services;

use App\Models\GooglePlaceSummary;
use App\Models\GoogleReview;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class GooglePlacesReviewSyncService
{
    public function refreshIfStale(int $maxAgeHours = 6): void
    {
        if (! config('services.google_places.api_key')) {
            return;
        }

        $latestSync = GooglePlaceSummary::query()->latest('synced_at')->value('synced_at');

        if ($latestSync && Carbon::parse($latestSync)->gt(now()->subHours($maxAgeHours))) {
            return;
        }

        $lock = Cache::lock('google-reviews-refresh', 300);

        if (! $lock->get()) {
            return;
        }

        app()->terminating(function () use ($lock) {
            try {
                $this->sync();
            } catch (\Throwable $exception) {
                report($exception);
            } finally {
                optional($lock)->release();
            }
        });
    }

    public function sync(?string $placeId = null): GooglePlaceSummary
    {
        $apiKey = config('services.google_places.api_key');
        $placeId = $placeId ?: config('services.google_places.place_id') ?: Setting::getValue('google_place_id');

        if (! $apiKey) {
            throw new RuntimeException('GOOGLE_PLACES_API_KEY is not configured.');
        }

        $placeId = $placeId ?: $this->resolvePlaceId($apiKey);

        $response = Http::timeout(20)
            ->retry(2, 500)
            ->get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $placeId,
                'fields' => 'name,rating,user_ratings_total,reviews,url',
                'reviews_sort' => 'newest',
                'language' => app()->getLocale() ?: 'tr',
                'key' => $apiKey,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Google Places request failed with HTTP ' . $response->status());
        }

        $payload = $response->json();
        $status = Arr::get($payload, 'status');

        if ($status !== 'OK') {
            $message = Arr::get($payload, 'error_message', 'Unknown Google Places error');
            throw new RuntimeException("Google Places returned {$status}: {$message}");
        }

        $result = Arr::get($payload, 'result', []);
        $syncedAt = now();

        $summary = GooglePlaceSummary::updateOrCreate(
            ['place_id' => $placeId],
            [
                'name' => Arr::get($result, 'name'),
                'rating' => Arr::get($result, 'rating'),
                'review_count' => (int) Arr::get($result, 'user_ratings_total', 0),
                'google_url' => Arr::get($result, 'url'),
                'raw_payload' => $result,
                'synced_at' => $syncedAt,
            ]
        );

        foreach (Arr::get($result, 'reviews', []) as $review) {
            $publishedAt = isset($review['time']) ? Carbon::createFromTimestamp((int) $review['time']) : null;

            GoogleReview::updateOrCreate(
                [
                    'place_id' => $placeId,
                    'author_name' => Arr::get($review, 'author_name', 'Google kullanıcısı'),
                    'published_at' => $publishedAt,
                ],
                [
                    'author_url' => Arr::get($review, 'author_url'),
                    'profile_photo_url' => Arr::get($review, 'profile_photo_url'),
                    'rating' => (int) Arr::get($review, 'rating', 5),
                    'text' => Arr::get($review, 'text'),
                    'relative_time_description' => Arr::get($review, 'relative_time_description'),
                    'language' => Arr::get($review, 'language'),
                    'is_active' => true,
                    'raw_payload' => $review,
                ]
            );
        }

        $this->persistPublicSettings($summary);

        Log::info('Google reviews synced', [
            'place_id' => $placeId,
            'rating' => $summary->rating,
            'review_count' => $summary->review_count,
            'reviews_returned' => count(Arr::get($result, 'reviews', [])),
        ]);

        return $summary;
    }

    protected function persistPublicSettings(GooglePlaceSummary $summary): void
    {
        $settings = [
            'google_place_id' => $summary->place_id,
            'google_rating' => (string) $summary->rating,
            'google_review_count' => (string) $summary->review_count,
            'google_reviews_synced_at' => optional($summary->synced_at)->toDateTimeString(),
            'google_maps_link' => $summary->google_url,
        ];

        foreach ($settings as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'type' => 'text',
                    'group' => 'contact',
                    'value' => [
                        'tr' => $value,
                        'en' => $value,
                    ],
                ]
            );
        }
    }

    protected function resolvePlaceId(string $apiKey): ?string
    {
        $query = config('services.google_places.place_query') ?: 'Ehlikeyf Meyhane Kaş';

        $response = Http::timeout(20)
            ->retry(2, 500)
            ->get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
                'input' => $query,
                'inputtype' => 'textquery',
                'fields' => 'place_id,name',
                'language' => app()->getLocale() ?: 'tr',
                'key' => $apiKey,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Google Place ID lookup failed with HTTP ' . $response->status());
        }

        $payload = $response->json();
        $status = Arr::get($payload, 'status');

        if ($status !== 'OK') {
            $message = Arr::get($payload, 'error_message', 'Unknown Google Places lookup error');
            throw new RuntimeException("Google Place ID lookup returned {$status}: {$message}");
        }

        $placeId = Arr::get($payload, 'candidates.0.place_id');

        if (! $placeId) {
            throw new RuntimeException('Google Place ID lookup did not return a candidate.');
        }

        return $placeId;
    }
}
