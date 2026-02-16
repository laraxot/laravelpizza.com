<?php

declare(strict_types=1);

return array (
  'name' => 'Snapshots',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID dello snapshot',
      'helper_text' => 'Identificativo univoco dello snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'aggregate_uuid' => 
    array (
      'label' => 'UUID Aggregato',
      'placeholder' => 'UUID dell\'aggregato',
      'helper_text' => 'Identificativo univoco dell\'aggregato',
      'tooltip' => '',
      'description' => '',
    ),
    'aggregate_version' => 
    array (
      'label' => 'Versione',
      'placeholder' => 'Versione dell\'aggregato',
      'helper_text' => 'Numero di versione dell\'aggregato',
      'tooltip' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Stato dello snapshot',
      'helper_text' => 'Stato corrente dello snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'helper_text' => 'Data di creazione dello snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'helper_text' => 'Data dell\'ultima modifica',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Snapshot',
      'tooltip' => 'Crea un nuovo snapshot',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica lo snapshot',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina lo snapshot',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli dello snapshot',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Snapshot creato con successo',
      'updated' => 'Snapshot aggiornato con successo',
      'deleted' => 'Snapshot eliminato con successo',
    ),
    'error' => 
    array (
      'create' => 'Errore durante la creazione dello snapshot',
      'update' => 'Errore durante l\'aggiornamento dello snapshot',
      'delete' => 'Errore durante l\'eliminazione dello snapshot',
    ),
    'confirm' => 
    array (
      'delete' => 'Sei sicuro di voler eliminare questo snapshot?',
    ),
  ),
  'filters' => 
  array (
    'aggregate_type' => 
    array (
      'label' => 'Tipo Aggregato',
      'options' => 
      array (
        'user' => 'Utente',
        'profile' => 'Profilo',
        'role' => 'Ruolo',
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
