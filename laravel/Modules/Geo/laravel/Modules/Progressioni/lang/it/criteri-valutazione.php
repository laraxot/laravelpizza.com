<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criterio di Valutazione',
        'plural' => 'Criteri di Valutazione',
        'group' => [
            'name' => 'Criteri',
            'description' => 'Gestione criteri di valutazione',
        ],
        'sort' => 3,
        'icon' => 'heroicon-o-clipboard-document-check',
        'label' => 'Criteri di Valutazione',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del criterio',
            'help' => 'Nome del criterio di valutazione',
        ],
        'parent' => [
            'label' => 'Criterio Padre',
            'placeholder' => 'Seleziona il criterio padre',
            'help' => 'Criterio di livello superiore',
        ],
        'parent_name' => [
            'label' => 'Nome Criterio Padre',
            'placeholder' => 'Nome del criterio padre',
            'help' => 'Nome del criterio di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse associate al criterio',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'Criteri importati con successo',
            'error' => 'Errore durante l\'importazione dei criteri',
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
            'filename_prefix' => 'Criteri_Valutazione_',
            'columns' => [
                'name' => [
                    'label' => 'Nome criterio',
                    'help' => 'Nome del criterio di valutazione',
                ],
                'parent_name' => [
                    'label' => 'Nome criterio padre',
                    'help' => 'Nome del criterio di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo criterio',
            'success' => 'Criterio di valutazione creato con successo',
            'error' => 'Errore durante la creazione del criterio',
        ],
        'edit' => [
            'label' => 'Modifica criterio',
            'success' => 'Criterio di valutazione aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del criterio',
        ],
        'delete' => [
            'label' => 'Elimina criterio',
            'success' => 'Criterio di valutazione eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del criterio',
            'confirmation' => 'Sei sicuro di voler eliminare questo criterio? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza criterio',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i criteri di valutazione',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo criterio di valutazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica il criterio di valutazione selezionato',
        ],
    ],
    'messages' => [
        'created' => 'Criterio di valutazione creato con successo',
        'updated' => 'Criterio di valutazione aggiornato con successo',
        'deleted' => 'Criterio di valutazione eliminato con successo',
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
