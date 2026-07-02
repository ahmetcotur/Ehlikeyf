<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        $urls = [];

        // 1. Static Pages
        $staticRoutes = [
            'home' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'our-story' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'menu' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'gallery' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'contact' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'booking' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'blog.index' => ['priority' => '0.8', 'changefreq' => 'daily'],
            'privacy-policy' => ['priority' => '0.3', 'changefreq' => 'monthly'],
            'terms-of-service' => ['priority' => '0.3', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $route => $meta) {
            $localeUrls = [];
            foreach ($locales as $locale) {
                // Get localized URL using LaravelLocalization
                $localeUrls[$locale] = LaravelLocalization::getLocalizedURL($locale, route($route, [], false), [], true);
            }

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => $localeUrls[$locale],
                    'alternates' => $localeUrls,
                    'lastmod' => date('Y-m-d'),
                    'changefreq' => $meta['changefreq'],
                    'priority' => $meta['priority'],
                ];
            }
        }

        // 2. Menu Categories
        $categories = Category::whereNull('parent_id')->get();
        foreach ($categories as $category) {
            $localeUrls = [];
            foreach ($locales as $locale) {
                $catSlug = $category->getTranslation('slug', $locale);
                if ($catSlug) {
                    $localeUrls[$locale] = LaravelLocalization::getLocalizedURL($locale, "/menu/{$catSlug}", [], true);
                }
            }

            if (!empty($localeUrls)) {
                foreach ($localeUrls as $locale => $url) {
                    $urls[] = [
                        'loc' => $url,
                        'alternates' => $localeUrls,
                        'lastmod' => $category->updated_at->format('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            }

            // Subcategories
            foreach ($category->children as $sub) {
                $subLocaleUrls = [];
                foreach ($locales as $locale) {
                    $catSlug = $category->getTranslation('slug', $locale);
                    $subSlug = $sub->getTranslation('slug', $locale);
                    if ($catSlug && $subSlug) {
                        $subLocaleUrls[$locale] = LaravelLocalization::getLocalizedURL($locale, "/menu/{$catSlug}/{$subSlug}", [], true);
                    }
                }

                if (!empty($subLocaleUrls)) {
                    foreach ($subLocaleUrls as $locale => $url) {
                        $urls[] = [
                            'loc' => $url,
                            'alternates' => $subLocaleUrls,
                            'lastmod' => $sub->updated_at->format('Y-m-d'),
                            'changefreq' => 'weekly',
                            'priority' => '0.7',
                        ];
                    }
                }
            }
        }

        // 3. Blog Posts
        $posts = BlogPost::where('is_active', true)->get();
        foreach ($posts as $post) {
            $localeUrls = [];
            foreach ($locales as $locale) {
                $slug = $post->getTranslation('slug', $locale);
                if ($slug) {
                    $localeUrls[$locale] = url("/{$slug}");
                }
            }

            if (!empty($localeUrls)) {
                foreach ($localeUrls as $locale => $url) {
                    $urls[] = [
                        'loc' => $url,
                        'alternates' => $localeUrls,
                        'lastmod' => $post->updated_at->format('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                    ];
                }
            }
        }

        // Build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . PHP_EOL;

        foreach ($urls as $url) {
            $xml .= '    <url>' . PHP_EOL;
            $xml .= '        <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
            foreach ($url['alternates'] as $lang => $altUrl) {
                $xml .= '        <xhtml:link rel="alternate" hreflang="' . htmlspecialchars($lang) . '" href="' . htmlspecialchars($altUrl) . '"/>' . PHP_EOL;
            }
            $xml .= '        <lastmod>' . htmlspecialchars($url['lastmod']) . '</lastmod>' . PHP_EOL;
            $xml .= '        <changefreq>' . htmlspecialchars($url['changefreq']) . '</changefreq>' . PHP_EOL;
            $xml .= '        <priority>' . htmlspecialchars($url['priority']) . '</priority>' . PHP_EOL;
            $xml .= '    </url>' . PHP_EOL;
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'max-age=3600, public',
        ]);
    }
}
