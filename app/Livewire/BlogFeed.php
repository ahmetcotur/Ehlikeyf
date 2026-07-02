<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use Exception;
use Illuminate\Support\Facades\Log;

class BlogFeed extends Component
{
    public $posts = [];
    public $error = false;

    public function mount()
    {
        $this->loadFeed();
    }

    public function loadFeed()
    {
        try {
            // Fetch latest 3 active posts from database
            $dbPosts = BlogPost::where('is_active', true)
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get();
            
            $items = [];
            foreach ($dbPosts as $post) {
                $description = strip_tags((string) $post->description);
                $description = html_entity_decode($description);
                if (mb_strlen($description) > 120) {
                    $description = mb_substr($description, 0, 117) . '...';
                }

                $items[] = [
                    'title' => $post->title,
                    'link' => url('/' . $post->slug),
                    'date' => $post->published_at ? $post->published_at->format('M d, Y') : '',
                    'description' => $description,
                    'image' => $post->image, 
                ];
            }

            $this->posts = $items;

        } catch (Exception $e) {
            Log::error('BlogFeed Error: ' . $e->getMessage());
            $this->error = true;
            $this->posts = [];
        }
    }

    public function render()
    {
        return view('livewire.blog-feed');
    }
}
