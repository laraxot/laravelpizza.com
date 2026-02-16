<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Risorse Attività',
    'plural' => 'Risorse Attività',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Gestione delle risorse di attività',
    ),
    'label' => 'Risorse Attività',
    'sort' => 64,
    'icon' => 'activity-resource-animated',
  ),
  'fields' => 
  array (
    'resource_type' => 
    array (
      'label' => 'Tipo Risorsa',
      'help' => 'Tipo di risorsa attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resource_id' => 
    array (
      'label' => 'ID Risorsa',
      'help' => 'Identificativo della risorsa',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'activity_count' => 
    array (
      'label' => 'Numero Attività',
      'help' => 'Numero di attività associate',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_activity' => 
    array (
      'label' => 'Ultima Attività',
      'help' => 'Data e ora dell\'ultima attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view_activities' => 
    array (
      'label' => 'Visualizza Attività',
      'tooltip' => 'Visualizza tutte le attività della risorsa',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta dati della risorsa',
    ),
  ),
  'messages' => 
  array (
    'no_resources' => 'Nessuna risorsa trovata',
    'resource_exported' => 'Risorsa esportata con successo',
  ),
  'label' => 'Activity Resource',
  'plural_label' => 'Activity Resource (Plurale)',
);
