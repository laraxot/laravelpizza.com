<?php

declare(strict_types=1);


return [
    'fields' => [
        'type' => [
            'label' => 'Tipo Notifica',
            'placeholder' => 'Inserisci il tipo di notifica',
            'helper_text' => 'Il tipo di notifica',
        ],
        'notifiable_type' => [
            'label' => 'Tipo Destinatario',
            'placeholder' => 'Inserisci il tipo di destinatario',
            'helper_text' => 'Il tipo di entità che riceve la notifica',
        ],
        'notifiable_id' => [
            'label' => 'ID Destinatario',
            'placeholder' => 'Inserisci l\'ID del destinatario',
            'helper_text' => 'L\'ID dell\'entità che riceve la notifica',
        ],
        'data' => [
            'label' => 'Dati Notifica',
            'placeholder' => 'Inserisci i dati della notifica',
            'helper_text' => 'I dati contenuti nella notifica',
        ],
        'read_at' => [
            'label' => 'Data Lettura',
            'placeholder' => 'Seleziona la data di lettura',
            'helper_text' => 'Quando la notifica è stata letta',
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Inserisci chi ha creato la notifica',
            'helper_text' => 'L\'utente che ha creato la notifica',
        ],
        'updated_by' => [
            'label' => 'Aggiornato Da',
            'placeholder' => 'Inserisci chi ha aggiornato la notifica',
            'helper_text' => 'L\'utente che ha aggiornato la notifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Notifica',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Notifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Notifica',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'mark_as_read' => [
            'label' => 'Segna come Letta',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
        ],
        'mark_as_unread' => [
            'label' => 'Segna come Non Letta',
            'icon' => 'heroicon-o-x-mark',
            'color' => 'danger',
        ],
    ],
];
