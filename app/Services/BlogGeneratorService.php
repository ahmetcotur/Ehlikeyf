<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Setting;
use App\Services\AiTranslationService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogGeneratorService
{
    protected ?string $apiKey;

    public function __construct()
    {
        // Load API key from settings
        $savedKey = Setting::where('key', 'gemini_api_key')->first();
        if ($savedKey) {
            $translations = $savedKey->getTranslations('value');
            $this->apiKey = $translations['en'] ?? $translations['tr'] ?? $savedKey->value ?? null;
        } else {
            $this->apiKey = null;
        }
    }

    /**
     * Generate an original blog post using Gemini, and translate it to all active locales.
     */
    public function generateAndSavePost(string $topics, string $tone): BlogPost
    {
        if (empty($this->apiKey)) {
            throw new \Exception("Gemini API Key is not set in Settings.");
        }

        Log::info("Starting AI Blog Generation. Topics: {$topics}, Tone: {$tone}");

        // 1. Generate post in Turkish (base language)
        $prompt = "You are a professional content creator and copywriter for 'Ehl-i Keyf', a bohemian, premium Mediterranean meyhane/restaurant located in Kaş, Antalya.\n";
        $prompt .= "Generate an original, engaging, and atmospheric blog post in Turkish.\n";
        $prompt .= "Topics/Keywords to cover: {$topics}\n";
        $prompt .= "Tone of voice: {$tone} (warm, authentic, gourmet storytelling, bohem, Kaş peninsula vibe)\n\n";
        $prompt .= "Make sure the content is detailed, with 4-5 descriptive paragraphs using appropriate HTML formatting (such as <h2>, <h3>, <p>, <strong>, and <ul> list tags if needed).\n";
        $prompt .= "Return ONLY a valid JSON object matching the exact keys below. Do not include markdown code block markers (like ```json) or explanation text. Only output the raw JSON string.\n";
        $prompt .= "JSON Format:\n";
        $prompt .= "{\n";
        $prompt .= "  \"title\": \"Blog post title (e.g. Kaş Akşamlarının Bohem Ruhu ve Meyhane Kültürü)\",\n";
        $prompt .= "  \"description\": \"A short meta description (1-2 sentences) summarizing the article\",\n";
        $prompt .= "  \"content\": \"The full blog article content in rich HTML.\"\n";
        $prompt .= "}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
            ]
        ]);

        if ($response->failed()) {
            Log::error("Gemini Blog Generator failed: " . $response->body());
            throw new \Exception("Gemini API error: " . ($response->json('error.message') ?? 'Unknown error'));
        }

        $resultText = $response->json('candidates.0.content.parts.0.text');
        if (empty($resultText)) {
            throw new \Exception("Empty response from Gemini blog generator model.");
        }

        $decoded = json_decode(trim($resultText), true);
        if (!is_array($decoded)) {
            $cleanText = preg_replace('/^```json\s*/i', '', trim($resultText));
            $cleanText = preg_replace('/```$/', '', $cleanText);
            $decoded = json_decode(trim($cleanText), true);

            if (!is_array($decoded)) {
                Log::error("Failed to parse Gemini blog generation output as JSON. Raw output: " . $resultText);
                throw new \Exception("Failed to decode blog content JSON from AI response.");
            }
        }

        $title = $decoded['title'] ?? 'Ehl-i Keyf Serüvenleri';
        $description = $decoded['description'] ?? 'Ehl-i Keyf Kaş blog yazıları.';
        $content = $decoded['content'] ?? '<p>Lezzetli Akdeniz sofralarında buluşmak dileğiyle...</p>';

        // 2. Create the blog post model in Turkish
        $post = new BlogPost();
        $post->setTranslation('title', 'tr', $title);
        $post->setTranslation('slug', 'tr', Str::slug($title));
        $post->setTranslation('description', 'tr', $description);
        $post->setTranslation('content', 'tr', $content);
        
        $post->published_at = now();
        $post->is_active = true;

        // Choose a beautiful default image from the gallery so the post doesn't look empty
        // We'll look for any WebP file in gallery or use a placeholder
        $post->image = 'gallery/029A8076.webp'; // standard beautiful authentic Ehl-i Keyf table setup
        
        $post->save();

        Log::info("AI Blog Post saved in Turkish. ID: {$post->id}. Starting translations.");

        // 3. Automatically translate to other active languages in the system
        $locales = config('laravellocalization.supportedLocales') ?? [];
        $translator = new AiTranslationService($this->apiKey);

        foreach ($locales as $code => $properties) {
            if ($code === 'tr') {
                continue;
            }

            try {
                $langName = $properties['name'] ?? $code;
                
                // Translate Title, Description, and Content in one batch to save tokens/time
                $batch = [
                    'title' => $title,
                    'description' => $description,
                    'content' => $content,
                ];

                // Translate batch
                $translatedBatch = $translator->translateBatch($batch, $langName);

                $tTitle = $translatedBatch['title'] ?? $title;
                $tDesc = $translatedBatch['description'] ?? $description;
                $tContent = $translatedBatch['content'] ?? $content;

                $post->setTranslation('title', $code, $tTitle);
                $post->setTranslation('slug', $code, Str::slug($tTitle));
                $post->setTranslation('description', $code, $tDesc);
                $post->setTranslation('content', $code, $tContent);
                
                Log::info("Translated AI Blog Post to {$code}");

            } catch (\Throwable $e) {
                Log::error("Failed to translate blog post {$post->id} to {$code}: " . $e->getMessage());
                // Fallback to Turkish values so the pages don't break
                $post->setTranslation('title', $code, $title);
                $post->setTranslation('slug', $code, Str::slug($title) . '-' . $code);
                $post->setTranslation('description', $code, $description);
                $post->setTranslation('content', $code, $content);
            }
        }

        $post->save();

        Log::info("AI Blog Post generation and translation completed successfully. ID: {$post->id}");

        return $post;
    }
}
