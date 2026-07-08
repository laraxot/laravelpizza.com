<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Werksleiter',
    ],
    'navigation' => [
        'name' => 'Werksleiter',
        'plural' => 'Werksleiter',
        'group' => [
            'name' => 'Organisation',
        ],
        'label' => 'Werksleiter',
        'sort' => 85,
        'icon' => 'heroicon-o-building-office-2',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'description' => 'id',
            'helper_text' => 'id',
            'placeholder' => 'id',
        ],
        'valutatore_id' => [
            'label' => 'Bewerter ID',
            'description' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
        ],
        'stabi' => [
            'label' => 'Werkscode',
            'description' => 'stabi',
            'helper_text' => 'stabi',
            'placeholder' => 'stabi',
        ],
        'repar' => [
            'label' => 'Abteilung',
            'description' => 'repar',
            'helper_text' => 'repar',
            'placeholder' => 'repar',
        ],
        'anno' => [
            'label' => 'Jahr',
            'placeholder' => 'jahr',
            'helper_text' => 'jahr',
            'description' => 'jahr',
        ],
        'matr' => [
            'label' => 'Mitarbeiternummer',
            'description' => 'matr',
            'helper_text' => 'matr',
            'placeholder' => 'matr',
        ],
        'cognome' => [
            'label' => 'Nachname',
        ],
        'nome' => [
            'label' => 'Vorname',
        ],
        'nome_stabi' => [
            'label' => 'Werksname',
            'description' => 'nome_stabi',
            'helper_text' => 'nome_stabi',
            'placeholder' => 'nome_stabi',
        ],
        'nome_diri' => [
            'label' => 'Leitername',
            'description' => 'nome_diri',
            'helper_text' => 'nome_diri',
            'placeholder' => 'nome_diri',
        ],
        'email' => [
            'label' => 'E-Mail',
            'description' => 'email',
            'helper_text' => 'email',
            'placeholder' => 'email',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Erstellen',
        ],
        'delete' => [
            'label' => 'Löschen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
        ],
        'view' => [
            'label' => 'Anzeigen',
        ],
    ],
];
