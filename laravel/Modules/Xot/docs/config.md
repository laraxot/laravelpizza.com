# Configurazione in il progetto

La configurazione del tema è gestita attraverso file di configurazione che definiscono le impostazioni del tema.

## Struttura della Configurazione

La configurazione è organizzata in:

```
config/
├── theme.php
└── components/
    ├── blocks.php
    ├── forms.php
    └── ui.php
```

## Configurazione del Tema

### theme.php
```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nome del Tema
    |--------------------------------------------------------------------------
    |
    | Nome del tema corrente.
    |
    */
    'name' => 'One',

    /*
    |--------------------------------------------------------------------------
    | Descrizione del Tema
    |--------------------------------------------------------------------------
    |
    | Breve descrizione del tema.
    |
    */
    'description' => 'Tema One per il progetto',

    /*
    |--------------------------------------------------------------------------
    | Versione del Tema
    |--------------------------------------------------------------------------
    |
    | Versione corrente del tema.
    |
    */
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Autore del Tema
    |--------------------------------------------------------------------------
    |
    | Nome dell'autore del tema.
    |
    */
    'author' => 'il progetto Team',

    /*
    |--------------------------------------------------------------------------
    | Percorso del Tema
    |--------------------------------------------------------------------------
    |
    | Percorso base del tema.
    |
    */
    'path' => 'themes/one',

    /*
    |--------------------------------------------------------------------------
    | Views del Tema
    |--------------------------------------------------------------------------
    |
    | Configurazione delle viste del tema.
    |
    */
    'views' => [
        'path' => 'resources/views',
        'namespace' => 'one',
    ],

    /*
    |--------------------------------------------------------------------------
    | Assets del Tema
    |--------------------------------------------------------------------------
    |
    | Configurazione degli assets del tema.
    |
    */
    'assets' => [
        'path' => 'public/themes/one',
        'url' => '/themes/one',
    ],

    /*
    |--------------------------------------------------------------------------
    | Provider del Tema
    |--------------------------------------------------------------------------
    |
    | Provider da registrare per il tema.
    |
    */
    'providers' => [
        \Themes\One\Providers\ThemeServiceProvider::class,
    ],
];
```

## Configurazione dei Componenti

### blocks.php
```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blocchi Disponibili
    |--------------------------------------------------------------------------
    |
    | Lista dei blocchi disponibili nel tema.
    |
    */
    'available' => [
        'hero' => [
            'name' => 'Hero',
            'description' => 'Blocco hero per la home page',
            'view' => 'one::components.blocks.hero.simple',
        ],
        'feature_sections' => [
            'name' => 'Feature Sections',
            'description' => 'Blocco per le sezioni caratteristiche',
            'view' => 'one::components.blocks.feature_sections.simple',
        ],
        'stats' => [
            'name' => 'Stats',
            'description' => 'Blocco per le statistiche',
            'view' => 'one::components.blocks.stats.simple',
        ],
        'cta' => [
            'name' => 'CTA',
            'description' => 'Blocco call-to-action',
            'view' => 'one::components.blocks.cta.simple',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurazione dei Blocchi
    |--------------------------------------------------------------------------
    |
    | Configurazione specifica per ogni blocco.
    |
    */
    'config' => [
        'hero' => [
            'max_title_length' => 100,
            'max_subtitle_length' => 200,
            'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
        ],
        'feature_sections' => [
            'max_sections' => 3,
            'max_title_length' => 50,
            'max_description_length' => 150,
        ],
        'stats' => [
            'max_stats' => 4,
            'max_value_length' => 10,
            'max_label_length' => 50,
        ],
        'cta' => [
            'max_title_length' => 100,
            'max_description_length' => 200,
            'max_button_text_length' => 50,
        ],
    ],
];
```

### forms.php
```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurazione dei Form
    |--------------------------------------------------------------------------
    |
    | Configurazione generale per i form.
    |
    */
    'defaults' => [
        'input' => [
            'class' => 'form-input',
        ],
        'label' => [
            'class' => 'form-label',
        ],
        'error' => [
            'class' => 'form-error',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validazione
    |--------------------------------------------------------------------------
    |
    | Regole di validazione per i form.
    |
    */
    'validation' => [
        'required' => true,
        'min_length' => 3,
        'max_length' => 255,
    ],
];
```

### ui.php
```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurazione UI
    |--------------------------------------------------------------------------
    |
    | Configurazione generale per i componenti UI.
    |
    */
    'defaults' => [
        'button' => [
            'primary' => [
                'class' => 'btn-primary',
            ],
            'secondary' => [
                'class' => 'btn-secondary',
            ],
        ],
        'card' => [
            'class' => 'card',
        ],
        'modal' => [
            'class' => 'modal',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Colori
    |--------------------------------------------------------------------------
    |
    | Schema colori del tema.
    |
    */
    'colors' => [
        'primary' => '#4f46e5',
        'secondary' => '#6b7280',
        'success' => '#10b981',
        'danger' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6',
    ],
];
```

## Best Practices

1. **Organizzazione**: Mantieni una struttura pulita e organizzata
2. **Documentazione**: Documenta tutte le opzioni di configurazione
3. **Validazione**: Valida i valori di configurazione
4. **Manutenibilità**: Mantieni il codice pulito e documentato
5. **Consistenza**: Mantieni uno stile coerente
6. **Sicurezza**: Proteggi le informazioni sensibili
7. **Performance**: Ottimizza la configurazione
8. **Versioning**: Gestisci correttamente le versioni 
## Collegamenti tra versioni di config.md
* [config.md](../../../Xot/docs/config.md)
* [config.md](../../../../Themes/One/docs/config.md)

