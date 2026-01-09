# Architettura Dashboard - Modulo Meetup

## Panoramica

Il dashboard del modulo Meetup (MeetupDashboard.php) rappresenta il centro nevralgico dell'esperienza admin per la gestione degli eventi e delle attività della community. Implementa i principi architetturali fondamentali del progetto Laravel Pizza Meetups basati su Laravel Folio, Laravel Volt e Filament PHP.

## Struttura e Componenti

### MeetupDashboard.php
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Xot\Filament\Pages\XotBasePage;
use Override;

class MeetupDashboard extends XotBasePage
{
    protected string $view = 'meetup::filament.pages.meetup-dashboard';

    /**
     * @return array<int, class-string>
     */
    public function getWidgets(): array
    {
        return [
            EventCalendarWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[Override]
    public function getFormSchema(): array
    {
        return [];
    }
}
```

### Filosofia del Dashboard

Il dashboard segue una filosofia di **componentizzazione modulare**:

1. **Estensibilità**: Estende `XotBasePage` per mantenere coerenza con la struttura Laraxot
2. **Widget-based**: Utilizza widget per organizzare le informazioni (es. `EventCalendarWidget`)
3. **Vista personalizzata**: Usa una vista specifica `'meetup::filament.pages.meetup-dashboard'`
4. **Layout flessibile**: Permette definizione di colonne tramite `getColumns()`
5. **Form dinamici**: Supporta schemi di form tramite `getFormSchema()` (attualmente vuoto)

### EventCalendarWidget

Il widget principale del dashboard:

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;
use Modules\Meetup\Models\Event;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Override;

class EventCalendarWidget extends XotBaseWidget
{
    protected string $view = 'meetup::filament.widgets.event-calendar';

    public string $type = 'event';

    /**
     * @var array<string, mixed>
     */
    protected array $lastDateSelection = [];

    public function getActionName(string $function): string
    {
        $actionSuffix = Str::of($function)->studly()->append('Action')->toString();
        $resource = XotData::make()->getUserResourceClassByType($this->type);
        $model = $resource::getModel();
        $modelString = is_string($model) ? $model : (string) $model;

        return Str::of($modelString)
            ->replace('\\Models\\', '\\Actions\\')
            ->append('\\Calendar\\'.$actionSuffix)
            ->toString();
    }

    /**
     * @param  array<string, mixed>  $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        /** @var array<int, array<string, mixed>> $events */
        $events = Event::whereBetween('start_date', [$fetchInfo['start']], $fetchInfo['end']])
            ->where('status', 'published')
            ->get()
            ->map(function (Event $event): array {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->toISOString(),
                    'end' => $event->end_date->toISOString(),
                    'backgroundColor' => '#DC2626',
                    'borderColor' => '#DC2626',
                    'textColor' => '#FFFFFF',
                ];
            })
            ->values()
            ->toArray();

        return $events;
    }

    /**
     * @return array<int|string, Component>
     */
    #[Override]
    public function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->maxLength(255),
            'dates' => Grid::make()
                ->schema([
                    'start_date' => DateTimePicker::make('start_date')
                        ->required(),
                    'end_date' => DateTimePicker::make('end_date')
                        ->required(),
                ]),
            'location' => TextInput::make('location')
                ->maxLength(255),
            'status' => Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'cancelled' => 'Cancelled',
                ])
                ->default('draft')
                ->required(),
        ];
    }

    /**
     * @param  array<string, mixed>|null  $view
     * @param  array<string, mixed>|null  $resource
     */
    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        $this->lastDateSelection = [
            'start' => $start,
            'end' => $end,
            'allDay' => $allDay,
            'view' => $view,
            'resource' => $resource,
        ];
    }
}
```

## Integrazione con l'Architettura Generale

### Principi Architetturali Applicati

1. **DRY (Don't Repeat Yourself)**:
   - Riutilizzo della classe base `XotBasePage` e `XotBaseWidget`
   - Codice condiviso tra diversi componenti Filament

2. **KISS (Keep It Simple, Stupid)**:
   - Struttura chiara e diretta
   - Minimo numero di componenti necessari
   - Separazione chiara tra logica e presentazione

3. **SOLID**:
   - **Single Responsibility**: Ogni classe ha un unico scopo ben definito
   - **Open/Closed**: Estensibilità tramite classi base
   - **Liskov Substitution**: Conformità con le interfacce Filament

4. **Laraxot**:
   - Uso esclusivo di classi `XotBase*` per estendere componenti Filament
   - Conformità con le regole architetturali Laraxot
   - Pattern modulari per estensibilità

### Relazione con il Modello Event

Il dashboard si integra strettamente con il modello `Event`:

```php
<?php
// Estratto dal modello Event
class Event extends Model
{
    use HasEvents;
    use HasSnapshots;
    use HasXotFactory;

    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 
        'location', 'status', 'event_status', 'event_attendance_mode',
        'attendees_count', 'max_attendees'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'event_status' => EventStatus::class,
        'event_attendance_mode' => EventAttendanceMode::class,
    ];

    // Schema.org Event JSON-LD structured data
    public function toSchemaOrg(): array
    {
        // Implementazione della struttura dati per Schema.org
    }
}
```

## Business Logic Implementata

### Funzionalità del Dashboard

1. **Visualizzazione Calendario Eventi**:
   - Carica gli eventi pubblicati
   - Mostra informazioni chiave (titolo, data, stato)
   - Supporta selezione di date

2. **Gestione Eventi**:
   - Form per creazione/modifica eventi
   - Validazione e controllo stato
   - Integrazione con data picker

3. **Integrazione con Schema.org**:
   - Supporto per structured data
   - Ottimizzazione SEO per eventi

## Pattern di Implementazione

### Widget Pattern
- Separazione tra dashboard e widget specifici
- Riutilizzo dei widget in diverse pagine
- Facilità di estensione e manutenzione

### Action Pattern
- Separazione tra logica di presentazione e business logic
- Utilizzo di classi Action per operazioni complesse
- Supporto per azioni asincrone

### XotBase Integration
- Conformità con la struttura Laraxot
- Estensibilità tramite classi base
- Standardizzazione dell'architettura

## Best Practices Implementate

1. **Type Safety**: Uso di `declare(strict_types=1)` e tipizzazione stretta
2. **Documentazione**: PHPDoc accurati e dettagliati
3. **Naming Convention**: Conformità con le regole Laraxot
4. **Architettura Modulare**: Separazione chiara delle responsabilità
5. **Estensibilità**: Facilità di aggiunta di nuovi widget e funzionalità

## Integrazione con il Sistema Generale

Il dashboard Meetup si integra con:
- Sistema di autenticazione User
- Servizio di notifiche Notify
- Gestione attività Activity
- Ottimizzazione SEO tramite modulo Seo
- File e media tramite modulo Media

## Conclusione

L'architettura del dashboard Meetup rappresenta un esempio perfetto di come i principi DRY, KISS e SOLID si integrino con l'architettura Laraxot per creare una soluzione modulare, estensibile e manutenibile. La combinazione di Filament PHP per l'admin, Laravel Folio per il frontend e un approccio modulare crea un sistema robusto che supporta la gestione completa degli eventi meetup.
