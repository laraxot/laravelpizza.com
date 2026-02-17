<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Codici Autorizzazione OAuth',
        'plural_label' => 'Codici Autorizzazione OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-code-bracket',
        'sort' => 31,
    ],
    'label' => 'Codice Autorizzazione OAuth',
    'plural_label' => 'Codici Autorizzazione OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco',
            'helper_text' => 'Identificativo numerico del codice',
            'description' => 'ID del codice',
        ],
        'user_id' => [
            'label' => 'Utente',
            'tooltip' => 'Utente associato',
            'placeholder' => 'Seleziona l\'utente',
            'helper_text' => 'Utente proprietario del codice',
            'description' => 'ID dell\'utente',
        ],
        'client_id' => [
            'label' => 'Client',
            'tooltip' => 'Client OAuth',
            'placeholder' => 'Seleziona il client',
            'helper_text' => 'Client che ha generato il codice',
            'description' => 'ID del client OAuth',
        ],
        'scopes' => [
            'label' => 'Ambiti',
            'tooltip' => 'Permessi del codice',
            'placeholder' => 'Seleziona gli ambiti',
            'helper_text' => 'Ambiti di permesso',
            'description' => 'Permessi associati al codice',
        ],
        'revoked' => [
            'label' => 'Revocato',
            'tooltip' => 'Stato di revoca',
            'helper_text' => 'Indica se il codice è stato revocato',
            'description' => 'Stato di revoca',
        ],
        'expires_at' => [
            'label' => 'Scade il',
            'tooltip' => 'Data di scadenza',
            'placeholder' => 'Seleziona la data',
            'helper_text' => 'Data e ora di scadenza del codice',
            'description' => 'Data di scadenza',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
            'tooltip' => 'Revoca il codice',
            'helper_text' => 'Revoca questo codice',
            'description' => 'Azione per revocare il codice',
            'success' => 'Codice di autorizzazione revocato con successo',
        ],
    ],
    'messages' => [
        'revoked' => 'Codice revocato con successo',
    ],
];
