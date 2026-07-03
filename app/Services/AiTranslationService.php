<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiTranslationService
{
    protected ?string $provider = null;
    protected ?string $apiKey = null;
    protected ?string $model = null;

    public function __construct(?string $apiKey = null, ?string $provider = null, ?string $model = null)
    {
        $this->provider = $provider ?: \App\Models\Setting::getValue('ai_provider', 'gemini');
        
        if ($apiKey) {
            $this->apiKey = $apiKey;
        } else {
            $this->apiKey = $this->provider === 'openrouter' 
                ? \App\Models\Setting::getValue('openrouter_api_key') 
                : \App\Models\Setting::getValue('gemini_api_key');
        }

        $this->model = $model ?: \App\Models\Setting::getValue('openrouter_model', 'google/gemini-2.5-flash');
    }

    /**
     * Translate an array of text values from source (English/Turkish) to target language.
     * Uses batching to translate multiple strings in a single API call.
     */
    public function translateBatch(array $strings, string $targetLanguage): array
    {
        if (empty($strings)) {
            return [];
        }

        try {
            $prompt = "Translate the values of the following JSON dictionary from English/Turkish to {$targetLanguage}.\n";
            $prompt .= "Ensure translations reflect a premium, bohemian Mediterranean meyhane/restaurant aesthetic where appropriate.\n";
            $prompt .= "Return ONLY a valid JSON object matching the exact keys and structures of the input. Do not include markdown code block markers (like ```json) or explanation text. Only output the raw JSON string.\n";
            $prompt .= "Input JSON:\n" . json_encode($strings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            if ($this->provider === 'openrouter') {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->post("https://openrouter.ai/api/v1/chat/completions", [
                    'model' => $this->model ?: 'google/gemini-2.5-flash',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'response_format' => ['type' => 'json_object']
                ]);

                if ($response->failed()) {
                    Log::error("OpenRouter Translation API request failed: " . $response->body());
                    throw new \Exception("OpenRouter API error: " . ($response->json('error.message') ?? 'Unknown error'));
                }

                $resultText = $response->json('choices.0.message.content');
            } else {
                // Gemini API
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
                    Log::error("Gemini Translation API request failed: " . $response->body());
                    throw new \Exception("Gemini API error: " . ($response->json('error.message') ?? 'Unknown error'));
                }

                $resultText = $response->json('candidates.0.content.parts.0.text');
            }

            if (empty($resultText)) {
                throw new \Exception("Empty response from translation model.");
            }

            $decoded = json_decode(trim($resultText), true);
            if (!is_array($decoded)) {
                // Try to strip potential markdown codeblocks if model ignored instruction
                $cleanText = preg_replace('/^```json\s*/i', '', trim($resultText));
                $cleanText = preg_replace('/```$/', '', $cleanText);
                $decoded = json_decode(trim($cleanText), true);

                if (!is_array($decoded)) {
                    Log::error("Failed to parse translation output as JSON. Raw output: " . $resultText);
                    throw new \Exception("Failed to decode translation JSON from AI response.");
                }
            }

            return $decoded;

        } catch (\Throwable $e) {
            Log::error("AI Translation Batch Exception: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper to split a large array into chunks and translate each chunk.
     */
    public function translateLargeBatch(array $strings, string $targetLanguage, int $chunkSize = 30): array
    {
        $translated = [];
        $chunks = array_chunk($strings, $chunkSize, true);

        foreach ($chunks as $chunk) {
            $result = $this->translateBatch($chunk, $targetLanguage);
            $translated = array_merge($translated, $result);
            // Sleep briefly to avoid API rate limits
            usleep(200000); 
        }

        return $translated;
    }
}
