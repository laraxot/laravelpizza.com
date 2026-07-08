<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Opzione Criteri',
        'plural' => 'Opzioni Criteri',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 94,
        'icon' => 'heroicon-o-list-bullet',
        'label' => 'Opzioni Criteri',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dell\'opzione',
            'help' => 'Nome identificativo dell\'opzione criteri',
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
            'help' => 'Risorse collegate a questa opzione criteri',
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
            'filename_prefix' => 'Opzioni_Criteri_',
            'columns' => [
                'name' => [
                    'label' => 'Nome opzione criteri',
                    'help' => 'Nome dell\'opzione criteri',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova opzione',
            'success' => 'Opzione criteri creata con successo',
            'error' => 'Errore durante la creazione dell\'opzione',
        ],
        'edit' => [
            'label' => 'Modifica opzione',
            'success' => 'Opzione criteri aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'opzione',
        ],
        'delete' => [
            'label' => 'Elimina opzione',
            'success' => 'Opzione criteri eliminata con successo',
            'error' => 'Errore durante l\'eliminazione dell\'opzione',
            'confirmation' => 'Sei sicuro di voler eliminare questa opzione? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza opzione',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutte le opzioni criteri',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea una nuova opzione criteri',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica l\'opzione criteri selezionata',
        ],
    ],
    'messages' => [
        'created' => 'Opzione criteri creata con successo',
        'updated' => 'Opzione criteri aggiornata con successo',
        'deleted' => 'Opzione criteri eliminata con successo',
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
