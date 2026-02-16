<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Invia SMS',
    'group' => 'Test',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Destinatario',
      'placeholder' => 'Inserisci numero di telefono',
      'helper_text' => 'Inserisci il numero con prefisso internazionale (es. +39)',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci testo del messaggio',
      'helper_text' => 'Il messaggio non può superare i 160 caratteri',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Provider',
      'placeholder' => 'Seleziona provider SMS',
      'helper_text' => 'Seleziona il provider da utilizzare per l\'invio',
      'options' => 
      array (
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
      ),
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia SMS',
      'tooltip' => 'Invia un messaggio SMS al destinatario',
    ),
  ),
  'messages' => 
  array (
    'success' => 'SMS inviato con successo',
    'error' => 'Errore nell\'invio dell\'SMS: :error',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
