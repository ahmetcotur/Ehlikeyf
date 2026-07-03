<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Feedback;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\FeedbackResource;
use Filament\Widgets\Widget;

class LatestSubmissionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-submissions-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1; // Show at the top of the dashboard

    public function getViewData(): array
    {
        return [
            'latestBookings' => Booking::latest('id')->take(5)->get(),
            'latestFeedback' => Feedback::latest('id')->take(5)->get(),
            'bookingUrl' => BookingResource::getUrl('index'),
            'feedbackUrl' => FeedbackResource::getUrl('index'),
        ];
    }
}
