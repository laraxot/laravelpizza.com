# Gestione Prenotazione Appuntamenti

## Overview
Questo documento descrive l'implementazione della funzionalità di prenotazione appuntamenti accessibile tramite la URL `/it/patient/book`. La funzionalità è parte integrante del modulo Patient e si integra con il sistema di gestione appuntamenti esistente.

## Collegamenti Correlati
- [Indice Roadmap Frontoffice](../roadmap_frontoffice.md)
- [UI/UX Base](./03-ui-ux-base.md)
- [Registrazione/Autenticazione](./04-registrazione-autenticazione.md)
- [Prenotazione Visite](./07-prenotazione-visite.md)
- [Modelli/Ereditarietà](./10-modelli-ereditarieta.md)

## Architettura

### 1. Controller e Route
```php
// Patient/Http/Controllers/AppointmentController.php
namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\Actions\Appointment\BookAppointmentAction;
use Modules\Patient\Data\AppointmentData;
use Modules\Patient\Rules\AppointmentRules;

class AppointmentController extends Controller
{
    public function book(BookAppointmentAction $action)
    {
        return $action->execute();
    }

    public function store(BookAppointmentAction $action, AppointmentData $data)
    {
        return $action->execute($data);
    }
}
```

### 2. Action
```php
// Patient/Actions/Appointment/BookAppointmentAction.php
namespace Modules\Patient\Actions\Appointment;

use Spatie\QueueableAction\QueueableAction;
use Modules\Patient\Data\AppointmentData;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\TimeSlot;
use Illuminate\View\View;

class BookAppointmentAction
{
    use QueueableAction;

    public function execute(?AppointmentData $data = null): View|RedirectResponse
    {
        if (!$data) {
            return view('patient::appointments.book', [
                'doctors' => Doctor::active()->get(),
                'timeSlots' => TimeSlot::available()->get(),
            ]);
        }

        // Validazione e creazione appuntamento
        $appointment = $this->createAppointment($data);
        
        // Notifica
        $this->notifyAppointmentCreated($appointment);

        return redirect()
            ->route('patient.appointments.show', $appointment)
            ->with('success', 'Appuntamento prenotato con successo');
    }

    private function createAppointment(AppointmentData $data): Appointment
    {
        return Appointment::create([
            'doctor_id' => $data->doctor_id,
            'patient_id' => auth()->id(),
            'date' => $data->date,
            'time' => $data->time,
            'notes' => $data->notes,
            'status' => AppointmentStatus::PENDING,
        ]);
    }
}
```

### 3. Data Object
```php
// Patient/Data/AppointmentData.php
namespace Modules\Patient\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\After;

class AppointmentData extends Data
{
    public function __construct(
        #[Required]
        public int $doctor_id,
        
        #[Required, Date, After('today')]
        public string $date,
        
        #[Required]
        public string $time,
        
        public ?string $notes = null,
    ) {}
}
```

### 4. View
```blade
{{-- Patient/Resources/views/appointments/book.blade.php --}}
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">{{ __('Prenota Appuntamento') }}</h1>
        
        <form action="{{ route('patient.appointments.store') }}" method="POST" x-data="appointmentForm()">
            @csrf
            
            {{-- Selezione Dentista --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('Seleziona Dentista') }}
                </label>
                <select 
                    name="doctor_id" 
                    class="mt-1 block w-full rounded-md border-gray-300"
                    x-model="selectedDoctor"
                    @change="loadAvailableDates"
                >
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }} - {{ $doctor->specialization }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Selezione Data --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('Data Appuntamento') }}
                </label>
                <input 
                    type="date" 
                    name="date" 
                    class="mt-1 block w-full rounded-md border-gray-300"
                    x-model="selectedDate"
                    @change="loadAvailableTimes"
                    :min="minDate"
                >
            </div>

            {{-- Selezione Orario --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('Orario Appuntamento') }}
                </label>
                <select 
                    name="time" 
                    class="mt-1 block w-full rounded-md border-gray-300"
                    x-model="selectedTime"
                    :disabled="!selectedDate"
                >
                    <template x-for="slot in availableTimeSlots" :key="slot.time">
                        <option :value="slot.time" x-text="slot.formatted_time"></option>
                    </template>
                </select>
            </div>

            {{-- Note --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('Note') }}
                </label>
                <textarea 
                    name="notes" 
                    class="mt-1 block w-full rounded-md border-gray-300"
                    x-model="notes"
                ></textarea>
            </div>

            <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded-md"
                :disabled="!isFormValid"
            >
                {{ __('Prenota') }}
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        function appointmentForm() {
            return {
                selectedDoctor: null,
                selectedDate: null,
                selectedTime: null,
                notes: '',
                availableTimeSlots: [],
                minDate: new Date().toISOString().split('T')[0],

                async loadAvailableDates() {
                    if (!this.selectedDoctor) return;
                    
                    const response = await fetch(`/api/doctors/${this.selectedDoctor}/available-dates`);
                    this.availableDates = await response.json();
                },

                async loadAvailableTimes() {
                    if (!this.selectedDoctor || !this.selectedDate) return;
                    
                    const response = await fetch(
                        `/api/doctors/${this.selectedDoctor}/available-times?date=${this.selectedDate}`
                    );
                    this.availableTimeSlots = await response.json();
                },

                get isFormValid() {
                    return this.selectedDoctor && 
                           this.selectedDate && 
                           this.selectedTime;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
```

## Workflow

### 1. Accesso alla Pagina
- L'utente accede a `/it/patient/book`
- Il sistema verifica l'autenticazione
- Viene caricata la lista dei dentisti disponibili
- Il calendario mostra le date disponibili per il dentista selezionato

### 2. Selezione Appuntamento
- L'utente seleziona il dentista
- Il sistema carica le date disponibili per il dentista selezionato
- L'utente sceglie la data disponibile
- Il sistema carica gli orari disponibili per la data selezionata
- L'utente seleziona l'orario tra quelli disponibili
- Opzionalmente aggiunge note

### 3. Conferma
- Il sistema verifica la disponibilità in tempo reale
- Invia notifica al dentista
- Conferma la prenotazione all'utente
- Reindirizza alla pagina di conferma con dettagli appuntamento

## Validazione

```php
// Patient/Rules/AppointmentRules.php
namespace Modules\Patient\Rules;

use Illuminate\Validation\Rule;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\TimeSlot;

class AppointmentRules
{
    public static function rules(): array
    {
        return [
            'doctor_id' => [
                'required',
                'exists:doctors,id',
                function ($attribute, $value, $fail) {
                    $doctor = Doctor::find($value);
                    if (!$doctor || !$doctor->is_active) {
                        $fail('Il dentista selezionato non è disponibile.');
                    }
                },
            ],
            'date' => [
                'required',
                'date',
                'after:today',
                function ($attribute, $value, $fail) {
                    if (!TimeSlot::isDateAvailable($value)) {
                        $fail('La data selezionata non è disponibile.');
                    }
                },
            ],
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (!TimeSlot::isTimeAvailable($value)) {
                        $fail('L\'orario selezionato non è disponibile.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
```

## Notifiche

```php
// Patient/Notifications/AppointmentBooked.php
namespace Modules\Patient\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Patient\Models\Appointment;

class AppointmentBooked extends Notification
{
    public function __construct(
        private Appointment $appointment
    ) {}

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appuntamento Prenotato')
            ->greeting('Ciao ' . $notifiable->name)
            ->line('Il tuo appuntamento è stato confermato.')
            ->line('Dentista: ' . $this->appointment->doctor->name)
            ->line('Data: ' . $this->appointment->date->format('d/m/Y'))
            ->line('Orario: ' . $this->appointment->time)
            ->action('Vedi Dettagli', url('/appointments/' . $this->appointment->id))
            ->line('Grazie per aver scelto i nostri servizi!');
    }

    public function toSms($notifiable): string
    {
        return sprintf(
            'Appuntamento confermato con %s il %s alle %s. Per modifiche: %s',
            $this->appointment->doctor->name,
            $this->appointment->date->format('d/m/Y'),
            $this->appointment->time,
            url('/appointments/' . $this->appointment->id)
        );
    }
}
```

## Test

```php
// Patient/Tests/Feature/AppointmentBookingTest.php
namespace Modules\Patient\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\Appointment;
use Modules\Patient\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_book_appointment()
    {
        $doctor = Doctor::factory()->create(['is_active' => true]);
        $timeSlot = TimeSlot::factory()->create([
            'doctor_id' => $doctor->id,
            'date' => now()->addDays(2),
            'time' => '10:00',
            'is_available' => true,
        ]);
        
        $response = $this->actingAs($this->createPatient())
            ->post(route('patient.appointments.store'), [
                'doctor_id' => $doctor->id,
                'date' => $timeSlot->date->format('Y-m-d'),
                'time' => $timeSlot->time,
                'notes' => 'Test appointment',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('appointments', [
            'doctor_id' => $doctor->id,
            'date' => $timeSlot->date->format('Y-m-d'),
            'time' => $timeSlot->time,
            'notes' => 'Test appointment',
        ]);
    }

    public function test_cannot_book_unavailable_slot()
    {
        $doctor = Doctor::factory()->create(['is_active' => true]);
        $timeSlot = TimeSlot::factory()->create([
            'doctor_id' => $doctor->id,
            'date' => now()->addDays(2),
            'time' => '10:00',
            'is_available' => false,
        ]);
        
        $response = $this->actingAs($this->createPatient())
            ->post(route('patient.appointments.store'), [
                'doctor_id' => $doctor->id,
                'date' => $timeSlot->date->format('Y-m-d'),
                'time' => $timeSlot->time,
            ]);

        $response->assertSessionHasErrors('time');
    }
}
```

## Best Practices

### 1. Validazione
- Utilizzare ValidationException::withMessages per errori custom
- Validare sempre lato server anche se presente validazione client
- Implementare regole di business specifiche per la prenotazione
- Utilizzare Data Objects per la validazione dei dati

### 2. Performance
- Implementare caching per la lista dei dentisti
- Ottimizzare le query per gli slot disponibili
- Utilizzare lazy loading per le immagini dei dentisti
- Implementare rate limiting per le richieste API

### 3. Sicurezza
- Verificare l'autenticazione dell'utente
- Implementare rate limiting per le prenotazioni
- Sanitizzare tutti gli input
- Validare i permessi per ogni azione

### 4. UX
- Fornire feedback immediato sulla disponibilità
- Implementare calendario interattivo
- Mostrare conferma chiara della prenotazione
- Gestire correttamente gli errori con messaggi chiari

## Checklist Implementazione

- [ ] Implementare controller e route
- [ ] Creare action per la prenotazione
- [ ] Implementare data object
- [ ] Creare view con form
- [ ] Implementare validazione
- [ ] Aggiungere notifiche
- [ ] Scrivere test
- [ ] Implementare caching
- [ ] Aggiungere rate limiting
- [ ] Ottimizzare performance
- [ ] Testare UX su mobile
- [ ] Documentare API

## Note Aggiuntive

- La funzionalità deve essere completamente responsive
- Implementare gestione errori robusta
- Aggiungere logging per debugging
- Considerare integrazione con sistema di pagamento per visite a pagamento
- Implementare sistema di reminder per appuntamenti
- Gestire correttamente i fusi orari
- Implementare sistema di backup per le prenotazioni
- Aggiungere analytics per monitorare l'utilizzo 