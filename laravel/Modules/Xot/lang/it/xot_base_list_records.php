<?php

declare(strict_types=1);

return [
    'fields' => [
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'tooltip' => 'Messaggio informativo',
            'description' => 'Messaggio di sistema o comunicazione',
            'helper_text' => '',
        ],
        'delete' => [
            'label' => 'Elimina',
            'placeholder' => 'Conferma eliminazione',
            'tooltip' => 'Rimuove definitivamente l\'elemento',
            'description' => 'Azione per eliminare il record selezionato',
            'helper_text' => '',
        ],
        'edit' => [
            'label' => 'Modifica',
            'placeholder' => 'Clicca per modificare',
            'tooltip' => 'Modifica i dati dell\'elemento',
            'description' => 'Azione per modificare il record selezionato',
            'helper_text' => '',
        ],
        'view' => [
            'label' => 'Visualizza',
            'placeholder' => 'Clicca per visualizzare',
            'tooltip' => 'Mostra i dettagli dell\'elemento',
            'description' => 'Azione per visualizzare il record selezionato',
            'helper_text' => '',
        ],
        'create' => [
            'label' => 'Crea',
            'placeholder' => 'Clicca per creare',
            'tooltip' => 'Crea un nuovo elemento',
            'description' => 'Azione per creare un nuovo record',
            'helper_text' => '',
        ],
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Seleziona layout',
            'tooltip' => 'Modifica la disposizione degli elementi',
            'description' => 'Configurazione del layout di visualizzazione',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'tooltip' => 'Crea un nuovo elemento',
            'description' => 'Azione per aggiungere un nuovo record al sistema',
        ],
        'export_xls' => [
            'label' => 'Esporta Excel',
            'tooltip' => 'Esporta dati in formato Excel',
            'description' => 'Azione per esportare i dati in un file Excel',
        ],
    ],
];
