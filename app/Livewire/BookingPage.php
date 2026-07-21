<?php

namespace App\Livewire;

use Livewire\Component;

class BookingPage extends Component
{
    public function render()
    {
        return view('livewire.booking-page')->layout('components.layouts.app', [
            'title' => __('Ehl-i Keyf Kaş | Rezervasyon Yap') . ' - ' . __('Table Booking'),
            'description' => __('Book your table at Ehl-i Keyf Kaş for an unforgettable Mediterranean tavern evening with nostalgic background music and delicious mezze.')
        ]);
    }
}
