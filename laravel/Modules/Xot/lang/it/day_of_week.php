<?php

declare(strict_types=1);

return array (
  'label' => 'Giorno della Settimana',
  'options' => 
  array (
    1 => 'Lunedì',
    2 => 'Martedì',
    3 => 'Mercoledì',
    4 => 'Giovedì',
    5 => 'Venerdì',
    6 => 'Sabato',
    7 => 'Domenica',
  ),
  'plural_label' => 'Day Of Week (Plurale)',
  'navigation' => 
  array (
    'name' => 'Day Of Week',
    'plural' => 'Day Of Week',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Day Of Week',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Day Of Week',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Day Of Week',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Day Of Week',
    ),
  ),
);
