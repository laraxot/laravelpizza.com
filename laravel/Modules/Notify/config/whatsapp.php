<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Default WhatsApp Driver
     * |--------------------------------------------------------------------------
     * |
     * | Supported drivers: "twilio", "vonage", "facebook", "360dialog"
     * |
     */
    'default' => env('WHATSAPP_DRIVER', 'twilio'),
    /*
     * |--------------------------------------------------------------------------
     * | WhatsApp Drivers
     * |--------------------------------------------------------------------------
     */
    'drivers' => [
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_WHATSAPP_FROM'),
        ],
        'vonage' => [
            'api_key' => env('VONAGE_KEY'),
            'api_secret' => env('VONAGE_SECRET'),
            'from' => env('VONAGE_WHATSAPP_FROM'),
        ],
        'facebook' => [
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'access_token' => env('FACEBOOK_ACCESS_TOKEN'),
            'phone_number_id' => env('FACEBOOK_PHONE_NUMBER_ID'),
        ],
        '360dialog' => [
            'api_key' => env('360DIALOG_API_KEY'),
            'phone_number_id' => env('360DIALOG_PHONE_NUMBER_ID'),
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Global Debug Mode
     * |--------------------------------------------------------------------------
     */
    'debug' => env('WHATSAPP_DEBUG', false),
    /*
     * |--------------------------------------------------------------------------
     * | WhatsApp Queue
     * |--------------------------------------------------------------------------
     */
    'queue' => env('WHATSAPP_QUEUE', 'default'),
    /*
     * |--------------------------------------------------------------------------
     * | Global Timeout
     * |--------------------------------------------------------------------------
     */
    'timeout' => env('WHATSAPP_TIMEOUT', 30),
    /*
     * |--------------------------------------------------------------------------
     * | Default Sender
     * |--------------------------------------------------------------------------
     */
    'from' => env('WHATSAPP_FROM'),
    /*
     * |--------------------------------------------------------------------------
     * | Retry Configuration
     * |--------------------------------------------------------------------------
     */
    'retry' => [
        'attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
        'delay' => env('WHATSAPP_RETRY_DELAY', 60),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Rate Limiting
     * |--------------------------------------------------------------------------
     */
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('WHATSAPP_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('WHATSAPP_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
];
