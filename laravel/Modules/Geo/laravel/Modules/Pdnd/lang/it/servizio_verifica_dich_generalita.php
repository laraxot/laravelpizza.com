<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'AMBIENTE TEST',
    ],
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Ricerca',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
    ],
    'fields' => [
        'codiceFiscale' => [
            'description' => 'codiceFiscale',
            'helper_text' => 'codiceFiscale',
            'placeholder' => 'codiceFiscale',
            'label' => 'codiceFiscale',
        ],
        'cognome' => [
            'description' => 'cognome',
        ],
        'dataNascita' => [
            'description' => 'dataNascita',
            'helper_text' => 'dataNascita',
        ],
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
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
    ],
];
