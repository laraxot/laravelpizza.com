<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Notifica',
  ),
  'navigation' => 
  array (
    'name' => 'Notifica',
    'plural' => 'Notifiche',
    'group' => 'Sistema',
    'label' => 'Notifiche',
    'icon' => 'notify-bell-animated',
    'sort' => 45,
  ),
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo',
      'tooltip' => 'Titolo della notifica',
      'placeholder' => 'es: Aggiornamento sistema',
      'help' => 'Inserisci un titolo chiaro e conciso',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'tooltip' => 'Contenuto della notifica',
      'placeholder' => 'es: Il sistema verrà aggiornato alle ore...',
      'help' => 'Inserisci il messaggio completo della notifica',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Tipo di notifica',
      'options' => 
      array (
        'system' => 
        array (
          'label' => 'Sistema',
          'tooltip' => 'Notifiche di sistema e manutenzione',
        ),
        'alert' => 
        array (
          'label' => 'Avviso',
          'tooltip' => 'Avvisi importanti',
        ),
        'info' => 
        array (
          'label' => 'Informazione',
          'tooltip' => 'Informazioni generali',
        ),
        'success' => 
        array (
          'label' => 'Successo',
          'tooltip' => 'Operazioni completate con successo',
        ),
        'warning' => 
        array (
          'label' => 'Attenzione',
          'tooltip' => 'Avvisi che richiedono attenzione',
        ),
        'error' => 
        array (
          'label' => 'Errore',
          'tooltip' => 'Errori e problemi',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato corrente della notifica',
      'options' => 
      array (
        'unread' => 
        array (
          'label' => 'Non letta',
          'tooltip' => 'Notifica non ancora visualizzata',
        ),
        'read' => 
        array (
          'label' => 'Letta',
          'tooltip' => 'Notifica già visualizzata',
        ),
        'archived' => 
        array (
          'label' => 'Archiviata',
          'tooltip' => 'Notifica spostata nell\'archivio',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'recipient' => 
    array (
      'label' => 'Destinatario',
      'tooltip' => 'Utente o gruppo destinatario della notifica',
      'placeholder' => 'es: mario.rossi@example.com',
      'help' => 'Seleziona uno o più destinatari',
      'helper_text' => '',
      'description' => '',
    ),
    'sent_at' => 
    array (
      'label' => 'Inviata il',
      'tooltip' => 'Data e ora di invio della notifica',
      'helper_text' => '',
      'description' => '',
    ),
    'read_at' => 
    array (
      'label' => 'Letta il',
      'tooltip' => 'Data e ora di lettura della notifica',
      'helper_text' => '',
      'description' => '',
    ),
    'archived_at' => 
    array (
      'label' => 'Archiviata il',
      'tooltip' => 'Data e ora di archiviazione della notifica',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'mark_as_read' => 
    array (
      'label' => 'Segna come letta',
      'tooltip' => 'Segna questa notifica come letta',
      'icon' => 'heroicon-o-check',
      'color' => 'success',
    ),
    'mark_as_unread' => 
    array (
      'label' => 'Segna come non letta',
      'tooltip' => 'Segna questa notifica come non letta',
      'icon' => 'heroicon-o-x-circle',
      'color' => 'warning',
    ),
    'archive' => 
    array (
      'label' => 'Archivia',
      'tooltip' => 'Sposta questa notifica nell\'archivio',
      'icon' => 'heroicon-o-archive-box',
      'color' => 'info',
    ),
    'unarchive' => 
    array (
      'label' => 'Ripristina',
      'tooltip' => 'Ripristina questa notifica dall\'archivio',
      'icon' => 'heroicon-o-archive-box-arrow-down',
      'color' => 'primary',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina definitivamente questa notifica',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'confirmation' => 
      array (
        'title' => 'Conferma eliminazione',
        'message' => 'Sei sicuro di voler eliminare questa notifica?',
        'confirm' => 'Sì, elimina',
        'cancel' => 'No, annulla',
      ),
    ),
    'mark_all_read' => 
    array (
      'label' => 'Segna tutte come lette',
      'tooltip' => 'Segna tutte le notifiche come lette',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'success',
    ),
    'archive_all' => 
    array (
      'label' => 'Archivia tutte',
      'tooltip' => 'Sposta tutte le notifiche nell\'archivio',
      'icon' => 'heroicon-o-archive-box-arrow-down',
      'color' => 'info',
      'confirmation' => 
      array (
        'title' => 'Conferma archiviazione',
        'message' => 'Sei sicuro di voler archiviare tutte le notifiche?',
        'confirm' => 'Sì, archivia tutte',
        'cancel' => 'No, annulla',
      ),
    ),
    'delete_all' => 
    array (
      'label' => 'Elimina tutte',
      'tooltip' => 'Elimina definitivamente tutte le notifiche',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'confirmation' => 
      array (
        'title' => 'Conferma eliminazione',
        'message' => 'Sei sicuro di voler eliminare tutte le notifiche?',
        'confirm' => 'Sì, elimina tutte',
        'cancel' => 'No, annulla',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_notifications' => 'Nessuna notifica',
    'success_sent' => 'Notifica inviata con successo',
    'error_sent' => 'Errore nell\'invio della notifica',
  ),
  'filters' => 
  array (
    'all' => 
    array (
      'label' => 'Tutte',
      'tooltip' => 'Mostra tutte le notifiche',
    ),
    'unread' => 
    array (
      'label' => 'Non lette',
      'tooltip' => 'Mostra solo le notifiche non lette',
    ),
    'read' => 
    array (
      'label' => 'Lette',
      'tooltip' => 'Mostra solo le notifiche lette',
    ),
    'archived' => 
    array (
      'label' => 'Archiviate',
      'tooltip' => 'Mostra solo le notifiche archiviate',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Filtra per tipo di notifica',
    ),
    'date' => 
    array (
      'label' => 'Data',
      'tooltip' => 'Filtra per data',
    ),
  ),
  'badges' => 
  array (
    'unread' => 
    array (
      'label' => 'Non letta',
      'tooltip' => 'Questa notifica non è ancora stata letta',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'tooltip' => 'Livello di priorità della notifica',
      'options' => 
      array (
        'high' => 
        array (
          'label' => 'Alta priorità',
          'tooltip' => 'Richiede attenzione immediata',
        ),
        'medium' => 
        array (
          'label' => 'Media priorità',
          'tooltip' => 'Richiede attenzione in giornata',
        ),
        'low' => 
        array (
          'label' => 'Bassa priorità',
          'tooltip' => 'Può essere gestita in seguito',
        ),
      ),
    ),
  ),
  'template' => 
  array (
    'navigation' => 
    array (
      'label' => 'Template Notifiche',
      'plural' => 'Template Notifiche',
      'group' => 'Sistema',
    ),
    'form' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'helper' => 'Nome univoco del template',
      ),
      'subject' => 
      array (
        'label' => 'Oggetto',
        'helper' => 'Oggetto della notifica',
      ),
      'type' => 
      array (
        'label' => 'Tipo',
        'helper' => 'Tipo di notifica',
      ),
      'body_text' => 
      array (
        'label' => 'Testo',
        'helper' => 'Versione testuale della notifica',
      ),
      'body_html' => 
      array (
        'label' => 'HTML',
        'helper' => 'Versione HTML della notifica',
      ),
      'preview_data' => 
      array (
        'label' => 'Dati Preview',
        'helper' => 'Dati JSON per il preview',
      ),
      'attachments' => 
      array (
        'label' => 'Allegati',
        'helper' => 'Allegati alla notifica (max 5 file, 5MB ciascuno]',
      ),
    ),
    'preview' => 
    array (
      'title' => 'Anteprima Template',
      'subheading' => 'Visualizza come apparirà la notifica',
      'text_version' => 'Versione Testuale',
      'html_version' => 'Versione HTML',
    ),
  ),
  'enums' => 
  array (
    'notification_type' => 
    array (
      'email' => 'Email',
      'sms' => 'SMS',
      'push' => 'Notifica Push',
    ),
  ),
  'label' => 'Notify',
  'plural_label' => 'Notify (Plurale)',
);
