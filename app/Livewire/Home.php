<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home')->layout('components.layouts.app', [
            'title' => __('Ehl-i Keyf Meyhane Kaş | Ehl-i biziz. Keyfini siz sürün.'),
            'description' => __('Ehl-i Keyf Kaş in Kaş, Antalya. Fresh Mediterranean seafood, traditional Turkish mezze, and unforgettable sunset views.')
        ]);
    }
}
