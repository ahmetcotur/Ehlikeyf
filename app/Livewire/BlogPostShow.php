<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostShow extends Component
{
    public $post;

    public function mount($slug)
    {
        $locales = array_keys(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales());
        foreach ($locales as $locale) {
            $this->post = BlogPost::where("slug->{$locale}", $slug)->first();
            if ($this->post) {
                app()->setLocale($locale);
                \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale($locale);
                return;
            }
        }

        throw new NotFoundHttpException();
    }

    public function render()
    {
        return view('livewire.blog-post-show', [
            'title' => $this->post->title,
            'description' => $this->post->description,
        ])->layout('components.layouts.app', [
            'title' => $this->post->title . ' - Ehl-i Keyf Meyhane Kaş',
            'description' => substr(strip_tags($this->post->description), 0, 160)
        ]);
    }
}
