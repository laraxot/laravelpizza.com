<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Eventi Privacy',
    'plural' => 'Eventi Privacy',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Registro degli eventi relativi alla privacy',
    ),
    'label' => 'Eventi Privacy',
    'sort' => 27,
    'icon' => 'gdpr-event',
  ),
  'fields' => 
  array (
    'event_type' => 
    array (
      'label' => 'Tipo Evento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user' => 
    array (
      'label' => 'Utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timestamp' => 
    array (
      'label' => 'Data e Ora',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'data' => 
    array (
      'label' => 'Dati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'source' => 
    array (
      'label' => 'Sorgente',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'event_types' => 
  array (
    'consent_granted' => 'Consenso Concesso',
    'consent_withdrawn' => 'Consenso Revocato',
    'data_access' => 'Accesso ai Dati',
    'data_modified' => 'Dati Modificati',
    'data_deleted' => 'Dati Eliminati',
  ),
  'label' => 'Event',
  'plural_label' => 'Event (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Event',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Event',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Event',
    ),
  ),
);
