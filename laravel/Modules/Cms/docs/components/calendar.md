# Calendar Component

## Overview
Il componente Calendar fornisce un'interfaccia per visualizzare e gestire calendari utilizzando FullCalendar.

## Installation
Il componente è parte del modulo Cms e viene registrato automaticamente.

## Usage
```php
<x-pub_theme::components.blocks.calendar 
    :events="$events"
    :config="$config"
/>
```

## Properties
- `events`: Array di eventi da visualizzare nel calendario
- `config`: Configurazione aggiuntiva per FullCalendar

## Configuration
Il componente utilizza le seguenti configurazioni di default:
- Localizzazione italiana
- Orari lavorativi standard
- Formattazione date in italiano

## Events
Gli eventi devono seguire il formato standard di FullCalendar:
```php
[
    'title' => 'Event Title',
    'start' => '2024-01-01T09:00:00',
    'end' => '2024-01-01T10:00:00',
]
```

## Dependencies
- FullCalendar
- Moment.js per la gestione delle date

## File Correlati

- `resources/views/components/blocks/calendar.blade.php`: Template del componente
- `lang/it/calendar.php`: File di traduzione
- `app/Filament/Widgets/*CalendarWidget.php`: Widget Filament

## Note
- Il componente utilizza i widget di Filament per il rendering del calendario
- Le traduzioni sono gestite attraverso il file di lingua del modulo
- La configurazione del calendario è definita nel trait `HasFullCalendarConfig`

## Collegamenti
- [Documentazione FullCalendar](../fullcalendar_parental_widgets.md)
- [Configurazione Widget](../fullcalendar_widget_implementation.md) 
