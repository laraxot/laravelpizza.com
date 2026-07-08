<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Importi Categorie',
        'group' => 'Indennità',
        'sort' => 100,
        'icon' => 'heroicon-o-currency-euro',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Codice ente',
            'help' => 'Codice identificativo dell\'ente',
        ],
        'categoria' => [
            'label' => 'Categoria',
            'placeholder' => 'Codice categoria',
            'help' => 'Categoria economica di riferimento',
        ],
        'lista_propro' => [
            'label' => 'Lista Profili Professionali',
            'placeholder' => 'Lista profili (es: 1,2,3)',
            'help' => 'Lista codici profili professionali separati da virgola',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Anno di riferimento',
            'help' => 'Anno di validità degli importi',
        ],
        'min' => [
            'label' => 'Importo Minimo',
            'placeholder' => '0.00',
            'help' => 'Importo minimo per la categoria',
        ],
        'max' => [
            'label' => 'Importo Massimo',
            'placeholder' => '0.00',
            'help' => 'Importo massimo per la categoria',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data di creazione del record',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data ultima modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Importo Categoria',
            'modal' => [
                'heading' => 'Crea Nuovo Importo Categoria',
                'description' => 'Inserisci i dati per creare un nuovo range di importi',
            ],
            'success' => 'Importo categoria creato con successo',
            'error' => 'Errore durante la creazione dell\'importo categoria',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal' => [
                'heading' => 'Modifica Importo Categoria',
                'description' => 'Aggiorna i dati dell\'importo categoria',
            ],
            'success' => 'Importo categoria aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Importo Categoria',
                'description' => 'Sei sicuro di voler eliminare questo importo categoria?',
            ],
            'confirmation' => 'Questa azione è irreversibile. Confermi l\'eliminazione?',
            'success' => 'Importo categoria eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'bulk_delete' => [
            'label' => 'Elimina selezionati',
            'modal' => [
                'heading' => 'Elimina importi categoria selezionati',
                'description' => 'Sei sicuro di voler eliminare gli importi categoria selezionati?',
            ],
            'success' => 'Importi categoria eliminati con successo',
            'error' => 'Errore durante l\'eliminazione degli importi categoria',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
    ],
    'sections' => [
        'general' => [
            'label' => 'Informazioni Generali',
            'description' => 'Dati principali dell\'importo categoria',
        ],
        'amounts' => [
            'label' => 'Importi',
            'description' => 'Range di importi minimo e massimo',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun importo categoria trovato',
        'validation_error' => 'Errori di validazione rilevati',
        'saved' => 'Importo categoria salvato con successo',
    ],
    'validation' => [
        'ente' => [
            'required' => 'Il campo ente è obbligatorio',
            'numeric' => 'Il campo ente deve essere numerico',
        ],
        'anno' => [
            'required' => 'Il campo anno è obbligatorio',
            'numeric' => 'Il campo anno deve essere numerico',
            'min' => 'L\'anno deve essere superiore a 2000',
            'max' => 'L\'anno deve essere inferiore a 2100',
        ],
        'min' => [
            'numeric' => 'L\'importo minimo deve essere numerico',
            'min_value' => 'L\'importo minimo deve essere maggiore o uguale a 0',
        ],
        'max' => [
            'numeric' => 'L\'importo massimo deve essere numerico',
            'min_value' => 'L\'importo massimo deve essere maggiore o uguale a 0',
            'greater_than_min' => 'L\'importo massimo deve essere maggiore del minimo',
        ],
    ],
    'label' => 'importi categoria',
];
