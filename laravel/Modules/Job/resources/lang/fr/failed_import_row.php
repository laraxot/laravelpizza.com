<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Ligne d\'Importation Échouée',
    'group' => 'Lignes d\'Importation',
    'icon' => 'heroicon-o-exclamation-circle',
    'sort' => 28,
  ),
  'label' => 'Ligne d\'Importation Échouée',
  'plural_label' => 'Lignes d\'Importation Échouées',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'import_batch_id' => 
    array (
      'label' => 'ID du Lot d\'Importation',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'row_index' => 
    array (
      'label' => 'Index de Ligne',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'errors' => 
    array (
      'label' => 'Erreurs',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'data' => 
    array (
      'label' => 'Données',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Créé À',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view_errors' => 
    array (
      'label' => 'Voir les Erreurs',
    ),
    'fix_row' => 
    array (
      'label' => 'Corriger la Ligne',
    ),
  ),
);
