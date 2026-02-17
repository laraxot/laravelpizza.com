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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nom',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'host' => [
            'label' => 'Hôte',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => 'Port',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => 'Nom d\'Utilisateur',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Mot de Passe',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => 'Chiffrement',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => 'Adresse Expéditeur',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => 'Nom Expéditeur',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Statut',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => 'Dernier Test À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Créé À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'description' => 'Corps HTML',
            'helper_text' => 'Contenu HTML de l\'email',
            'label' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Déconnexion',
            'icon' => 'logout',
            'label' => 'Déconnexion',
        ],
        'emailFormActions' => [
            'tooltip' => 'Actions du Formulaire Email',
            'icon' => 'emailFormActions',
            'label' => 'Actions du Formulaire Email',
        ],
        'profile' => [
            'tooltip' => 'Profil',
            'icon' => 'profile',
        ],
        'send_test_email' => [
            'label' => 'Envoyer Email de Test',
        ],
        'test_connection' => [
            'label' => 'Tester la Connexion',
        ],
    ],
];
