<?php

declare(strict_types=1);

return [
  'event' => [
    'navigation' => [
      'label' => 'Eventi',
      'group' => 'Meetups',
      'icon' => 'heroicon-o-calendar',
      'sort' => 11,
    ],
    'actions' => [
      'logout' => [
        'tooltip' => 'logout',
      ],
      'seed_events' => [
        'label' => 'Importa Eventi JSON',
        'notification' => [
          'title' => 'Importazione Completata',
          'body' => 'Importati :count eventi con successo.',
        ],
      ],
    ],
    'filters' => [
      'status' => [
        'label' => 'Stato',
        'upcoming' => 'In arrivo',
        'completed' => 'Completato',
        'cancelled' => 'Cancellato',
        'draft' => 'Bozza',
      ],
      'event_status' => [
        'label' => 'Stato Evento',
        'confirmed' => 'Confermato',
        'scheduled' => 'Programmato',
        'cancelled' => 'Cancellato',
        'postponed' => 'Rinviato',
      ],
      'attendance_mode' => [
        'label' => 'Modalità',
        'offline' => 'In presenza',
        'online' => 'Online',
        'mixed' => 'Mista',
      ],
      'has_capacity' => [
        'label' => 'Posti disponibili',
        'yes' => 'Con posti',
        'no' => 'Completo',
      ],
    ],
  ],
  'navigation' => [
    'sort' => 49,
  ],
  'actions' => [
    'logout' => [
      'tooltip' => 'logout',
    ],
  ],
  'fields' => [
    'event_status' => [
      'label' => 'event_status',
    ],
  ],
  'label' => 'Event',
  'plural_label' => 'Event (Plurale)',
];
