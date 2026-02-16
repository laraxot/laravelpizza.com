<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Consensi',
    'plural' => 'Consensi',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Gestione dei consensi privacy',
    ),
    'label' => 'Gestione Consensi',
    'sort' => 62,
    'icon' => 'gdpr-consent',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo Consenso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'date' => 
    array (
      'label' => 'Data',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip_address' => 
    array (
      'label' => 'Indirizzo IP',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'statuses' => 
  array (
    'granted' => 'Concesso',
    'denied' => 'Negato',
    'withdrawn' => 'Revocato',
    'expired' => 'Scaduto',
  ),
  'actions' => 
  array (
    'grant' => 'Concedi',
    'deny' => 'Nega',
    'withdraw' => 'Revoca',
    'renew' => 'Rinnova',
  ),
  'label' => 'Consent',
  'plural_label' => 'Consent (Plurale)',
);
