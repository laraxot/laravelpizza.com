<?php

declare(strict_types=1);

return [
    'navigation' => ['label' => 'Codici Dispositivo OAuth', 'plural_label' => 'Codici Dispositivo OAuth', 'group' => 'OAuth', 'icon' => 'heroicon-o-device-phone-mobile', 'sort' => 32],
    'label' => 'Codice Dispositivo OAuth',
    'plural_label' => 'Codici Dispositivo OAuth',
    'fields' => [
        'id' => ['label' => 'ID', 'tooltip' => 'Identificativo univoco del codice dispositivo', 'helper_text' => 'ID del codice dispositivo (RFC8628)', 'description' => 'ID del codice'],
        'user_code' => ['label' => 'Codice utente', 'tooltip' => 'Codice da inserire sul dispositivo secondario', 'placeholder' => 'Es. ABCD-1234', 'helper_text' => 'Codice breve mostrato all\'utente per l\'autorizzazione', 'description' => 'Codice utente'],
        'user_id' => ['label' => 'Utente', 'tooltip' => 'Utente che ha approvato (se approvato)', 'placeholder' => 'Seleziona l\'utente', 'helper_text' => 'Utente che ha autorizzato il dispositivo', 'description' => 'ID dell\'utente'],
        'client_id' => ['label' => 'Client', 'tooltip' => 'Client OAuth', 'placeholder' => 'Seleziona il client', 'helper_text' => 'Client che ha richiesto l\'autorizzazione', 'description' => 'ID del client OAuth'],
        'scopes' => ['label' => 'Ambiti', 'tooltip' => 'Permessi richiesti', 'placeholder' => 'Ambiti', 'helper_text' => 'Ambiti di permesso richiesti', 'description' => 'Permessi associati'],
    ],
    'messages' => ['revoked' => 'Codice dispositivo revocato con successo'],
];
