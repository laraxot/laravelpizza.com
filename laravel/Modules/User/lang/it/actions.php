<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Azioni',
    'plural_label' => 'Azioni',
    'group' => 'User',
    'icon' => 'heroicon-o-cog',
    'sort' => 50,
  ),
  'label' => 'Azioni',
  'plural_label' => 'Azioni',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
  'attach_user' => 
  array (
    'label' => 'Collega Utente',
    'tooltip' => 'Collega un utente',
    'helper_text' => 'Collega un utente a questa risorsa',
    'description' => 'Azione per collegare un utente',
  ),
  'associate_user' => 
  array (
    'label' => 'Associa Utente',
    'tooltip' => 'Associa un utente',
    'helper_text' => 'Associa un utente a questa risorsa',
    'description' => 'Azione per associare un utente',
  ),
  'user_actions' => 
  array (
    'label' => 'Azioni Utente',
    'tooltip' => 'Azioni relative all\'utente',
    'helper_text' => 'Elenco delle azioni utente',
    'description' => 'Azioni utente disponibili',
  ),
  'view' => 
  array (
    'label' => 'Visualizza',
    'tooltip' => 'Visualizza dettagli',
    'helper_text' => 'Visualizza i dettagli',
    'description' => 'Azione di visualizzazione',
  ),
  'edit' => 
  array (
    'label' => 'Modifica',
    'tooltip' => 'Modifica elemento',
    'helper_text' => 'Modifica questo elemento',
    'description' => 'Azione di modifica',
  ),
  'delete' => 
  array (
    'label' => 'Elimina',
    'tooltip' => 'Elimina elemento',
    'helper_text' => 'Elimina questo elemento',
    'description' => 'Azione di eliminazione',
  ),
  'detach' => 
  array (
    'label' => 'Scollega',
    'tooltip' => 'Scollega elemento',
    'helper_text' => 'Scollega questo elemento',
    'description' => 'Azione di scollegamento',
  ),
  'replicate' => 
  array (
    'label' => 'Duplica',
    'tooltip' => 'Duplica elemento',
    'helper_text' => 'Crea una copia di questo elemento',
    'description' => 'Azione di duplicazione',
  ),
  'row_actions' => 
  array (
    'label' => 'Azioni Riga',
    'tooltip' => 'Azioni per questa riga',
    'helper_text' => 'Azioni disponibili per la riga',
    'description' => 'Azioni della riga',
  ),
  'delete_selected' => 
  array (
    'label' => 'Elimina Selezionati',
    'tooltip' => 'Elimina gli elementi selezionati',
    'helper_text' => 'Elimina tutti gli elementi selezionati',
    'description' => 'Azione bulk di eliminazione',
  ),
  'confirm_detach' => 
  array (
    'label' => 'Conferma Scollegamento',
    'tooltip' => 'Conferma lo scollegamento',
    'helper_text' => 'Sei sicuro di voler scollegare questo utente?',
    'description' => 'Messaggio di conferma scollegamento',
  ),
  'confirm_delete' => 
  array (
    'label' => 'Conferma Eliminazione',
    'tooltip' => 'Conferma l\'eliminazione',
    'helper_text' => 'Sei sicuro di voler eliminare gli utenti selezionati?',
    'description' => 'Messaggio di conferma eliminazione',
  ),
  'success_attached' => 
  array (
    'label' => 'Successo Collegamento',
    'tooltip' => 'Operazione riuscita',
    'helper_text' => 'Utente collegato con successo',
    'description' => 'Messaggio di successo',
  ),
  'success_detached' => 
  array (
    'label' => 'Successo Scollegamento',
    'tooltip' => 'Operazione riuscita',
    'helper_text' => 'Utente scollegato con successo',
    'description' => 'Messaggio di successo',
  ),
  'success_deleted' => 
  array (
    'label' => 'Successo Eliminazione',
    'tooltip' => 'Operazione riuscita',
    'helper_text' => 'Utenti eliminati con successo',
    'description' => 'Messaggio di successo',
  ),
  'oauth' => 
  array (
    'revoke_client' => 
    array (
      'label' => 'Revoca Client',
      'tooltip' => 'Revoca il client OAuth',
      'helper_text' => 'Revoca questo client OAuth',
      'description' => 'Azione per revocare il client',
      'modal' => 
      array (
        'heading' => 'Revoca Client OAuth',
        'description' => 'Sei sicuro di voler revocare questo client OAuth? Questa azione revocherà il client e tutti i token associati. L\'operazione non può essere annullata.',
        'confirm' => 'Revoca Client',
        'cancel' => 'Annulla',
      ),
      'success' => 'Client revocato con successo',
      'error' => 'Errore durante la revoca del client',
    ),
    'revoke_token' => 
    array (
      'label' => 'Revoca Token',
      'tooltip' => 'Revoca il token OAuth',
      'helper_text' => 'Revoca questo token',
      'description' => 'Azione per revocare il token',
      'modal' => 
      array (
        'heading' => 'Revoca Token OAuth',
        'description' => 'Sei sicuro di voler revocare questo token? L\'operazione non può essere annullata.',
        'confirm' => 'Revoca Token',
        'cancel' => 'Annulla',
      ),
      'success' => 'Token revocato con successo',
      'error' => 'Errore durante la revoca del token',
    ),
    'create_client' => 
    array (
      'label' => 'Crea Client',
      'tooltip' => 'Crea un nuovo client',
      'helper_text' => 'Crea un nuovo client OAuth',
      'description' => 'Azione per creare un client',
      'success' => 'Client creato con successo',
      'error' => 'Errore durante la creazione del client',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore',
  ),
);
