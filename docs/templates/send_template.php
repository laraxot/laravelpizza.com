<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Nome Funzionalità',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-paper-airplane',
        'sort' => 10,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
            'description' => 'Descrizione del campo',
        ],
        // Altri campi...
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta Azione',
        ],
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
