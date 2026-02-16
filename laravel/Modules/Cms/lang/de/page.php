<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Pagine',
    'plural' => 'Pagine',
    'group' => 
    array (
      'name' => 'Gestione Contenuti',
      'description' => 'Gestione delle pagine del sito',
    ),
    'label' => 'Pagine',
    'sort' => '5',
    'icon' => 'heroicon-o-document',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID della pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Titolo della pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'placeholder' => 'Slug della pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'label' => 'Contenuto',
      'placeholder' => 'Contenuto della pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'meta_title' => 
    array (
      'label' => 'Meta Titolo',
      'placeholder' => 'Meta titolo per SEO',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'meta_description' => 
    array (
      'label' => 'Meta Descrizione',
      'placeholder' => 'Meta descrizione per SEO',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Stato della pagina',
      'options' => 
      array (
        'published' => 'Pubblicata',
        'draft' => 'Bozza',
        'scheduled' => 'Programmata',
        'archived' => 'Archiviata',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Layout della pagina',
      'options' => 
      array (
        'default' => 'Predefinito',
        'full-width' => 'Larghezza piena',
        'sidebar' => 'Con barra laterale',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'parent_id' => 
    array (
      'label' => 'Pagina Genitore',
      'placeholder' => 'Seleziona la pagina genitore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'order' => 
    array (
      'label' => 'Ordine',
      'placeholder' => 'Ordine di visualizzazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'lang' => 
    array (
      'label' => 'Lingua',
      'placeholder' => 'Seleziona la lingua della pagina',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'placeholder' => 'Data e ora ultima modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Attiva/Disattiva Colonne',
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
    'create' => 
    array (
      'label' => 'create',
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
    'footer_blocks' => 
    array (
      'label' => 'footer_blocks',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'caption' => 
    array (
      'label' => 'caption',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Pagina',
    ),
    'edit' => 'Modifica Pagina',
    'delete' => 'Elimina Pagina',
    'publish' => 'Pubblica',
    'unpublish' => 'Ritira',
    'archive' => 'Archivia',
    'restore' => 'Ripristina',
    'preview' => 'Anteprima',
    'activeLocale' => 
    array (
      'label' => 'activeLocale',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Pagina creata con successo',
    'updated' => 'Pagina aggiornata con successo',
    'deleted' => 'Pagina eliminata con successo',
    'published' => 'Pagina pubblicata con successo',
    'unpublished' => 'Pagina ritirata con successo',
    'archived' => 'Pagina archiviata con successo',
    'restored' => 'Pagina ripristinata con successo',
  ),
  'validation' => 
  array (
    'title_required' => 'Der Titel ist erforderlich',
    'slug_unique' => 'Der Slug muss eindeutig sein',
    'content_required' => 'Der Inhalt ist erforderlich',
  ),
  'model' => 
  array (
    'label' => 'page.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
