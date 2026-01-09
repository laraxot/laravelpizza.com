<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Test SMTP',
        'group' => 'Notifications',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'Test SMTP',
    'plural_label' => 'Tests SMTP',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'host' => [
            'label' => 'Hôte',
        ],
        'port' => [
            'label' => 'Port',
        ],
        'username' => [
            'label' => 'Nom d\'utilisateur',
        ],
        'password' => [
            'label' => 'Mot de passe',
        ],
        'encryption' => [
            'label' => 'Chiffrement',
        ],
        'from_address' => [
            'label' => 'Adresse de l\'expéditeur',
        ],
        'from_name' => [
            'label' => 'Nom de l\'expéditeur',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'last_tested_at' => [
            'label' => 'Dernier test le',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
    ],
    'actions' => [
        'send_test_email' => [
            'label' => 'Envoyer un email de test',
        ],
        'test_connection' => [
            'label' => 'Tester la connexion',
        ],
    ],
];