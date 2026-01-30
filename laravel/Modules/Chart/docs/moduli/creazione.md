# Creazione Moduli il progetto

## Struttura Base dei Moduli

Ogni modulo deve seguire questa struttura:
```
laravel/Modules/[NomeModulo]/
├── Config/
├── Console/
├── Database/
│   ├── Factories/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Providers/
├── Resources/
│   ├── js/
│   ├── lang/
│   └── views/
├── Routes/
├── Services/
├── Tests/
└── module.json
```

## Moduli da Creare

### 1. Modulo Patient

```bash

# Creazione struttura base
mkdir -p laravel/Modules/Patient/{Config,Console,Database/{Factories,Migrations,Seeders},Filament/{Resources,Pages,Widgets},Http/{Controllers,Middleware,Requests},Models,Providers,Resources/{js,lang,views},Routes,Services,Tests}
```

#### Models
```php
// laravel/Modules/Patient/Models/Patient.php
namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\Traits\HasPatient;

class Patient extends Model
{
    use HasPatient;

    protected $fillable = [
        'nome',
        'cognome',
        'codice_fiscale',
        'data_nascita',
        'sesso',
        'indirizzo',
        'citta',
        'provincia',
        'cap',
        'telefono',
        'email',
        'note',
    ];

    protected $casts = [
        'data_nascita' => 'date',
    ];
}
```

#### Filament Resource
```php
// laravel/Modules/Patient/Filament/Resources/PatientResource.php
namespace Modules\Patient\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Patient\Models\Patient;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestione Pazienti';
    protected static ?string $navigationLabel = 'Pazienti';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('nome')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('cognome')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('codice_fiscale')
                ->required()
                ->unique(Patient::class)
                ->rules(['regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/']),
            Forms\Components\DatePicker::make('data_nascita')
                ->required(),
            Forms\Components\Select::make('sesso')
                ->options([
                    'M' => 'Maschio',
                    'F' => 'Femmina',
                ])
                ->required(),
            // ... altri campi
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('cognome')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('codice_fiscale')
                ->searchable(),
            Tables\Columns\TextColumn::make('data_nascita')
                ->date('d/m/Y')
                ->sortable(),
        ];
    }
}
```

### 2. Modulo Dental

```bash

# Creazione struttura base
mkdir -p laravel/Modules/Dental/{Config,Console,Database/{Factories,Migrations,Seeders},Filament/{Resources,Pages,Widgets},Http/{Controllers,Middleware,Requests},Models,Providers,Resources/{js,lang,views},Routes,Services,Tests}
```

#### Models
```php
// laravel/Modules/Dental/Models/Visit.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Dental\Traits\HasVisit;

class Visit extends Model
{
    use HasVisit;

    protected $fillable = [
        'patient_id',
        'data_visita',
        'tipo_visita',
        'note',
        'stato',
        'costo',
        'pagato',
    ];

    protected $casts = [
        'data_visita' => 'datetime',
        'costo' => 'decimal:2',
        'pagato' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
```

#### Filament Resource
```php
// laravel/Modules/Dental/Filament/Resources/VisitResource.php
namespace Modules\Dental\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Dental\Models\Visit;
use Modules\Xot\Filament\Resources\XotBaseResource;

class VisitResource extends XotBaseResource
{
    protected static ?string $model = Visit::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Gestione Visite';
    protected static ?string $navigationLabel = 'Visite';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'nome')
                ->required(),
            Forms\Components\DateTimePicker::make('data_visita')
                ->required(),
            Forms\Components\Select::make('tipo_visita')
                ->options([
                    'prima_visita' => 'Prima Visita',
                    'controllo' => 'Controllo',
                    'trattamento' => 'Trattamento',
                ])
                ->required(),
            Forms\Components\Textarea::make('note'),
            Forms\Components\Select::make('stato')
                ->options([
                    'programmata' => 'Programmata',
                    'completata' => 'Completata',
                    'cancellata' => 'Cancellata',
                ])
                ->required(),
            Forms\Components\TextInput::make('costo')
                ->numeric()
                ->required(),
            Forms\Components\Toggle::make('pagato'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('patient.nome')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('data_visita')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
            Tables\Columns\TextColumn::make('tipo_visita')
                ->badge(),
            Tables\Columns\TextColumn::make('stato')
                ->badge(),
            Tables\Columns\TextColumn::make('costo')
                ->money('EUR'),
        ];
    }
}
```

### 3. Modulo ISEE

```bash

# Creazione struttura base
mkdir -p laravel/Modules/ISEE/{Config,Console,Database/{Factories,Migrations,Seeders},Filament/{Resources,Pages,Widgets},Http/{Controllers,Middleware,Requests},Models,Providers,Resources/{js,lang,views},Routes,Services,Tests}
```

#### Models
```php
// laravel/Modules/ISEE/Models/ISEE.php
namespace Modules\ISEE\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\ISEE\Traits\HasISEE;

class ISEE extends Model
{
    use HasISEE;

    protected $fillable = [
        'patient_id',
        'data_scadenza',
        'valore_isee',
        'valore_isr',
        'valore_patrimonio',
        'valore_reddito',
        'note',
    ];

    protected $casts = [
        'data_scadenza' => 'date',
        'valore_isee' => 'decimal:2',
        'valore_isr' => 'decimal:2',
        'valore_patrimonio' => 'decimal:2',
        'valore_reddito' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
```

#### Filament Resource
```php
// laravel/Modules/ISEE/Filament/Resources/ISEEResource.php
namespace Modules\ISEE\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\ISEE\Models\ISEE;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ISEEResource extends XotBaseResource
{
    protected static ?string $model = ISEE::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Gestione ISEE';
    protected static ?string $navigationLabel = 'ISEE';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'nome')
                ->required(),
            Forms\Components\DatePicker::make('data_scadenza')
                ->required(),
            Forms\Components\TextInput::make('valore_isee')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('valore_isr')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('valore_patrimonio')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('valore_reddito')
                ->numeric()
                ->required(),
            Forms\Components\Textarea::make('note'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('patient.nome')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('data_scadenza')
                ->date('d/m/Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('valore_isee')
                ->money('EUR')
                ->sortable(),
            Tables\Columns\TextColumn::make('valore_isr')
                ->money('EUR')
                ->sortable(),
        ];
    }
}
```

## Configurazione dei Moduli

Per ogni modulo, creare il file `module.json`:

```json
// laravel/Modules/Patient/module.json
{
    "name": "Patient",
    "providers": [
        "Modules\\Patient\\Providers\\PatientServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": []
}
```

## Service Provider

Per ogni modulo, creare il Service Provider:

```php
// laravel/Modules/Patient/Providers/PatientServiceProvider.php
namespace Modules\Patient\Providers;

use Illuminate\Support\ServiceProvider;

class PatientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(module_path('Patient', 'Database/Migrations'));
        $this->loadRoutesFrom(module_path('Patient', 'Routes/web.php'));
        $this->loadViewsFrom(module_path('Patient', 'Resources/views'), 'patient');
        $this->loadTranslationsFrom(module_path('Patient', 'Resources/lang'), 'patient');
    }
}
```

## Note di Implementazione

1. **Dipendenze tra Moduli**:
   - Patient è il modulo base
   - Dental e ISEE dipendono da Patient
   - Aggiornare i `module.json` con le dipendenze

2. **Testing**:
   - Creare test per ogni modello
   - Testare le relazioni tra moduli
   - Verificare le validazioni

3. **Traduzioni**:
   - Aggiungere file di traduzione in IT/EN
   - Utilizzare le chiavi di traduzione nelle viste

4. **Validazione**:
   - Implementare regole di validazione
   - Gestire gli errori
   - Aggiungere messaggi personalizzati

5. **Sicurezza**:
   - Implementare le policies
   - Verificare i permessi
