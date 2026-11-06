<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki/concepts/claude-audit-static.md
// File: lang/de/section_actions.php
return [
    'actions' => [
        'create' => [
            'label' => 'Crea Sezione',
            'modal' => [
                'heading' => 'Crea Nuova Sezione',
                'submit' => 'Crea',
                'cancel' => 'Annulla',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Sezione',
            'modal' => [
                'heading' => 'Modifica Sezione',
                'submit' => 'Salva',
                'cancel' => 'Annulla',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Sezione',
            'modal' => [
                'heading' => 'Elimina Sezione',
                'description' => 'Sei sicuro di voler eliminare questa sezione?',
                'submit' => 'Elimina',
                'cancel' => 'Annulla',
            ],
        ],
        'view' => [
            'label' => 'Visualizza Sezione',
        ],
        'activeLocale' => [
            'label' => 'Lingua Attiva',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'save' => [
            'label' => 'save',
        ],
        'preview' => [
            'label' => 'preview',
        ],
    ],
];
