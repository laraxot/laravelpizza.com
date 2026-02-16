<?php

declare(strict_types=1);

return array (
  'calendar' => 
  array (
    'title' => 'Calendario',
    'description' => 'Gestisci i tuoi appuntamenti',
    'types' => 
    array (
      'patient' => 'Calendario Paziente',
      'doctor' => 'Calendario Medico',
      'admin' => 'Calendario Amministratore',
    ),
    'events' => 
    array (
      'title' => 'Appuntamento',
      'start' => 'Inizio',
      'end' => 'Fine',
      'patient' => 'Paziente',
      'doctor' => 'Medico',
      'status' => 'Stato',
      'type' => 'Tipo',
    ),
    'actions' => 
    array (
      'create' => 'Nuovo Appuntamento',
      'edit' => 'Modifica Appuntamento',
      'delete' => 'Elimina Appuntamento',
      'view' => 'Visualizza Dettagli',
    ),
    'messages' => 
    array (
      'created' => 'Appuntamento creato con successo',
      'updated' => 'Appuntamento aggiornato con successo',
      'deleted' => 'Appuntamento eliminato con successo',
    ),
  ),
  'buttons' => 
  array (
    'today' => 'Oggi',
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
  ),
  'labels' => 
  array (
    'all_day' => 'Tutto il giorno',
    'no_events' => 'Nessun evento',
  ),
  'errors' => 
  array (
    'load_failed' => 'Impossibile caricare gli eventi',
    'save_failed' => 'Impossibile salvare l\'evento',
    'delete_failed' => 'Impossibile eliminare l\'evento',
  ),
  'success' => 
  array (
    'event_created' => 'Evento creato con successo',
    'event_updated' => 'Evento aggiornato con successo',
    'event_deleted' => 'Evento eliminato con successo',
  ),
  'label' => 'Calendar',
  'plural_label' => 'Calendar (Plurale)',
  'navigation' => 
  array (
    'name' => 'Calendar',
    'plural' => 'Calendar',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Calendar',
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
      'label' => 'Crea Calendar',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Calendar',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Calendar',
    ),
  ),
);
