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
            'label' => 'Nom d\'Utilisateur',
        ],
        'password' => [
            'label' => 'Mot de Passe',
        ],
        'encryption' => [
            'label' => 'Chiffrement',
        ],
        'from_address' => [
            'label' => 'Adresse Expéditeur',
        ],
        'from_name' => [
            'label' => 'Nom Expéditeur',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'last_tested_at' => [
            'label' => 'Dernier Test À',
        ],
        'created_at' => [
            'label' => 'Créé À',
        ],
        'body_html' => [
            'description' => 'Corps HTML',
            'helper_text' => 'Contenu HTML de l\'email',
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
