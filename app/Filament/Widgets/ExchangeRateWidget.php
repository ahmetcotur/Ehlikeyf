<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Services\ExchangeRateService;

class ExchangeRateWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '300s';

    protected function getStats(): array
    {
        $tryPerUsd = app(ExchangeRateService::class)->getUsdToTryRate();
        $usdRate = $tryPerUsd > 0 ? (1 / $tryPerUsd) : 0;
        
        return [
            Stat::make('Güncel USD/TRY Kuru', number_format($tryPerUsd, 2) . ' ₺')
                ->description('1 USD = ' . number_format($tryPerUsd, 2) . ' TRY')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Güncel TRY/USD Kuru', '$ ' . number_format($usdRate, 4))
                ->description('1 TRY = ' . number_format($usdRate, 4) . ' USD')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),
        ];
    }
}
