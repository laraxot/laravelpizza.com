<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'WhatsApp',
    'plural' => 'WhatsApp',
  ),
  'navigation' => 
  array (
    'name' => 'Invio WhatsApp',
    'plural' => 'Invio WhatsApp',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche WhatsApp',
    ),
    'label' => 'Invio WhatsApp',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'sort' => '20',
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
      'helper_text' => 'Il messaggio non può superare i 4096 caratteri',
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Provider WhatsApp',
      'placeholder' => 'Seleziona il provider WhatsApp',
      'helper_text' => 'Seleziona il provider WhatsApp da utilizzare',
      'tooltip' => '',
      'description' => '',
    ),
    'template' => 
    array (
      'label' => 'Template',
      'placeholder' => 'Inserisci il nome del template',
      'helper_text' => 'Nome del template (opzionale)',
      'tooltip' => '',
      'description' => '',
    ),
    'parameters' => 
    array (
      'label' => 'Parametri',
      'placeholder' => 'Inserisci i parametri',
      'helper_text' => 'Parametri per il template (opzionale)',
      'tooltip' => '',
      'description' => '',
    ),
    'media_url' => 
    array (
      'label' => 'URL Media',
      'placeholder' => 'Inserisci l\'URL del media',
      'helper_text' => 'URL del media (opzionale)',
      'tooltip' => '',
      'description' => '',
    ),
    'media_type' => 
    array (
      'label' => 'Tipo Media',
      'placeholder' => 'Seleziona il tipo di media',
      'helper_text' => 'Seleziona il tipo di media',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'drivers' => 
  array (
    'twilio' => 'Twilio',
    'messagebird' => 'MessageBird',
    'vonage' => 'Vonage',
    'infobip' => 'Infobip',
  ),
  'media_types' => 
  array (
    'image' => 'Immagine',
    'video' => 'Video',
    'document' => 'Documento',
    'audio' => 'Audio',
  ),
  'actions' => 
  array (
    'send' => 'Invia WhatsApp',
    'cancel' => 'Annulla',
  ),
  'messages' => 
  array (
    'success' => 'WhatsApp inviato con successo',
    'error' => 'Si è verificato un errore durante l\'invio del WhatsApp',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
