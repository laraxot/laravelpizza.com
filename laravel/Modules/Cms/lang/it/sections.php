<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'class' => 
    array (
      'label' => 'Classi CSS',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'id' => 
    array (
      'label' => 'ID HTML',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'background_color' => 
    array (
      'label' => 'Colore Sfondo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'text_color' => 
    array (
      'label' => 'Colore Testo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'blocks' => 
  array (
    'logo' => 
    array (
      'title' => 'Logo',
      'fields' => 
      array (
        'image' => 'Immagine',
        'alt' => 'Testo Alternativo',
        'height' => 'Altezza',
      ),
    ),
    'navigation' => 
    array (
      'title' => 'Navigazione',
      'fields' => 
      array (
        'items' => 'Voci Menu',
        'label' => 'Etichetta',
        'url' => 'URL',
        'target' => 'Target',
        'is_active' => 'Attivo',
      ),
    ),
    'actions' => 
    array (
      'title' => 'Azioni',
      'fields' => 
      array (
        'items' => 'Bottoni',
        'label' => 'Etichetta',
        'url' => 'URL',
        'type' => 'Tipo',
      ),
      'types' => 
      array (
        'primary' => 'Primario',
        'secondary' => 'Secondario',
        'outline' => 'Outline',
        'link' => 'Link',
      ),
    ),
  ),
  'sections' => 
  array (
    'info' => 'Informazioni',
    'style' => 'Stile',
    'content' => 'Contenuti',
  ),
  'label' => 'Sections',
  'plural_label' => 'Sections (Plurale)',
  'navigation' => 
  array (
    'name' => 'Sections',
    'plural' => 'Sections',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Sections',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Sections',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Sections',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Sections',
    ),
  ),
);
