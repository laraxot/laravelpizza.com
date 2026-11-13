<?php

declare(strict_types=1);

return [
    'fields' => [
        'blocks' => [
            'tooltip' => '',
        ],
        'content_blocks' => [
            'tooltip' => '',
        ],
        'sidebar_blocks' => [
            'tooltip' => '',
        ],
        'footer_blocks' => [
            'tooltip' => '',
        ],
        'content' => [
            'tooltip' => '',
        ],
    ],
    'label' => 'Page Content Builder',
    'plural_label' => 'Page Content Builder (Plurale)',
    'navigation' => [
        'name' => 'Page Content Builder',
        'plural' => 'Page Content Builder',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Page Content Builder',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Page Content Builder',
        ],
        'edit' => [
            'label' => 'Modifica Page Content Builder',
        ],
        'delete' => [
            'label' => 'Elimina Page Content Builder',
        ],
    ],
    'messages' => [
        'block_unavailable' => [
            'title' => 'Blocco non disponibile',
            'body' => 'Il blocco ":block" non puo essere caricato e non e mostrato nell\'editor. Controllare il log prima di salvare.',
        ],
    ],
];
