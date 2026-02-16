<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'WhatsApp',
    'group' => 'Notify',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'sort' => 10,
  ),
  'fields' => 
  array (
    'phone_number' => 
    array (
      'label' => 'Numero Telefono',
      'placeholder' => 'Inserisci numero WhatsApp',
      'helper_text' => 'Numero di telefono per l\'invio WhatsApp',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci messaggio WhatsApp',
      'helper_text' => 'Testo del messaggio da inviare',
      'tooltip' => '',
      'description' => '',
    ),
    'template' => 
    array (
      'label' => 'Template',
      'placeholder' => 'Seleziona template',
      'help' => 'Template predefinito per il messaggio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia WhatsApp',
      'tooltip' => 'Invia messaggio WhatsApp',
      'success' => 'Messaggio WhatsApp inviato con successo',
      'error' => 'Errore nell\'invio del messaggio WhatsApp',
    ),
  ),
  'label' => 'Send Whats App',
  'plural_label' => 'Send Whats App (Plurale)',
);
