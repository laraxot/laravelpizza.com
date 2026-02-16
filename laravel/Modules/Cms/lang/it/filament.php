<?php

declare(strict_types=1);

return array (
  'resources' => 
  array (
    'section' => 
    array (
      'label' => 'Sezione',
      'plural' => 'Sezioni',
      'navigation' => 
      array (
        'label' => 'Sezioni',
        'icon' => 'heroicon-o-rectangle-stack',
      ),
    ),
  ),
  'blocks' => 
  array (
    'footer' => 
    array (
      'label' => 'Footer',
      'info' => 
      array (
        'label' => 'Info Footer',
        'fields' => 
        array (
          'logo' => 'Logo Footer',
          'company_name' => 'Nome Azienda',
          'description' => 'Descrizione',
          'email' => 'Email',
          'phone' => 'Telefono',
          'address' => 'Indirizzo',
        ),
      ),
      'links' => 
      array (
        'label' => 'Link Footer',
        'fields' => 
        array (
          'title' => 'Titolo Sezione',
          'links' => 
          array (
            'label' => 'Link',
            'fields' => 
            array (
              'label' => 'Etichetta Link',
              'url' => 'URL',
              'icon' => 'Icona (opzionale]',
            ),
          ),
        ),
      ),
      'social' => 
      array (
        'label' => 'Social Footer',
        'fields' => 
        array (
          'title' => 'Titolo Sezione',
          'social_links' => 'Link Social',
          'platform' => 'Piattaforma Social',
          'url' => 'URL Profilo',
        ),
      ),
      'contact' => 
      array (
        'label' => 'Contatti Footer',
        'fields' => 
        array (
          'title' => 'Titolo Sezione',
          'address' => 'Indirizzo',
          'phone' => 'Telefono',
          'email' => 'Email',
        ),
      ),
      'newsletter' => 
      array (
        'label' => 'Newsletter Footer',
        'fields' => 
        array (
          'title' => 'Titolo Sezione',
          'description' => 'Descrizione',
          'button_text' => 'Testo Pulsante',
        ),
      ),
      'quick_links' => 
      array (
        'label' => 'Link Rapidi Footer',
        'fields' => 
        array (
          'title' => 'Titolo',
          'links' => 
          array (
            'label' => 'Link Rapidi',
            'fields' => 
            array (
              'label' => 'Etichetta',
              'url' => 'URL',
              'target' => 'Target',
            ),
          ),
        ),
      ),
    ),
  ),
  'label' => 'Filament',
  'plural_label' => 'Filament (Plurale)',
  'navigation' => 
  array (
    'name' => 'Filament',
    'plural' => 'Filament',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Filament',
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
      'label' => 'Crea Filament',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Filament',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Filament',
    ),
  ),
);
