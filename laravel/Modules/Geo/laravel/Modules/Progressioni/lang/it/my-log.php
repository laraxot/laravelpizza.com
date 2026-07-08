<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Log Personale',
        'plural' => 'Log Personali',
        'group' => [
            'name' => 'Log',
            'description' => 'Gestione log personali',
        ],
        'sort' => 9,
        'icon' => 'heroicon-o-document-text',
        'label' => 'Log Personali',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del log',
            'help' => 'Nome identificativo del log personale',
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
            'help' => 'Risorse collegate a questo log personale',
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
            'filename_prefix' => 'Log_Personali_',
            'columns' => [
                'name' => [
                    'label' => 'Nome log',
                    'help' => 'Nome del log personale',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo log',
            'success' => 'Log personale creato con successo',
            'error' => 'Errore durante la creazione del log',
        ],
        'edit' => [
            'label' => 'Modifica log',
            'success' => 'Log personale aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del log',
        ],
        'delete' => [
            'label' => 'Elimina log',
            'success' => 'Log personale eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del log',
            'confirmation' => 'Sei sicuro di voler eliminare questo log? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza log',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i log personali',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo log personale',
        ],
    ],
    'messages' => [
        'created' => 'Log personale creato con successo',
        'updated' => 'Log personale aggiornato con successo',
        'deleted' => 'Log personale eliminato con successo',
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
