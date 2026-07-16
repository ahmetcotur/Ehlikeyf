<?php

namespace Tests\Unit;

use App\Models\BlogPost;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BlogPostImageUrlTest extends TestCase
{
    #[Test]
    public function uploaded_blog_images_are_served_from_public_storage(): void
    {
        config(['app.url' => 'https://ehlikeyfkas.com']);
        config(['filesystems.disks.public.url' => 'https://ehlikeyfkas.com/storage']);

        $post = new BlogPost(['image' => 'blog/example.webp']);

        $this->assertSame('https://ehlikeyfkas.com/storage/blog/example.webp', $post->image_url);
    }

    #[Test]
    public function existing_legacy_public_blog_images_keep_their_images_url(): void
    {
        config(['app.url' => 'https://ehlikeyfkas.com']);
        config(['filesystems.disks.public.url' => 'https://ehlikeyfkas.com/storage']);
        $path = public_path('images/blog/legacy-test.webp');

        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, 'legacy image fixture');

        try {
            $post = new BlogPost(['image' => 'blog/legacy-test.webp']);

            $this->assertSame('http://localhost/images/blog/legacy-test.webp', $post->image_url);
        } finally {
            @unlink($path);
        }
    }

    #[Test]
    public function absolute_blog_image_urls_are_left_unchanged(): void
    {
        $post = new BlogPost(['image' => 'https://cdn.example.com/blog/example.webp']);

        $this->assertSame('https://cdn.example.com/blog/example.webp', $post->image_url);
    }
}
