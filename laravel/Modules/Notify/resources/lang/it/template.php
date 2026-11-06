<?php

declare(strict_types=1);


return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del template',
        ],
        'code' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice univoco del template',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione del template',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto dell\'email',
        ],
        'body_html' => [
            'label' => 'Corpo HTML',
            'placeholder' => 'Inserisci il contenuto HTML dell\'email',
        ],
        'body_text' => [
            'label' => 'Corpo Testo',
            'placeholder' => 'Inserisci il contenuto testuale dell\'email',
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
        ],
        'variables' => [
            'label' => 'Variabili',
            'placeholder' => 'Definisci le variabili disponibili nel template',
        ],
        'conditions' => [
            'label' => 'Condizioni',
            'placeholder' => 'Definisci le condizioni di invio',
        ],
        'preview_data' => [
            'label' => 'Dati Anteprima',
            'placeholder' => 'Inserisci i dati per l\'anteprima',
        ],
        'metadata' => [
            'label' => 'Metadati',
            'placeholder' => 'Inserisci metadati aggiuntivi',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria del template',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Indica se il template è attivo',
        ],
        'version' => [
            'label' => 'Versione',
            'tooltip' => 'Versione corrente del template',
        ],
        'tenant_id' => [
            'label' => 'Tenant',
            'tooltip' => 'Tenant associato al template',
        ],
        'grapesjs_data' => [
            'label' => 'Dati GrapesJS',
            'tooltip' => 'Dati dell\'editor GrapesJS',
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
];
