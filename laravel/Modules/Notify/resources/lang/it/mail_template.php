<?php

declare(strict_types=1);

return [
    'fields' => [
        'mailable' => [
            'label' => 'Classe Mailable',
            'placeholder' => 'Inserisci la classe Mailable',
            'helper_text' => 'La classe che gestisce l\'invio dell\'email',
            'tooltip' => '',
            'description' => '',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto dell\'email',
            'helper_text' => 'L\'oggetto che apparirà nell\'email',
            'tooltip' => '',
            'description' => '',
        ],
        'html_template' => [
            'label' => 'Template HTML',
            'placeholder' => 'Inserisci il template HTML',
            'helper_text' => 'Il contenuto HTML dell\'email',
            'tooltip' => '',
            'description' => '',
        ],
        'text_template' => [
            'label' => 'Template Testo',
            'placeholder' => 'Inserisci il template testuale',
            'helper_text' => 'Il contenuto testuale dell\'email (versione plain text)',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Template Email',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Template Email',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Template Email',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'preview' => [
            'label' => 'Anteprima Email',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
