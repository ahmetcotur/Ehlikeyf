<?php
namespace App\Livewire;

use App\Models\GalleryImage;
use Livewire\Component;

class Gallery extends Component
{
    public function render()
    {
        $images = GalleryImage::where('is_active', true)->orderBy('order_column')->get();
        
        return view('livewire.gallery', [
            'images' => $images
        ])->title(__('Gallery') . ' - Ehl-i Keyf Meyhane Kaş');
    }
}
