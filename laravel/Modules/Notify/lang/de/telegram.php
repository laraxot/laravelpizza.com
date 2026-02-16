<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Telegram',
    'plural' => 'Telegram',
  ),
  'navigation' => 
  array (
    'name' => 'Invio Telegram',
    'plural' => 'Invio Telegram',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche Telegram',
    ),
    'label' => 'Invio Telegram',
    'icon' => 'notify-telegram-animated',
    'sort' => '30',
  ),
  'fields' => 
  array (
    'chat_id' => 
    array (
      'label' => 'ID Chat',
      'placeholder' => 'Inserisci l\'ID della chat',
      'helper_text' => 'ID della chat Telegram a cui inviare il messaggio',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci il messaggio',
      'helper_text' => 'Testo del messaggio da inviare',
      'tooltip' => '',
      'description' => '',
    ),
    'parse_mode' => 
    array (
      'label' => 'Formato',
      'placeholder' => 'Seleziona il formato',
      'helper_text' => 'Formato di parsing del messaggio',
      'options' => 
      array (
        'text' => 'Testo semplice',
        'html' => 'HTML',
        'markdown' => 'Markdown',
      ),
      'tooltip' => '',
      'description' => '',
    ),
    'driver' => 
    array (
      'label' => 'Provider Telegram',
      'placeholder' => 'Seleziona il provider Telegram',
      'helper_text' => 'Seleziona il provider Telegram da utilizzare',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'drivers' => 
  array (
    'telegram' => 'Telegram',
    'botapi' => 'Bot API',
    'laravel_telegram' => 'Laravel Telegram',
  ),
  'actions' => 
  array (
    'send' => 'Invia Telegram',
    'cancel' => 'Annulla',
  ),
  'messages' => 
  array (
    'success' => 'Messaggio Telegram inviato con successo',
    'error' => 'Si è verificato un errore durante l\'invio del messaggio Telegram',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
