<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'breadcrumb',
        'plural' => 'breadcrumbs',
        'group' => [
            'name' => 'Site',
        ],
    ],
    'fields' => [
        'background_color' => [
            'label' => 'background_color',
        ],
        'background' => [
            'label' => 'background',
        ],
        'overlay_color' => [
            'label' => 'overlay_color',
        ],
        'overlay_opacity' => [
            'label' => 'overlay_opacity',
        ],
        'class' => [
            'label' => 'class',
        ],
        'style' => [
            'label' => 'style',
        ],
        'name' => 'Nome',
        'guard_name' => 'Guard',
        'permissions' => 'Permessi',
        'roles' => 'Ruoli',
        'updated_at' => 'Aggiornato il',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
    ],
    'rating' => [
        'no_import' => 'Nessuna cifra inserita',
        'import_zero' => 'Nessuna cifra inserita',
        'import_min' => 'Hai superato la cifra di :credits: crediti',
        'no_choice' => 'Nessuna opzione scelta',
    ],
    'single_expired' => 'Scaduto',
    'expired' => 'Articolo scaduto, non si possono fare più scommesse',
    'no_vote' => 'Siamo spiacenti, ma questa votazione è chiusa da :TIME, per favore prova a fare un altra previsione',
    'your_bet' => 'La tua previsione',
    'your_amount' => 'Previsione',
    'if_win' => 'Se vinci',
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'updateAction' => [
            'label' => 'updateAction',
        ],
    ],
];
