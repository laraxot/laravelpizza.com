<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del template',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'code' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice univoco del template',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione del template',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto dell\'email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'label' => 'Corpo HTML',
            'placeholder' => 'Inserisci il contenuto HTML dell\'email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_text' => [
            'label' => 'Corpo Testo',
            'placeholder' => 'Inserisci il contenuto testuale dell\'email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'channels' => [
            'label' => 'Canali',
            'placeholder' => 'Seleziona i canali di invio',
            'options' => [
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Invia notifica via email',
                ],
                'sms' => [
                    'label' => 'SMS',
                    'tooltip' => 'Invia notifica via SMS',
                ],
                'push' => [
                    'label' => 'Push',
                    'tooltip' => 'Invia notifica push',
                ],
                'whatsapp' => [
                    'label' => 'WhatsApp',
                    'tooltip' => 'Invia notifica via WhatsApp',
                ],
                'telegram' => [
                    'label' => 'Telegram',
                    'tooltip' => 'Invia notifica via Telegram',
                ],
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'variables' => [
            'label' => 'Variabili',
            'placeholder' => 'Definisci le variabili disponibili nel template',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'conditions' => [
            'label' => 'Condizioni',
            'placeholder' => 'Definisci le condizioni di invio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'preview_data' => [
            'label' => 'Dati Anteprima',
            'placeholder' => 'Inserisci i dati per l\'anteprima',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'metadata' => [
            'label' => 'Metadati',
            'placeholder' => 'Inserisci metadati aggiuntivi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria del template',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Indica se il template è attivo',
            'helper_text' => '',
            'description' => '',
        ],
        'version' => [
            'label' => 'Versione',
            'tooltip' => 'Versione corrente del template',
            'helper_text' => '',
            'description' => '',
        ],
        'tenant_id' => [
            'label' => 'Tenant',
            'tooltip' => 'Tenant associato al template',
            'helper_text' => '',
            'description' => '',
        ],
        'grapesjs_data' => [
            'label' => 'Dati GrapesJS',
            'tooltip' => 'Dati dell\'editor GrapesJS',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Template',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Template',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Template',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
        ],
        'duplicate' => [
            'label' => 'Duplica',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'success',
        ],
        'version' => [
            'label' => 'Nuova Versione',
            'icon' => 'heroicon-o-document-text',
            'color' => 'primary',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
