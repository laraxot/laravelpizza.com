# Implementazione Prenotazione Visite

## Descrizione del Task
Questo documento descrive l'implementazione del sistema di prenotazione visite per le gestanti all'interno del frontoffice di il progetto, includendo la ricerca di odontoiatri disponibili, gestione del calendario e notifiche.

## Stato Attuale
- **Completamento**: 55%
- **Responsabile**: Team Frontoffice
- **Ultimo aggiornamento**: Aprile 2025

## Implementazione

### 1. Struttura del Modulo (Completato)
Il sistema di prenotazione visite sfrutta due moduli principali, implementati tramite nwidart/laravel-modules:

- `Patient`: gestione profili pazienti e storico visite
- `Dental`: gestione appuntamenti, calendario e odontoiatri

```
laravel/Modules/Patient/
└── Models/
    └── Patient.php
    └── MedicalHistory.php
    └── Pregnancy.php

laravel/Modules/Dental/
└── Models/
    └── Appointment.php
    └── Availability.php
    └── DentalProcedure.php
```

### 2. Modelli Dati (Completato)
I modelli principali sono implementati utilizzando le best practice Laravel con Spatie/laravel-data per la gestione DTOs:

```php
// laravel/Modules/Patient/Models/Patient.php
namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;
use Modules\Dental\Models\Appointment;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Patient extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'dentist_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'fiscal_code',
        'address',
        'city',
        'postal_code',
        'phone',
        'emergency_contact',
        'emergency_phone',
        'isee_validated',
        'pregnancy_validated',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'isee_validated' => 'boolean',
        'pregnancy_validated' => 'boolean',
    ];
    
    // Accessor per nome completo
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function dentist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function pregnancy(): HasOne
    {
        return $this->hasOne(Pregnancy::class);
    }
    
    public function medicalHistory(): HasOne
    {
        return $this->hasOne(MedicalHistory::class);
    }
}
```

```php
// laravel/Modules/Dental/Models/Availability.php
namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'dentist_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
        'max_appointments',
        'appointment_duration',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_available' => 'boolean',
        'day_of_week' => 'integer',
    ];

    public function dentist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }
}
```

### 3. Ricerca Odontoiatri (Completato - 90%)
Il sistema di ricerca odontoiatri è implementato tramite un componente Livewire:

```php
// laravel/Modules/Patient/Http/Livewire/DentistSearch.php
namespace Modules\Patient\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\User\Models\User;
use Modules\Dental\Models\Availability;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class DentistSearch extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $city = '';
    public ?string $date = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'date' => ['except' => ''],
    ];
    
    public function render()
    {
        $locale = app()->getLocale();
        
        $dentists = User::role('odontoiatra')
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhereHas('profile', function (Builder $query) {
                            $query->where('specialization', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->city, function (Builder $query) {
                $query->whereHas('profile', function (Builder $query) {
                    $query->where('city', 'like', "%{$this->city}%");
                });
            })
            ->when($this->date, function (Builder $query) {
                $date = Carbon::parse($this->date);
                $dayOfWeek = $date->dayOfWeek;
                
                $query->whereHas('availabilities', function (Builder $query) use ($dayOfWeek) {
                    $query->where('day_of_week', $dayOfWeek)
                        ->where('is_available', true);
                });
            })
            ->with(['profile', 'availabilities'])
            ->paginate(8);
            
        $cities = User::role('odontoiatra')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('profiles.city')
            ->distinct()
            ->pluck('profiles.city')
            ->toArray();
            
        return view('patient::livewire.dentist-search', [
            'dentists' => $dentists,
            'cities' => $cities,
            'locale' => $locale,
        ]);
    }
}
```

### 4. Calendario Disponibilità (In corso - 60%)
La visualizzazione delle disponibilità dell'odontoiatra è implementata con un componente Livewire:

```php
// laravel/Modules/Patient/Http/Livewire/AppointmentCalendar.php
namespace Modules\Patient\Http\Livewire;

use Livewire\Component;
use Modules\Dental\Models\Availability;
use Modules\Dental\Models\Appointment;
use Modules\User\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppointmentCalendar extends Component
{
    public User $dentist;
    public string $selectedDate = '';
    public array $availableSlots = [];
    public ?string $selectedSlot = null;
    
    public function mount(User $dentist)
    {
        $this->dentist = $dentist;
        $this->selectedDate = Carbon::now()->addDay()->format('Y-m-d');
        $this->calculateAvailableSlots();
    }
    
    public function updatedSelectedDate()
    {
        $this->calculateAvailableSlots();
        $this->selectedSlot = null;
    }
    
    public function calculateAvailableSlots()
    {
        $date = Carbon::parse($this->selectedDate);
        $dayOfWeek = $date->dayOfWeek;
        
        // Recupera disponibilità per il giorno della settimana
        $availability = Availability::where('dentist_id', $this->dentist->id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();
            
        if (!$availability) {
            $this->availableSlots = [];
            return;
        }
        
        // Calcola gli slot disponibili
        $startTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);
        $duration = $availability->appointment_duration ?? 30; // minuti
        
        $slots = [];
        $current = clone $startTime;
        
        while ($current->lessThan($endTime)) {
            $slotStart = clone $current;
            $slotEnd = clone $current->addMinutes($duration);
            
            // Verifica se c'è già un appuntamento prenotato
            $existingAppointment = Appointment::where('dentist_id', $this->dentist->id)
                ->whereDate('appointment_date', $date->format('Y-m-d'))
                ->whereTime('appointment_date', '>=', $slotStart->format('H:i:s'))
                ->whereTime('appointment_date', '<', $slotEnd->format('H:i:s'))
                ->exists();
                
            if (!$existingAppointment) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'value' => $slotStart->format('H:i'),
                ];
            }
        }
        
        $this->availableSlots = $slots;
    }
    
    public function render()
    {
        $locale = app()->getLocale();
        
        // Disponibilità prossimi 14 giorni
        $availableDays = [];
        $period = CarbonPeriod::create(now(), now()->addDays(14));
        
        foreach ($period as $date) {
            $dayOfWeek = $date->dayOfWeek;
            $isAvailable = Availability::where('dentist_id', $this->dentist->id)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_available', true)
                ->exists();
                
            if ($isAvailable) {
                $availableDays[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('d'),
                    'month' => $date->format('m'),
                    'weekday' => $date->translatedFormat('D'),
                ];
            }
        }
        
        return view('patient::livewire.appointment-calendar', [
            'availableDays' => $availableDays,
            'locale' => $locale,
        ]);
    }
}
```

### 5. Prenotazione Appuntamento (In corso - 50%)
Il sistema di prenotazione appuntamenti include un form Livewire per selezionare data, orario e informazioni aggiuntive:

```php
// laravel/Modules/Patient/Http/Livewire/BookAppointment.php
namespace Modules\Patient\Http\Livewire;

use Livewire\Component;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;
use Modules\User\Models\User;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Notify\Facades\Notification;

class BookAppointment extends Component
{
    public User $dentist;
    public string $selectedDate = '';
    public string $selectedTime = '';
    public string $reason = '';
    public string $notes = '';
    public bool $termsAccepted = false;
    
    protected $rules = [
        'selectedDate' => 'required|date|after:today',
        'selectedTime' => 'required',
        'reason' => 'required|string|max:255',
        'notes' => 'nullable|string|max:1000',
        'termsAccepted' => 'accepted',
    ];
    
    protected $messages = [
        'selectedDate.required' => 'La data è obbligatoria',
        'selectedDate.after' => 'La data deve essere successiva a oggi',
        'selectedTime.required' => 'L\'orario è obbligatorio',
        'reason.required' => 'Il motivo della visita è obbligatorio',
        'termsAccepted.accepted' => 'Devi accettare i termini e le condizioni',
    ];
    
    public function mount(User $dentist)
    {
        $this->dentist = $dentist;
    }
    
    public function submit()
    {
        $this->validate();
        
        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        
        // Composizione data e ora
        $appointmentDateTime = Carbon::parse(
            $this->selectedDate . ' ' . $this->selectedTime
        );
        
        // Creazione appuntamento
        $appointment = Appointment::create([
            'dentist_id' => $this->dentist->id,
            'patient_id' => $patient->id,
            'appointment_date' => $appointmentDateTime,
            'status' => AppointmentStatus::PENDING,
            'reason' => $this->reason,
            'notes' => $this->notes,
        ]);
        
        // Invio notifiche
        Notification::send(
            $this->dentist,
            new AppointmentRequestNotification($appointment)
        );
        
        Notification::send(
            Auth::user(),
            new AppointmentConfirmationNotification($appointment)
        );
        
        session()->flash('message', 'Appuntamento prenotato con successo! In attesa di conferma.');
        
        $locale = app()->getLocale();
        return redirect()->route('patient.appointments.index', ['locale' => $locale]);
    }
    
    public function render()
    {
        $locale = app()->getLocale();
        return view('patient::livewire.book-appointment', [
            'locale' => $locale,
        ]);
    }
}
```

### 6. Gestione Appuntamenti (In corso - 60%)
Sistema per visualizzare, modificare e cancellare gli appuntamenti:

```php
// laravel/Modules/Patient/Http/Controllers/AppointmentController.php
namespace Modules\Patient\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Modules\Dental\Enums\AppointmentStatus;

class AppointmentController extends Controller
{
    public function index(Request $request, string $locale)
    {
        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', [AppointmentStatus::PENDING, AppointmentStatus::CONFIRMED])
            ->where('appointment_date', '>=', now())
            ->with('dentist')
            ->orderBy('appointment_date')
            ->get();
            
        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', [AppointmentStatus::COMPLETED, AppointmentStatus::CANCELLED, AppointmentStatus::NO_SHOW])
            ->orWhere(function ($query) {
                $query->where('appointment_date', '<', now());
            })
            ->with('dentist')
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        return view('patient::appointments.index', [
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,
            'locale' => $locale,
        ]);
    }
    
    public function show(Request $request, string $locale, Appointment $appointment)
    {
        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        
        // Verifica che l'appuntamento appartenga al paziente
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }
        
        return view('patient::appointments.show', [
            'appointment' => $appointment->load('dentist'),
            'locale' => $locale,
        ]);
    }
    
    public function cancel(Request $request, string $locale, Appointment $appointment)
    {
        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        
        // Verifica che l'appuntamento appartenga al paziente
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }
        
        // Verifica che l'appuntamento possa essere cancellato
        if ($appointment->appointment_date->isPast()) {
            return back()->with('error', 'Non è possibile cancellare appuntamenti passati');
        }
        
        if ($appointment->status === AppointmentStatus::COMPLETED) {
            return back()->with('error', 'Non è possibile cancellare appuntamenti già completati');
        }
        
        $appointment->status = AppointmentStatus::CANCELLED;
        $appointment->save();
        
        // Invio notifica all'odontoiatra
        Notification::send(
            $appointment->dentist,
            new AppointmentCancelledNotification($appointment)
        );
        
        return redirect()
            ->route('patient.appointments.index', ['locale' => $locale])
            ->with('message', 'Appuntamento cancellato con successo');
    }
}
```

### 7. Notifiche (Da completare - 30%)
Sistema di notifiche per promemoria e conferme appuntamenti:

```php
// laravel/Modules/Notify/Notifications/AppointmentConfirmationNotification.php
namespace Modules\Notify\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Dental\Models\Appointment;

class AppointmentConfirmationNotification extends Notification
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
        $locale = app()->getLocale();
        
        return (new MailMessage)
            ->subject(__('notify::appointments.confirmation_subject'))
            ->greeting(__('notify::appointments.greeting', ['name' => $notifiable->name]))
            ->line(__('notify::appointments.confirmation_line1'))
            ->line(__('notify::appointments.confirmation_line2', [
                'date' => $this->appointment->appointment_date->format('d/m/Y'),
                'time' => $this->appointment->appointment_date->format('H:i'),
                'dentist' => $this->appointment->dentist->name,
            ]))
            ->action(
                __('notify::appointments.view_appointment'),
                url("/{$locale}/patient/appointments/{$this->appointment->id}")
            )
            ->line(__('notify::appointments.confirmation_line3'));
    }
    
    public function toArray($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => __('notify::appointments.confirmation_database', [
                'date' => $this->appointment->appointment_date->format('d/m/Y H:i'),
                'dentist' => $this->appointment->dentist->name,
            ]),
            'type' => 'appointment_confirmation',
        ];
    }
}
```

### 8. Localizzazione URL (Completato)
Tutte le rotte rispettano la convenzione URL con locale:

```php
// laravel/Modules/Patient/Routes/web.php
Route::prefix('{locale}')->middleware(['web', 'auth', 'locale', 'role:gestante'])->group(function () {
    Route::prefix('patient')->name('patient.')->group(function () {
        // Ricerca odontoiatri
        Route::get('/dentists', [DentistController::class, 'index'])->name('dentists.index');
        Route::get('/dentists/{dentist}', [DentistController::class, 'show'])->name('dentists.show');
        
        // Gestione appuntamenti
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        
        // Prenotazione appuntamenti
        Route::get('/dentists/{dentist}/book', [BookingController::class, 'showBookingForm'])->name('dentists.book');
        Route::post('/dentists/{dentist}/book', [BookingController::class, 'store'])->name('dentists.book.store');
    });
});
```

## Test

I test sono implementati utilizzando Pest (non PHPUnit):

```php
// laravel/Modules/Patient/Tests/Feature/AppointmentBookingTest.php
use Modules\User\Models\User;
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Availability;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Enums\AppointmentStatus;

test('patient can search for dentists', function () {
    // Arrange
    $user = User::factory()->create();
    $user->assignRole('gestante');
    
    Patient::factory()->create([
        'user_id' => $user->id,
    ]);
    
    $dentist = User::factory()->create(['name' => 'Dr. Mario Rossi']);
    $dentist->assignRole('odontoiatra');
    $dentist->profile()->create([
        'city' => 'Milano',
        'specialization' => 'Odontoiatria generale',
    ]);
    
    // Act
    $response = $this->actingAs($user)
                     ->get(route('patient.dentists.index', [
                         'locale' => 'it',
                         'search' => 'Rossi',
                         'city' => 'Milano'
                     ]));
    
    // Assert
    $response->assertSuccessful();
    $response->assertSee('Dr. Mario Rossi');
    $response->assertSee('Milano');
});

test('patient can book an appointment', function () {
    // Arrange
    $user = User::factory()->create();
    $user->assignRole('gestante');
    
    Patient::factory()->create([
        'user_id' => $user->id,
    ]);
    
    $dentist = User::factory()->create();
    $dentist->assignRole('odontoiatra');
    
    // Crea disponibilità
    $today = now();
    $tomorrow = now()->addDay();
    $dayOfWeek = $tomorrow->dayOfWeek;
    
    Availability::create([
        'dentist_id' => $dentist->id,
        'day_of_week' => $dayOfWeek,
        'start_time' => '09:00',
        'end_time' => '18:00',
        'is_available' => true,
        'appointment_duration' => 30,
    ]);
    
    // Act
    $response = $this->actingAs($user)
                     ->post(route('patient.dentists.book.store', [
                         'locale' => 'it',
                         'dentist' => $dentist->id
                     ]), [
                         'selectedDate' => $tomorrow->format('Y-m-d'),
                         'selectedTime' => '10:00',
                         'reason' => 'Controllo periodico',
                         'notes' => 'Prima visita',
                         'termsAccepted' => true,
                     ]);
    
    // Assert
    $response->assertRedirect(route('patient.appointments.index', ['locale' => 'it']));
    $this->assertDatabaseHas('appointments', [
        'dentist_id' => $dentist->id,
        'status' => AppointmentStatus::PENDING->value,
        'reason' => 'Controllo periodico',
    ]);
});
```

## Traduzione e Localizzazione

Le traduzioni sono gestite tramite il modulo Lang e rispettano la convenzione:

```php
// laravel/Modules/Patient/Resources/lang/it/appointments.php
return [
    'title' => 'I miei appuntamenti',
    'upcoming' => 'Appuntamenti futuri',
    'past' => 'Appuntamenti passati',
    'book' => 'Prenota appuntamento',
    'book_with' => 'Prenota con :dentist',
    'no_appointments' => 'Non hai appuntamenti',
    'search' => [
        'title' => 'Cerca odontoiatra',
        'placeholder' => 'Nome o specializzazione',
        'city' => 'Città',
        'date' => 'Data disponibilità',
        'button' => 'Cerca',
    ],
    'form' => [
        'date' => 'Data',
        'time' => 'Orario',
        'reason' => 'Motivo della visita',
        'notes' => 'Note aggiuntive',
        'terms' => 'Accetto i termini e le condizioni',
        'submit' => 'Conferma prenotazione',
    ],
    'status' => [
        'pending' => 'In attesa',
        'confirmed' => 'Confermato',
        'completed' => 'Completato',
        'cancelled' => 'Cancellato',
        'no_show' => 'Non presentato',
    ],
    'cancel' => [
        'button' => 'Cancella appuntamento',
        'confirm' => 'Sei sicuro di voler cancellare questo appuntamento?',
        'yes' => 'Sì, cancella',
        'no' => 'No, mantieni',
    ],
];
```

## Prossimi Passi

1. Completare l'implementazione del sistema di gestione appuntamenti
2. Implementare il sistema di notifiche push e promemoria via email/SMS
3. Sviluppare la visualizzazione dei documenti clinici dopo la visita
4. Aggiungere la funzionalità di feedback post-visita
5. Integrare la funzionalità di prenotazione con Google Calendar

## Collegamenti

- [Modulo Patient](/var/www/html/base_<nome progetto>/laravel/Modules/Patient/)
- [Modulo Dental](/var/www/html/base_<nome progetto>/laravel/Modules/Dental/)
- [Modulo Notify](/var/www/html/base_<nome progetto>/laravel/Modules/Notify/)
- [Roadmap Frontoffice](/var/www/html/base_<nome progetto>/docs/roadmap_frontoffice.md)
