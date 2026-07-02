<?php

namespace App\Livewire;

use Livewire\Component;

class OurStory extends Component
{
    public function render()
    {
        return view('livewire.our-story')
            ->layout('components.layouts.app', [
                'title' => __('Our Story Title') . ' | Ehl-i Keyf Meyhane Kaş',
                'description' => __('Our Story Subtitle')
            ]);
    }
}
