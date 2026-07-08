<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda Criteri',
        'plural' => 'Scheda Criteri',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 65,
        'icon' => 'heroicon-o-clipboard-document-list',
        'label' => 'Scheda Criteri',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della scheda criteri',
            'help' => 'Nome identificativo della scheda criteri',
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
            'help' => 'Risorse collegate a questa scheda criteri',
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
            'filename_prefix' => 'Scheda_Criteri_',
            'columns' => [
                'name' => [
                    'label' => 'Nome scheda criteri',
                    'help' => 'Nome della scheda criteri',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova scheda',
            'success' => 'Scheda criteri creata con successo',
            'error' => 'Errore durante la creazione della scheda',
        ],
        'edit' => [
            'label' => 'Modifica scheda',
            'success' => 'Scheda criteri aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della scheda',
        ],
        'delete' => [
            'label' => 'Elimina scheda',
            'success' => 'Scheda criteri eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della scheda',
            'confirmation' => 'Sei sicuro di voler eliminare questa scheda? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza scheda',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutte le schede criteri',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea una nuova scheda criteri',
        ],
    ],
    'messages' => [
        'created' => 'Scheda criteri creata con successo',
        'updated' => 'Scheda criteri aggiornata con successo',
        'deleted' => 'Scheda criteri eliminata con successo',
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
