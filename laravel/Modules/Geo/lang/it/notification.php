<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo di notifica',
      'help' => 'Tipo di notifica da inviare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo della notifica',
      'help' => 'Titolo della notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci il messaggio della notifica',
      'help' => 'Contenuto della notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'recipients' => 
    array (
      'label' => 'Destinatari',
      'placeholder' => 'Seleziona i destinatari',
      'help' => 'Utenti che riceveranno la notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'placeholder' => 'Seleziona i canali di notifica',
      'help' => 'Canali attraverso cui inviare la notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'placeholder' => 'Seleziona la priorità',
      'help' => 'Livello di priorità della notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'scheduled_at' => 
    array (
      'label' => 'Programmata per',
      'placeholder' => 'Seleziona data e ora',
      'help' => 'Data e ora di invio programmato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires_at' => 
    array (
      'label' => 'Scade il',
      'placeholder' => 'Seleziona data e ora',
      'help' => 'Data e ora di scadenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'data' => 
    array (
      'label' => 'Dati aggiuntivi',
      'placeholder' => 'Inserisci dati aggiuntivi',
      'help' => 'Dati aggiuntivi per la notifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_read' => 
    array (
      'label' => 'Letta',
      'help' => 'Indica se la notifica è stata letta',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_sent' => 
    array (
      'label' => 'Inviata',
      'help' => 'Indica se la notifica è stata inviata',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'type_required' => 'Il tipo è obbligatorio',
    'type_invalid' => 'Il tipo non è valido',
    'title_required' => 'Il titolo è obbligatorio',
    'title_min_length' => 'Il titolo deve essere di almeno 3 caratteri',
    'title_max_length' => 'Il titolo non può superare 255 caratteri',
    'message_required' => 'Il messaggio è obbligatorio',
    'message_min_length' => 'Il messaggio deve essere di almeno 10 caratteri',
    'message_max_length' => 'Il messaggio non può superare 1000 caratteri',
    'recipients_required' => 'I destinatari sono obbligatori',
    'recipients_array' => 'I destinatari devono essere un array',
    'channels_required' => 'I canali sono obbligatori',
    'channels_array' => 'I canali devono essere un array',
    'priority_required' => 'La priorità è obbligatoria',
    'priority_invalid' => 'La priorità non è valida',
    'scheduled_at_date' => 'La data programmata deve essere una data valida',
    'scheduled_at_future' => 'La data programmata deve essere nel futuro',
    'expires_at_date' => 'La data di scadenza deve essere una data valida',
    'expires_at_future' => 'La data di scadenza deve essere nel futuro',
    'data_json' => 'I dati aggiuntivi devono essere in formato JSON valido',
  ),
  'messages' => 
  array (
    'notification_created' => 'Notifica creata con successo',
    'notification_updated' => 'Notifica aggiornata con successo',
    'notification_deleted' => 'Notifica eliminata con successo',
    'notification_sent' => 'Notifica inviata con successo',
    'notification_scheduled' => 'Notifica programmata con successo',
    'notification_cancelled' => 'Notifica annullata con successo',
    'notification_read' => 'Notifica segnata come letta',
    'notification_unread' => 'Notifica segnata come non letta',
    'notifications_sent' => ':count notifiche inviate con successo',
    'notifications_failed' => ':count notifiche fallite',
    'notifications_partial' => ':sent/:total notifiche inviate con successo',
  ),
  'errors' => 
  array (
    'notification_creation_failed' => 'Impossibile creare la notifica',
    'notification_update_failed' => 'Impossibile aggiornare la notifica',
    'notification_deletion_failed' => 'Impossibile eliminare la notifica',
    'notification_sending_failed' => 'Impossibile inviare la notifica',
    'notification_scheduling_failed' => 'Impossibile programmare la notifica',
    'notification_cancellation_failed' => 'Impossibile annullare la notifica',
    'notification_marking_failed' => 'Impossibile aggiornare lo stato della notifica',
    'recipients_invalid' => 'Destinatari non validi',
    'channels_invalid' => 'Canali non validi',
    'template_not_found' => 'Template non trovato',
    'channel_not_configured' => 'Canale non configurato',
    'rate_limit_exceeded' => 'Limite di invio superato',
    'quota_exceeded' => 'Quota di notifiche esaurita',
    'service_unavailable' => 'Servizio di notifica non disponibile',
    'authentication_failed' => 'Autenticazione fallita',
    'authorization_failed' => 'Autorizzazione negata',
  ),
  'notification_types' => 
  array (
    'info' => 'Informazione',
    'success' => 'Successo',
    'warning' => 'Avviso',
    'error' => 'Errore',
    'alert' => 'Allerta',
    'reminder' => 'Promemoria',
    'update' => 'Aggiornamento',
    'announcement' => 'Annuncio',
    'custom' => 'Personalizzata',
  ),
  'notification_channels' => 
  array (
    'mail' => 'Email',
    'database' => 'Database',
    'broadcast' => 'Broadcast',
    'nexmo' => 'SMS (Nexmo]',
    'slack' => 'Slack',
    'telegram' => 'Telegram',
    'push' => 'Push Notification',
    'webhook' => 'Webhook',
    'custom' => 'Personalizzato',
  ),
  'notification_priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
    'critical' => 'Critica',
  ),
  'notification_statuses' => 
  array (
    'pending' => 'In attesa',
    'scheduled' => 'Programmata',
    'sending' => 'Invio in corso',
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'read' => 'Letta',
    'failed' => 'Fallita',
    'cancelled' => 'Annullata',
    'expired' => 'Scaduta',
  ),
  'label' => 'Notification',
  'plural_label' => 'Notification (Plurale)',
  'navigation' => 
  array (
    'name' => 'Notification',
    'plural' => 'Notification',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Notification',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Notification',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Notification',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Notification',
    ),
  ),
);
