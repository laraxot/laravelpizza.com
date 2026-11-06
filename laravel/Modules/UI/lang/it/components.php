<?php

declare(strict_types=1);

return [
    'state_icons' => [
        'no_transitions' => 'Nessuna transizione disponibile',
    ],
    'label' => 'Components',
    'plural_label' => 'Components (Plurale)',
    'navigation' => [
        'name' => 'Components',
        'plural' => 'Components',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Components',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
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
        'logo' => [
            'alt' => 'Logo',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Components',
        ],
        'edit' => [
            'label' => 'Modifica Components',
        ],
        'delete' => [
            'label' => 'Elimina Components',
        ],
        'close' => [
            'label' => 'Chiudi',
        ],
    ],
    'header' => [
        'toggle_menu' => [
            'label' => 'Apri o chiudi il menu',
        ],
        'about' => [
            'label' => 'Chi siamo',
        ],
        'blog' => [
            'label' => 'Blog',
        ],
        'power_ups' => [
            'label' => 'Power-ups',
        ],
        'view_dashboard' => [
            'label' => 'Vai alla dashboard',
        ],
    ],
    'post_footer' => [
        'see_also' => [
            'label' => 'Vedi anche',
        ],
    ],
    'nav_item' => [
        'toggle_children' => [
            'label' => 'Mostra o nascondi le sottovoci',
        ],
    ],
    'order_column' => [
        'move_up' => [
            'label' => 'Sposta su',
        ],
        'move_down' => [
            'label' => 'Sposta giù',
        ],
    ],
    'qr_reader' => [
        'scan' => [
            'label' => 'Scansiona',
        ],
        'search' => [
            'label' => 'Cerca',
        ],
    ],
];
