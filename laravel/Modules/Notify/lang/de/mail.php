<?php

declare(strict_types=1);


return [
    'template' => [
        'navigation' => [
            'group' => 'Notifiche',
            'label' => 'Template Email',
            'plural' => 'Template Email',
            'singular' => 'Template Email',
            'icon' => 'heroicon-o-envelope',
            'sort' => '1',
        ],
        'sections' => [
            'main' => 'Informazioni Principali',
        ],
        'fields' => [
            'name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome del template',
                'tooltip' => 'Il nome identificativo del template email',
            ],
            'layout' => [
                'label' => 'Layout',
                'placeholder' => 'Seleziona il layout del template',
                'tooltip' => 'Il layout grafico che verrà utilizzato per l\'email',
            ],
            'mailable' => [
                'label' => 'Classe Mailable',
                'placeholder' => 'Inserisci il nome della classe Mailable',
                'tooltip' => 'La classe PHP che gestisce l\'invio dell\'email',
            ],
            'subject' => [
                'label' => 'Oggetto',
                'placeholder' => 'Inserisci l\'oggetto dell\'email',
                'tooltip' => 'L\'oggetto che apparirà nell\'email',
            ],
            'body_html' => [
                'label' => 'Contenuto HTML',
                'placeholder' => 'Inserisci il contenuto HTML dell\'email',
                'tooltip' => 'Il contenuto dell\'email in formato HTML',
            ],
            'body_text' => [
                'label' => 'Contenuto Testo',
                'placeholder' => 'Inserisci il contenuto testuale dell\'email',
                'tooltip' => 'Versione testuale dell\'email per client che non supportano HTML',
            ],
        ],
        'actions' => [
            'preview' => [
                'label' => 'Anteprima',
                'tooltip' => 'Visualizza un\'anteprima del template',
            ],
        ],
        'messages' => [
            'created' => 'Template email creato con successo',
            'updated' => 'Template email aggiornato con successo',
            'deleted' => 'Template email eliminato con successo',
        ],
    ],
];
