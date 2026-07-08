<?php

declare(strict_types=1);

return [
    's3test' => [
        'heading' => 'Test',
        'description' => 'Pagina di test ',
        'info' => [
            'title' => 'Informazioni Test',
            'description' => 'Questa pagina permette di testare l\'invio di email tramite il sistema S3. Inserisci i dati richiesti e clicca su "Invia Email" per procedere con il test.',
        ],
        'fields' => [
            'to' => [
                'label' => 'Destinatario',
                'placeholder' => 'Inserisci l\'indirizzo email del destinatario',
                'helper_text' => 'L\'email verrà inviata a questo indirizzo',
                'description' => 'Indirizzo email del destinatario',
            ],
            'subject' => [
                'label' => 'Oggetto',
                'placeholder' => 'Inserisci l\'oggetto dell\'email',
                'helper_text' => 'L\'oggetto apparirà nella casella di posta del destinatario',
                'description' => 'Oggetto dell\'email',
            ],
            'body_html' => [
                'label' => 'Contenuto',
                'placeholder' => 'Inserisci il contenuto dell\'email',
                'helper_text' => 'Il contenuto può includere formattazione HTML',
                'description' => 'Contenuto dell\'email',
            ],
        ],
        'actions' => [
            'send_email' => [
                'label' => 'Invia Email',
                'success' => 'Email inviata con successo',
                'error' => 'Errore durante l\'invio dell\'email',
            ],
            'sendEmail' => [
                'label' => 'Invia Email',
                'success' => 'Email inviata con successo',
                'error' => 'Errore durante l\'invio dell\'email',
            ],
        ],
        'notifications' => [
            'check_email_client' => 'Controlla il tuo client email',
            'email_sent_success' => 'Email inviata con successo',
            'email_sent_error' => 'Errore durante l\'invio dell\'email',
        ],
    ],
    'label' => 'Pages',
    'plural_label' => 'Pages (Plurale)',
    'navigation' => [
        'name' => 'Pages',
        'plural' => 'Pages',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Pages',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Pages',
        ],
        'edit' => [
            'label' => 'Modifica Pages',
        ],
        'delete' => [
            'label' => 'Elimina Pages',
        ],
    ],
];
