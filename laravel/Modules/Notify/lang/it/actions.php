<?php

declare(strict_types=1);

return array (
  'send_notification_bulk' => 
  array (
    'label' => 'Invia notifiche',
    'form' => 
    array (
      'template_slug' => 
      array (
        'label' => 'Template',
        'placeholder' => 'Seleziona un template',
        'helper_text' => 'Seleziona il template di notifica da utilizzare',
      ),
      'channels' => 
      array (
        'label' => 'Canali',
        'helper_text' => 'Seleziona uno o più canali di invio',
        'options' => 
        array (
          'mail' => 'Email',
          'sms' => 'SMS',
          'whatsapp' => 'WhatsApp',
        ),
      ),
    ),
    'errors' => 
    array (
      'unsupported_channel' => 'Canale :channel non supportato',
      'email_not_available' => 'Email non disponibile per questo record',
      'phone_not_available' => 'Numero di telefono non disponibile per questo record',
      'whatsapp_not_available' => 'Numero WhatsApp non disponibile per questo record',
      'channel_not_sent' => 'Canale non inviato (dati non disponibili]',
    ),
    'notifications' => 
    array (
      'success' => 
      array (
        'title' => 'Notifiche inviate',
        'body' => 'Inviate :count notifiche su :total con successo',
      ),
      'warning' => 
      array (
        'title' => 'Dati non validi',
        'invalid_data' => 'Template e almeno un canale devono essere selezionati',
      ),
      'error' => 
      array (
        'title' => 'Alcune notifiche non sono state inviate',
        'item' => 'Record :record (canale :channel]: :error',
        'more_errors' => '... e altri :count errori',
      ),
    ),
  ),
  'label' => 'Actions',
  'plural_label' => 'Actions (Plurale)',
  'navigation' => 
  array (
    'name' => 'Actions',
    'plural' => 'Actions',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Actions',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Actions',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Actions',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Actions',
    ),
  ),
);
