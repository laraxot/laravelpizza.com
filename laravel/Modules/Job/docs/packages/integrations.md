# Integrazioni

## Pacchetti Utilizzati

### Calendar
- [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar)
  - Integrazione Google Calendar
  - Eventi
  - Notifiche
  - Configurazione dettagliata
  - Integrazione con Filament

### Slack
- [spatie/laravel-slack-alerts](https://github.com/spatie/laravel-slack-alerts)
  - Alert Slack
  - Notifiche
  - Configurazione dettagliata
  - Integrazione con Filament
  - Webhook

## Configurazione

### Calendar
```php
// config/google-calendar.php
return [
    'default_auth_profile' => 'service_account',
    'auth_profiles' => [
        'service_account' => [
            'credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),
        ],
    ],
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
];
```

### Slack
```php
// config/slack-alerts.php
return [
    'webhook_urls' => [
        'default' => env('SLACK_ALERT_WEBHOOK_URL'),
    ],
];
```

## Utilizzo

### Calendar
```php
// Creare evento
GoogleCalendar::createEvent(
    'Event Title',
    Carbon::now(),
    Carbon::now()->addHour(),
    [
        'description' => 'Event Description',
    ]
);

// Lista eventi
$events = GoogleCalendar::getEvents(
    Carbon::now(),
    Carbon::now()->addWeek()
);
```

### Slack
```php
// Inviare alert
SlackAlert::message('Job completato con successo!');

// Alert con emoji
SlackAlert::message('Job fallito! :warning:');

// Alert con canale
SlackAlert::to('channel-name')->message('Job in corso...');
```

## Documentazione Collegata

- [Queue](queue.md)
- [Monitoraggio](monitoring.md)
- [Performance](performance.md)
- [Panoramica](../packages.md)
### Versione HEAD

### Versione HEAD

## Collegamenti tra versioni di integrations.md
* [integrations.md](docs/tecnico/filament/integrations.md)
* [integrations.md](../../../Job/docs/packages/integrations.md)

### Versione Incoming

---

### Versione Incoming

---
