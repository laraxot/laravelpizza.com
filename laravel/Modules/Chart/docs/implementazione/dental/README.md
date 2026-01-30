# Modulo Dental il progetto

## Panoramica
Il modulo Dental gestisce le visite odontoiatriche, i trattamenti e il piano terapeutico per i pazienti.

## Configurazione

### Installazione
```bash

# Creazione del modulo
php artisan module:make Dental

# Pubblicazione configurazione
php artisan vendor:publish --tag=dental-config
```

### Dipendenze
- module_xot_fila3
- module_tenant_fila3
- module_user_fila3
- module_patient_fila3
- module_media_fila3

## Modello Dati

### Tabelle
- `appointments` - Appuntamenti visite
- `treatments` - Catalogo trattamenti
- `patient_treatments` - Trattamenti eseguiti/pianificati
- `treatment_plans` - Piani terapeutici
- `treatment_notes` - Note cliniche

### Modelli Principali

#### Appointment
```php
namespace Modules\Dental\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class Appointment extends BaseModel
{
    use BelongsToTenant;
    
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'notes',
        'location',
    ];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => AppointmentStatus::class,
    ];
    
    // Relazioni
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    
    public function treatmentPlan()
    {
        return $this->belongsTo(TreatmentPlan::class);
    }
    
    public function patientTreatments()
    {
        return $this->hasMany(PatientTreatment::class);
    }
    
    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>=', now())
                     ->orderBy('start_time');
    }
    
    public function scopePast($query)
    {
        return $query->where('start_time', '<', now())
                     ->orderByDesc('start_time');
    }
    
    public function scopeForDoctor($query, User $doctor)
    {
        return $query->where('doctor_id', $doctor->id);
    }
    
    // Attributes
    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
    
    public function getIsCompleteAttribute()
    {
        return $this->status === AppointmentStatus::COMPLETED;
    }
}
```

#### Treatment
```php
namespace Modules\Dental\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;

class Treatment extends BaseModel
{
    use BelongsToTenant;
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'duration',
        'category',
        'is_active',
        'requires_approval',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
        'category' => TreatmentCategory::class,
    ];
    
    // Relazioni
    public function patientTreatments()
    {
        return $this->hasMany(PatientTreatment::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByCategory($query, TreatmentCategory $category)
    {
        return $query->where('category', $category);
    }
}
```

#### TreatmentPlan
```php
namespace Modules\Dental\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;

class TreatmentPlan extends BaseModel
{
    use BelongsToTenant;
    
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'notes',
        'total_cost',
        'discount_percentage',
        'discount_amount',
        'final_cost',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_cost' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'status' => TreatmentPlanStatus::class,
    ];
    
    // Relazioni
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    
    public function treatments()
    {
        return $this->hasMany(PatientTreatment::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    // Calcoli
    public function calculateTotalCost()
    {
        $this->total_cost = $this->treatments()->sum('price');
        
        if ($this->discount_percentage > 0) {
            $this->discount_amount = $this->total_cost * ($this->discount_percentage / 100);
        }
        
        $this->final_cost = $this->total_cost - $this->discount_amount;
        
        return $this;
    }
    
    // Attributes
    public function getProgressPercentageAttribute()
    {
        $total = $this->treatments()->count();
        
        if ($total === 0) {
            return 0;
        }
        
        $completed = $this->treatments()
            ->where('status', PatientTreatmentStatus::COMPLETED)
            ->count();
            
        return round(($completed / $total) * 100);
    }
    
    public function getIsCompleteAttribute()
    {
        return $this->status === TreatmentPlanStatus::COMPLETED;
    }
}
```

## Enums

### AppointmentStatus
```php
namespace Modules\Dental\Enums;

enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';
    
    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Programmato',
            self::CONFIRMED => 'Confermato',
            self::IN_PROGRESS => 'In corso',
            self::COMPLETED => 'Completato',
            self::CANCELLED => 'Cancellato',
            self::NO_SHOW => 'Non presentato',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'gray',
            self::CONFIRMED => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
            self::NO_SHOW => 'danger',
        };
    }
}
```

### TreatmentCategory
```php
namespace Modules\Dental\Enums;

enum TreatmentCategory: string
{
    case DIAGNOSTIC = 'diagnostic';
    case PREVENTION = 'prevention';
    case RESTORATION = 'restoration';
    case ENDODONTICS = 'endodontics';
    case PERIODONTICS = 'periodontics';
    case PROSTHODONTICS = 'prosthodontics';
    case ORAL_SURGERY = 'oral_surgery';
    case ORTHODONTICS = 'orthodontics';
    case IMPLANTOLOGY = 'implantology';
    
    public function label(): string
    {
        return match($this) {
            self::DIAGNOSTIC => 'Diagnostica',
            self::PREVENTION => 'Prevenzione',
            self::RESTORATION => 'Conservativa',
            self::ENDODONTICS => 'Endodonzia',
            self::PERIODONTICS => 'Parodontologia',
            self::PROSTHODONTICS => 'Protesi',
            self::ORAL_SURGERY => 'Chirurgia orale',
            self::ORTHODONTICS => 'Ortodonzia',
            self::IMPLANTOLOGY => 'Implantologia',
        };
    }
}
```

## Filament Resources

### Calendario Appuntamenti
```php
namespace Modules\Dental\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Filament\Resources\AppointmentResource\Pages;
use Modules\Dental\Enums\AppointmentStatus;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $recordTitleAttribute = 'title';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Appuntamento')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'full_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Paziente'),
                            
                        Forms\Components\Select::make('doctor_id')
                            ->relationship('doctor', 'name')
                            ->label('Medico')
                            ->required(),
                            
                        Forms\Components\TextInput::make('title')
                            ->label('Titolo')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Descrizione')
                            ->rows(3),
                    ]),
                    
                Forms\Components\Section::make('Pianificazione')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_time')
                            ->label('Data e ora inizio')
                            ->required()
                            ->timezone('Europe/Rome'),
                            
                        Forms\Components\DateTimePicker::make('end_time')
                            ->label('Data e ora fine')
                            ->required()
                            ->timezone('Europe/Rome')
                            ->after('start_time'),
                            
                        Forms\Components\Select::make('status')
                            ->options(AppointmentStatus::class)
                            ->enum(AppointmentStatus::class)
                            ->required()
                            ->label('Stato'),
                            
                        Forms\Components\TextInput::make('location')
                            ->label('Luogo')
                            ->maxLength(255),
                    ]),
                    
                Forms\Components\Section::make('Note')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Note')
                            ->rows(3),
                    ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            AppointmentResource\RelationManagers\PatientTreatmentsRelationManager::make(),
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'calendar' => Pages\CalendarView::route('/calendar'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
```

### Calendario (Vista)
```php
namespace Modules\Dental\Filament\Resources\AppointmentResource\Pages;

use Filament\Resources\Pages\Page;
use Modules\Dental\Filament\Resources\AppointmentResource;
use Filament\Forms\Components\DatePicker;
use Modules\Dental\Models\Appointment;
use Modules\User\Models\User;

class CalendarView extends Page
{
    protected static string $resource = AppointmentResource::class;
    
    protected static string $view = 'dental::filament.resources.appointments.calendar';
    
    public $date;
    public $view = 'week';
    public $doctorId = null;
    
    public function mount()
    {
        $this->date = today();
    }
    
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('create')
                ->url(AppointmentResource::getUrl('create'))
                ->icon('heroicon-o-plus'),
                
            \Filament\Actions\Action::make('view')
                ->label('Cambia vista')
                ->icon('heroicon-o-view-columns')
                ->action(function (array $data): void {
                    $this->view = $data['view'];
                })
                ->form([
                    \Filament\Forms\Components\Select::make('view')
                        ->options([
                            'day' => 'Giorno',
                            'week' => 'Settimana',
                            'month' => 'Mese',
                        ])
                        ->default($this->view)
                        ->required(),
                ]),
                
            \Filament\Actions\Action::make('date')
                ->label('Cambia data')
                ->icon('heroicon-o-calendar')
                ->action(function (array $data): void {
                    $this->date = $data['date'];
                })
                ->form([
                    DatePicker::make('date')
                        ->default($this->date)
                        ->required(),
                ]),
                
            \Filament\Actions\Action::make('doctor')
                ->label('Filtra medico')
                ->icon('heroicon-o-user')
                ->action(function (array $data): void {
                    $this->doctorId = $data['doctor_id'];
                })
                ->form([
                    \Filament\Forms\Components\Select::make('doctor_id')
                        ->label('Medico')
                        ->options(User::role('doctor')->pluck('name', 'id'))
                        ->placeholder('Tutti i medici')
                        ->allowDeselection(),
                ]),
        ];
    }
    
    public function getViewData(): array
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->when($this->doctorId, function ($query) {
                return $query->where('doctor_id', $this->doctorId);
            });
            
        switch ($this->view) {
            case 'day':
                $startDate = $this->date->startOfDay();
                $endDate = $this->date->copy()->endOfDay();
                break;
                
            case 'week':
                $startDate = $this->date->copy()->startOfWeek();
                $endDate = $this->date->copy()->endOfWeek();
                break;
                
            case 'month':
                $startDate = $this->date->copy()->startOfMonth();
                $endDate = $this->date->copy()->endOfMonth();
                break;
                
            default:
                $startDate = $this->date->copy()->startOfWeek();
                $endDate = $this->date->copy()->endOfWeek();
        }
        
        $appointments = $appointments->whereBetween('start_time', [$startDate, $endDate])->get();
        
        return [
            'view' => $this->view,
            'date' => $this->date,
            'appointments' => $appointments,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }
}
```

## Piano Terapeutico

### Service di Creazione
```php
namespace Modules\Dental\Services;

use Modules\Dental\Models\TreatmentPlan;
use Modules\Dental\Models\PatientTreatment;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;
use Illuminate\Support\Collection;
use Modules\Dental\Enums\TreatmentPlanStatus;
use Modules\Dental\Enums\PatientTreatmentStatus;

class TreatmentPlanService
{
    public function createPlan(
        Patient $patient,
        User $doctor,
        string $title,
        ?string $description,
        Collection $treatments,
        ?float $discountPercentage = 0
    ): TreatmentPlan {
        // Crea piano terapeutico
        $plan = new TreatmentPlan([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'title' => $title,
            'description' => $description,
            'status' => TreatmentPlanStatus::DRAFT,
            'start_date' => now(),
            'discount_percentage' => $discountPercentage,
        ]);
        
        $plan->save();
        
        // Crea trattamenti nel piano
        foreach ($treatments as $treatment) {
            $patientTreatment = new PatientTreatment([
                'treatment_id' => $treatment['id'],
                'price' => $treatment['price'],
                'status' => PatientTreatmentStatus::PLANNED,
                'planned_date' => $treatment['planned_date'] ?? null,
                'notes' => $treatment['notes'] ?? null,
            ]);
            
            $plan->treatments()->save($patientTreatment);
        }
        
        // Calcola costi
        $plan->calculateTotalCost()->save();
        
        return $plan;
    }
    
    public function approvePlan(TreatmentPlan $plan): TreatmentPlan
    {
        $plan->status = TreatmentPlanStatus::APPROVED;
        $plan->save();
        
        // Evento approvazione piano
        // event(new TreatmentPlanApproved($plan));
        
        return $plan;
    }
    
    public function completeTreatment(
        PatientTreatment $treatment,
        User $doctor,
        ?string $notes = null
    ): PatientTreatment {
        $treatment->status = PatientTreatmentStatus::COMPLETED;
        $treatment->completed_date = now();
        $treatment->doctor_id = $doctor->id;
        
        if ($notes) {
            $treatment->notes = $notes;
        }
        
        $treatment->save();
        
        // Controllo se il piano è completato
        $plan = $treatment->treatmentPlan;
        $allCompleted = $plan->treatments()
            ->where('status', '!=', PatientTreatmentStatus::COMPLETED)
            ->count() === 0;
            
        if ($allCompleted) {
            $plan->status = TreatmentPlanStatus::COMPLETED;
            $plan->end_date = now();
            $plan->save();
            
            // Evento completamento piano
            // event(new TreatmentPlanCompleted($plan));
        }
        
        return $treatment;
    }
}
```

## Notifiche

### Promemoria Appuntamento
```php
namespace Modules\Dental\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Dental\Models\Appointment;

class AppointmentReminderNotification extends Notification
{
    protected Appointment $appointment;
    
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Promemoria Appuntamento')
            ->greeting("Gentile {$notifiable->full_name},")
            ->line("Le ricordiamo che ha un appuntamento il {$this->appointment->start_time->format('d/m/Y')} alle ore {$this->appointment->start_time->format('H:i')}.")
            ->line("Motivo: {$this->appointment->title}")
            ->line("Medico: {$this->appointment->doctor->name}")
            ->line("Luogo: {$this->appointment->location}")
            ->action('Vedi Dettaglio', route('filament.tenant.resources.appointments.view', $this->appointment))
            ->line('In caso di impedimento, la preghiamo di contattarci per riprogrammare l\'appuntamento.')
            ->line('Grazie per aver scelto il progetto.');
    }
    
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Promemoria Appuntamento',
            'body' => "Appuntamento {$this->appointment->start_time->format('d/m/Y H:i')} - {$this->appointment->title}",
            'action_url' => route('filament.tenant.resources.appointments.view', $this->appointment),
            'icon' => 'heroicon-o-calendar',
            'color' => 'primary',
        ];
    }
}
```

## Commands

### Promemoria Appuntamenti
```php
namespace Modules\Dental\Console\Commands;

use Illuminate\Console\Command;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;
use Modules\Dental\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'dental:appointment-reminders';
    protected $description = 'Send reminders for upcoming appointments';
    
    public function handle()
    {
        // Appuntamenti di domani
        $tomorrowStart = Carbon::tomorrow()->startOfDay();
        $tomorrowEnd = Carbon::tomorrow()->endOfDay();
        
        $appointments = Appointment::query()
            ->with('patient')
            ->whereBetween('start_time', [$tomorrowStart, $tomorrowEnd])
            ->whereIn('status', [AppointmentStatus::SCHEDULED, AppointmentStatus::CONFIRMED])
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'appointment_reminder')
                    ->where('created_at', '>', Carbon::now()->subHours(24));
            })
            ->get();
            
        foreach ($appointments as $appointment) {
            $appointment->patient->notify(new AppointmentReminderNotification($appointment));
            
            $this->info("Promemoria inviato per appuntamento {$appointment->id} del paziente {$appointment->patient->full_name}");
        }
        
        $this->info("Invio completato. {$appointments->count()} notifiche inviate.");
        
        return Command::SUCCESS;
    }
}
```

## API

### Endpoints
| Metodo | URI                                 | Azione                              |
|--------|------------------------------------|-------------------------------------|
| GET    | `/api/appointments`                | Lista appuntamenti                  |
| POST   | `/api/appointments`                | Crea appuntamento                   |
| GET    | `/api/appointments/{appointment}`  | Dettaglio appuntamento              |
| PUT    | `/api/appointments/{appointment}`  | Aggiorna appuntamento               |
| DELETE | `/api/appointments/{appointment}`  | Cancella appuntamento               |
| GET    | `/api/treatments`                  | Lista trattamenti disponibili       |
| GET    | `/api/patients/{patient}/treatment-plans` | Piani terapeutici paziente   |
| POST   | `/api/treatment-plans`             | Crea piano terapeutico              |
| PUT    | `/api/treatment-plans/{plan}/approve` | Approva piano terapeutico        |

## Report

### Trattamenti Principali
```php
namespace Modules\Dental\Reports;

use Modules\Dental\Models\PatientTreatment;
use Modules\Dental\Enums\PatientTreatmentStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TopTreatmentsReport
{
    public function generate(
        Carbon $startDate, 
        Carbon $endDate, 
        int $limit = 10
    ): array {
        $data = PatientTreatment::query()
            ->join('treatments', 'patient_treatments.treatment_id', '=', 'treatments.id')
            ->where('patient_treatments.status', PatientTreatmentStatus::COMPLETED)
            ->whereBetween('patient_treatments.completed_date', [$startDate, $endDate])
            ->select([
                'treatments.name',
                'treatments.category',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(patient_treatments.price) as total_revenue')
            ])
            ->groupBy('treatments.id', 'treatments.name', 'treatments.category')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
            
        return [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'treatments' => $data,
            'total_count' => $data->sum('count'),
            'total_revenue' => $data->sum('total_revenue'),
        ];
    }
}
```

## Feature Tests

```php
namespace Modules\Dental\Tests\Feature;

use Tests\TestCase;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;
use Modules\Patient\Models\Patient;
use Modules\User\Models\User;
use Modules\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_create_appointment()
    {
        // Setup
        $tenant = Tenant::factory()->create();
        $doctor = User::factory()->create(['tenant_id' => $tenant->id]);
        $doctor->assignRole('doctor');
        
        $patient = Patient::factory()->create(['tenant_id' => $tenant->id]);
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $user->assignRole('receptionist');
        
        $startTime = Carbon::tomorrow()->setHour(10)->setMinute(0);
        $endTime = $startTime->copy()->addMinutes(30);
        
        $appointmentData = [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'title' => 'Visita di controllo',
            'description' => 'Controllo periodico',
            'start_time' => $startTime->toDateTimeString(),
            'end_time' => $endTime->toDateTimeString(),
            'status' => AppointmentStatus::SCHEDULED->value,
        ];
        
        // Azione
        $response = $this->actingAs($user)
            ->postJson('/api/appointments', $appointmentData);
            
        // Verifica
        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Visita di controllo')
            ->assertJsonPath('data.status', AppointmentStatus::SCHEDULED->value);
            
        $this->assertDatabaseHas('appointments', [
            'title' => 'Visita di controllo',
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
        ]);
    }
    
    public function test_can_update_appointment_status()
    {
        // Setup
        $tenant = Tenant::factory()->create();
        $doctor = User::factory()->create(['tenant_id' => $tenant->id]);
        $doctor->assignRole('doctor');
        
        $patient = Patient::factory()->create(['tenant_id' => $tenant->id]);
        $appointment = Appointment::factory()->create([
            'tenant_id' => $tenant->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'status' => AppointmentStatus::SCHEDULED,
        ]);
        
        // Azione
        $response = $this->actingAs($doctor)
            ->putJson("/api/appointments/{$appointment->id}", [
                'status' => AppointmentStatus::COMPLETED->value,
            ]);
            
        // Verifica
        $response->assertStatus(200)
            ->assertJsonPath('data.status', AppointmentStatus::COMPLETED->value);
            
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => AppointmentStatus::COMPLETED->value,
        ]);
    }
}
``` 

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

