<?php

declare(strict_types=1);

return [
    'fields' => [
        'user_id' => ['label' => 'user_id', 'placeholder' => 'user_id', 'helper_text' => 'user_id', 'description' => 'user_id'],
        'client_id' => ['label' => 'client_id', 'placeholder' => 'client_id', 'helper_text' => 'client_id', 'description' => 'client_id'],
        'scopes' => ['label' => 'scopes', 'placeholder' => 'scopes', 'helper_text' => 'scopes', 'description' => 'scopes'],
        'revoked' => ['label' => 'revoked', 'placeholder' => 'revoked', 'helper_text' => 'revoked', 'description' => 'revoked'],
        'name' => ['label' => 'name', 'placeholder' => 'name', 'helper_text' => 'name', 'description' => 'name'],
        'expires_at' => ['label' => 'expires_at', 'placeholder' => 'expires_at', 'helper_text' => 'expires_at', 'description' => 'expires_at'],
    ],
    'sections' => [
        'empty' => ['label' => 'empty', 'heading' => 'empty'],
        'Codice Autorizzazione OAuth' => ['label' => 'Codice Autorizzazione OAuth', 'heading' => 'Codice Autorizzazione OAuth'],
    ],
];
