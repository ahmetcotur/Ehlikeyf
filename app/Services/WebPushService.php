<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\PushSubscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Exception;

class WebPushService
{
    /**
     * Get or generate VAPID keys
     */
    public static function getVapidKeys(): array
    {
        $publicKeySetting = Setting::where('key', 'vapid_public_key')->first();
        $privateKeySetting = Setting::where('key', 'vapid_private_key')->first();

        if (!$publicKeySetting || !$privateKeySetting) {
            try {
                // Generate VAPID keys
                $keys = \Minishlink\WebPush\VAPID::createVapidKeys();
                
                $publicKeySetting = Setting::updateOrCreate(
                    ['key' => 'vapid_public_key'],
                    [
                        'type' => 'text',
                        'group' => 'branding',
                        'value' => ['tr' => $keys['publicKey'], 'en' => $keys['publicKey']]
                    ]
                );

                $privateKeySetting = Setting::updateOrCreate(
                    ['key' => 'vapid_private_key'],
                    [
                        'type' => 'text',
                        'group' => 'branding',
                        'value' => ['tr' => $keys['privateKey'], 'en' => $keys['privateKey']]
                    ]
                );
            } catch (Exception $e) {
                logger()->error('Failed to generate VAPID keys: ' . $e->getMessage());
                return ['publicKey' => '', 'privateKey' => ''];
            }
        }

        return [
            'publicKey' => is_array($publicKeySetting->value) ? ($publicKeySetting->value['tr'] ?? '') : $publicKeySetting->value,
            'privateKey' => is_array($privateKeySetting->value) ? ($privateKeySetting->value['tr'] ?? '') : $privateKeySetting->value,
        ];
    }

    /**
     * Send push notification to all subscribers
     */
    public static function sendNotification(string $title, string $body, string $actionUrl = null)
    {
        $keys = self::getVapidKeys();
        if (empty($keys['publicKey']) || empty($keys['privateKey'])) {
            return;
        }

        $subscriptions = PushSubscription::all();
        if ($subscriptions->isEmpty()) {
            return;
        }

        try {
            $auth = [
                'VAPID' => [
                    'subject' => 'mailto:info@ehlikeyfkas.com',
                    'publicKey' => $keys['publicKey'],
                    'privateKey' => $keys['privateKey'],
                ],
            ];

            $webPush = new WebPush($auth);
            $payload = json_encode([
                'title' => $title,
                'body' => $body,
                'icon' => '/logo.png',
                'badge' => '/logo.png',
                'url' => $actionUrl ?: '/admin',
            ]);

            foreach ($subscriptions as $sub) {
                $subscription = Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                ]);

                $webPush->queueNotification($subscription, $payload);
            }

            foreach ($webPush->flush() as $report) {
                $endpoint = $report->getEndpoint();
                if (!$report->isSuccess()) {
                    logger()->warning("Push failed for endpoint {$endpoint}: " . $report->getReason());
                    if ($report->isSubscriptionExpired()) {
                        PushSubscription::where('endpoint', $endpoint)->delete();
                    }
                }
            }
        } catch (Exception $e) {
            logger()->error('Error sending Web Push notification: ' . $e->getMessage());
        }
    }
}
