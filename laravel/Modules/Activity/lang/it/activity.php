<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Attività',
    'plural' => 'Attività',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Gestione delle attività di sistema',
    ),
    'label' => 'Attività',
    'sort' => 60,
    'icon' => 'activity-animated',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'help' => 'Identificativo unico dell\'attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'log_name' => 
    array (
      'label' => 'Nome Log',
      'help' => 'Nome del log di attività',
      'placeholder' => 'log_name',
      'helper_text' => 'log_name',
      'description' => 'log_name',
      'tooltip' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'help' => 'Descrizione dell\'attività',
      'placeholder' => 'description',
      'helper_text' => 'description',
      'description' => 'description',
      'tooltip' => '',
    ),
    'subject_type' => 
    array (
      'label' => 'Tipo Soggetto',
      'help' => 'Tipo di entità coinvolta',
      'placeholder' => 'subject_type',
      'helper_text' => 'subject_type',
      'description' => 'subject_type',
      'tooltip' => '',
    ),
    'subject_id' => 
    array (
      'label' => 'ID Soggetto',
      'help' => 'Identificativo dell\'entità coinvolta',
      'placeholder' => 'subject_id',
      'helper_text' => 'subject_id',
      'description' => 'subject_id',
      'tooltip' => '',
    ),
    'causer_type' => 
    array (
      'label' => 'Tipo Causatore',
      'help' => 'Tipo di entità che ha causato l\'attività',
      'placeholder' => 'causer_type',
      'helper_text' => 'causer_type',
      'description' => 'causer_type',
      'tooltip' => '',
    ),
    'causer_id' => 
    array (
      'label' => 'ID Causatore',
      'help' => 'Identificativo dell\'entità che ha causato l\'attività',
      'placeholder' => 'causer_id',
      'helper_text' => 'causer_id',
      'description' => 'causer_id',
      'tooltip' => '',
    ),
    'properties' => 
    array (
      'label' => 'Proprietà',
      'help' => 'Proprietà aggiuntive dell\'attività',
      'placeholder' => 'properties',
      'helper_text' => 'properties',
      'description' => 'properties',
      'tooltip' => '',
    ),
    'batch_uuid' => 
    array (
      'label' => 'Batch UUID',
      'help' => 'Identificativo del batch di attività',
      'placeholder' => 'batch_uuid',
      'helper_text' => 'batch_uuid',
      'description' => 'batch_uuid',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione dell\'attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'help' => 'Data e ora di aggiornamento dell\'attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza dettagli attività',
    ),
    'restore' => 
    array (
      'label' => 'Ripristina',
      'tooltip' => 'Ripristina stato precedente',
    ),
  ),
  'messages' => 
  array (
    'no_activities' => 'Nessuna attività trovata',
    'activity_restored' => 'Attività ripristinata con successo',
  ),
  'label' => 'Activity',
  'plural_label' => 'Activity (Plurale)',
);
