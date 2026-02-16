<?php

declare(strict_types=1);

return [
    'attach_user' => 'Collega Utente',
    'associate_user' => 'Associa Utente',
    'user_actions' => 'Azioni Utente',
    'view' => 'Visualizza',
    'edit' => 'Modifica',
    'delete' => 'Cancella',
    'detach' => 'Scollega',
    'replicate' => 'Duplica',
    'row_actions' => 'Azioni',
    'delete_selected' => 'Elimina Selezionati',
    'confirm_detach' => 'Sei sicuro di voler scollegare questo utente?',
    'confirm_delete' => 'Sei sicuro di voler eliminare gli utenti selezionati?',
    'success_attached' => 'Utente collegato con successo',
    'success_detached' => 'Utente scollegato con successo',
    'success_deleted' => 'Utenti eliminati con successo',
    'oauth' => [
        'revoke_client' => [
            'label' => 'Revoca Client',
            'modal' => [
                'heading' => 'Revoca Client OAuth',
                'description' => 'Sei sicuro di voler revocare questo client OAuth? Questa azione revocherà il client e tutti i token associati. L\'operazione non può essere annullata.',
                'confirm' => 'Revoca Client',
            ],
            'success' => 'Client revocato con successo',
            'error' => 'Errore durante la revoca del client',
        ],
        'revoke_token' => [
            'label' => 'Revoca Token',
            'modal' => [
                'heading' => 'Revoca Token OAuth',
                'description' => 'Sei sicuro di voler revocare questo token? L\'operazione non può essere annullata.',
                'confirm' => 'Revoca Token',
            ],
            'success' => 'Token revocato con successo',
            'error' => 'Errore durante la revoca del token',
        ],
        'create_client' => [
            'label' => 'Crea Client',
            'success' => 'Client creato con successo',
            'error' => 'Errore durante la creazione del client',
        ],
    ],
    'navigation' => [],
    'label' => '',
    'plural_label' => '',
    'fields' => [],
    'actions' => [],
];
