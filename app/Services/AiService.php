<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Shared AI service layer — one integration used by Coach, Assistant and
 * Creator. Provider, prompts, limits and logging live in config/ai.php so
 * every Block consumes the same plumbing.
 */
class AiService
{
    public function chat(array $messages, ?array $options = []): ?string
    {
        $provider = config('ai.provider', 'openai');
        $key = config("ai.providers.{$provider}.key");
        $base = rtrim(config("ai.providers.{$provider}.base_url", ''), '/');
        $model = $options['model'] ?? config("ai.providers.{$provider}.model", 'gpt-4o-mini');

        if (! $key || ! $base) {
            Log::warning('ai.chat skipped — provider not configured', ['provider' => $provider]);

            return null;
        }

        $start = microtime(true);

        try {
            $response = Http::withToken($key)
                ->timeout((int) config('ai.timeout', 60))
                ->post($base.'/chat/completions', array_filter([
                    'model' => $model,
                    'messages' => $messages,
                    'response_format' => ($options['json'] ?? false) ? ['type' => 'json_object'] : null,
                    'max_tokens' => $options['max_tokens'] ?? config('ai.max_tokens', 1024),
                    'temperature' => $options['temperature'] ?? 0.4,
                ]));
        } catch (\Throwable $e) {
            Log::error('ai.chat failed', ['error' => $e->getMessage()]);

            return null;
        }

        $latency = (int) ((microtime(true) - $start) * 1000);
        $content = $response->json('choices.0.message.content');
        $usage = $response->json('usage', []);

        Log::channel(config('ai.log_channel', 'stack'))->info('ai.chat', [
            'provider' => $provider,
            'model' => $model,
            'latency_ms' => $latency,
            'tokens' => $usage['total_tokens'] ?? null,
            'ok' => $response->ok(),
        ]);

        return $response->ok() ? $content : null;
    }

    public function complete(string $system, string $prompt, array $options = []): ?string
    {
        return $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $prompt],
        ], $options);
    }
}
