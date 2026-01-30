# Implementazione Dashboard Odontoiatra

## Descrizione del Task
Questo documento descrive l'implementazione della dashboard per gli odontoiatri che partecipano al progetto il progetto, focalizzandosi sulla gestione delle gestanti assegnate, appuntamenti e documentazione clinica.

## Stato Attuale
- **Completamento**: 65%
- **Responsabile**: Team Frontoffice
- **Ultimo aggiornamento**: Aprile 2025

## Implementazione

### 1. Struttura del Modulo Dental (Completato)
Il modulo Dental è stato creato tramite il pacchetto nwidart/laravel-modules e integra le funzionalità Laraxot. La struttura attuale include:

```
laravel/Modules/Dental/
├── Config/
├── Database/
│   ├── Migrations/
│   ├── Seeders/
│   └── Factories/
├── Http/
│   ├── Controllers/
│   ├── Livewire/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Providers/
├── Resources/
│   ├── lang/
│   └── views/
└── Routes/
```

### 2. Modelli Dati (Completato)
Sono stati implementati i seguenti modelli con relazioni e trait necessari:

```php
// laravel/Modules/Dental/Models/Appointment.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;
use Modules\Patient\Models\Patient;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Appointment extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'dentist_id',
        'patient_id',
        'appointment_date',
        'status',
        'notes',
        'treatment_type',
        'treatment_description',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'status' => AppointmentStatus::class, // Utilizzo di PHP 8.2+ enum
    ];

    public function dentist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
```

Con l'enum AppointmentStatus:

```php
// laravel/Modules/Dental/Enums/AppointmentStatus.php
namespace Modules\Dental\Enums;

enum AppointmentStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public function label(): string
    {
        return match($this) {
            self::PENDING => __('dental::appointments.status.pending'),
            self::CONFIRMED => __('dental::appointments.status.confirmed'),
            self::COMPLETED => __('dental::appointments.status.completed'),
            self::CANCELLED => __('dental::appointments.status.cancelled'),
            self::NO_SHOW => __('dental::appointments.status.no_show'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'gray',
            self::CONFIRMED => 'blue',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
            self::NO_SHOW => 'yellow',
        };
    }
}
```

### 3. Dashboard Principale (Completato 80%)
La dashboard principale è implementata come Livewire component, utilizzando Volt per una sintassi più concisa:

```php
// laravel/Modules/Dental/Http/Livewire/DentistDashboard.php
<?php

namespace Modules\Dental\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DentistDashboard extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $appointmentStatus = '';
    public string $dateRange = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'appointmentStatus' => ['except' => ''],
        'dateRange' => ['except' => ''],
    ];
    
    public function render()
    {
        $dentistId = Auth::id();
        $locale = app()->getLocale();
        
        $appointments = Appointment::query()
            ->where('dentist_id', $dentistId)
            ->when($this->search, function (Builder $query) {
                $query->whereHas('patient', function (Builder $query) {
                    $query->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->appointmentStatus, function (Builder $query) {
                $query->where('status', $this->appointmentStatus);
            })
            ->when($this->dateRange, function (Builder $query) {
                // Logica filtro date
            })
            ->with('patient')
            ->latest('appointment_date')
            ->paginate(10);
            
        $patients = Patient::where('dentist_id', $dentistId)->count();
        
        // Statistiche per widget dashboard
        $stats = [
            'total_patients' => $patients,
            'upcoming_appointments' => Appointment::where('dentist_id', $dentistId)
                ->where('appointment_date', '>', now())
                ->count(),
            'completed_appointments' => Appointment::where('dentist_id', $dentistId)
                ->where('status', 'completed')
                ->count(),
        ];
        
        return view('dental::livewire.dentist-dashboard', [
            'appointments' => $appointments,
            'stats' => $stats,
            'locale' => $locale,
        ]);
    }
    
    // Altri metodi...
}
```

### 4. Localizzazione URL (Completato)
Tutte le rotte seguono la convenzione di localizzazione URL richiesta:

```php
// laravel/Modules/Dental/Routes/web.php
Route::prefix('{locale}')->middleware(['web', 'auth', 'locale', 'role:odontoiatra'])->group(function () {
    Route::prefix('dental')->group(function () {
        Route::get('/dashboard', DentistDashboardController::class)->name('dental.dashboard');
        Route::get('/patients', [PatientController::class, 'index'])->name('dental.patients.index');
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('dental.patients.show');
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('dental.appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('dental.appointments.show');
        // Altre rotte...
    });
});
```

### 5. Scheda Paziente (In corso - 70%)
La scheda del paziente include storia clinica, visite passate e documenti:

```php
// laravel/Modules/Dental/Http/Controllers/PatientController.php
namespace Modules\Dental\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Appointment;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    public function show(Request $request, string $locale, Patient $patient)
    {
        // Verifica che l'odontoiatra possa vedere questo paziente
        Gate::authorize('view', $patient);
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->where('dentist_id', auth()->id())
            ->with('medias')
            ->latest('appointment_date')
            ->get();
            
        $medicalHistory = $patient->medicalHistory()->latest()->first();
        
        return view('dental::patients.show', [
            'patient' => $patient,
            'appointments' => $appointments,
            'medicalHistory' => $medicalHistory,
            'locale' => $locale,
        ]);
    }
}
```

### 6. Gestione Note Cliniche (Da completare - 40%)
Sistema in sviluppo per creare e gestire note cliniche private e pubbliche:

```php
// laravel/Modules/Dental/Models/ClinicalNote.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class ClinicalNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'appointment_id',
        'content',
        'is_private',
        'category',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
```

### 7. Gestione Disponibilità (Da completare - 30%)
Sistema per configurare la disponibilità dell'odontoiatra per le prenotazioni:

```php
// laravel/Modules/Dental/Http/Livewire/AvailabilityManager.php
namespace Modules\Dental\Http\Livewire;

use Livewire\Component;
use Modules\Dental\Models\Availability;
use Carbon\Carbon;

class AvailabilityManager extends Component
{
    public array $availabilities = [];
    public array $weekDays = [];
    
    public function mount()
    {
        $this->initWeekDays();
        $this->loadAvailabilities();
    }
    
    public function render()
    {
        return view('dental::livewire.availability-manager', [
            'locale' => app()->getLocale(),
        ]);
    }
    
    // Altri metodi...
}
```

## Traduzione e Localizzazione

Tutte le traduzioni sono gestite tramite il modulo Lang e rispettano la convenzione richiesta. Esempio di file di traduzione:

```php
// laravel/Modules/Dental/Resources/lang/it/appointments.php
return [
    'title' => 'Gestione appuntamenti',
    'list' => 'Lista appuntamenti',
    'create' => 'Nuovo appuntamento',
    'status' => [
        'pending' => 'In attesa',
        'confirmed' => 'Confermato',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Non presentato',
    ],
    'fields' => [
        'patient' => [
            'label' => 'Paziente',
        ],
        'date' => [
            'label' => 'Data appuntamento',
        ],
        'time' => [
            'label' => 'Orario',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'notes' => [
            'label' => 'Note',
        ],
    ],
];
```

## Componenti UI

I componenti utilizzano il modulo UI e rispettano i requisiti per i componenti Filament se applicabili. Esempio:

```php
// laravel/Modules/Dental/Filament/Resources/AppointmentResource.php
namespace Modules\Dental\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Dental\Models\Appointment;
use Filament\Forms;
use Filament\Tables;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
    
    public static function getFormSchema(): array
    {
        return [
            'patient_id' => Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'full_name'),
            'appointment_date' => Forms\Components\DateTimePicker::make('appointment_date'),
            'status' => Forms\Components\Select::make('status')
                ->options(AppointmentStatus::class),
            'notes' => Forms\Components\Textarea::make('notes'),
        ];
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'patient.full_name' => Tables\Columns\TextColumn::make('patient.full_name'),
            'appointment_date' => Tables\Columns\TextColumn::make('appointment_date')
                ->dateTime(),
            'status' => Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'pending',
                    'blue' => 'confirmed',
                    'green' => 'completed',
                    'red' => 'cancelled',
                    'yellow' => 'no_show',
                ]),
        ];
    }
}
```

## Test

I test sono implementati utilizzando Pest (non PHPUnit) per garantire la corretta funzionalità:

```php
// laravel/Modules/Dental/Tests/Feature/DentistDashboardTest.php
use Modules\User\Models\User;
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Appointment;

test('dentist can see only their patients', function () {
    // Arrange
    $dentist = User::factory()->create();
    $dentist->assignRole('odontoiatra');
    
    $otherDentist = User::factory()->create();
    $otherDentist->assignRole('odontoiatra');
    
    $patient1 = Patient::factory()->create(['dentist_id' => $dentist->id]);
    $patient2 = Patient::factory()->create(['dentist_id' => $otherDentist->id]);
    
    // Act
    $response = $this->actingAs($dentist)
                     ->get(route('dental.dashboard', ['locale' => 'it']));
    
    // Assert
    $response->assertSuccessful();
    $response->assertSee($patient1->full_name);
    $response->assertDontSee($patient2->full_name);
});

test('dentist can view appointment details', function () {
    // Arrange
    $dentist = User::factory()->create();
    $dentist->assignRole('odontoiatra');
    
    $patient = Patient::factory()->create(['dentist_id' => $dentist->id]);
    $appointment = Appointment::factory()->create([
        'dentist_id' => $dentist->id,
        'patient_id' => $patient->id
    ]);
    
    // Act
    $response = $this->actingAs($dentist)
                     ->get(route('dental.appointments.show', [
                         'locale' => 'it',
                         'appointment' => $appointment->id
                     ]));
    
    // Assert
    $response->assertSuccessful();
    $response->assertSee($patient->full_name);
    $response->assertSee($appointment->appointment_date->format('d/m/Y'));
});
```

## Prossimi Passi

1. Completare il sistema di gestione note cliniche
2. Implementare il modulo di gestione disponibilità
3. Sviluppare la funzionalità di export documentazione per pazienti
4. Integrare il sistema di notifiche per promemoria appuntamenti
5. Completare i test e ottimizzare le performance delle query

## Links ai File Principali

- [Modulo Dental](/var/www/html/base_<nome progetto>/laravel/Modules/Dental/)
- [Modulo Patient](/var/www/html/base_<nome progetto>/laravel/Modules/Patient/)
- [Roadmap Frontoffice](/var/www/html/base_<nome progetto>/docs/roadmap_frontoffice.md)
