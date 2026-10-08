<?php

return [
    'provider' => env('AI_PROVIDER', 'openai'),

    'providers' => [
        'openai' => [
            'base_url' => env('AI_OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'key' => env('AI_OPENAI_KEY'),
            'model' => env('AI_OPENAI_MODEL', 'gpt-4o-mini'),
        ],
    ],

    'timeout' => env('AI_TIMEOUT', 60),
    'max_tokens' => env('AI_MAX_TOKENS', 1024),
    'log_channel' => env('AI_LOG_CHANNEL', 'stack'),
];
