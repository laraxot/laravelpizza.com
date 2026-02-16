<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Navigation Label',
    'group' => 'Job',
    'icon' => 'heroicon-o-cog',
    'sort' => 50,
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'description' => 'Unique identifier for the job',
      'helper_text' => 'Auto-generated job identifier',
      'tooltip' => '',
    ),
    'queue' => 
    array (
      'label' => 'Queue',
      'description' => 'Queue name where the job is waiting',
      'helper_text' => 'Name of the queue this job belongs to',
      'tooltip' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'description' => 'Job data and parameters',
      'helper_text' => 'Serialized job data and parameters',
      'tooltip' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Attempts',
      'description' => 'Number of execution attempts',
      'helper_text' => 'How many times this job has been attempted',
      'tooltip' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reserved At',
      'description' => 'When the job was reserved for processing',
      'helper_text' => 'Timestamp when job was picked up for processing',
      'tooltip' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Available At',
      'description' => 'When the job becomes available for processing',
      'helper_text' => 'Timestamp when job becomes available for execution',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'description' => 'When the job was created',
      'helper_text' => 'Timestamp when job was added to queue',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta i dati in un file',
      'icon' => 'export-icon',
      'color' => 'green',
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Nome area',
          'tooltip' => 'Nome dell\'area da esportare',
        ),
        'parent_name' => 
        array (
          'label' => 'Nome area livello superiore',
          'tooltip' => 'Nome dell\'area di livello superiore',
        ),
      ),
    ),
    'process' => 
    array (
      'label' => 'Processa',
      'tooltip' => 'Processa il job in attesa',
      'icon' => 'play-circle',
      'color' => 'green',
      'modal' => 
      array (
        'heading' => 'Processa Job',
        'description' => 'Vuoi processare questo job in attesa?',
      ),
      'messages' => 
      array (
        'success' => 'Job processato con successo',
      ),
    ),
    'cancel' => 
    array (
      'label' => 'Cancella',
      'tooltip' => 'Cancella il job in attesa',
      'icon' => 'delete-icon',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Cancella Job',
        'description' => 'Vuoi cancellare questo job in attesa?',
      ),
      'messages' => 
      array (
        'success' => 'Job cancellato con successo',
      ),
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
      'tooltip' => 'Riprova il job fallito',
      'icon' => 'redo',
      'color' => 'yellow',
      'modal' => 
      array (
        'heading' => 'Riprova Job',
        'description' => 'Vuoi riprovare questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Job riprovato con successo',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun job in attesa',
    'job_processed' => 'Job processato',
    'job_cancelled' => 'Job cancellato',
    'job_retried' => 'Job riprovato',
  ),
  'statuses' => 
  array (
    'waiting' => 'In Attesa',
    'reserved' => 'Riservato',
    'delayed' => 'Ritardato',
    'ready' => 'Pronto',
  ),
  'priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
  ),
  'types' => 
  array (
    'default' => 'Default',
    'scheduled' => 'Schedulato',
    'recurring' => 'Ricorrente',
    'batch' => 'Batch',
  ),
  'label' => 'Jobs Waiting',
  'plural_label' => 'Jobs Waiting (Plurale)',
);
