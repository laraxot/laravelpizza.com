<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'send_email_parameters',
  ),
  'navigation' => 
  array (
    'name' => 'send_email_parameters',
    'plural' => 'send_email_parameters',
    'group' => 
    array (
      'name' => 'Invia',
    ),
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome Area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parent' => 
    array (
      'label' => 'Settore di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parent.name' => 
    array (
      'label' => 'Settore di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parent_name' => 
    array (
      'label' => 'Settore di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'assets' => 
    array (
      'label' => 'Quantità di asset',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'name' => 'Importa da file',
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'name' => 'Esporta dati',
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
  ),
  'label' => 'Send Email Parameters',
  'plural_label' => 'Send Email Parameters (Plurale)',
);
