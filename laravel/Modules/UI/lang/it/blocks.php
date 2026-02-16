<?php

declare(strict_types=1);

return [
  'navigation' => [
    'fields' => [
      'items' => [
        'label' => 'Voci di navigazione',
      ],
      'text' => [
        'label' => 'Testo link',
      ],
      'url' => [
        'label' => 'URL link',
      ],
    ],
  ],
  'category' => [
    'fields' => [
      'name' => [
        'label' => 'Nome',
      ],
      'slug' => [
        'label' => 'Slug',
      ],
      'parent' => [
        'label' => 'Categoria padre',
      ],
    ],
  ],
  'post' => [
    'fields' => [
      'title' => [
        'label' => 'Titolo',
      ],
      'content' => [
        'label' => 'Contenuto',
      ],
      'image' => [
        'label' => 'Immagine',
      ],
    ],
  ],
  'contact' => [
    'fields' => [
      'name' => [
        'label' => 'Nome',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'phone' => [
        'label' => 'Telefono',
      ],
    ],
  ],
  'label' => 'Blocks',
  'plural_label' => 'Blocks (Plurale)',
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
  'actions' => [
    'create' => [
      'label' => 'Crea Blocks',
    ],
    'edit' => [
      'label' => 'Modifica Blocks',
    ],
    'delete' => [
      'label' => 'Elimina Blocks',
    ],
  ],
];
