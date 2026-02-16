<?php

declare(strict_types=1);

return array (
  'breadcrumb' => 'Cronologia',
  'title' => 'Cronologia :record',
  'default_datetime_format' => 'd/m/Y, H:i:s',
  'table' => 
  array (
    'field' => 'Campo',
    'old' => 'Vecchio',
    'new' => 'Nuovo',
    'restore' => 'Ripristina',
  ),
  'events' => 
  array (
    'updated' => 'Aggiornato',
    'created' => 'Creato',
    'deleted' => 'Eliminato',
    'restored' => 'Ripristinato',
    'restore_successful' => 'Ripristinato con successo',
    'restore_failed' => 'Ripristino fallito',
  ),
  'subject' => 
  array (
    'type' => 'Tipo',
    'id' => 'ID',
    'unknown' => 'Sconosciuto',
  ),
  'metadata' => 
  array (
    'log_name' => 'Log',
    'batch_uuid' => 'Batch UUID',
    'properties' => 'Proprietà',
  ),
  'no_changes' => 'Nessuna modifica registrata',
  'no_description' => 'Nessuna descrizione disponibile',
  'modified' => 'Modificato',
  'fields_modified' => ':count campo modificato|:count campi modificati',
  'anonymous' => 'Utente Anonimo',
  'label' => 'Activities',
  'plural_label' => 'Activities (Plurale)',
  'navigation' => 
  array (
    'name' => 'Activities',
    'plural' => 'Activities',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Activities',
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
      'label' => 'Crea Activities',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Activities',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Activities',
    ),
  ),
);
