<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Settings',
    'fields' => [
        'free_models_only' => [
            'label' => 'Free models only',
            'placeholder' => '',
            'helper_text' => 'When on, paid models are dropped before any call (OpenRouter: only :free and openrouter/free).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_providers' => [
            'label' => 'Image providers',
            'placeholder' => '',
            'helper_text' => 'In order: if the first one fails the next is tried (groq, openrouter).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_models' => [
            'label' => 'Image models',
            'placeholder' => '',
            'helper_text' => 'Per provider; several models separated by commas (OpenRouter tries them in order).',
            'tooltip' => '',
            'description' => '',
        ],
        'vision_timeout' => [
            'label' => 'Image timeout (seconds)',
            'placeholder' => '',
            'helper_text' => 'Maximum wait to read a photo.',
            'tooltip' => '',
            'description' => '',
        ],
        'image_model' => [
            'label' => 'Image editing model',
            'placeholder' => '',
            'helper_text' => 'OpenRouter only. No free model generates images.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_providers' => [
            'label' => 'Assistant providers',
            'placeholder' => '',
            'helper_text' => 'In order: if the first one fails the next is tried.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_models' => [
            'label' => 'Assistant models',
            'placeholder' => '',
            'helper_text' => 'Text model per provider.',
            'tooltip' => '',
            'description' => '',
        ],
        'assistant_timeout' => [
            'label' => 'Assistant timeout (seconds)',
            'placeholder' => '',
            'helper_text' => 'Maximum wait for a chat answer.',
            'tooltip' => '',
            'description' => '',
        ],
        'model' => [
            'label' => 'Completion model',
            'placeholder' => 'gpt-3.5-turbo-instruct',
            'helper_text' => 'Model used to generate predictions (GeneratePredictionsAction).',
            'tooltip' => '',
            'description' => '',
        ],
        'chat_model' => [
            'label' => 'Chat model',
            'placeholder' => 'gpt-4o-mini',
            'helper_text' => 'Model used for prediction drafts (GeneratePredictionDraftsAction).',
            'tooltip' => '',
            'description' => '',
        ],
        'temperature' => [
            'label' => 'Predictions temperature',
            'placeholder' => '0.7',
            'helper_text' => 'Randomness of predictions: from 0 (deterministic) to 2.',
            'tooltip' => '',
            'description' => '',
        ],
        'chat_temperature' => [
            'label' => 'Drafts temperature',
            'placeholder' => '0.6',
            'helper_text' => 'Randomness of prediction drafts: from 0 (deterministic) to 2.',
            'tooltip' => '',
            'description' => '',
        ],
        'max_tokens' => [
            'label' => 'Max tokens per prediction',
            'placeholder' => '1500',
            'helper_text' => 'Maximum length of the generated answer for predictions.',
            'tooltip' => '',
            'description' => '',
        ],
        'timeout' => [
            'label' => 'Request timeout (seconds)',
            'placeholder' => '30',
            'helper_text' => 'Maximum wait for each ticket classification and suggestion request.',
            'tooltip' => '',
            'description' => '',
        ],
        'retry_attempts' => [
            'label' => 'Attempts per request',
            'placeholder' => '3',
            'helper_text' => 'How many times a failed ticket request is retried, with growing waits between attempts.',
            'tooltip' => '',
            'description' => '',
        ],
        'openai_base_url' => [
            'label' => 'API base URL',
            'placeholder' => 'https://api.openai.com/v1',
            'helper_text' => 'Address of the OpenAI-compatible API used for tickets, without trailing slash. The API key stays in the .env file.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Save',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Save',
        ],
        'profile' => [
            'label' => 'Profile',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profile',
        ],
        'logout' => [
            'label' => 'Log out',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Log out',
        ],
    ],
];
