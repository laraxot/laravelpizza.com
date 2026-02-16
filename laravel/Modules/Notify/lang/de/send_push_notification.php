<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Invio Notifica Push',
  ),
  'navigation' => 
  array (
    'name' => 'Invio Notifica Push',
    'plural' => 'Invio Notifiche Push',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Funzionalità per l\'invio di notifiche push tramite Firebase',
    ),
    'label' => 'Invio Notifiche Push',
    'icon' => 'notify-push-animated',
    'sort' => '51',
  ),
  'fields' => 
  array (
    'device_token' => 
    array (
      'label' => 'Token Dispositivo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'options' => 
      array (
        'notification' => 'Notifica',
        'data' => 'Dati',
        'both' => 'Entrambi',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'body' => 
    array (
      'label' => 'Contenuto',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'data' => 
    array (
      'label' => 'Dati Aggiuntivi',
      'description' => 'Dati in formato JSON da inviare con la notifica',
      'tooltip' => '',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia Notifica',
      'success' => 'Notifica push inviata con successo',
      'error' => 'Errore durante l\'invio della notifica push',
    ),
    'preview' => 
    array (
      'label' => 'Anteprima',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
