<?php

declare(strict_types=1);

return array (
  'sections' => 
  array (
    'fields' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'tooltip' => 'Inserisci il nome della sezione',
      ),
      'slug' => 
      array (
        'label' => 'Slug',
        'tooltip' => 'Identificatore univoco della sezione',
      ),
      'image' => 
      array (
        'label' => 'Immagine',
        'tooltip' => 'Seleziona un\'immagine per la sezione',
      ),
      'content' => 
      array (
        'label' => 'Contenuto',
        'tooltip' => 'Inserisci il contenuto della sezione',
      ),
      'status' => 
      array (
        'label' => 'Stato',
        'tooltip' => 'Seleziona lo stato della sezione',
        'options' => 
        array (
          'draft' => 'Bozza',
          'published' => 'Pubblicato',
          'archived' => 'Archiviato',
        ),
      ),
    ),
  ),
  'blocks' => 
  array (
    'quick_links' => 
    array (
      'fields' => 
      array (
        'label' => 
        array (
          'label' => 'Etichetta',
          'tooltip' => 'Inserisci l\'etichetta per i link rapidi',
        ),
        'links' => 
        array (
          'label' => 'Link',
          'tooltip' => 'Aggiungi i link rapidi',
          'fields' => 
          array (
            'label' => 
            array (
              'label' => 'Etichetta',
              'tooltip' => 'Inserisci l\'etichetta del link',
            ),
            'url' => 
            array (
              'label' => 'URL',
              'tooltip' => 'Inserisci l\'URL del link',
            ),
          ),
        ),
      ),
    ),
    'footer' => 
    array (
      'links' => 
      array (
        'fields' => 
        array (
          'links' => 
          array (
            'label' => 'Link',
            'tooltip' => 'Aggiungi i link del footer',
            'fields' => 
            array (
              'label' => 
              array (
                'label' => 'Etichetta',
                'tooltip' => 'Inserisci l\'etichetta del link',
              ),
              'url' => 
              array (
                'label' => 'URL',
                'tooltip' => 'Inserisci l\'URL del link',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'filament' => 
  array (
    'blocks' => 
    array (
      'footer' => 
      array (
        'links' => 
        array (
          'fields' => 
          array (
            'links' => 
            array (
              'fields' => 
              array (
                'label' => 
                array (
                  'label' => 'Etichetta',
                  'tooltip' => 'Inserisci l\'etichetta del link',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'label' => 'Cms',
  'plural_label' => 'Cms (Plurale)',
  'navigation' => 
  array (
    'name' => 'Cms',
    'plural' => 'Cms',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Cms',
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
      'label' => 'Crea Cms',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Cms',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Cms',
    ),
  ),
);
