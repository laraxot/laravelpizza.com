<?php

declare(strict_types=1);

return array (
  'resource' => 
  array (
    'name' => 'Dashboard',
    'plural' => 'Dashboard',
  ),
  'navigation' => 
  array (
    'name' => 'Dashboard',
    'plural' => 'Dashboard',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Panoramica delle notifiche',
    ),
    'label' => 'Dashboard',
    'sort' => 49,
    'icon' => 'notify-dashboard-animated',
    'description' => 'Panoramica del sistema di notifiche',
  ),
  'widgets' => 
  array (
    'total_notifications' => 
    array (
      'label' => 'Totale Notifiche',
      'description' => 'Numero totale di notifiche nel sistema',
    ),
    'unread_notifications' => 
    array (
      'label' => 'Notifiche Non Lette',
      'description' => 'Numero di notifiche ancora da leggere',
    ),
    'notifications_by_type' => 
    array (
      'label' => 'Notifiche per Tipo',
      'description' => 'Distribuzione delle notifiche per tipologia',
    ),
    'recent_notifications' => 
    array (
      'label' => 'Notifiche Recenti',
      'description' => 'Elenco delle notifiche più recenti',
    ),
    'notification_trends' => 
    array (
      'label' => 'Trend Notifiche',
      'description' => 'Andamento delle notifiche nel tempo',
    ),
    'channel_status' => 
    array (
      'label' => 'Stato Canali',
      'description' => 'Stato operativo dei canali di notifica',
    ),
    'top_recipients' => 
    array (
      'label' => 'Destinatari Principali',
      'description' => 'Utenti che ricevono più notifiche',
    ),
  ),
  'cards' => 
  array (
    'overall_status' => 
    array (
      'label' => 'Stato Generale',
      'description' => 'Panoramica dello stato del sistema di notifiche',
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'description' => 'Configurazione dei canali di notifica',
    ),
    'templates' => 
    array (
      'label' => 'Template',
      'description' => 'Template disponibili per le notifiche',
    ),
    'logs' => 
    array (
      'label' => 'Log',
      'description' => 'Registri delle attività di notifica',
    ),
  ),
  'actions' => 
  array (
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'tooltip' => 'Aggiorna i dati della dashboard',
      'success_message' => 'Dashboard aggiornata con successo',
      'error_message' => 'Errore nell\'aggiornamento della dashboard',
    ),
    'export' => 
    array (
      'label' => 'Esporta Dati',
      'tooltip' => 'Esporta i dati statistici in formato CSV',
      'success_message' => 'Dati esportati con successo',
      'error_message' => 'Errore nell\'esportazione dei dati',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'no_data' => 'Nessun dato disponibile per il periodo selezionato',
    'loading' => 'Caricamento dati in corso...',
  ),
  'label' => 'Dashboard',
  'plural_label' => 'Dashboard (Plurale)',
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
);
