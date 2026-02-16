<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea',
      'tooltip' => 'Crea nuovo file di traduzione',
      'success' => 'File di traduzione creato con successo',
    ),
    'lang' => 
    array (
      'label' => 'Lingua',
      'tooltip' => 'Seleziona lingua',
    ),
  ),
  'fields' => 
  array (
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica file di traduzione',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'tooltip' => 'Mostra o nascondi colonne della tabella',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Riordina i record nella tabella',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reset Filtri',
      'tooltip' => 'Ripristina i filtri ai valori predefiniti',
      'helper_text' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'description' => 'Contenuto del file di traduzione',
      'helper_text' => '',
      'placeholder' => 'Inserisci contenuto traduzione',
      'label' => 'Contenuto',
      'tooltip' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri selezionati',
      'helper_text' => '',
      'description' => '',
    ),
    'snapshots' => 
    array (
      'fields' => 
      array (
        'updated_at' => 
        array (
          'help' => 
          array (
            'description' => 'Data e ora dell\'ultimo aggiornamento',
            'helper_text' => '',
            'placeholder' => 'Data aggiornamento',
            'label' => 'Data Aggiornamento',
          ),
          'label' => 
          array (
            'description' => 'Etichetta per la data di aggiornamento',
            'helper_text' => '',
            'placeholder' => 'Etichetta data',
            'label' => 'Etichetta Data',
          ),
        ),
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Apri il pannello dei filtri',
      'helper_text' => '',
      'description' => '',
    ),
    'key' => 
    array (
      'label' => 'Chiave',
      'placeholder' => 'Inserisci chiave traduzione',
      'help' => 'Chiave identificativa della traduzione',
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
  ),
  'navigation' => 
  array (
    'label' => 'File Traduzione',
    'group' => 'Lang',
    'icon' => 'heroicon-o-language',
    'sort' => 73,
  ),
  'model' => 
  array (
    'label' => 'File Traduzione',
    'placeholder' => 'Seleziona file traduzione',
    'helper_text' => 'File di traduzione per la gestione delle lingue',
  ),
  'label' => 'Translation File',
  'plural_label' => 'Translation File (Plurale)',
);
