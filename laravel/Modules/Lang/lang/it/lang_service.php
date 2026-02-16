<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'language' => 
    array (
      'label' => 'Lingua',
      'placeholder' => 'Seleziona la lingua',
      'helper_text' => 'Lingua attualmente selezionata per l\'interfaccia',
      'tooltip' => '',
      'description' => '',
    ),
    'available_languages' => 
    array (
      'label' => 'Lingue Disponibili',
      'placeholder' => 'Elenco lingue disponibili',
      'helper_text' => 'Lingue disponibili per la selezione nell\'interfaccia',
      'tooltip' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'placeholder' => 'Inserisci il valore',
      'helper_text' => 'Valore della traduzione',
      'tooltip' => '',
      'description' => '',
    ),
    'key' => 
    array (
      'label' => 'Chiave',
      'placeholder' => 'Inserisci la chiave di traduzione',
      'helper_text' => 'Chiave identificativa per la traduzione',
      'tooltip' => '',
      'description' => '',
    ),
    'locale' => 
    array (
      'label' => 'Locale',
      'placeholder' => 'Seleziona il locale',
      'helper_text' => 'Codice locale della lingua (es. it, en, de]',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'change_language' => 
    array (
      'label' => 'Cambia Lingua',
      'tooltip' => 'Cambia la lingua dell\'interfaccia',
      'success' => 'Lingua cambiata con successo',
      'error' => 'Errore durante il cambio lingua',
      'confirmation' => 'Sei sicuro di voler cambiare la lingua?',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'tooltip' => 'Annulla l\'operazione corrente',
    ),
    'save' => 
    array (
      'label' => 'Salva',
      'tooltip' => 'Salva le modifiche',
      'success' => 'Modifiche salvate con successo',
      'error' => 'Errore durante il salvataggio',
    ),
    'create' => 
    array (
      'label' => 'Crea Traduzione',
      'tooltip' => 'Crea una nuova traduzione',
      'success' => 'Traduzione creata con successo',
      'error' => 'Errore durante la creazione della traduzione',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica la traduzione selezionata',
      'success' => 'Traduzione modificata con successo',
      'error' => 'Errore durante la modifica della traduzione',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina la traduzione selezionata',
      'success' => 'Traduzione eliminata con successo',
      'error' => 'Errore durante l\'eliminazione della traduzione',
      'confirmation' => 'Sei sicuro di voler eliminare questa traduzione?',
    ),
  ),
  'messages' => 
  array (
    'language_changed' => 'Lingua cambiata correttamente',
    'error' => 'Si è verificato un errore durante il cambio lingua',
    'no_translations' => 'Nessuna traduzione trovata',
    'loading' => 'Caricamento traduzioni in corso...',
    'empty_state' => 'Nessuna traduzione disponibile',
    'search_placeholder' => 'Cerca traduzioni...',
  ),
  'validation' => 
  array (
    'language_required' => 'La lingua è obbligatoria',
    'language_valid' => 'La lingua selezionata non è valida',
    'key_required' => 'La chiave di traduzione è obbligatoria',
    'key_unique' => 'Questa chiave di traduzione esiste già',
    'value_required' => 'Il valore della traduzione è obbligatorio',
    'locale_required' => 'Il locale è obbligatorio',
    'locale_valid' => 'Il formato del locale non è valido',
  ),
  'navigation' => 
  array (
    'label' => 'Servizio Lingue',
    'group' => 'Localizzazione',
    'icon' => 'heroicon-o-language',
  ),
  'page' => 
  array (
    'title' => 'Gestione Traduzioni',
    'heading' => 'Servizio Lingue',
    'description' => 'Gestisci le traduzioni e le lingue disponibili nel sistema',
  ),
  'label' => 'Lang Service',
  'plural_label' => 'Lang Service (Plurale)',
);
