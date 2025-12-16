<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Contatti',
        'group' => 'Gestione Contenuti',
        'icon' => 'heroicon-o-phone',
        'color' => 'primary',
        'sort' => '10',
    ],
    'model' => [
        'label' => 'Contatto',
        'plural' => 'Contatti',
        'description' => 'Gestione informazioni di contatto dello studio',
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo Contatto',
            'placeholder' => 'Inserisci il titolo (es. Studio Dentistico)',
            'help' => 'Nome o titolo principale per identificare il contatto',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Descrivi brevemente l\'attività dello studio',
            'help' => 'Breve descrizione delle attività e servizi offerti',
        ],
        'email' => [
            'label' => 'Email di Contatto',
            'placeholder' => 'inserisci@email.it',
            'help' => 'Indirizzo email principale per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Numero di Telefono',
            'placeholder' => '+39 06 1234567',
            'help' => 'Numero di telefono principale dello studio',
        ],
        'address' => [
            'label' => 'Indirizzo Completo',
            'placeholder' => 'Via Roma, 123 - 00100 Roma',
            'help' => 'Indirizzo fisico completo dello studio',
        ],
        'map_url' => [
            'label' => 'Link Mappa',
            'placeholder' => 'https://maps.google.com/...',
            'help' => 'URL per aprire la posizione su Google Maps o servizi simili',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Contatto',
            'modal_heading' => 'Aggiungi nuovo contatto',
            'modal_description' => 'Inserisci le informazioni di contatto',
            'success' => 'Contatto creato con successo',
            'error' => 'Errore durante la creazione del contatto',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal_heading' => 'Modifica contatto',
            'modal_description' => 'Aggiorna le informazioni di contatto',
            'success' => 'Contatto aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal_heading' => 'Elimina contatto',
            'modal_description' => 'Sei sicuro di voler eliminare questo contatto?',
            'success' => 'Contatto eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirmation' => 'Questa azione è irreversibile',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun contatto configurato',
        'loading' => 'Caricamento contatti in corso...',
        'saved' => 'Modifiche salvate correttamente',
    ],
];
