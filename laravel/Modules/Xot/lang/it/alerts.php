<?php

declare(strict_types=1);

return [
  'backend' => [
    'roles' => [
      'created' => 'Ruolo creato con successo.',
      'deleted' => 'Ruolo cancellato con successo.',
      'updated' => 'Ruolo aggiornato con successo.',
    ],
    'users' => [
      'confirmation_email' => 'Una nuova e-mail di conferma è stata inviata all\'indirizzo registrato.',
      'created' => 'L\'utente è stato creato con successo',
      'deleted' => 'L\'utente è stato eliminato con successo.',
      'deleted_permanently' => 'L\'utente è stato eliminato definitivamente.',
      'restored' => 'L\'utente è stato ripristinato con successo.',
      'updated' => 'L\'utente è stato aggiornato con successo.',
      'updated_password' => 'La password dell\'utente è stata aggiornata con successo.',
    ],
  ],
  'label' => 'Alerts',
  'plural_label' => 'Alerts (Plurale)',
  'navigation' => [
    'name' => 'Alerts',
    'plural' => 'Alerts',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Alerts',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'fields' => [
    'id' => [
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
    ],
    'created_at' => [
      'label' => 'Data Creazione',
    ],
    'updated_at' => [
      'label' => 'Ultima Modifica',
    ],
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Alerts',
    ],
    'edit' => [
      'label' => 'Modifica Alerts',
    ],
    'delete' => [
      'label' => 'Elimina Alerts',
    ],
  ],
];
