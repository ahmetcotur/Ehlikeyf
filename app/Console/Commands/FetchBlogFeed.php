<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use SimpleXMLElement;
use Illuminate\Support\Facades\Http;

class FetchBlogFeed extends Command
{
    protected $signature = 'blog:fetch';
    protected $description = 'Fetches blog posts from Ehl-i Keyfkas.com.tr/feed and saves them locally';

    public function handle()
    {
        $this->info("Fetching RSS feed...");
        
        try {
            $response = Http::timeout(20)->get('https://Ehl-i Keyfkas.com.tr/feed/');
            if (!$response->successful()) {
                $this->error("Failed to fetch RSS feed");
                return 1;
            }

            $xml = new SimpleXMLElement($response->body());
            $namespaces = $xml->getNamespaces(true);
            
            $count = 0;
            foreach ($xml->channel->item as $item) {
                // Find image
                $imageUrl = null;
                $contentEncoded = '';
                
                if (isset($namespaces['content'])) {
                    $contentEncoded = (string) $item->children($namespaces['content'])->encoded;
                }

                if (isset($item->enclosure) && isset($item->enclosure['url'])) {
                    $imageUrl = (string) $item->enclosure['url'];
                } elseif (isset($namespaces['media']) && $media = $item->children($namespaces['media'])) {
                    if (isset($media->content) && isset($media->content->attributes()->url)) {
                        $imageUrl = (string) $media->content->attributes()->url;
                    }
                }
                if (!$imageUrl && $contentEncoded) {
                    preg_match('/<img[^>]+src="([^">]+)"/', $contentEncoded, $matches);
                    if (isset($matches[1])) {
                        $imageUrl = $matches[1];
                    }
                }

                // Download image if exists
                $localImagePath = null;
                if ($imageUrl) {
                    $filename = basename($imageUrl);
                    // Handle query strings in filename
                    $filename = explode('?', $filename)[0];
                    $path = public_path('images/blog/' . $filename);
                    
                    if (!is_dir(public_path('images/blog'))) {
                        mkdir(public_path('images/blog'), 0777, true);
                    }

                    if (!file_exists($path)) {
                        $this->info("Downloading image: $filename");
                        $imgData = @file_get_contents($imageUrl);
                        if ($imgData !== false) {
                            file_put_contents($path, $imgData);
                            $localImagePath = 'blog/' . $filename;
                        }
                    } else {
                        $localImagePath = 'blog/' . $filename;
                    }
                }

                $title = (string) $item->title;
                $slug = Str::slug($title);
                // Ensure slug is unique enough or exactly matches the old URL ending if possible
                $originalLink = (string) $item->link;
                
                // Try to extract exact slug from link
                $pathInfo = parse_url($originalLink, PHP_URL_PATH);
                if ($pathInfo) {
                    $extractedSlug = trim($pathInfo, '/');
                    if ($extractedSlug && $extractedSlug !== 'blog') {
                       $slug = $extractedSlug;
                    }
                }

                // Description
                $description = strip_tags((string) $item->description);
                $description = html_entity_decode($description);

                // Create or update
                BlogPost::updateOrCreate(
                    ['original_link' => $originalLink],
                    [
                        'title' => ['tr' => $title, 'en' => $title], // Assuming source is TR, will copy to EN
                        'slug' => ['tr' => $slug, 'en' => $slug],
                        'description' => ['tr' => $description, 'en' => $description],
                        'content' => ['tr' => $contentEncoded, 'en' => $contentEncoded],
                        'image' => $localImagePath,
                        'published_at' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                        'is_active' => true,
                    ]
                );
                
                $count++;
            }
            
            $this->info("Successfully imported $count blog posts.");

        } catch (\Exception $e) {
            $this->error("Error extracting feed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
