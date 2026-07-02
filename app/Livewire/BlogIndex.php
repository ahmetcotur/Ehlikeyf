<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = BlogPost::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('livewire.blog-index', [
            'posts' => $posts
        ])->layout('components.layouts.app', [
            'title' => __('Journal & Stories') . ' | Ehl-i Keyf Meyhane Kaş',
            'description' => __('Discover the latest news, recipes, and stories from the heart of the Mediterranean.')
        ]);
    }
}
