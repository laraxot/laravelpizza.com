<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Esclusi Extra',
        'plural' => 'Esclusi Extra',
        'group' => [
            'name' => 'Esclusioni',
            'description' => 'Gestione esclusioni extra',
        ],
        'sort' => 38,
        'icon' => 'heroicon-o-x-circle',
        'label' => 'Esclusi Extra',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo dell\'escluso extra',
        ],
        'parent' => [
            'label' => 'Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore',
        ],
        'parent_name' => [
            'label' => 'Nome Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questo elemento',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
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
            'filename_prefix' => 'Esclusi_Extra_',
            'columns' => [
                'name' => [
                    'label' => 'Nome elemento',
                    'help' => 'Nome dell\'elemento escluso',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo elemento',
            'success' => 'Elemento escluso creato con successo',
            'error' => 'Errore durante la creazione dell\'elemento',
        ],
        'edit' => [
            'label' => 'Modifica elemento',
            'success' => 'Elemento escluso aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'elemento',
        ],
        'delete' => [
            'label' => 'Elimina elemento',
            'success' => 'Elemento escluso eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dell\'elemento',
            'confirmation' => 'Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza elemento',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti gli elementi esclusi',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo elemento escluso',
        ],
    ],
    'messages' => [
        'created' => 'Elemento escluso creato con successo',
        'updated' => 'Elemento escluso aggiornato con successo',
        'deleted' => 'Elemento escluso eliminato con successo',
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
