<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome regione',
      'placeholder' => 'Inserisci il nome della regione',
      'help' => 'Nome ufficiale della regione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'code' => 
    array (
      'label' => 'Codice',
      'placeholder' => 'Inserisci il codice della regione',
      'help' => 'Codice identificativo della regione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'capital' => 
    array (
      'label' => 'Capoluogo',
      'placeholder' => 'Inserisci il capoluogo',
      'help' => 'Capoluogo della regione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'population' => 
    array (
      'label' => 'Popolazione',
      'placeholder' => 'Inserisci il numero di abitanti',
      'help' => 'Numero di abitanti della regione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'area' => 
    array (
      'label' => 'Superficie',
      'placeholder' => 'Inserisci la superficie in km²',
      'help' => 'Superficie della regione in chilometri quadrati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attiva',
      'help' => 'Indica se la regione è attiva nel sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome della regione è obbligatorio',
    'code_required' => 'Il codice della regione è obbligatorio',
    'code_unique' => 'Il codice della regione deve essere unico',
    'country_required' => 'Il paese è obbligatorio',
  ),
  'messages' => 
  array (
    'region_created' => 'Regione creata con successo',
    'region_updated' => 'Regione aggiornata con successo',
    'region_deleted' => 'Regione eliminata con successo',
    'region_activated' => 'Regione attivata con successo',
    'region_deactivated' => 'Regione disattivata con successo',
  ),
  'label' => 'Region',
  'plural_label' => 'Region (Plurale)',
  'navigation' => 
  array (
    'name' => 'Region',
    'plural' => 'Region',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Region',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Region',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Region',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Region',
    ),
  ),
);
