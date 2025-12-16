<?php

declare(strict_types=1);

return [
    'name' => 'Gdpr',
    'description' => 'Modulo per il Gdpr',
    // 'icon' => 'heroicon-o-clock',
    'icon' => 'gdpr-icon',
    'navigation' => [
        'enabled' => true,
        'sort' => 20,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Impostazioni Generali GDPR
     * |--------------------------------------------------------------------------
     * |
     * | Configurazioni base per la gestione della privacy e protezione dati
     * |
     */
    'enabled' => env('GDPR_ENABLED', true),
    /*
     * |--------------------------------------------------------------------------
     * | Cookie Policy
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per la gestione dei cookie e banner informativi
     * |
     */
    'cookie' => [
        'consent_lifetime' => env('GDPR_COOKIE_LIFETIME', 365), // giorni
        'categories' => [
            'necessary' => [
                'name' => 'Necessari',
                'description' => 'Cookie tecnici essenziali per il funzionamento del sito',
                'required' => true,
            ],
            'analytics' => [
                'name' => 'Analitici',
                'description' => 'Cookie per analisi statistiche anonime',
                'required' => false,
            ],
            'marketing' => [
                'name' => 'Marketing',
                'description' => 'Cookie per marketing e profilazione',
                'required' => false,
            ],
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Retention Policy
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione dei periodi di conservazione dei dati
     * |
     */
    'retention' => [
        'user_data' => [
            'personal' => 365 * 5, // 5 anni
            'logs' => 365, // 1 anno
            'documents' => 365 * 10, // 10 anni
        ],
        'insurance_data' => [
            'policies' => 365 * 10, // 10 anni dalla scadenza
            'claims' => 365 * 10, // 10 anni dalla chiusura
            'quotes' => 365 * 2, // 2 anni
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Registro dei Trattamenti
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per il registro delle attività di trattamento
     * |
     */
    'processing_register' => [
        'enabled' => true,
        'categories' => [
            'customer_management' => [
                'name' => 'Gestione Clienti',
                'purpose' => 'Gestione anagrafica e contrattuale clienti',
                'legal_basis' => 'contratto',
            ],
            'policy_management' => [
                'name' => 'Gestione Polizze',
                'purpose' => 'Gestione polizze assicurative',
                'legal_basis' => 'contratto',
            ],
            'claims_management' => [
                'name' => 'Gestione Sinistri',
                'purpose' => 'Gestione pratiche sinistri',
                'legal_basis' => 'contratto',
            ],
            'marketing' => [
                'name' => 'Marketing',
                'purpose' => 'Invio comunicazioni commerciali',
                'legal_basis' => 'consenso',
            ],
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Consensi Specifici Settore Assicurativo
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione dei consensi specifici richiesti nel settore assicurativo
     * |
     */
    'insurance_consents' => [
        'health_data' => [
            'code' => 'con1',
            'description' => 'Al trattamento dei dati particolari (ad esempio stato di salute) per le finalità relative all\'attività assicurativa (quali indicate al punto 1 del paragrafo Dati e finalità del trattamento), da parte del Titolare e degli altri soggetti sopraindicati sempre per le medesime finalità',
            'required' => true,
        ],
        'marketing_communications' => [
            'code' => 'con2',
            'description' => 'Al trattamento dei dati personali per finalità di marketing e commerciali effettuate dal Titolare (quali indicate al punto 3 del paragrafo Dati e finalità del trattamento), con modalità tradizionali e con modalità automatizzate di contatto',
            'required' => false,
        ],
        'profiling' => [
            'code' => 'con3',
            'description' => 'Al trattamento dei dati personali per finalità di profilazione effettuata dal Titolare (quali indicate al punto 4 del paragrafo Dati e finalità del trattamento), sia con l\'intervento umano sia in modalità automatizzata',
            'required' => false,
        ],
        'third_party_marketing' => [
            'code' => 'con4',
            'description' => 'Al trattamento dei dati personali per l\'invio per finalità di marketing effettuato dal Titolare, con modalità tradizionali e automatizzate di contatto',
            'required' => false,
        ],
        'group_marketing' => [
            'code' => 'con5',
            'description' => 'Al trattamento dei dati personali per finalità di marketing di altre Società del Gruppo nonché di soggetti appartenenti a determinate categorie merceologiche',
            'required' => false,
        ],
        'broker_marketing' => [
            'code' => 'con6',
            'description' => 'Al trattamento dei dati personali per finalità di marketing del Suo intermediario di riferimento',
            'required' => false,
        ],
        'soft_spam_opposition' => [
            'code' => 'con7',
            'description' => 'Dichiaro di oppormi al trattamento per finalità di marketing diretto nelle modalità del "soft spam"',
            'required' => false,
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Documenti Privacy
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione dei documenti privacy richiesti
     * |
     */
    'privacy_documents' => [
        'generali' => [
            'name' => 'Informativa Privacy Generali',
            'filename' => 'Informativa_Privacy_Generali.pdf',
            'required' => true,
        ],
        'broker' => [
            'name' => 'Informativa Privacy Oris Broker',
            'filename' => 'Informativa_Privacy_Oris_Broker.pdf',
            'required' => true,
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Diritti dell'Interessato
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione per la gestione delle richieste degli interessati
     * |
     */
    'data_subject_rights' => [
        'enabled' => true,
        'request_types' => [
            'access' => [
                'name' => 'Accesso',
                'description' => 'Richiesta di accesso ai dati personali',
                'response_days' => 30,
            ],
            'rectification' => [
                'name' => 'Rettifica',
                'description' => 'Richiesta di rettifica dei dati personali',
                'response_days' => 30,
            ],
            'erasure' => [
                'name' => 'Cancellazione',
                'description' => 'Richiesta di cancellazione dei dati personali',
                'response_days' => 30,
            ],
            'portability' => [
                'name' => 'Portabilità',
                'description' => 'Richiesta di portabilità dei dati',
                'response_days' => 30,
            ],
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Misure di Sicurezza
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione delle misure di sicurezza implementate
     * |
     */
    'security_measures' => [
        'encryption' => [
            'enabled' => true,
            'algorithm' => 'AES-256-CBC',
        ],
        'access_control' => [
            'enabled' => true,
            'max_attempts' => 5,
            'lockout_minutes' => 30,
        ],
        'logging' => [
            'enabled' => true,
            'events' => [
                'login',
                'logout',
                'data_access',
                'data_modification',
                'data_deletion',
            ],
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Data Protection Officer
     * |--------------------------------------------------------------------------
     * |
     * | Informazioni di contatto del DPO
     * |
     */
    'dpo' => [
        'name' => env('GDPR_DPO_NAME', ''),
        'email' => env('GDPR_DPO_EMAIL', ''),
        'phone' => env('GDPR_DPO_PHONE', ''),
    ],
];
