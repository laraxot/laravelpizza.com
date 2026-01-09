<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Permessi Team',
        'plural' => 'Permessi Team',
        'icon' => 'heroicon-o-lock-closed',
        'group' => 'Team',
        'sort' => 20,
    ],
    'label' => 'Permesso Team',
    'plural_label' => 'Permessi Team',
    'fields' => [
        'id' => ['label' => 'ID'],
        'team_id' => ['label' => 'Team'],
        'team.name' => ['label' => 'Team'],
        'user_id' => ['label' => 'Utente'],
        'user.name' => ['label' => 'Utente'],
        'permission' => ['label' => 'Permesso'],
        'created_at' => ['label' => 'Creato il'],
        'updated_at' => ['label' => 'Aggiornato il'],
    ],
];
