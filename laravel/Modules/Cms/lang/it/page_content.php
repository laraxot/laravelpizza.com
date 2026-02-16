<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Contenuti Pagina',
    'plural' => 'Contenuti Pagina',
    'group' => 
    array (
      'name' => 'Gestione Contenuti',
      'description' => 'Gestione dei contenuti delle pagine del sito',
    ),
    'label' => 'Contenuti Pagina',
    'sort' => 87,
    'icon' => 'heroicon-o-document-text',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID del contenuto pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Nome del contenuto',
      'helper_text' => 'name',
      'description' => 'name',
      'tooltip' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Slug del contenuto pagina',
      'description' => 'slug',
      'helper_text' => 'slug',
      'tooltip' => '',
    ),
    'blocks' => 
    array (
      'label' => 'Blocchi',
      'placeholder' => 'Blocchi di contenuto',
      'tooltip' => '',
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
    'created_by' => 
    array (
      'label' => 'Creato da',
      'placeholder' => 'Creato da',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_by' => 
    array (
      'label' => 'Aggiornato da',
      'placeholder' => 'Aggiornato da',
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
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
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
    'delete' => 
    array (
      'label' => 'delete',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'edit' => 
    array (
      'label' => 'edit',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'view' => 
    array (
      'label' => 'view',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 'Visualizza Contenuto',
    'create' => 
    array (
      'label' => 'create',
    ),
    'edit' => 'Modifica Contenuto',
    'delete' => 'Elimina Contenuto',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Contenuto creato con successo',
    'updated' => 'Contenuto aggiornato con successo',
    'deleted' => 'Contenuto eliminato con successo',
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome è obbligatorio',
    'slug_unique' => 'Lo slug deve essere unico',
    'blocks_required' => 'I blocchi di contenuto sono obbligatori',
  ),
  'model' => 
  array (
    'label' => 'page content.model',
  ),
  'sections' => 
  array (
    'Content' => 
    array (
      'label' => 'Content',
      'heading' => 'Content',
    ),
  ),
  'label' => 'Page Content',
  'plural_label' => 'Page Content (Plurale)',
);
