<?php

declare(strict_types=1);

return [
    'sections' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
                'tooltip' => 'Inserisci il nome della sezione',
            ],
            'slug' => [
                'label' => 'Slug',
                'tooltip' => 'Identificatore univoco della sezione',
            ],
            'image' => [
                'label' => 'Immagine',
                'tooltip' => 'Seleziona un\'immagine per la sezione',
            ],
            'content' => [
                'label' => 'Contenuto',
                'tooltip' => 'Inserisci il contenuto della sezione',
            ],
            'status' => [
                'label' => 'Stato',
                'tooltip' => 'Seleziona lo stato della sezione',
                'options' => [
                    'draft' => 'Bozza',
                    'published' => 'Pubblicato',
                    'archived' => 'Archiviato',
                ],
            ],
        ],
    ],
    'blocks' => [
        'quick_links' => [
            'fields' => [
                'label' => [
                    'label' => 'Etichetta',
                    'tooltip' => 'Inserisci l\'etichetta per i link rapidi',
                ],
                'links' => [
                    'label' => 'Link',
                    'tooltip' => 'Aggiungi i link rapidi',
                    'fields' => [
                        'label' => [
                            'label' => 'Etichetta',
                            'tooltip' => 'Inserisci l\'etichetta del link',
                        ],
                        'url' => [
                            'label' => 'URL',
                            'tooltip' => 'Inserisci l\'URL del link',
                        ],
                    ],
                ],
            ],
        ],
        'footer' => [
            'links' => [
                'fields' => [
                    'links' => [
                        'label' => 'Link',
                        'tooltip' => 'Aggiungi i link del footer',
                        'fields' => [
                            'label' => [
                                'label' => 'Etichetta',
                                'tooltip' => 'Inserisci l\'etichetta del link',
                            ],
                            'url' => [
                                'label' => 'URL',
                                'tooltip' => 'Inserisci l\'URL del link',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'filament' => [
        'blocks' => [
            'footer' => [
                'links' => [
                    'fields' => [
                        'links' => [
                            'fields' => [
                                'label' => [
                                    'label' => 'Etichetta',
                                    'tooltip' => 'Inserisci l\'etichetta del link',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'label' => 'Cms',
    'plural_label' => 'Cms (Plurale)',
    'navigation' => [
        'name' => 'Cms',
        'plural' => 'Cms',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Cms',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Cms',
        ],
        'edit' => [
            'label' => 'Modifica Cms',
        ],
        'delete' => [
            'label' => 'Elimina Cms',
        ],
    ],
];
