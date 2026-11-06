<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Client',
        'plural' => 'Clients',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei client e delle loro autorizzazioni',
        ],
        'label' => 'Mandant',
        'sort' => '92',
        'icon' => 'user-user-client',
    ],
    'fields' => [
        'name' => [
            'label' => 'name',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'client.plural.model',
        ],
    ],
];
