<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utilisateur du locataire',
        'group' => 'Locataire',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 39,
    ],
    'label' => 'Utilisateur du locataire',
    'plural_label' => 'Utilisateurs du locataire',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'tenant_id' => [
            'label' => 'Locataire',
        ],
        'role' => [
            'label' => 'Rôle',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'updated_at' => [
            'label' => 'Mis à jour le',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Changer le rôle',
        ],
        'remove_user' => [
            'label' => 'Supprimer l\'utilisateur',
        ],
    ],
];