<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SocialkasInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.socialkas-info-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 10;
}
