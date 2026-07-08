<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'AMBIENTE PRODUZIONE',
    ],
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Ricerca',
            'tooltip' => 'Ricerca',
            'icon' => 'heroicon-o-magnifying-glass',
        ],
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
    ],
    'fields' => [
        'descrizioneLocalita' => [
            'description' => 'descrizioneLocalita',
            'helper_text' => 'descrizioneLocalita',
            'placeholder' => 'descrizioneLocalita',
            'label' => 'descrizioneLocalita',
        ],
        'siglaProvinciaIstat' => [
            'description' => 'siglaProvinciaIstat',
            'helper_text' => 'siglaProvinciaIstat',
            'placeholder' => 'siglaProvinciaIstat',
            'label' => 'siglaProvinciaIstat',
        ],
        'codiceIstat' => [
            'description' => 'codiceIstat',
            'helper_text' => 'codiceIstat',
            'placeholder' => 'codiceIstat',
            'label' => 'codiceIstat',
        ],
        'nomeComune' => [
            'description' => 'nomeComune',
            'helper_text' => 'nomeComune',
            'placeholder' => 'nomeComune',
            'label' => 'nomeComune',
        ],
        'dataNascita' => [
            'description' => 'dataNascita',
            'helper_text' => 'dataNascita',
            'placeholder' => 'dataNascita',
            'label' => 'dataNascita',
        ],
        'sesso' => [
            'description' => 'sesso',
            'helper_text' => 'sesso',
            'placeholder' => 'sesso',
            'label' => 'sesso',
        ],
        'nome' => [
            'description' => 'nome',
            'helper_text' => 'nome',
            'placeholder' => 'nome',
            'label' => 'nome',
        ],
        'cognome' => [
            'description' => 'cognome',
            'label' => 'cognome',
            'placeholder' => 'cognome',
            'helper_text' => 'cognome',
        ],
        'codiceFiscale' => [
            'label' => 'codiceFiscale',
            'placeholder' => 'codiceFiscale',
            'helper_text' => 'codiceFiscale',
            'description' => 'codiceFiscale',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
    ],
];
