<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Notifica',
    'plural' => 'Notifiche',
  ),
  'navigation' => 
  array (
    'name' => 'Gestione Notifiche',
    'plural' => 'Gestione Notifiche',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione centralizzata delle notifiche di sistema',
    ),
    'label' => 'Gestione Notifiche',
    'icon' => 'notify-notification-animated',
    'sort' => 46,
  ),
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo',
      'helper_text' => 'Titolo della notifica',
      'placeholder' => 'Inserisci il titolo',
      'tooltip' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'helper_text' => 'Contenuto della notifica',
      'placeholder' => 'Inserisci il messaggio',
      'tooltip' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'helper_text' => 'Tipologia di notifica',
      'placeholder' => 'Seleziona il tipo',
      'options' => 
      array (
        'system' => 'Sistema',
        'alert' => 'Avviso',
        'info' => 'Informazione',
        'success' => 'Successo',
        'warning' => 'Attenzione',
        'error' => 'Errore',
      ),
      'tooltip' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'helper_text' => 'Stato corrente della notifica',
      'placeholder' => 'Seleziona lo stato',
      'options' => 
      array (
        'unread' => 'Non letta',
        'read' => 'Letta',
        'archived' => 'Archiviata',
      ),
      'tooltip' => '',
      'description' => '',
    ),
    'recipient' => 
    array (
      'label' => 'Destinatario',
      'helper_text' => 'Utente destinatario della notifica',
      'placeholder' => 'Seleziona il destinatario',
      'tooltip' => '',
      'description' => '',
    ),
    'sent_at' => 
    array (
      'label' => 'Inviata il',
      'helper_text' => 'Data e ora di invio della notifica',
      'tooltip' => '',
      'description' => '',
    ),
    'read_at' => 
    array (
      'label' => 'Letta il',
      'helper_text' => 'Data e ora di lettura della notifica',
      'tooltip' => '',
      'description' => '',
    ),
    'archived_at' => 
    array (
      'label' => 'Archiviata il',
      'helper_text' => 'Data e ora di archiviazione della notifica',
      'tooltip' => '',
      'description' => '',
    ),
    'channel' => 
    array (
      'label' => 'Canale',
      'tooltip' => 'Canale di invio della notifica',
      'helper_text' => 'Seleziona il canale attraverso cui inviare la notifica',
      'placeholder' => 'Seleziona un canale',
      'options' => 
      array (
        'email' => 
        array (
          'label' => 'Email',
          'tooltip' => 'Invia tramite email',
        ),
        'sms' => 
        array (
          'label' => 'SMS',
          'tooltip' => 'Invia tramite SMS',
        ),
        'push' => 
        array (
          'label' => 'Push',
          'tooltip' => 'Invia come notifica push',
        ),
        'telegram' => 
        array (
          'label' => 'Telegram',
          'tooltip' => 'Invia tramite Telegram',
        ),
      ),
      'description' => '',
    ),
    'template' => 
    array (
      'label' => 'Template',
      'tooltip' => 'Template da utilizzare per la notifica',
      'helper_text' => 'Scegli il modello predefinito per questa notifica',
      'placeholder' => 'Seleziona un template',
      'options' => 
      array (
        'subject' => 
        array (
          'label' => 'Oggetto',
          'tooltip' => 'Oggetto della notifica',
          'placeholder' => 'es: Notifica importante',
        ),
        'body' => 
        array (
          'label' => 'Corpo',
          'tooltip' => 'Contenuto principale della notifica',
          'placeholder' => 'Inserisci il testo della notifica...',
        ),
        'variables' => 
        array (
          'label' => 'Variabili disponibili',
          'tooltip' => 'Variabili che possono essere utilizzate nel template',
          'helper_text' => 'Usa {variable} per inserire valori dinamici',
        ),
      ),
      'description' => '',
    ),
    'schedule' => 
    array (
      'label' => 'Programmazione',
      'tooltip' => 'Quando inviare la notifica',
      'helper_text' => 'Imposta quando la notifica deve essere inviata',
      'placeholder' => 'Seleziona l\'opzione di programmazione',
      'options' => 
      array (
        'immediate' => 
        array (
          'label' => 'Immediata',
          'tooltip' => 'Invia subito la notifica',
        ),
        'scheduled' => 
        array (
          'label' => 'Programmata',
          'tooltip' => 'Programma l\'invio per una data specifica',
        ),
        'date' => 
        array (
          'label' => 'Data',
          'tooltip' => 'Data di invio programmato',
          'placeholder' => 'es: 01/01/2024',
        ),
        'time' => 
        array (
          'label' => 'Ora',
          'tooltip' => 'Ora di invio programmato',
          'placeholder' => 'es: 14:30',
        ),
      ),
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'mark_as_read' => 
    array (
      'label' => 'Segna come letta',
      'tooltip' => 'Marca la notifica come letta',
      'success_message' => 'Notifica segnata come letta',
      'error_message' => 'Errore nel segnare la notifica come letta',
    ),
    'mark_as_unread' => 
    array (
      'label' => 'Segna come non letta',
      'tooltip' => 'Marca la notifica come non letta',
      'success_message' => 'Notifica segnata come non letta',
      'error_message' => 'Errore nel segnare la notifica come non letta',
    ),
    'archive' => 
    array (
      'label' => 'Archivia',
      'tooltip' => 'Archivia la notifica',
      'success_message' => 'Notifica archiviata con successo',
      'error_message' => 'Errore nell\'archiviazione della notifica',
    ),
    'unarchive' => 
    array (
      'label' => 'Ripristina',
      'tooltip' => 'Ripristina la notifica archiviata',
      'success_message' => 'Notifica ripristinata con successo',
      'error_message' => 'Errore nel ripristino della notifica',
    ),
    'send' => 
    array (
      'label' => 'Invia',
      'tooltip' => 'Invia la notifica',
      'success_message' => 'Notifica inviata con successo',
      'error_message' => 'Errore nell\'invio della notifica',
    ),
    'resend' => 
    array (
      'label' => 'Invia nuovamente',
      'tooltip' => 'Invia nuovamente la notifica',
      'success_message' => 'Notifica inviata nuovamente con successo',
      'error_message' => 'Errore nell\'invio della notifica',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina definitivamente la notifica',
      'success_message' => 'Notifica eliminata con successo',
      'error_message' => 'Errore nell\'eliminazione della notifica',
      'confirmation' => 'Sei sicuro di voler eliminare questa notifica? Questa azione non può essere annullata.',
    ),
  ),
  'messages' => 
  array (
    'no_notifications' => 'Non hai notifiche',
    'all_read' => 'Tutte le notifiche sono state lette',
    'mark_all_read' => 'Segna tutte come lette',
    'notification_sent' => 'Notifica inviata con successo',
    'notification_error' => 'Si è verificato un errore durante l\'invio della notifica',
    'delete_confirmation' => 'Sei sicuro di voler eliminare questa notifica?',
    'batch_action_confirmation' => 'Sei sicuro di voler eseguire questa azione su tutte le notifiche selezionate?',
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
  ),
  'label' => 'Notification',
  'plural_label' => 'Notification (Plurale)',
);
