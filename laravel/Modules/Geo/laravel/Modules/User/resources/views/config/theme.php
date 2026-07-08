<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Configurazione del Tema One
     * |--------------------------------------------------------------------------
     * |
     * | Questo file contiene la configurazione del tema One.
     * |
     */

    'name' => 'One',
    'description' => 'Tema predefinito per il progetto',
    'version' => '1.0.0',
    /*
     * |--------------------------------------------------------------------------
     * | Percorsi
     * |--------------------------------------------------------------------------
     * |
     * | Questi percorsi sono utilizzati per caricare le viste e gli assets del tema.
     * |
     */

    'paths' => [
        'views' => 'resources/views',
        'assets' => 'assets',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Blocchi
     * |--------------------------------------------------------------------------
     * |
     * | Questi blocchi sono disponibili nel tema.
     * |
     */

    'blocks' => [
        'hero',
        'feature_sections',
        'team',
        'stats',
        'cta',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Integrazione con il Modulo CMS
     * |--------------------------------------------------------------------------
     * |
     * | Questa sezione contiene la configurazione per l'integrazione con il modulo CMS.
     * |
     */

    'cms' => [
        'content_path' => 'laravel/config/local/<nome progetto>/database/content/pages',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Integrazione con Laravel Folio
     * |--------------------------------------------------------------------------
     * |
     * | Questa sezione contiene la configurazione per l'integrazione con Laravel Folio.
     * |
     */

    'folio' => [
        'pages_path' => 'resources/views/pages',
    ],
];
