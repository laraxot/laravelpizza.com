<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Codici Dispositivo OAuth',
        'plural_label' => 'Codici Dispositivo OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => 32,
    ],
    'label' => 'Codice Dispositivo OAuth',
    'plural_label' => 'Codici Dispositivo OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del codice dispositivo',
            'helper_text' => 'ID del codice dispositivo (RFC8628)',
            'description' => 'ID del codice',
        ],
        'user_code' => [
            'label' => 'Codice utente',
            'tooltip' => 'Codice da inserire sul dispositivo secondario',
            'placeholder' => 'Es. ABCD-1234',
            'helper_text' => 'Codice breve mostrato all\'utente per l\'autorizzazione',
            'description' => 'Codice utente',
        ],
        'user_id' => [
            'label' => 'Utente',
            'tooltip' => 'Utente che ha approvato (se approvato)',
            'placeholder' => 'Seleziona l\'utente',
            'helper_text' => 'Utente che ha autorizzato il dispositivo',
            'description' => 'ID dell\'utente',
        ],
        'client_id' => [
            'label' => 'Client',
            'tooltip' => 'Client OAuth',
            'placeholder' => 'Seleziona il client',
            'helper_text' => 'Client che ha richiesto l\'autorizzazione',
            'description' => 'ID del client OAuth',
        ],
        'scopes' => [
            'label' => 'Ambiti',
            'tooltip' => 'Permessi richiesti',
            'placeholder' => 'Ambiti',
            'helper_text' => 'Ambiti di permesso richiesti',
            'description' => 'Permessi associati',
        ],
        'revoked' => [
            'label' => 'Revocato',
            'tooltip' => 'Stato di revoca',
            'helper_text' => 'Indica se il codice è stato revocato',
            'description' => 'Stato di revoca',
        ],
        'user_approved_at' => [
            'label' => 'Approvato il',
            'tooltip' => 'Data e ora di approvazione',
            'placeholder' => 'Data approvazione',
            'helper_text' => 'Quando l\'utente ha approvato il dispositivo',
            'description' => 'Data approvazione',
        ],
        'last_polled_at' => [
            'label' => 'Ultimo polling',
            'tooltip' => 'Ultima richiesta di verifica',
            'placeholder' => 'Data ultimo polling',
            'helper_text' => 'Ultima volta che il client ha verificato lo stato',
            'description' => 'Data ultimo polling',
        ],
        'expires_at' => [
            'label' => 'Scade il',
            'tooltip' => 'Data di scadenza',
            'placeholder' => 'Seleziona la data',
            'helper_text' => 'Data e ora di scadenza del codice',
            'description' => 'Data di scadenza',
        ],
    ],
    'filters' => [
        'revoked' => 'Revocati',
        'expired' => 'Scaduti',
        'valid' => 'Validi',
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
            'tooltip' => 'Revoca il codice dispositivo',
            'helper_text' => 'Revoca questo codice dispositivo',
            'description' => 'Azione per revocare il codice',
            'success' => 'Codice dispositivo revocato con successo',
        ],
    ],
    'messages' => [
        'revoked' => 'Codice dispositivo revocato con successo',
    ],
];
