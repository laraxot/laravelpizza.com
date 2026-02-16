<?php

declare(strict_types=1);

return array (
  'instructions' => 
  array (
    'title' => 'Configurazione Orari',
    'description' => 'Imposta gli orari di apertura per ogni giorno della settimana. Lascia vuoto per giorni di chiusura.',
  ),
  'headers' => 
  array (
    'day' => 'Giorno',
    'morning' => 'Mattino',
    'afternoon' => 'Pomeriggio',
  ),
  'legend' => 
  array (
    'open' => 'Aperto',
    'closed' => 'Chiuso',
    'format' => 'Formato: HH:MM',
  ),
  'days' => 
  array (
    'monday' => 'Lunedì',
    'tuesday' => 'Martedì',
    'wednesday' => 'Mercoledì',
    'thursday' => 'Giovedì',
    'friday' => 'Venerdì',
    'saturday' => 'Sabato',
    'sunday' => 'Domenica',
  ),
  'periods' => 
  array (
    'morning' => 'Mattino',
    'afternoon' => 'Pomeriggio',
    'evening' => 'Sera',
  ),
  'labels' => 
  array (
    'morning' => 'Mattino',
    'afternoon' => 'Pomeriggio',
    'from' => 'Dalle',
    'to' => 'Alle',
    'closed' => 'Chiuso',
  ),
  'descriptions' => 
  array (
    'day_schedule' => 'Configura gli orari di apertura per questo giorno',
  ),
  'placeholders' => 
  array (
    'morning_hours' => 'Orari del mattino',
    'afternoon_hours' => 'Orari del pomeriggio',
  ),
  'notes' => 
  array (
    'format_hint' => 'Utilizzare il formato 24 ore (es. 14:30 per le 2:30 del pomeriggio]',
    'empty_hint' => 'Lasciare vuoto significa "chiuso"',
  ),
  'validation' => 
  array (
    'invalid_format' => 'Formato orario non valido. Utilizzare HH:MM-HH:MM',
    'invalid_time_range' => 'L\'orario di apertura deve essere precedente all\'orario di chiusura',
    'overlapping_hours' => 'Gli orari non possono sovrapporsi nello stesso giorno',
    'from_before_to' => 'L\'orario "Dalle" deve essere precedente all\'orario "Alle"',
    'to_after_from' => 'L\'orario "Alle" deve essere successivo all\'orario "Dalle"',
    'time_sequence' => 'L\'orario di inizio deve essere precedente a quello di fine',
    'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
    'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session  :day, devi specificare anche quello di chiusura.',
    'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session  :day, devi specificare anche quello di apertura.',
    'opening_before_closing' => 'L\'orario di apertura del :session per :day deve essere precedente a quello di chiusura.',
    'morning' => 'mattino',
    'afternoon' => 'pomeriggio',
    'opening_hours' => 
    array (
      'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
      'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session  :day, devi specificare anche quello di chiusura.',
      'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session  :day, devi specificare anche quello di apertura.',
      'opening_before_closing' => 'L\'orario di apertura del :session  :day deve essere precedente a quello di chiusura.',
      'morning' => 'mattino',
      'afternoon' => 'pomeriggio',
    ),
  ),
  'label' => 'Opening Hours',
  'plural_label' => 'Opening Hours (Plurale)',
  'navigation' => 
  array (
    'name' => 'Opening Hours',
    'plural' => 'Opening Hours',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Opening Hours',
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
      'label' => 'Crea Opening Hours',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Opening Hours',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Opening Hours',
    ),
  ),
);
