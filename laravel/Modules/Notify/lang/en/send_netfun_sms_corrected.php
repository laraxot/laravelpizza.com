<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Invio SMS Netfun',
    'plural' => 'Invio SMS Netfun',
  ),
  'navigation' => 
  array (
    'name' => 'Invio SMS (Netfun)',
    'plural' => 'Invio SMS (Netfun)',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione dell\'invio di notifiche SMS tramite Netfun',
    ),
    'label' => 'Invio SMS (Netfun)',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'sort' => '15',
  ),
  'fields' => 
  array (
    'to' => 
    array (
      'label' => 'Destinatario',
      'placeholder' => 'Inserisci il numero di telefono',
      'helper_text' => 'Numero di telefono del destinatario',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Scrivi il testo del messaggio',
      'helper_text' => 'Contenuto del messaggio SMS',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia',
      'tooltip' => 'Invia un messaggio SMS tramite Netfun',
      'success_message' => 'Messaggio SMS inviato con successo',
      'error_message' => 'Errore nell\'invio del messaggio SMS',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Messaggio SMS inviato con successo tramite Netfun',
    'error' => 'Si è verificato un errore durante l\'invio del messaggio SMS',
    'confirmation' => 'Sei sicuro di voler inviare questo messaggio SMS?',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
