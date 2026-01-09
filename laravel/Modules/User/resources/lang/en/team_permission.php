<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Team Permissions',
        'plural' => 'Team Permissions',
        'icon' => 'heroicon-o-lock-closed',
        'group' => 'Teams',
        'sort' => 20,
    ],
    'label' => 'Team Permission',
    'plural_label' => 'Team Permissions',
    'fields' => [
        'id' => ['label' => 'ID'],
        'team_id' => ['label' => 'Team'],
        'team.name' => ['label' => 'Team'],
        'user_id' => ['label' => 'User'],
        'user.name' => ['label' => 'User'],
        'permission' => ['label' => 'Permission'],
        'created_at' => ['label' => 'Created At'],
        'updated_at' => ['label' => 'Updated At'],
    ],
];
