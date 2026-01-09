# Documentazione Backoffice il progetto

## Introduzione

Questo documento descrive l'architettura e l'implementazione del backoffice del progetto il progetto. Il backoffice è l'interfaccia amministrativa utilizzata per gestire pazienti, appuntamenti, trattamenti odontoiatrici, reportistica e tutte le altre funzionalità del sistema, con particolare attenzione alla gestione delle gestanti in condizioni di vulnerabilità socio-economica.

## Architettura Generale

Il backoffice di il progetto è basato esclusivamente su Filament, un framework admin per Laravel che offre un'interfaccia moderna, accessibile e flessibile. L'architettura è modulare, con ogni modulo che fornisce il proprio pannello amministrativo attraverso classi che estendono `XotBasePanelProvider`.

La scelta di Filament come unico framework per l'interfaccia amministrativa garantisce:
- Esperienza utente coerente in tutto il sistema
- Elevata produttività degli sviluppatori
- Manutenibilità del codice
- Facilità di estensione con nuove funzionalità

### Principi Architetturali

1. **Modularità**: Ogni funzionalità è isolata nel proprio modulo
2. **Estensibilità**: Utilizzo di classi base che possono essere estese
3. **Convenzione over Configuration**: Struttura standardizzata per tutti i moduli
4. **Riusabilità**: Componenti comuni condivisi tra moduli

## Moduli Principali del Backoffice

Il backoffice di il progetto è organizzato nei seguenti moduli:

| Modulo | Descrizione | Stato |
|--------|-------------|-------|
| User | Gestione utenti e permessi | Completato |
| Patient | Gestione anagrafica e dati pazienti | Completato |
| Dental | Gestione appuntamenti e trattamenti | Completato |
| Notify | Sistema notifiche multi-canale | Completato |
| Reporting | Reportistica e analisi dati | Completato |
| Tenant | Gestione multi-tenant | Completato |
| Lang | Supporto multilingua | Completato |
| Activity | Logging e audit trail | Completato |
| Gdpr | Conformità privacy e consensi | Completato |
| Media | Gestione file e documenti | Completato |

## Struttura dei Pannelli Amministrativi

Ogni modulo del sistema implementa il proprio pannello amministrativo estendendo la classe base `XotBasePanelProvider`:

```php
// Modules/Dental/app/Providers/Filament/AdminPanelProvider.php
namespace Modules\Dental\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dental')
            ->path('dental')
            ->login()
            ->colors([
                'primary' => Color::Teal,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                FilamentSpatieLaravelHealthPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

## Risorse Filament

Le risorse Filament rappresentano i modelli del sistema e forniscono interfacce per la gestione dei dati. In il progetto, tutte le risorse estendono `XotBaseResource` che garantisce coerenza nell'implementazione:

```php
// Modules/Dental/app/Filament/Resources/AppointmentResource.php
namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Dental\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;

    public static function getFormSchema(): array
    {
        return [
            'patient_id' => Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'full_name')
                ->searchable()
                ->required(),
            'dentist_id' => Forms\Components\Select::make('dentist_id')
                ->relationship('dentist', 'full_name')
                ->searchable()
                ->required(),
            'date' => Forms\Components\DatePicker::make('date')
                ->required(),
            'start_time' => Forms\Components\TimePicker::make('start_time')
                ->required(),
            'end_time' => Forms\Components\TimePicker::make('end_time')
                ->required(),
            'type' => Forms\Components\Select::make('type')
                ->options(AppointmentType::options())
                ->required(),
            'status' => Forms\Components\Select::make('status')
                ->options(AppointmentStatus::options())
                ->required(),
            'notes' => Forms\Components\Textarea::make('notes')
                ->columnSpan(2),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'patient.full_name' => Tables\Columns\TextColumn::make('patient.full_name')
                ->searchable()
                ->sortable(),
            'dentist.full_name' => Tables\Columns\TextColumn::make('dentist.full_name')
                ->searchable()
                ->sortable(),
            'date' => Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable(),
            'start_time' => Tables\Columns\TextColumn::make('start_time')
                ->time()
                ->sortable(),
            'type' => Tables\Columns\BadgeColumn::make('type')
                ->enum(AppointmentType::options())
                ->colors([
                    'primary' => AppointmentType::CHECKUP->value,
                    'success' => AppointmentType::CLEANING->value,
                    'warning' => AppointmentType::TREATMENT->value,
                    'danger' => AppointmentType::EMERGENCY->value,
                ]),
            'status' => Tables\Columns\BadgeColumn::make('status')
                ->enum(AppointmentStatus::options())
                ->colors([
                    'success' => AppointmentStatus::CONFIRMED->value,
                    'warning' => AppointmentStatus::PENDING->value,
                    'danger' => AppointmentStatus::CANCELLED->value,
                    'info' => AppointmentStatus::COMPLETED->value,
                ]),
        ];
    }
}
```

## Workflow per Prenotazioni

Una delle funzionalità più importanti del backoffice è il workflow multi-step per le prenotazioni, implementato tramite il modulo Dental. Il workflow è strutturato nelle seguenti fasi:

1. **Selezione Paziente**: Individuazione della gestante dall'anagrafica
2. **Verifica Requisiti**: Controllo ISEE e stato di gravidanza
3. **Selezione Dentista**: Scelta del medico disponibile
4. **Pianificazione Appuntamento**: Selezione data e ora
5. **Definizione Trattamento**: Indicazione del tipo di trattamento previsto
6. **Conferma**: Riepilogo e conferma della prenotazione
7. **Notifica**: Invio comunicazione automatica alla paziente

Il workflow è implementato utilizzando le funzionalità di Filament per form multi-step e componenti personalizzati:

```php
// Modules/Dental/app/Filament/Resources/AppointmentWorkflowResource/Forms/WorkflowForms.php
namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Forms;

use Filament\Forms;
use Modules\Dental\Filament\Components\AppointmentWorkflowProgress;
use Modules\Dental\Filament\Components\AppointmentWorkflowSummary;

class WorkflowForms
{
    public static function getPatientStep(): array
    {
        return [
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->label('Paziente')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->required(),
                    // Altri campi
                ])
        ];
    }

    // Altri metodi per i vari step del workflow...

    public static function getSummaryStep(AppointmentWorkflow $workflow): array
    {
        return [
            AppointmentWorkflowSummary::make($workflow),
            Forms\Components\Checkbox::make('send_confirmation')
                ->label('Invia email di conferma alla paziente')
                ->default(true),
        ];
    }
}
```

## Sistema di Reportistica

Il backoffice include un potente sistema di reportistica, implementato attraverso il modulo Reporting, che consente di:

- Generare report sugli appuntamenti per periodo
- Monitorare i trattamenti più comuni
- Analizzare la distribuzione geografica delle pazienti
- Tracciare l'utilizzo delle risorse
- Esportare dati in vari formati (CSV, Excel, PDF)

La reportistica è implementata utilizzando:

- Chart.js per visualizzazioni grafiche
- Filament Tables per visualizzazioni tabulari
- Spatie Laravel-Excel per esportazioni
- Componenti Filament personalizzati per dashboard

## Sicurezza e Privacy

In conformità con i requisiti GDPR, il backoffice implementa:

- Controllo accessi granulare basato su ruoli
- Logging completo delle attività (chi ha fatto cosa e quando)
- Oscuramento dati sensibili nei log
- Gestione esplicita dei consensi
- Procedure automatizzate per richieste di portabilità/cancellazione dati

## Integrazione con Moduli Esterni

Il backoffice si integra con vari servizi esterni:

- Sistema di verifica ISEE
- Sistema di notifiche multi-canale (email, SMS)
- Storage sicuro per documenti
- Servizi di autenticazione

## Estensione del Backoffice

Per estendere il backoffice con nuove funzionalità:

1. Creare un nuovo modulo usando `php artisan module:make NomeModulo`
2. Implementare i modelli necessari estendendo `XotBaseModel`
3. Creare risorse Filament estendendo `XotBaseResource`
4. Registrare il modulo nel service provider
5. Implementare le migrazioni necessarie

Esempio di pagina dashboard:

```php
// Modules/Predict/app/Filament/Pages/Dashboard.php
namespace Modules\Predict\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            // Widget per l'intestazione
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Widget per il footer
        ];
    }
}
```

## Widget

I widget sono componenti riutilizzabili che possono essere aggiunti alle dashboard o alle pagine. Sono definiti in:

```
Modules/ModuleName/app/Filament/Widgets/
```

Esempio di widget per statistiche:

```php
// Modules/Predict/app/Filament/Widgets/StatsOverview.php
namespace Modules\Predict\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Predict\Models\Market;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Mercati Totali', Market::count()),
            Stat::make('Mercati Attivi', Market::where('status', 'active')->count()),
            Stat::make('Mercati Chiusi', Market::where('status', 'closed')->count()),
        ];
    }
}
```

## Clusters

Filament 3 introduce il concetto di Clusters, che permettono di organizzare le risorse in gruppi logici. I Clusters sono definiti in:

```
Modules/ModuleName/app/Filament/Clusters/
```

Esempio di Cluster:

```php
// Modules/Predict/app/Filament/Clusters/MarketManagement/MarketCluster.php
namespace Modules\Predict\Filament\Clusters\MarketManagement;

use Filament\Clusters\Cluster;

class MarketCluster extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Gestione Mercati';

    protected static ?int $navigationSort = 1;
}
```

## Autenticazione e Autorizzazioni

L'autenticazione e le autorizzazioni nel backoffice sono gestite attraverso:

1. **Guard**: Configurabile tramite `FILAMENT_AUTH_GUARD` in `.env`
2. **Middleware**: Personalizzabile in ogni `AdminPanelProvider`
3. **Policies**: Per il controllo granulare delle autorizzazioni sulle risorse

Esempio di configurazione delle autorizzazioni:

```php
// Modules/ModuleName/app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        // Altre configurazioni
        ->authGuard('web')
        ->authMiddleware([
            Authenticate::class,
        ])
        ->authorization(function (User $user) {
            return $user->hasRole('admin');
        });
}
```

## Personalizzazione del Tema

Filament supporta la personalizzazione del tema attraverso Tailwind CSS. La configurazione del tema è definita in:

```
Modules/ModuleName/resources/css/filament/
```

La configurazione di Tailwind per Filament:

```js
// tailwind.config.js
import preset from '../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
```

## Integrazione con i Moduli

Ogni modulo del sistema può registrare il proprio `AdminPanelProvider` nel file `module.json`:

```json
{
    "providers": [
        "Modules\\ModuleName\\Providers\\Filament\\AdminPanelProvider"
    ]
}
```

Questo permette un'architettura modulare dove ogni modulo può estendere il backoffice con le proprie funzionalità.

## Best Practices

1. **Estendere XotBaseResource e XotBaseServiceProvider**:
   - Utilizzare `XotBaseResource` come base per tutte le risorse Filament
   - Tutti i Service Provider dei moduli DEVONO estendere `XotBaseServiceProvider` e mai `Illuminate\Support\ServiceProvider`
   - Tutti i Route Service Provider dei moduli DEVONO estendere `XotBaseRouteServiceProvider` e mai `Illuminate\Foundation\Support\Providers\RouteServiceProvider`
2. **Organizzazione dei Form**: Utilizzare sezioni e tab per organizzare form complessi
3. **Azioni Personalizzate**: Creare azioni personalizzate per operazioni specifiche
4. **Filtri e Ricerca**: Implementare filtri e ricerca avanzata per tabelle con molti dati
5. **Validazione**: Utilizzare le regole di validazione di Laravel nei form
6. **Localizzazione**: Supportare più lingue utilizzando i file di traduzione
7. **Autorizzazioni Granulari**: Implementare policies per un controllo preciso delle autorizzazioni

## Esempi di Implementazione

### Form con Relazioni

```php
Forms\Components\Select::make('user_id')
    ->relationship('user', 'name')
    ->searchable()
    ->preload()
    ->required(),
```

### Tabella con Filtri

```php
->filters([
    Tables\Filters\SelectFilter::make('status')
        ->options([
            'active' => 'Attivo',
            'pending' => 'In attesa',
            'closed' => 'Chiuso',
        ]),
])
```

### Azione Personalizzata

```php
Tables\Actions\Action::make('close')
    ->label('Chiudi Mercato')
    ->icon('heroicon-o-lock-closed')
    ->color('danger')
    ->requiresConfirmation()
    ->action(function (Market $record) {
        $record->update(['status' => 'closed']);
    }),
```

## Conclusione

Il backoffice basato su Filament fornisce un'interfaccia amministrativa potente e flessibile per la gestione del sistema. La struttura modulare permette di estendere facilmente le funzionalità mantenendo la coerenza dell'interfaccia utente.
