# Integrazioni il progetto

## Moduli Core

### 1. Patient Module
```php
namespace Modules\Patient\Filament\Resources;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestione Pazienti';
    protected static ?string $navigationLabel = 'Pazienti';

    public static function getFormSchema(): array
    {
        return [
            // Schema specifico per i pazienti
        ];
    }
}
```

### 2. Dental Module
```php
namespace Modules\Dental\Filament\Resources;

class VisitResource extends XotBaseResource
{
    protected static ?string $model = Visit::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Gestione Visite';
    protected static ?string $navigationLabel = 'Visite';

    public static function getFormSchema(): array
    {
        return [
            // Schema specifico per le visite
        ];
    }
}
```

### 3. ISEE Module
```php
namespace Modules\ISEE\Filament\Resources;

class ISEEResource extends XotBaseResource
{
    protected static ?string $model = ISEE::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Gestione ISEE';
    protected static ?string $navigationLabel = 'ISEE';

    public static function getFormSchema(): array
    {
        return [
            // Schema specifico per ISEE
        ];
    }
}
```

## Relazioni tra Moduli

### 1. Patient-Visit
```php
class PatientResource extends XotBaseResource
{
    public static function getRelations(): array
    {
        return [
            RelationManagers\VisitsRelationManager::class,
        ];
    }
}
```

### 2. Patient-ISEE
```php
class PatientResource extends XotBaseResource
{
    public static function getRelations(): array
    {
        return [
            RelationManagers\ISEEsRelationManager::class,
        ];
    }
}
```

## Widgets Specializzati

### 1. Patient Stats
```php
namespace Modules\Patient\Filament\Widgets;

class PatientStatsWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Statistiche Pazienti';
    protected static ?int $sort = 1;

    public function getData(): array
    {
        return [
            'total' => Patient::count(),
            'active' => Patient::active()->count(),
            'new_today' => Patient::today()->count(),
        ];
    }
}
```

### 2. Visit Calendar
```php
namespace Modules\Dental\Filament\Widgets;

class VisitCalendarWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Calendario Visite';
    protected static ?int $sort = 2;

    public function getData(): array
    {
        return [
            'visits' => Visit::upcoming()->get(),
        ];
    }
}
```

## Pages Specializzate

### 1. Dashboard
```php
namespace Modules\Core\Filament\Pages;

class Dashboard extends XotBasePage
{
    protected static string $view = 'core::filament.pages.dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';

    public function getTitle(): string
    {
        return $this->trans('Dashboard');
    }
}
```

### 2. Report
```php
namespace Modules\Reporting\Filament\Pages;

class PatientReport extends XotBasePage
{
    protected static string $view = 'reporting::filament.pages.patient-report';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Reportistica';
    protected static ?string $navigationLabel = 'Report Pazienti';

    public function getTitle(): string
    {
        return $this->trans('Report Pazienti');
    }
}
```

## Forms Specializzati

### 1. Patient Registration
```php
namespace Modules\Patient\Filament\Forms;

class PatientRegistrationForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            // Schema registrazione paziente
        ];
    }
}
```

### 2. Visit Form
```php
namespace Modules\Dental\Filament\Forms;

class VisitForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            // Schema visita
        ];
    }
}
```

## Tables Specializzate

### 1. Patient List
```php
namespace Modules\Patient\Filament\Tables;

class PatientTable extends XotBaseTable
{
    public static function getTableColumns(): array
    {
        return [
            // Colonne lista pazienti
        ];
    }
}
```

### 2. Visit List
```php
namespace Modules\Dental\Filament\Tables;

class VisitTable extends XotBaseTable
{
    public static function getTableColumns(): array
    {
        return [
            // Colonne lista visite
        ];
    }
}
```

## Traduzioni

### 1. Patient Module
```php
return [
    'resources' => [
        'patient' => [
            'title' => 'Paziente',
            'navigation' => [
                'group' => 'Gestione Pazienti',
                'label' => 'Pazienti',
            ],
        ],
    ],
];
```

### 2. Dental Module
```php
return [
    'resources' => [
        'visit' => [
            'title' => 'Visita',
            'navigation' => [
                'group' => 'Gestione Visite',
                'label' => 'Visite',
            ],
        ],
    ],
];
```

## Testing

### 1. Patient Tests
```php
namespace Modules\Patient\Tests\Filament\Resources;

class PatientResourceTest extends TestCase
{
    public function test_can_list_patients()
    {
        $this->get(route('filament.resources.patient.index'))
            ->assertSuccessful();
    }
}
```

### 2. Visit Tests
```php
namespace Modules\Dental\Tests\Filament\Resources;

class VisitResourceTest extends TestCase
{
    public function test_can_list_visits()
    {
        $this->get(route('filament.resources.visit.index'))
            ->assertSuccessful();
    }
}
```

## Performance

### 1. Query Optimization
```php
class PatientResource extends XotBaseResource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['visits', 'isee'])
            ->latest();
    }
}
```

### 2. Cache Implementation
```php
class PatientStatsWidget extends XotBaseWidget
{
    public function getData(): array
    {
        return Cache::remember('patient_stats', 3600, function () {
            return [
                'total' => Patient::count(),
                'active' => Patient::active()->count(),
            ];
        });
    }
}
```

## Sicurezza

### 1. Permessi
```php
class PatientResource extends XotBaseResource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_patients');
    }
}
```

### 2. Validazione
```php
class PatientForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('fiscal_code')
                ->required()
                ->unique(Patient::class)
                ->rules(['regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/']),
        ];
    }
}
``` 
## Collegamenti tra versioni di integrations.md
* [integrations.md](docs/tecnico/filament/integrations.md)
* [integrations.md](laravel/Modules/Job/docs/packages/integrations.md)

