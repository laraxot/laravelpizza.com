<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Default SMS Driver
     * |--------------------------------------------------------------------------
     * |
     * | This option controls the default SMS driver that will be used when
     * | sending SMS messages. Supported drivers: "smsfactor", "twilio", "nexmo",
     * | "plivo", "gammu", "netfun"
     * |
     */

    'default' => env('SMS_DRIVER', 'smsfactor'),
    /*
     * |--------------------------------------------------------------------------
     * | SMS Drivers
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the SMS drivers for your application. Out of
     * | the box, Laravel supports several drivers including SMSFactor, Twilio,
     * | Nexmo, Plivo, and Gammu.
     * |
     */

    'drivers' => [
        'smsfactor' => [
            'token' => env('SMSFACTOR_TOKEN'),
            'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        ],
        'nexmo' => [
            'key' => env('NEXMO_KEY'),
            'secret' => env('NEXMO_SECRET'),
        ],
        'plivo' => [
            'auth_id' => env('PLIVO_AUTH_ID'),
            'auth_token' => env('PLIVO_AUTH_TOKEN'),
        ],
        'gammu' => [
            'path' => env('GAMMU_PATH', '/usr/bin/gammu'),
            'config' => env('GAMMU_CONFIG', '/etc/gammurc'),
        ],
        'netfun' => [
            // Token API fornito da Netfun (obbligatorio)
            'token' => env('NETFUN_TOKEN'),
            // Endpoint REST ufficiale Netfun (batch)
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
            // Opzionale: callback per report di consegna
            // 'callback_url' => env('NETFUN_CALLBACK_URL'),
            // Circuit breaker specifico per Netfun (se necessario)
            'circuit_breaker' => [
                'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
                'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
            ],
        ],
        'agiletelecom' => [
            'username' => env('AGILETELECOM_USERNAME'),
            'password' => env('AGILETELECOM_PASSWORD'),
            'sender' => env('AGILETELECOM_SENDER', 'MyApp'),
            'endpoint' => env('AGILETELECOM_API_URL', 'https://secure.agiletelecom.com/services/sms/send'),
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Global Debug Mode
     * |--------------------------------------------------------------------------
     * |
     * | Enable or disable debug mode for all SMS drivers. This will log
     * | detailed information about SMS sending attempts and responses.
     * |
     */

    'debug' => env('SMS_DEBUG', false),
    /*
     * |--------------------------------------------------------------------------
     * | SMS Queue
     * |--------------------------------------------------------------------------
     * |
     * | This option allows you to specify the queue that should be used for
     * | sending SMS messages. This is useful for handling large volumes of
     * | SMS messages without blocking your application.
     * |
     */

    'queue' => env('SMS_QUEUE', 'default'),
    /*
     * |--------------------------------------------------------------------------
     * | SMS Retry Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the retry settings for failed SMS messages.
     * | You can specify the number of retries and the delay between retries.
     * |
     */

    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Rate Limiting
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the rate limiting settings for SMS messages.
     * | This helps prevent abuse and ensures fair usage of the SMS service.
     * |
     */

    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Circuit Breaker
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the circuit breaker settings for SMS messages.
     * | This helps prevent cascading failures when the SMS service is down.
     * |
     */

    'circuit_breaker' => [
        'enabled' => env('SMS_CIRCUIT_BREAKER_ENABLED', true),
        'threshold' => env('SMS_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('SMS_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Timeout
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the timeout settings for SMS messages.
     * | This helps prevent hanging requests when the SMS service is slow.
     * |
     */

    'timeout' => env('SMS_TIMEOUT', 30),
    /*
     * |--------------------------------------------------------------------------
     * | SMS Logging
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the logging settings for SMS messages.
     * | This helps track the delivery status and troubleshoot issues.
     * |
     */

    'logging' => [
        'enabled' => env('SMS_LOGGING_ENABLED', true),
        'channel' => env('SMS_LOGGING_CHANNEL', 'stack'),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Validation
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the validation settings for phone numbers.
     * | This helps ensure that only valid phone numbers are used.
     * |
     */

    'validation' => [
        'enabled' => env('SMS_VALIDATION_ENABLED', true),
        'pattern' => env('SMS_VALIDATION_PATTERN', '/^\+[1-9]\d{1,14}$/'),
    ],
];
