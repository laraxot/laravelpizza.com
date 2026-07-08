<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Categoria ProPro',
        'plural' => 'Categorie ProPro',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 9,
        'icon' => 'heroicon-o-tag',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'id' => [
            'label' => 'id',
        ],
        'categoria' => [
            'label' => 'categoria',
        ],
        'lista_propro' => [
            'label' => 'lista_propro',
        ],
        'lista_propro_sup' => [
            'label' => 'lista_propro_sup',
        ],
        'posti' => [
            'label' => 'posti',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
            'placeholder' => 'created_at',
            'helper_text' => 'created_at',
            'description' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
            'placeholder' => 'updated_at',
            'helper_text' => 'updated_at',
            'description' => 'updated_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
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
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
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
    ],
    'model' => [
        'label' => 'Modello Categoria Progressioni',
        'placeholder' => 'Seleziona modello categoria',
        'tooltip' => 'Modello dati per le categorie di progressioni',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire le categorie e proposte di progressione',
        'help' => 'Modello che definisce la struttura dati per le categorie di progressioni',
    ],
    'label' => 'categoria propro',
];
