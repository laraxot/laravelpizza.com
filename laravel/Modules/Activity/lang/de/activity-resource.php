<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco dell\'attività999',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Descrizione dell\'attività',
      'helper_text' => '',
      'description' => '',
    ),
    'subject_type' => 
    array (
      'label' => 'Tipo Soggetto',
      'tooltip' => 'Tipo di entità soggetta all\'attività',
      'helper_text' => '',
      'description' => '',
    ),
    'subject_id' => 
    array (
      'label' => 'ID Soggetto',
      'tooltip' => 'Identificativo dell\'entità soggetta all\'attività',
      'helper_text' => '',
      'description' => '',
    ),
    'causer_type' => 
    array (
      'label' => 'Tipo Autore',
      'tooltip' => 'Tipo di entità che ha causato l\'attività',
      'helper_text' => '',
      'description' => '',
    ),
    'causer_id' => 
    array (
      'label' => 'ID Autore',
      'tooltip' => 'Identificativo dell\'entità che ha causato l\'attività',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'Data e ora di creazione dell\'attività',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli dell\'attività',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina questa attività',
      'confirmation' => 'Sei sicuro di voler eliminare questa attività?',
    ),
  ),
  'filters' => 
  array (
    'date' => 
    array (
      'label' => 'Data',
      'tooltip' => 'Filtra per data di creazione',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Filtra per tipo di attività',
    ),
  ),
  'snapshots' => 
  array (
    'fields' => 
    array (
      'id' => 
      array (
        'label' => 'ID',
        'help' => 'Identificativo univoco dello snapshot',
      ),
      'aggregate_uuid' => 
      array (
        'label' => 'UUID Aggregato',
        'help' => 'UUID dell\'aggregato',
      ),
      'aggregate_version' => 
      array (
        'label' => 'Versione Aggregato',
        'help' => 'Versione dell\'aggregato',
      ),
      'state' => 
      array (
        'label' => 'Stato',
        'help' => 'Stato dello snapshot',
      ),
      'created_at' => 
      array (
        'label' => 'Data Creazione',
        'help' => 'Data di creazione dello snapshot',
      ),
      'updated_at' => 
      array (
        'label' => 'Data Aggiornamento',
        'help' => 'Data di ultimo aggiornamento dello snapshot',
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
