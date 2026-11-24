<?php

declare(strict_types=1);

// Pagine di errore (laravel/resources/views/errors/*, Themes/Meetup/resources/views/errors/page.blade.php)
return [
    '403' => [
        'title' => 'Accès refusé',
        'message' => 'Cette page n\'est pas disponible pour votre compte.',
    ],
    '404' => [
        'title' => 'Page introuvable',
        'message' => 'La page que vous cherchez n\'existe pas ou a été déplacée.',
    ],
    '419' => [
        'title' => 'Session expirée',
        'message' => 'La page est restée ouverte trop longtemps. Rechargez-la et réessayez.',
    ],
    '429' => [
        'title' => 'Trop de requêtes',
        'message' => 'Attendez une minute et réessayez.',
    ],
    '500' => [
        'title' => 'Un problème est survenu',
        'message' => 'Nous avons un problème technique. Réessayez dans quelques minutes.',
    ],
    '503' => [
        'title' => 'De retour bientôt',
        'message' => 'Nous mettons le site à jour. Réessayez dans quelques minutes.',
    ],
    'label' => 'Erreur',
    'actions' => [
        'home' => 'Retour à l\'accueil',
        'events' => 'Voir les prochains événements',
        'reload' => 'Recharger la page',
        'login' => 'Se connecter',
    ],
];
