<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => [
            'retribuzioni' => [
                'label' => 'Retribuzioni',
                'description' => 'Gestione retribuzioni e incentivi',
                'icon' => 'heroicon-o-banknotes',
            ],
        ],
        'incentivi' => [
            'label' => 'Incentivo',
            'plural' => 'Incentivi',
            'icon' => 'incentivi-money',
        ],
        'progetto' => [
            'label' => 'Progetto',
            'plural' => 'Progetti',
            'icon' => 'incentivi-project',
        ],
        'gruppo-lavoro' => [
            'label' => 'Gruppo di Lavoro',
            'plural' => 'Gruppi di Lavoro',
            'icon' => 'incentivi-team',
        ],
        'attivita' => [
            'label' => 'Attività',
            'plural' => 'Attività',
            'icon' => 'incentivi-activity',
        ],
    ],
    'resources' => [
        'incentivi' => [
            'label' => 'Incentivo',
            'plural_label' => 'Incentivi',
            'icon' => 'incentivi-money',
        ],
        'progetto' => [
            'label' => 'Progetto',
            'plural_label' => 'Progetti',
            'icon' => 'incentivi-project',
            'fields' => [
                'nome' => [
                    'label' => 'Nome',
                    'placeholder' => 'Inserisci il nome del progetto',
                ],
                'tipo' => [
                    'label' => 'Tipo',
                    'placeholder' => 'Seleziona il tipo di progetto',
                ],
                'settore' => [
                    'label' => 'Settore',
                    'placeholder' => 'Seleziona il settore',
                ],
                'stato' => [
                    'label' => 'Stato',
                    'options' => [
                        'bozza' => 'Bozza',
                        'in_corso' => 'In Corso',
                        'completato' => 'Completato',
                        'annullato' => 'Annullato',
                    ],
                ],
                'data_inizio' => [
                    'label' => 'Data Inizio',
                    'placeholder' => 'Seleziona la data di inizio',
                ],
                'data_fine' => [
                    'label' => 'Data Fine',
                    'placeholder' => 'Seleziona la data di fine',
                ],
            ],
        ],
        'gruppo-lavoro' => [
            'label' => 'Gruppo di Lavoro',
            'plural_label' => 'Gruppi di Lavoro',
            'icon' => 'incentivi-team',
            'fields' => [
                'nome' => [
                    'label' => 'Nome',
                    'placeholder' => 'Inserisci il nome del gruppo',
                ],
                'responsabile' => [
                    'label' => 'Responsabile',
                    'placeholder' => 'Seleziona il responsabile',
                ],
                'membri' => [
                    'label' => 'Membri',
                    'placeholder' => 'Seleziona i membri del gruppo',
                ],
            ],
        ],
        'attivita' => [
            'label' => 'Attività',
            'plural_label' => 'Attività',
            'icon' => 'incentivi-activity',
            'fields' => [
                'nome' => [
                    'label' => 'Nome',
                    'placeholder' => 'Inserisci il nome dell\'attività',
                ],
                'descrizione' => [
                    'label' => 'Descrizione',
                    'placeholder' => 'Inserisci la descrizione',
                ],
                'stato' => [
                    'label' => 'Stato',
                    'options' => [
                        'da_iniziare' => 'Da Iniziare',
                        'in_corso' => 'In Corso',
                        'completata' => 'Completata',
                        'sospesa' => 'Sospesa',
                    ],
                ],
            ],
        ],
        'dipendente' => [
            'label' => 'Dipendente',
            'plural_label' => 'Dipendenti',
            'fields' => [
                'nome' => [
                    'label' => 'Nome',
                    'placeholder' => 'Inserisci il nome',
                ],
                'cognome' => [
                    'label' => 'Cognome',
                    'placeholder' => 'Inserisci il cognome',
                ],
                'matricola' => [
                    'label' => 'Matricola',
                    'placeholder' => 'Inserisci la matricola',
                ],
            ],
        ],
        'liquidazione' => [
            'label' => 'Liquidazione',
            'plural_label' => 'Liquidazioni',
            'fields' => [
                'importo' => [
                    'label' => 'Importo',
                    'placeholder' => 'Inserisci l\'importo',
                ],
                'data' => [
                    'label' => 'Data',
                    'placeholder' => 'Seleziona la data',
                ],
                'stato' => [
                    'label' => 'Stato',
                    'options' => [
                        'in_elaborazione' => 'In Elaborazione',
                        'approvata' => 'Approvata',
                        'pagata' => 'Pagata',
                        'annullata' => 'Annullata',
                    ],
                ],
            ],
        ],
    ],
];
