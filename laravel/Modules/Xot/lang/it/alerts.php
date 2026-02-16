<?php

declare(strict_types=1);

return array (
  'backend' => 
  array (
    'roles' => 
    array (
      'created' => 'Ruolo creato con successo.',
      'deleted' => 'Ruolo cancellato con successo.',
      'updated' => 'Ruolo aggiornato con successo.',
    ),
    'users' => 
    array (
      'confirmation_email' => 'Una nuova e-mail di conferma è stata inviata all\'indirizzo registrato.',
      'created' => 'L\'utente è stato creato con successo',
      'deleted' => 'L\'utente è stato eliminato con successo.',
      'deleted_permanently' => 'L\'utente è stato eliminato definitivamente.',
      'restored' => 'L\'utente è stato ripristinato con successo.',
      'updated' => 'L\'utente è stato aggiornato con successo.',
      'updated_password' => 'La password dell\'utente è stata aggiornata con successo.',
    ),
  ),
  'label' => 'Alerts',
  'plural_label' => 'Alerts (Plurale)',
  'navigation' => 
  array (
    'name' => 'Alerts',
    'plural' => 'Alerts',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Alerts',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Alerts',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Alerts',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Alerts',
    ),
  ),
);
