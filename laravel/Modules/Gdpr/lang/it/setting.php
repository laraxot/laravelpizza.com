<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'consent_lifetime' => [
            'label' => 'Validità della scelta sui cookie (giorni)',
            'placeholder' => '180',
            'helper_text' => 'Prima di questo periodo il banner non viene riproposto. Il Garante non ammette meno di 6 mesi: minimo 180.',
            'tooltip' => '',
            'description' => '',
        ],
        'info_banner' => [
            'label' => 'Barra informativa sui cookie tecnici',
            'placeholder' => '',
            'helper_text' => "Con soli cookie tecnici la barra non è obbligatoria: basta l'informativa nella cookie policy. Se spenta, il sito si apre senza barra. Con cookie di analisi o marketing la barra del consenso compare sempre.",
            'tooltip' => '',
            'description' => '',
        ],
        'policy_path' => [
            'label' => 'Pagina della cookie policy',
            'placeholder' => '/cookie-policy',
            'helper_text' => 'Percorso senza lingua (es. /cookie-policy): il prefisso della lingua lo aggiunge il sito.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
