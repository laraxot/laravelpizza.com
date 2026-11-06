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
