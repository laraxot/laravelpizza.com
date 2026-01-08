# FullCalendar (saade/filament-fullcalendar) – Integrazione PTVX

## Introduzione
FullCalendar è il plugin di riferimento per la gestione di calendari interattivi in Filament. Permette la visualizzazione, creazione, modifica e cancellazione di eventi tramite modali e azioni Filament, con supporto multilingua, tema scuro e ampia personalizzazione.

## Requisiti e Installazione
- Laravel >= 10
- Filament >= 3.x
- Composer

Installa il pacchetto:
```bash
composer require saade/filament-fullcalendar
```

Aggiungi il plugin al provider Filament:
```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

$panel->plugin(
    FilamentFullCalendarPlugin::make()
        ->schedulerLicenseKey()
        ->selectable()
        ->editable()
        ->timezone()
        ->locale()
        ->plugins()
        ->config()
);
```

## Creazione Widget
```bash
php artisan make:filament-widget CalendarWidget
```
Estendi la classe:
```php
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        // Vedi esempi sotto
        return [];
    }
}
```
**Attenzione:** rimuovi la proprietà `protected static string $view` dal widget generato.

## Esempi Pratici
### 1. fetchEvents con array
```php
public function fetchEvents(array $fetchInfo): array
{
    return Event::query()
        ->where('starts_at', '>=', $fetchInfo['start'])
        ->where('ends_at', '<=', $fetchInfo['end'])
        ->get()
        ->map(fn (Event $event) => [
            'title' => $event->name,
            'start' => $event->starts_at,
            'end' => $event->ends_at,
        ])->all();
}
```
### 2. fetchEvents con EventData
```php
use Saade\FilamentFullCalendar\Data\EventData;
public function fetchEvents(array $fetchInfo): array
{
    return Event::query()
        ->where('starts_at', '>=', $fetchInfo['start'])
        ->where('ends_at', '<=', $fetchInfo['end'])
        ->get()
        ->map(fn (Event $event) => EventData::make()
            ->id($event->uuid)
            ->title($event->name)
            ->start($event->starts_at)
            ->end($event->ends_at)
        )->toArray();
}
```
### 3. Configurazione avanzata
```php
public function config(): array
{
    return [
        'firstDay' => 1,
        'headerToolbar' => [
            'left' => 'dayGridWeek,dayGridDay',
            'center' => 'title',
            'right' => 'prev,next today',
        ],
    ];
}
```
### 4. Azioni custom e form
```php
public Model|string|null $model = Event::class;
public function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('name'),
        Forms\Components\Grid::make()->schema([
            Forms\Components\DateTimePicker::make('starts_at'),
            Forms\Components\DateTimePicker::make('ends_at'),
        ]),
    ];
}
```
### 5. Hooks JS (es. tooltip)
```php
public function eventDidMount(): string
{
    return <<<JS
        function({ event, el }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
        }
    JS;
}
```

## Best Practice
- Usare sempre tipi espliciti e PHPDoc
- Validare i dati in fetchEvents
- Gestire i permessi con le policy Filament
- Documentare ogni personalizzazione
- Aggiornare la doc UI e root ad ogni variazione

## Cosa NON fare (Anti-pattern)
- Non duplicare la logica di fetchEvents in più widget
- Non lasciare azioni senza validazione
- Non usare stringhe hardcoded per label/tooltip
- Non ignorare la gestione degli errori JS

## Template per nuova regola/integrazione
```md
### [Titolo Regola]
- **Ambito**: [UI/root]
- **Motivazione**: [perché è importante]
- **Regola**: [enunciato chiaro]
- **Esempio pratico**:
  ```php
  // Codice di esempio
  ```
- **Anti-pattern**:
  ```php
  // Codice da evitare
  ```
- **Collegamenti**: [link a doc correlate]
```

## Collegamenti e Risorse
- [Documentazione ufficiale](https://filamentphp.com/plugins/saade-fullcalendar)
- [GitHub](https://github.com/saade/filament-fullcalendar)
- [Esempio Laravel Daily](https://laraveldaily.com/post/filament-show-calendar-of-tasks-with-fullcalendar)
- [Modules/UI/docs/full-calendar.md](../Modules/UI/docs/full-calendar.md)
- [Regole .mdc](../.cursor/rules/cursor.mdc), [../.windsurf/rules/windsurf.mdc]

## Ultimo aggiornamento
2025-06-04
