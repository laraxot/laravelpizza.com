<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Menu',
    'plural' => 'Menu',
    'group' => 
    array (
      'name' => 'Gestione Menu',
      'description' => 'Gestione dei menu del sito',
    ),
    'label' => 'Menu',
    'sort' => '57',
    'icon' => 'heroicon-o-bars-3',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID del menu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Nome del menu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Slug del menu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Descrizione del menu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Tipo di menu',
      'options' => 
      array (
        'main' => 'Principale',
        'footer' => 'Footer',
        'sidebar' => 'Barra laterale',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Stato del menu',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'draft' => 'Bozza',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'message',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'title',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 'Crea Menu',
    'edit' => 'Modifica Menu',
    'delete' => 'Elimina Menu',
    'sort' => 'Ordina Voci',
    'add_item' => 'Aggiungi Voce',
  ),
  'messages' => 
  array (
    'created' => 'Menu creato con successo',
    'updated' => 'Menu aggiornato con successo',
    'deleted' => 'Menu eliminato con successo',
    'sorted' => 'Voci del menu ordinate con successo',
    'item_added' => 'Voce aggiunta con successo',
  ),
  'validation' => 
  array (
    'name_required' => 'Der Name ist erforderlich',
    'slug_unique' => 'Lo slug deve essere unico',
    'type_in' => 'Il tipo deve essere uno tra: main, footer, sidebar',
  ),
  'model' => 
  array (
    'label' => 'menu.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
