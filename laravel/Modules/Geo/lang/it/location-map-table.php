<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Tabella Posizioni',
    'group' => 'Gestione Territorio',
    'icon' => 'ui-geo-location',
    'sort' => 15,
  ],
  'table' => [
    'columns' => [
      'name' => 'Nome',
      'address' => 'Indirizzo',
      'coordinates' => 'Coordinate',
      'actions' => 'Azioni',
    ],
    'filters' => [
      'with_coordinates' => 'Con coordinate',
      'without_coordinates' => 'Senza coordinate',
    ],
  ],
  'actions' => [
    'view_on_map' => 'Visualizza sulla mappa',
    'edit_coordinates' => 'Modifica coordinate',
    'export' => 'Esporta dati',
  ],
  'label' => 'Location Map Table',
  'plural_label' => 'Location Map Table (Plurale)',
  'fields' => [
    'id' => [
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
    ],
    'created_at' => [
      'label' => 'Data Creazione',
    ],
    'updated_at' => [
      'label' => 'Ultima Modifica',
    ],
  ],
];
