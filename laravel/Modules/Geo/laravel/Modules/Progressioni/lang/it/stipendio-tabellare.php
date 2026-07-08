<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Stipendio Tabellare',
        'plural' => 'Stipendi Tabellari',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 22,
        'icon' => 'heroicon-o-currency-euro',
        'label' => 'Stipendi Tabellari',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo dello stipendio tabellare',
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
            'help' => 'Risorse collegate a questo stipendio tabellare',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Identificativo univoco del record',
        ],
        'cateco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica del dipendente',
        ],
        'posfun' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale del dipendente',
        ],
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo',
            'help' => 'Importo dello stipendio tabellare in euro',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Inserisci l\'anno',
            'help' => 'Anno di riferimento dello stipendio',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione',
            'help' => 'Data di creazione del record',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'placeholder' => 'Data di aggiornamento',
            'help' => 'Data dell\'ultimo aggiornamento',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'help' => 'Apri il pannello dei filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'help' => 'Applica i filtri selezionati',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtri',
            'help' => 'Rimuovi tutti i filtri applicati',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'help' => 'Riordina i record nella tabella',
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
            'filename_prefix' => 'Stipendi_Tabellari_',
            'columns' => [
                'name' => [
                    'label' => 'Nome stipendio',
                    'help' => 'Nome dello stipendio tabellare',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
                'cateco' => [
                    'label' => 'Categoria economica',
                    'help' => 'Categoria economica del dipendente',
                ],
                'posfun' => [
                    'label' => 'Posizione funzionale',
                    'help' => 'Posizione funzionale del dipendente',
                ],
                'importo' => [
                    'label' => 'Importo',
                    'help' => 'Importo dello stipendio tabellare',
                ],
                'anno' => [
                    'label' => 'Anno',
                    'help' => 'Anno di riferimento',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo stipendio',
            'success' => 'Stipendio tabellare creato con successo',
            'error' => 'Errore durante la creazione dello stipendio',
        ],
        'edit' => [
            'label' => 'Modifica stipendio',
            'success' => 'Stipendio tabellare aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento dello stipendio',
        ],
        'delete' => [
            'label' => 'Elimina stipendio',
            'success' => 'Stipendio tabellare eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dello stipendio',
            'confirmation' => 'Sei sicuro di voler eliminare questo stipendio? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza stipendio',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti gli stipendi tabellari',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo stipendio tabellare',
        ],
    ],
    'messages' => [
        'created' => 'Stipendio tabellare creato con successo',
        'updated' => 'Stipendio tabellare aggiornato con successo',
        'deleted' => 'Stipendio tabellare eliminato con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'string' => 'Il campo :attribute deve essere una stringa',
        'numeric' => 'Il campo :attribute deve essere un numero',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
        'date' => 'Il campo :attribute deve essere una data valida',
    ],
];
