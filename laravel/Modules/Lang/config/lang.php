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

    // `default_locale` e `available_locales` non li leggeva nessuno: le lingue dell'editor delle
    // traduzioni sono in `Modules\Lang\Datas\LangConfigData` (SettingPage), un'unica definizione.
    'fallback_locale' => 'en',
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione Cache e Performance
     * |--------------------------------------------------------------------------
     * |
     * | Ottimizzazioni per performance e scalabilità
     * |
     */

    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 ora
        'prefix' => 'lang_translations',
        'compression' => true,
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
        'enabled' => true,
        'strict_mode' => false,
        'auto_fix' => false,
        'report_missing_keys' => true,
        'quality_threshold' => 95, // %
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
        'enabled' => false,
        'provider' => 'google',
        'api_key' => null,
        'fallback_chain' => [
            'it' => ['en', 'de'],
            'de' => ['en', 'it'],
            'en' => ['it', 'de'],
        ],
        'quality_check' => true,
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
        'auto_labels' => true,
        'auto_placeholders' => true,
        'auto_help_text' => true,
        'component_prefix' => '',
        'fallback_to_key' => false,
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
        'enabled' => false,
        'log_missing_keys' => true,
        'log_performance' => false,
        'log_channel' => 'translations',
        'show_keys_in_production' => false,
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
        'lazy_loading' => true,
        'memory_optimization' => true,
        'batch_loading' => true,
        'preload_common_keys' => true,
        'compression_level' => 6,
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
        'validate_file_integrity' => true,
        'max_file_size' => 1024 * 1024, // 1MB
        'allowed_extensions' => ['php'],
        'scan_for_malicious_code' => true,
        'rate_limiting' => true,
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

    /*
     * |--------------------------------------------------------------------------
     * | Scrittura delle chiavi mancanti
     * |--------------------------------------------------------------------------
     * |
     * | Quando AutoLabelAction non trova una chiave, SaveTransAction la scrive nel
     * | file di lingua del modulo. E' comodo mentre si sviluppa e dannoso durante i
     * | test: la suite tocca migliaia di etichette e riscrive l'albero di lavoro,
     * | lasciando in `git status` file che nessuno ha modificato a mano.
     * |
     * | Solo default: niente env() nei config di modulo (Larastan lo vieta fuori
     * | dal config/ di root). Lo spegnimento reale sotto test non passa da qui:
     * | SaveTransAction legge Config::get('lang.save_missing_translations',
     * | ! app()->runningUnitTests()), e la config di modulo non e' comunque
     * | caricata nell'app dei test.
     * |
     */

    'save_missing_translations' => true,
];
