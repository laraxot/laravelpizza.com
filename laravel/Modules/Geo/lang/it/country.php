<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome paese',
      'placeholder' => 'Inserisci il nome del paese',
      'help' => 'Nome ufficiale del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'code' => 
    array (
      'label' => 'Codice',
      'placeholder' => 'Inserisci il codice ISO',
      'help' => 'Codice ISO del paese (es. IT, US, DE]',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'phone_code' => 
    array (
      'label' => 'Prefisso telefonico',
      'placeholder' => 'Inserisci il prefisso telefonico',
      'help' => 'Prefisso telefonico internazionale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'currency' => 
    array (
      'label' => 'Valuta',
      'placeholder' => 'Seleziona la valuta',
      'help' => 'Valuta ufficiale del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'language' => 
    array (
      'label' => 'Lingua',
      'placeholder' => 'Seleziona la lingua',
      'help' => 'Lingua ufficiale del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso orario',
      'placeholder' => 'Seleziona il fuso orario',
      'help' => 'Fuso orario principale del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'capital' => 
    array (
      'label' => 'Capitale',
      'placeholder' => 'Inserisci la capitale',
      'help' => 'Capitale del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'population' => 
    array (
      'label' => 'Popolazione',
      'placeholder' => 'Inserisci il numero di abitanti',
      'help' => 'Numero di abitanti del paese',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'area' => 
    array (
      'label' => 'Superficie',
      'placeholder' => 'Inserisci la superficie in km²',
      'help' => 'Superficie del paese in chilometri quadrati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'help' => 'Indica se il paese è attivo nel sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome del paese è obbligatorio',
    'code_required' => 'Il codice ISO è obbligatorio',
    'code_unique' => 'Il codice ISO deve essere unico',
    'phone_code_required' => 'Il prefisso telefonico è obbligatorio',
  ),
  'messages' => 
  array (
    'country_created' => 'Paese creato con successo',
    'country_updated' => 'Paese aggiornato con successo',
    'country_deleted' => 'Paese eliminato con successo',
    'country_activated' => 'Paese attivato con successo',
    'country_deactivated' => 'Paese disattivato con successo',
  ),
  'label' => 'Country',
  'plural_label' => 'Country (Plurale)',
  'navigation' => 
  array (
    'name' => 'Country',
    'plural' => 'Country',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Country',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Country',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Country',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Country',
    ),
  ),
);
