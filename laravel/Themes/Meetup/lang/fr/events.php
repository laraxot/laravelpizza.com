<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label' => 'Tous les événements',
            'description' => 'Libellé du filtre : tous les événements',
        ],
        'upcoming' => [
            'label' => 'À venir',
            'description' => 'Libellé : événements à venir',
        ],
        'past' => [
            'label' => 'Événements passés',
            'description' => 'Libellé : événements passés',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label' => 'À propos de cet événement',
            'description' => 'Titre de section pour la description',
        ],
        'event_details' => [
            'label' => 'Détails de l’événement',
            'description' => 'Titre de section pour les informations',
        ],
        'date' => [
            'label' => 'Date',
            'description' => 'Libellé pour la date',
        ],
        'time' => [
            'label' => 'Heure',
            'description' => 'Libellé pour l’heure',
        ],
        'location' => [
            'label' => 'Lieu',
            'description' => 'Libellé pour le lieu',
        ],
        'language' => [
            'label' => 'Langue',
            'description' => 'Libellé pour la langue',
        ],
        'attendees' => [
            'label' => 'Participants',
            'description' => 'Libellé pour les participants',
        ],
        'people_joined' => [
            'label' => ':count personnes ont participé',
            'description' => 'Message : nombre de participants',
        ],
        'available_spots' => [
            'label' => ':count places disponibles',
            'description' => 'Message : places disponibles',
        ],
        'spots_filled' => [
            'label' => 'places occupées',
            'description' => 'Libellé : places occupées',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label' => 'Retour aux événements',
            'tooltip' => 'Revenir à la liste',
            'helper_text' => '',
            'description' => 'Lien retour à la liste',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
        ],
        'register_now' => [
            'label' => 'S’inscrire maintenant',
            'tooltip' => 'Réserver votre place',
            'helper_text' => '',
            'description' => 'CTA inscription',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'primary',
        ],
        'join_event' => [
            'label' => 'Participer à cet événement',
            'tooltip' => 'S’inscrire pour participer',
            'helper_text' => '',
            'description' => 'CTA participation',
            'icon' => 'heroicon-o-user-plus',
            'color' => 'primary',
        ],
        'book_your_spot' => [
            'label' => 'Réservez votre place !',
            'tooltip' => 'Réserver votre place',
            'helper_text' => '',
            'description' => 'CTA urgence',
            'icon' => 'heroicon-o-ticket',
            'color' => 'primary',
        ],
        'share_event' => [
            'label' => 'Partager cet événement',
            'tooltip' => 'Partager avec des amis',
            'helper_text' => '',
            'description' => 'Libellé bouton partager',
            'icon' => 'heroicon-o-share',
            'color' => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label' => 'Aucun événement trouvé',
            'description' => 'Message lorsqu’aucun événement n’est disponible',
        ],
        'check_back_later' => [
            'label' => 'Revenez plus tard',
            'description' => 'Invitation à revenir plus tard',
        ],
        'event_fallback_title' => [
            'label' => 'Événement',
            'description' => 'Titre de secours lorsque le titre manque',
        ],
        'spots_filling_fast' => [
            'label' => 'Les places partent vite !',
            'description' => 'Message d’urgence pour places limitées',
        ],
        'event_location' => [
            'label' => 'Lieu de l’événement',
            'description' => 'Titre section lieu',
        ],
        'map_loading' => [
            'label' => 'Chargement de la carte…',
            'description' => 'Message pendant le chargement de la carte',
        ],
        'click_to_view' => [
            'label' => 'Voir sur Google Maps',
            'description' => 'Instruction pour voir la localisation sur la carte',
        ],
    ],
];
