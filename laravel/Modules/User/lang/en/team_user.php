<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Team Member',
        'group' => 'Team',
        'icon' => 'heroicon-o-users',
        'sort' => 38,
    ],
    'label' => 'Team Member',
    'plural_label' => 'Team Members',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'team_id' => [
            'label' => 'Team',
        ],
        'role' => [
            'label' => 'Role',
        ],
        'joined_at' => [
            'label' => 'Joined At',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Change Role',
        ],
        'remove_user' => [
            'label' => 'Remove User',
        ],
    ],
];