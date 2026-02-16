<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'SMS',
    'plural' => 'SMS',
  ),
  'navigation' => 
  array (
    'name' => 'Invio SMS',
    'plural' => 'Invio SMS',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche SMS',
    ),
    'label' => 'Invio SMS',
    'icon' => 'heroicon-o-device-phone-mobile',
    'sort' => '10',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Numero di telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'helper_text' => 'Inserisci il numero di telefono con prefisso internazionale (es. +39)',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci il messaggio',
      'helper_text' => 'Il messaggio non può superare i 160 caratteri',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Provider SMS',
      'placeholder' => 'Seleziona il provider SMS',
      'helper_text' => 'Seleziona il provider SMS da utilizzare',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'drivers' => 
  array (
    'smsfactor' => 'SMSFactor',
    'twilio' => 'Twilio',
    'nexmo' => 'Nexmo',
    'plivo' => 'Plivo',
    'gammu' => 'Gammu',
    'netfun' => 'Netfun',
  ),
  'actions' => 
  array (
    'send' => 'Invia SMS',
    'cancel' => 'Annulla',
  ),
  'messages' => 
  array (
    'success' => 'SMS inviato con successo',
    'error' => 'Si è verificato un errore durante l\'invio dell\'SMS',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
