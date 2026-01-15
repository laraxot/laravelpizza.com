<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Basculer la disposition du tableau',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Basculer la disposition',
                'tooltip' => 'Basculer entre la vue liste et la vue grille',
                'helper_text' => 'Changer le type d\'affichage',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Disposition',
            'placeholder' => 'Sélectionner le type de disposition',
            'tooltip' => 'Choisir entre la vue liste et la vue grille',
            'help' => 'Choisissez le type de disposition le plus adapté pour afficher les données',
        ],
    ],
];
