<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dirigente Stabilimento',
        'plural' => 'Dirigenti Stabilimento',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 5,
        'icon' => 'heroicon-o-building-office',
        'label' => 'Dirigenti Stabilimento',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del dirigente',
            'help' => 'Nome identificativo del dirigente di stabilimento',
        ],
        'parent' => [
            'label' => 'Elemento Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Elemento Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questo dirigente di stabilimento',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Dirigenti_Stabilimento_',
            'columns' => [
                'name' => [
                    'label' => 'Nome dirigente',
                    'help' => 'Nome del dirigente di stabilimento',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo dirigente',
            'success' => 'Dirigente di stabilimento creato con successo',
            'error' => 'Errore durante la creazione del dirigente',
        ],
        'edit' => [
            'label' => 'Modifica dirigente',
            'success' => 'Dirigente di stabilimento aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del dirigente',
        ],
        'delete' => [
            'label' => 'Elimina dirigente',
            'success' => 'Dirigente di stabilimento eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del dirigente',
            'confirmation' => 'Sei sicuro di voler eliminare questo dirigente? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza dirigente',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i dirigenti di stabilimento',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo dirigente di stabilimento',
        ],
    ],
    'messages' => [
        'created' => 'Dirigente di stabilimento creato con successo',
        'updated' => 'Dirigente di stabilimento aggiornato con successo',
        'deleted' => 'Dirigente di stabilimento eliminato con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'string' => 'Il campo :attribute deve essere una stringa',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
    ],
];
