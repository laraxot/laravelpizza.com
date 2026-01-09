<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token di Accesso OAuth',
        'plural' => 'Token di Accesso OAuth',
        'icon' => 'heroicon-o-key',
        'group' => 'OAuth',
        'sort' => 10,
    ],
    'label' => 'Token di Accesso OAuth',
    'plural_label' => 'Token di Accesso OAuth',
    'fields' => [
        'id' => ['label' => 'ID'],
        'user.name' => ['label' => 'Utente'],
        'client.name' => ['label' => 'Client'],
        'name' => ['label' => 'Nome'],
        'scopes' => ['label' => 'Scopes'],
        'revoked' => ['label' => 'Revocato'],
        'created_at' => ['label' => 'Creato il'],
        'expires_at' => ['label' => 'Scade il'],
        'user_id' => ['label' => 'ID Utente'],
        'client_id' => ['label' => 'ID Client'],
    ],
];
