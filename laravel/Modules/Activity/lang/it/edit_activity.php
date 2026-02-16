<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Modifica Attività',
    'plural' => 'Modifica Attività',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Modifica delle attività di sistema',
    ),
    'label' => 'Modifica Attività',
    'sort' => 65,
    'icon' => 'activity-edit-animated',
  ),
  'form' => 
  array (
    'title' => 'Modifica Attività',
    'description' => 'Modifica i dettagli dell\'attività',
    'save' => 'Salva Modifiche',
    'cancel' => 'Annulla',
  ),
  'fields' => 
  array (
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci descrizione',
      'help' => 'Descrizione dettagliata dell\'attività',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'properties' => 
    array (
      'label' => 'Proprietà',
      'placeholder' => 'Inserisci proprietà',
      'help' => 'Proprietà aggiuntive in formato JSON',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'metadata' => 
    array (
      'label' => 'Metadata',
      'placeholder' => 'Inserisci metadata',
      'help' => 'Informazioni metadata aggiuntive',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Attività modificata con successo',
    'error' => 'Errore durante la modifica dell\'attività',
    'validation_error' => 'Errore di validazione: controlla i campi inseriti',
  ),
  'validation' => 
  array (
    'description.required' => 'La descrizione è obbligatoria',
    'description.max' => 'La descrizione non può superare :max caratteri',
    'properties.json' => 'Le proprietà devono essere un JSON valido',
  ),
  'label' => 'Edit Activity',
  'plural_label' => 'Edit Activity (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Edit Activity',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Edit Activity',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Edit Activity',
    ),
  ),
);
