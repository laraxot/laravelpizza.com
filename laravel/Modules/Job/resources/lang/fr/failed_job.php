<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Emploi Échoué',
    'group' => 'Emplois Échoués',
    'icon' => 'heroicon-o-exclamation-triangle',
    'sort' => 27,
  ),
  'label' => 'Emploi Échoué',
  'plural_label' => 'Emplois Échoués',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'label' => 'Connexion',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'File d\'attente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Charge Utile',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'exception' => 
    array (
      'label' => 'Exception',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Échoué À',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Réessayer',
    ),
    'delete' => 
    array (
      'label' => 'Supprimer',
    ),
    'retry_all' => 
    array (
      'label' => 'Réessayer Tous',
    ),
    'delete_all' => 
    array (
      'label' => 'Supprimer Tous',
    ),
  ),
);
