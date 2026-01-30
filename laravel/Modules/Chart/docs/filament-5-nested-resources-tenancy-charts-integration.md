# Integrazione Completa di Filament 5.x: Nested Resources, Tenancy e Chart Widgets

## Panoramica

Questo documento descrive l'integrazione completa delle funzionalità avanzate di Filament PHP 5.x all'interno del framework Laraxot: risorse annidate (nested resources), multi-tenancy e chart widgets. Queste funzionalità sono particolarmente rilevanti per il progetto Quaeris, che richiede una gestione complessa di dati di survey multi-tenant con visualizzazioni grafiche avanzate.

## 1. Nested Resources in Filament 5.x

### Concetto Base
Le nested resources permettono di creare una struttura gerarchica di risorse dove una risorsa è "annidata" all'interno di un'altra. Ad esempio, `LessonResource` può essere annidata all'interno di `CourseResource`.

### Creazione di Nested Resources
Per creare una nested resource, usare il comando:
```bash
php artisan make:filament-resource Lesson --nested
```

### Configurazione della Relazione
La nested resource deve puntare alla risorsa padre:
```php
// In LessonResource.php
protected static ?string $parentResource = CourseResource::class;
```

La risorsa padre può avere un relation manager o una pagina di gestione:
```php
// In CourseResource.php
protected static ?string $relatedResource = LessonResource::class;
```

### Personalizzazione dei Nomi di Relazione
In alcuni casi, potrebbe essere necessario personalizzare i nomi delle relazioni:

```php
use App\Filament\Resources\Courses\CourseResource;
use Filament\Resources\ParentResourceRegistration;

public static function getParentResourceRegistration(): ?ParentResourceRegistration
{
    return CourseResource::asParent()
        ->relationship('lessons')
        ->inverseRelationship('course');
}
```

## 2. Multi-tenancy in Filament 5.x

### Architettura Multi-tenant
La multi-tenancy consente a un'applicazione di servire più clienti (tenant) separati, ognuno con i propri dati e regole di accesso. In Filament, questa funzionalità è implementata attraverso:

1. **Modello Tenant**: Un modello (es. `Team`) che rappresenta ogni tenant
2. **Relazione Utente-Tenant**: Gli utenti appartengono a uno o più tenant
3. **Scoping Automatico**: Le risorse vengono automaticamente scolate al tenant corrente

### Configurazione Base
```php
use App\Models\Team;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Team::class);
}
```

### Implementazione nel Modello Utente
```php
<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant)->exists();
    }
}
```

### Scoping Automatico
Filament applica automaticamente global scopes alle query per le risorse tenant-aware:
- Le query vengono automaticamente scolate al tenant corrente
- Le nuove risorse vengono automaticamente associate al tenant corrente
- Le risorse non appartenenti al tenant corrente tornano 404

### Disabilitazione della Tenancy per Specifiche Risorse
```php
protected static bool $isScopedToTenant = false;
```

## 3. Chart Widgets in Filament 5.x

### Creazione di Chart Widgets
```bash
php artisan make:filament-widget BlogPostsChart --chart
```

### Tipi di Chart Disponibili
- Bar chart
- Bubble chart
- Doughnut chart
- Line chart
- Pie chart
- Polar area chart
- Radar chart
- Scatter chart

### Implementazione Base
```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### Filtraggio dei Dati
```php
public ?string $filter = 'today';

protected function getFilters(): ?array
{
    return [
        'today' => 'Today',
        'week' => 'Last week',
        'month' => 'Last month',
        'year' => 'This year',
    ];
}
```

### Filtri Personalizzati
```php
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Widgets\ChartWidget\Concerns\HasFiltersSchema;

class BlogPostsChart extends ChartWidget
{
    use HasFiltersSchema;

    public function filtersSchema(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('startDate')
                ->default(now()->subDays(30)),
            DatePicker::make('endDate')
                ->default(now()),
        ]);
    }
}
```

## 4. Integrazione con Laravel Modules

### Struttura del Modulo
La struttura di un modulo che implementa queste funzionalità:

```
Modules/
└── Quaeris/
    ├── app/
    │   ├── Filament/
    │   │   ├── Resources/
    │   │   │   ├── SurveyResource/
    │   │   │   │   ├── Pages/
    │   │   │   │   └── RelationManagers/
    │   │   │   ├── QuestionResource/
    │   │   │   │   └── Pages/
    │   │   │   └── ResponseResource/
    │   │   └── Widgets/
    │   │       └── SurveyChartWidget.php
    │   └── Models/
    │       ├── Survey.php
    │       ├── Question.php
    │       └── Response.php
    └── docs/
        └── filament-integration.md
```

### Relazioni tra Modelli
```php
// In Survey.php
public function questions()
{
    return $this->hasMany(Question::class);
}

public function responses()
{
    return $this->hasMany(Response::class);
}

// In Question.php
public function survey()
{
    return $this->belongsTo(Survey::class);
}

public function responses()
{
    return $this->hasMany(Response::class);
}

// In Response.php
public function survey()
{
    return $this->belongsTo(Survey::class);
}

public function question()
{
    return $this->belongsTo(Question::class);
}
```

## 5. Implementazione Pratica nel Progetto Quaeris

### Nested Resources per Survey-Question-Response
```php
// SurveyResource.php
class SurveyResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Quaeris\Models\Survey::class;
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            'questions' => QuestionRelationManager::class,
        ];
    }
}

// QuestionResource.php
class QuestionResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Quaeris\Models\Question::class;
    protected static ?string $parentResource = SurveyResource::class;
}

// ResponseResource.php
class ResponseResource extends XotBaseResource
{
    protected static ?string $model = \Modules\Quaeris\Models\Response::class;
    protected static ?string $parentResource = QuestionResource::class;
}
```

### Chart Widget per Analisi Survey
```php
<?php

namespace Modules\Quaeris\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Modules\Quaeris\Models\Response;

class SurveyResponseChart extends ChartWidget
{
    protected ?string $heading = 'Survey Responses';
    
    public ?int $surveyId = null;

    protected function getData(): array
    {
        $responses = Trend::model(Response::class)
            ->where('survey_id', $this->surveyId)
            ->between(
                start: now()->subDays(30),
                end: now()
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Responses',
                    'data' => $responses->map(fn ($value) => $value->aggregate),
                ],
            ],
            'labels' => $responses->map(fn ($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

### Implementazione Multi-tenant
```php
// In Survey.php
class Survey extends XotBaseModel
{
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (auth()->hasUser() && filament()->getTenant()) {
                $query->where('tenant_id', filament()->getTenant()->id);
            }
        });
    }

    public function creating(Survey $survey): void
    {
        if (auth()->hasUser() && filament()->getTenant()) {
            $survey->tenant_id = filament()->getTenant()->id;
        }
    }
}
```

## 6. Best Practices e Considerazioni di Sicurezza

### Sicurezza Multi-tenant
- Implementare sempre il controllo `canAccessTenant()`
- Verificare che le relazioni siano correttamente scolate
- Usare `scopedUnique()` e `scopedExists()` per la validazione
- Testare accuratamente la separazione dei dati

### Prestazioni
- Implementare caching appropriato per i dati di chart
- Ottimizzare le query con eager loading
- Usare indici appropriati sulle colonne tenant
- Considerare la paginazione per grandi dataset

### Architettura
- Seguire il pattern DRY con XotBaseResource
- Implementare correttamente i contratti Filament
- Mantenere la coerenza tra i moduli
- Documentare adeguatamente le interazioni

## 7. Conclusione

L'integrazione di nested resources, multi-tenancy e chart widgets in Filament 5.x all'interno del framework Laraxot fornisce una solida base per applicazioni complesse come Quaeris. Queste funzionalità, quando implementate correttamente, consentono di gestire strutture dati gerarchiche, separare i dati per tenant e fornire potenti strumenti di analisi visiva, tutto mantenendo alta la qualità del codice e la sicurezza dei dati.