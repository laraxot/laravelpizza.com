<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome area',
      'placeholder' => 'Inserisci il nome dell\'area',
      'help' => 'Nome identificativo dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Descrizione dettagliata dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo di area',
      'help' => 'Tipo di area geografica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'geometry' => 
    array (
      'label' => 'Geometria',
      'placeholder' => 'Inserisci la geometria',
      'help' => 'Geometria dell\'area in formato GeoJSON',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'center_latitude' => 
    array (
      'label' => 'Latitudine centro',
      'placeholder' => 'Inserisci la latitudine del centro',
      'help' => 'Latitudine del centro dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'center_longitude' => 
    array (
      'label' => 'Longitudine centro',
      'placeholder' => 'Inserisci la longitudine del centro',
      'help' => 'Longitudine del centro dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'area_value' => 
    array (
      'label' => 'Superficie',
      'placeholder' => 'Inserisci la superficie',
      'help' => 'Superficie dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'perimeter' => 
    array (
      'label' => 'Perimetro',
      'placeholder' => 'Inserisci il perimetro',
      'help' => 'Perimetro dell\'area',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attiva',
      'help' => 'Indica se l\'area è attiva nel sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome dell\'area è obbligatorio',
    'type_required' => 'Il tipo di area è obbligatorio',
    'geometry_required' => 'La geometria è obbligatoria',
    'geometry_invalid' => 'La geometria non è valida',
    'center_latitude_required' => 'La latitudine del centro è obbligatoria',
    'center_longitude_required' => 'La longitudine del centro è obbligatoria',
  ),
  'messages' => 
  array (
    'area_created' => 'Area creata con successo',
    'area_updated' => 'Area aggiornata con successo',
    'area_deleted' => 'Area eliminata con successo',
    'area_activated' => 'Area attivata con successo',
    'area_deactivated' => 'Area disattivata con successo',
    'geometry_imported' => 'Geometria importata con successo',
    'geometry_exported' => 'Geometria esportata con successo',
    'area_calculated' => 'Area calcolata con successo',
    'perimeter_calculated' => 'Perimetro calcolato con successo',
  ),
  'area_types' => 
  array (
    'administrative' => 'Amministrativa',
    'natural' => 'Naturale',
    'urban' => 'Urbana',
    'rural' => 'Rurale',
    'protected' => 'Protetta',
    'commercial' => 'Commerciale',
    'residential' => 'Residenziale',
    'industrial' => 'Industriale',
    'recreational' => 'Ricreativa',
    'custom' => 'Personalizzata',
  ),
  'area_units' => 
  array (
    'km2' => 'Chilometri quadrati',
    'm2' => 'Metri quadrati',
    'ha' => 'Ettari',
    'acres' => 'Acri',
    'sq_mi' => 'Miglia quadrate',
  ),
  'perimeter_units' => 
  array (
    'km' => 'Chilometri',
    'm' => 'Metri',
    'mi' => 'Miglia',
    'ft' => 'Piedi',
    'yd' => 'Iarde',
  ),
  'label' => 'Area',
  'plural_label' => 'Area (Plurale)',
  'navigation' => 
  array (
    'name' => 'Area',
    'plural' => 'Area',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Area',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Area',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Area',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Area',
    ),
  ),
);
