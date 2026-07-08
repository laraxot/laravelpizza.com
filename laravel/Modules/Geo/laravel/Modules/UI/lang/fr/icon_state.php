<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nom',
            'placeholder' => 'Entrez le nom',
            'help' => 'Nom d\'identification de l\'élément',
            'description' => 'Nom de l\'objet',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'edit-name' => [
            'label' => 'Modifier le nom',
            'placeholder' => 'Nouveau nom',
            'help' => 'Modifier le nom existant',
            'description' => 'Action pour modifier le nom',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'change-state' => [
            'label' => 'Changer l\'état',
            'placeholder' => 'Sélectionner un nouvel état',
            'help' => 'Modifier l\'état actuel',
            'description' => 'Action pour changer l\'état',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'État',
            'placeholder' => 'Sélectionner un état',
            'help' => 'État actuel de l\'élément',
            'description' => 'Condition actuelle du système',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Message',
            'placeholder' => 'Entrez un message',
            'help' => 'Message informatif',
            'description' => 'Texte du message',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'messages' => [
        'invalid_state_instance' => 'Instance d\'état non valide',
        'record_not_found' => 'Enregistrement non trouvé',
        'transition_completed' => [
            'title' => 'Transition terminée',
            'body' => 'La transition d\'état a été terminée avec succès',
        ],
        'transition_error' => [
            'title' => 'Erreur de transition',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
