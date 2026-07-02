<?php

namespace App\Livewire;

use Livewire\Component;

class StaticPage extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $title = $this->slug === 'privacy-policy' ? __('Privacy Policy') : __('Terms of Service');
        return view('livewire.static-page')->layout('components.layouts.app', ['title' => $title . ' - Ehl-i Keyf Meyhane Kaş']);
    }
}
