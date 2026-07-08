<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Categoria ProPro',
        'plural' => 'Categorie ProPro',
        'group' => [
            'name' => 'Progressioni',
            'description' => 'Gestione delle progressioni di carriera',
        ],
        'sort' => 58,
        'icon' => 'heroicon-o-document-text',
        'label' => 'Categorie ProPro',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della categoria ProPro',
            'help' => 'Nome identificativo della categoria ProPro',
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
            'help' => 'Risorse collegate a questa categoria ProPro',
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
            'filename_prefix' => 'Categorie_ProPro_',
            'columns' => [
                'name' => [
                    'label' => 'Nome categoria ProPro',
                    'help' => 'Nome della categoria ProPro',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova categoria',
            'success' => 'Categoria ProPro creata con successo',
            'error' => 'Errore durante la creazione della categoria',
        ],
        'edit' => [
            'label' => 'Modifica categoria',
            'success' => 'Categoria ProPro aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della categoria',
        ],
        'delete' => [
            'label' => 'Elimina categoria',
            'success' => 'Categoria ProPro eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della categoria',
            'confirmation' => 'Sei sicuro di voler eliminare questa categoria? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza categoria',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutte le categorie ProPro',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea una nuova categoria ProPro',
        ],
    ],
    'messages' => [
        'created' => 'Categoria ProPro creata con successo',
        'updated' => 'Categoria ProPro aggiornata con successo',
        'deleted' => 'Categoria ProPro eliminata con successo',
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
