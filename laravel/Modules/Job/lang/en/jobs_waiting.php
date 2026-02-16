<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Waiting Jobs',
    'plural' => 'Waiting Jobs',
    'group' => 
    array (
      'name' => 'System',
      'description' => 'Queue job monitoring',
    ),
    'label' => 'Waiting Jobs',
    'sort' => '15',
    'icon' => 'heroicon-o-cog',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco del job',
      'placeholder' => 'ID del job',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Queue',
      'tooltip' => 'Name of the job queue',
      'placeholder' => 'Select queue',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => 'Data associated with the job',
      'placeholder' => 'Load job data',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Attempts',
      'tooltip' => 'Number of execution attempts',
      'placeholder' => 'Attempts made',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reserved At',
      'tooltip' => 'Date and time when the job was reserved',
      'placeholder' => 'Select date',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Available At',
      'tooltip' => 'Date and time when the job becomes available',
      'placeholder' => 'Select date',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Job creation date',
      'placeholder' => 'Creation date',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Current job status',
      'placeholder' => 'Select status',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priority',
      'tooltip' => 'Job priority',
      'placeholder' => 'Select priority',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'tooltip' => 'Job type (Import, Export, etc.)',
      'placeholder' => 'Select type',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Job name',
      'placeholder' => 'Enter job name',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'tooltip' => 'Job description',
      'placeholder' => 'Enter description',
      'helper_text' => '',
      'description' => '',
    ),
    'delay' => 
    array (
      'label' => 'Delay',
      'tooltip' => 'Delay time before the job is executed',
      'placeholder' => 'Enter delay',
      'helper_text' => '',
      'description' => '',
    ),
    'timeout' => 
    array (
      'label' => 'Timeout',
      'tooltip' => 'Maximum job execution time',
      'placeholder' => 'Enter timeout',
      'helper_text' => '',
      'description' => '',
    ),
    'tags' => 
    array (
      'label' => 'Tags',
      'tooltip' => 'Tags associated with the job',
      'placeholder' => 'Enter tags',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'tooltip' => 'User\'s first name',
      'placeholder' => 'Enter first name',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'tooltip' => 'User\'s last name',
      'placeholder' => 'Enter last name',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'label' => 'Seleziona Tutti',
      'tooltip' => 'Seleziona tutti gli elementi disponibili',
      'placeholder' => '',
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
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa dati da un file XLS o CSV',
      'icon' => 'import-icon',
      'color' => 'blue',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'Seleziona un file XLS o CSV da caricare',
          'tooltip' => 'Seleziona un file da caricare per l\'importazione',
          'placeholder' => 'Scegli un file',
        ),
      ),
    ),
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
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
