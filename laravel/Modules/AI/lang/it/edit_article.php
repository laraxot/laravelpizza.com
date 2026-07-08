<?php

declare(strict_types=1);

return [
    'actions' => [
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'translate' => [
            'label' => 'translate',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo dell\'articolo',
            'help' => 'Il titolo deve essere descrittivo e accattivante',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Scrivi il contenuto dell\'articolo',
            'help' => 'Utilizza l\'editor rich text per formattare il contenuto',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato dell\'articolo',
            'help' => 'Lo stato determina la visibilità dell\'articolo',
        ],
        'content_blocks' => [
            'label' => 'content_blocks',
            'description' => 'content_blocks',
            'helper_text' => 'content_blocks',
            'placeholder' => 'content_blocks',
        ],
        'sidebar_blocks' => [
            'label' => 'sidebar_blocks',
            'description' => 'sidebar_blocks',
            'helper_text' => 'sidebar_blocks',
            'placeholder' => 'sidebar_blocks',
        ],
        'footer_blocks' => [
            'label' => 'footer_blocks',
            'description' => 'footer_blocks',
            'helper_text' => 'footer_blocks',
            'placeholder' => 'footer_blocks',
        ],
    ],
];
