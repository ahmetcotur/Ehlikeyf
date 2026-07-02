<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class BookingPage extends Component
{
    public $name;
    public $phone;
    public $email;
    public $booking_date;
    public $booking_time;
    public $party_size = 2;
    public $seating_area = 'garden'; // default: Bahçe
    public $notes;
    
    public $successMessage = false;

    // Available time slots
    public $timeSlots = [
        '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00'
    ];

    public function mount()
    {
        $this->booking_date = Carbon::today()->format('Y-m-d');
    }

    public function incrementPartySize()
    {
        if ($this->party_size < 30) {
            $this->party_size++;
        }
    }

    public function decrementPartySize()
    {
        if ($this->party_size > 1) {
            $this->party_size--;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|string',
            'phone' => 'required|min:10|string',
            'email' => 'nullable|email',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|in:' . implode(',', $this->timeSlots),
            'party_size' => 'required|integer|min:1|max:30',
            'seating_area' => 'required|in:garden,terrace',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required.'),
            'name.min' => __('Name must be at least 3 characters.'),
            'phone.required' => __('Phone number is required.'),
            'phone.min' => __('Phone number must be valid.'),
            'booking_date.required' => __('Date is required.'),
            'booking_date.after_or_equal' => __('Date must be today or in the future.'),
            'booking_time.required' => __('Time slot is required.'),
            'party_size.required' => __('Please select party size.'),
            'seating_area.required' => __('Please select seating area.'),
        ];
    }

    public function submit()
    {
        $this->validate();

        $booking = Booking::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
            'party_size' => $this->party_size,
            'seating_area' => $this->seating_area,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        try {
            \App\Services\WebPushService::sendNotification(
                'Yeni Masa Rezervasyonu! 🍽️',
                "{$this->name} - {$this->party_size} Kişi, Saat: {$this->booking_time}",
                url('/admin/bookings')
            );
        } catch (\Exception $e) {
            logger()->error('Failed to send push notification: ' . $e->getMessage());
        }

        $this->successMessage = true;

        // Reset form except success message
        $this->reset(['name', 'phone', 'email', 'booking_time', 'notes']);
        $this->booking_date = Carbon::today()->format('Y-m-d');
        $this->party_size = 2;
        $this->seating_area = 'garden';
    }

    public function render()
    {
        return view('livewire.booking-page')->layout('components.layouts.app', [
            'title' => __('Ehl-i Keyf Kaş | Rezervasyon Yap') . ' - ' . __('Table Booking'),
            'description' => __('Book your table at Ehl-i Keyf Kaş for an unforgettable Mediterranean tavern evening with nostalgic background music and delicious mezze.')
        ]);
    }
}
