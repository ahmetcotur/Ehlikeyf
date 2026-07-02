<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    private const API_URL = 'https://www.tcmb.gov.tr/kurlar/today.xml';

    /**
     * Fetch the value of 1 USD in TRY.
     */
    public function getUsdToTryRate(): float
    {
        return Cache::remember('usd_to_try_rate_tcmb', 43200, function () {
            try {
                $xml = @simplexml_load_file(self::API_URL);
                if ($xml) {
                    foreach ($xml->Currency as $currency) {
                        if ((string)$currency['CurrencyCode'] === 'USD') {
                            return (float)$currency->ForexSelling;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('ExchangeRateService TCMB failed: ' . $e->getMessage());
            }
            
            return 35.70; // Fallback
        });
    }
}
