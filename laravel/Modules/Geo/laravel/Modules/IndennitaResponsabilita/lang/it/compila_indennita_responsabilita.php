<?php

declare(strict_types=1);

return [
    'fields' => [
        'dal' => [
            'label' => 'dal',
            'description' => 'dal',
            'helper_text' => '',
            'placeholder' => 'dal',
        ],
        'al' => [
            'label' => 'al',
            'description' => 'al',
            'helper_text' => '',
            'placeholder' => 'al',
        ],
        'note' => [
            'description' => '',
            'helper_text' => '',
            'label' => 'Compiti con Responsabilità Procedimentale di Coordinamento (minimo 2 addetti)',
            'label1' => 'Descrivere meglio compiti che comportano la responsabilità',
            'placeholder' => '',
        ],
        'ratings' => [
            12 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.12.pivot.value',
                        'helper_text' => 'ratings.12.pivot.value',
                        'placeholder' => 'ratings.12.pivot.value',
                        'label' => 'ratings.12.pivot.value',
                    ],
                ],
            ],
            11 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.11.pivot.value',
                        'helper_text' => 'ratings.11.pivot.value',
                        'placeholder' => 'ratings.11.pivot.value',
                        'label' => 'ratings.11.pivot.value',
                    ],
                ],
            ],
            3 => [
                'pivot' => [
                    'value' => [
                        'description' => '',
                        'helper_text' => '',
                        'placeholder' => '',
                        'label' => 'Autonomia operativa',
                    ],
                ],
            ],
            4 => [
                'pivot' => [
                    'value' => [
                        'description' => '',
                        'helper_text' => '',
                        'placeholder' => '',
                        'label' => 'Grado di responsabilità istruttoria e/ di processo',
                    ],
                ],
            ],
            10 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.10.pivot.value',
                        'helper_text' => 'ratings.10.pivot.value',
                        'placeholder' => 'ratings.10.pivot.value',
                        'label' => 'ratings.10.pivot.value',
                    ],
                ],
            ],
            9 => [
                'pivot' => [
                    'value' => [
                        'description' => 'ratings.9.pivot.value',
                        'helper_text' => 'ratings.9.pivot.value',
                        'placeholder' => 'ratings.9.pivot.value',
                        'label' => 'ratings.9.pivot.value',
                    ],
                ],
            ],
            7 => [
                'pivot' => [
                    'value' => [
                        'description' => '',
                        'helper_text' => '',
                        'placeholder' => '',
                        'label' => 'Responsabilità concorso/supporto alle decisioni del Dirigente/Responsabile',
                    ],
                ],
            ],
            6 => [
                'pivot' => [
                    'value' => [
                        'description' => '',
                        'helper_text' => '',
                        'placeholder' => '',
                        'label' => 'Grado di responsabilità realizzazione piani e programmi di attività',
                    ],
                ],
            ],
            5 => [
                'pivot' => [
                    'value' => [
                        'description' => '',
                        'helper_text' => '',
                        'placeholder' => '',
                        'label' => 'Grado di responsabilità di spesa',
                    ],
                ],
            ],
        ],
        'matr' => [
            'label' => 'matr',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
            'description' => 'matr',
        ],
        'cognome' => [
            'label' => 'cognome',
            'placeholder' => 'cognome',
            'helper_text' => 'cognome',
            'description' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
            'placeholder' => 'nome',
            'helper_text' => 'nome',
            'description' => 'nome',
        ],
        'annuale_attribuito' => [
            'description' => 'annuale_attribuito',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
        'Risultati' => [
            'heading' => 'Risultati',
            'label' => 'Risultati',
        ],
        'Informazioni Generali' => [
            'label' => 'Informazioni Generali',
            'heading' => 'Informazioni Generali',
        ],
        'Valutazioni Anno 2025' => [
            'label' => 'Valutazioni Anno 2025',
            'heading' => 'Valutazioni Anno 2025',
        ],
        'Riepilogo Calcoli' => [
            'heading' => 'Riepilogo Calcoli',
            'label' => 'Riepilogo Calcoli',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'back' => [
            'tooltip' => 'back',
            'label' => 'back',
            'icon' => 'back',
        ],
    ],
    'title' => 'compila indennita responsabilita',
];
