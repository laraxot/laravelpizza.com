<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Base Localizzazione
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione principale per il sistema di localizzazione
     * | del modulo Lang. Segue i principi DRY + KISS + SOLID.
     * |
     */

    'default_locale' => env('APP_LOCALE', 'it'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'available_locales' => ['it', 'en', 'de'],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Cache e Performance
     * |--------------------------------------------------------------------------
     * |
     * | Ottimizzazioni per performance e scalabilità
     * |
     */

    'cache' => [
        'enabled' => env('LANG_CACHE_ENABLED', true),
        'ttl' => env('LANG_CACHE_TTL', 3600), // 1 ora
        'prefix' => 'lang_translations',
        'compression' => env('LANG_CACHE_COMPRESSION', true),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Validazione
     * |--------------------------------------------------------------------------
     * |
     * | Sistema di validazione e controllo qualità traduzioni
     * |
     */

    'validation' => [
        'enabled' => env('LANG_VALIDATION_ENABLED', true),
        'strict_mode' => env('LANG_STRICT_MODE', false),
        'auto_fix' => env('LANG_AUTO_FIX', false),
        'report_missing_keys' => env('LANG_REPORT_MISSING', true),
        'quality_threshold' => env('LANG_QUALITY_THRESHOLD', 95), // %
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Auto-Translation
     * |--------------------------------------------------------------------------
     * |
     * | Integrazione con servizi di traduzione automatica
     * |
     */

    'auto_translate' => [
        'enabled' => env('LANG_AUTO_TRANSLATE', false),
        'provider' => env('LANG_TRANSLATION_PROVIDER', 'google'),
        'api_key' => env('LANG_TRANSLATION_API_KEY'),
        'fallback_chain' => [
            'it' => ['en', 'de'],
            'de' => ['en', 'it'],
            'en' => ['it', 'de'],
        ],
        'quality_check' => env('LANG_AUTO_QUALITY_CHECK', true),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Filament Integration
     * |--------------------------------------------------------------------------
     * |
     * | Integrazione specifica con Filament UI
     * |
     */

    'filament' => [
        'auto_labels' => env('LANG_FILAMENT_AUTO_LABELS', true),
        'auto_placeholders' => env('LANG_FILAMENT_AUTO_PLACEHOLDERS', true),
        'auto_help_text' => env('LANG_FILAMENT_AUTO_HELP', true),
        'component_prefix' => env('LANG_FILAMENT_PREFIX', ''),
        'fallback_to_key' => env('LANG_FILAMENT_FALLBACK_KEY', false),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Struttura File
     * |--------------------------------------------------------------------------
     * |
     * | Standardizzazione struttura file traduzioni
     * |
     */

    'structure' => [
        'required_files' => [
            'fields.php',
            'actions.php',
            'messages.php',
            'validation.php',
        ],
        'optional_files' => [
            'navigation.php',
            'errors.php',
            'notifications.php',
            'emails.php',
        ],
        'naming_convention' => 'snake_case',
        'array_syntax' => 'short', // [] invece di array()
        'strict_types' => true,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Debug e Logging
     * |--------------------------------------------------------------------------
     * |
     * | Strumenti per sviluppo e troubleshooting
     * |
     */

    'debug' => [
        'enabled' => env('LANG_DEBUG', false),
        'log_missing_keys' => env('LANG_LOG_MISSING', true),
        'log_performance' => env('LANG_LOG_PERFORMANCE', false),
        'log_channel' => env('LANG_LOG_CHANNEL', 'translations'),
        'show_keys_in_production' => env('LANG_SHOW_KEYS_PROD', false),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Performance
     * |--------------------------------------------------------------------------
     * |
     * | Ottimizzazioni avanzate per performance
     * |
     */

    'performance' => [
        'lazy_loading' => env('LANG_LAZY_LOADING', true),
        'memory_optimization' => env('LANG_MEMORY_OPT', true),
        'batch_loading' => env('LANG_BATCH_LOADING', true),
        'preload_common_keys' => env('LANG_PRELOAD_COMMON', true),
        'compression_level' => env('LANG_COMPRESSION_LEVEL', 6),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Sicurezza
     * |--------------------------------------------------------------------------
     * |
     * | Protezioni e validazioni di sicurezza
     * |
     */

    'security' => [
        'validate_file_integrity' => env('LANG_VALIDATE_INTEGRITY', true),
        'max_file_size' => env('LANG_MAX_FILE_SIZE', 1024 * 1024), // 1MB
        'allowed_extensions' => ['php'],
        'scan_for_malicious_code' => env('LANG_SCAN_MALICIOUS', true),
        'rate_limiting' => env('LANG_RATE_LIMITING', true),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Business Logic
     * |--------------------------------------------------------------------------
     * |
     * | Regole specifiche per logica di business
     * |
     */

    'business' => [
        'enforce_naming_conventions' => true,
        'require_context_in_keys' => true,
        'validate_business_terms' => true,
        'consistency_check' => true,
        'domain_specific_validation' => true,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Laraxot Integration
     * |--------------------------------------------------------------------------
     * |
     * | Integrazione specifica con framework Laraxot
     * |
     */

    'laraxot' => [
        'module_auto_discovery' => true,
        'shared_translations' => true,
        'cross_module_validation' => true,
        'unified_naming' => true,
        'framework_compliance' => true,
    ],
];
