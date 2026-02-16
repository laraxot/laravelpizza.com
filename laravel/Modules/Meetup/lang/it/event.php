<?php

declare(strict_types=1);

return array (
  'event' => 
  array (
    'navigation' => 
    array (
      'label' => 'Eventi',
      'group' => 'Meetups',
      'icon' => 'heroicon-o-calendar',
      'sort' => 11,
    ),
    'actions' => 
    array (
      'logout' => 
      array (
        'tooltip' => 'logout',
      ),
      'seed_events' => 
      array (
        'label' => 'Importa Eventi JSON',
        'notification' => 
        array (
          'title' => 'Importazione Completata',
          'body' => 'Importati :count eventi con successo.',
        ),
      ),
    ),
    'filters' => 
    array (
      'status' => 
      array (
        'label' => 'Stato',
        'upcoming' => 'In arrivo',
        'completed' => 'Completato',
        'cancelled' => 'Cancellato',
        'draft' => 'Bozza',
      ),
      'event_status' => 
      array (
        'label' => 'Stato Evento',
        'confirmed' => 'Confermato',
        'scheduled' => 'Programmato',
        'cancelled' => 'Cancellato',
        'postponed' => 'Rinviato',
      ),
      'attendance_mode' => 
      array (
        'label' => 'Modalità',
        'offline' => 'In presenza',
        'online' => 'Online',
        'mixed' => 'Mista',
      ),
      'has_capacity' => 
      array (
        'label' => 'Posti disponibili',
        'yes' => 'Con posti',
        'no' => 'Completo',
      ),
    ),
  ),
  'navigation' => 
  array (
    'sort' => 49,
  ),
  'actions' => 
  array (
    'logout' => 
    array (
      'tooltip' => 'logout',
    ),
  ),
  'fields' => 
  array (
    'event_status' => 
    array (
      'label' => 'event_status',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'label' => 'Event',
  'plural_label' => 'Event (Plurale)',
);
