<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    |
    | The default model to use for completions.
    */
    'model' => config('services.openai.model', 'gpt-3.5-turbo-instruct'),

    /*
    |--------------------------------------------------------------------------
    | Chat Model
    |--------------------------------------------------------------------------
    |
    | The default model to use for chat completions.
    */
    'chat_model' => config('services.openai.chat_model', 'gpt-3.5-turbo'),

    /*
    |--------------------------------------------------------------------------
    | Temperature
    |--------------------------------------------------------------------------
    |
    | Controls randomness in outputs. Lower values are more deterministic.
    | Range: 0.0 - 2.0
    */
    'temperature' => config('services.openai.temperature', 0.7),

    /*
    |--------------------------------------------------------------------------
    | Max Tokens
    |--------------------------------------------------------------------------
    |
    | Maximum number of tokens to generate in the completion.
    */
    'max_tokens' => config('services.openai.max_tokens', 1500),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configuration for rate limiting API calls.
    */
    'rate_limit' => [
        'max_predictions_per_request' => is_numeric(config('services.openai.max_predictions', 100))
            ? (int) config('services.openai.max_predictions', 100)
            : 100,
        'delay_between_calls_ms' => is_numeric(config('services.openai.delay_ms', 1000))
            ? (int) config('services.openai.delay_ms', 1000)
            : 1000,
        'timeout_seconds' => is_numeric(config('services.openai.timeout', 30))
            ? (int) config('services.openai.timeout', 30)
            : 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable or disable logging for AI operations.
    */
    'logging' => config('services.openai.logging', true),

];
