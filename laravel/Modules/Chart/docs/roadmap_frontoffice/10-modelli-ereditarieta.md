# Implementazione dei Modelli e Best Practices di Ereditarietà

## Descrizione del Task
Questo documento descrive l'implementazione dei modelli nel modulo Patient, con particolare attenzione al pattern Single Table Inheritance (STI) e alle best practices per l'ereditarietà delle classi.

## Stato Attuale
- **Completamento**: 90%
- **Responsabile**: Team Backend
- **Ultimo aggiornamento**: Maggio 2025

## Implementazione

### 1. Pattern Single Table Inheritance (Completato)
Il modulo Patient implementa il pattern Single Table Inheritance (STI) per gestire diversi tipi di utenti (Doctor, Patient) che condividono la stessa tabella `users` nel database.

#### Struttura di Ereditarietà
```
BaseUser (Modules\User\app\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

#### File Implementati
- `Modules\User\app\Models\BaseUser.php`: Classe base per tutti gli utenti
- `Modules\Patient\Models\User.php`: Estensione specifica per il modulo Patient
- `Modules\Patient\Models\Doctor.php`: Modello per i dottori
- `Modules\Patient\Models\Patient.php`: Modello per i pazienti

### 2. Modello Doctor (Completato)

Il modello Doctor estende User e implementa il pattern STI:

```php
// Modules\Patient\Models\Doctor.php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Parental\HasParent;

/**
 * Class Doctor
 *
 * Questa classe implementa il pattern Single Table Inheritance (STI)
 * estendendo la classe User e utilizzando il trait HasParent.
 */
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        'specialization',
        'certifications',
        'availability',
        'status',
    ];

    /**
     * Definisce i cast per gli attributi.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'certifications' => 'array',
            'availability' => 'array',
        ]);
    }

    /**
     * Relazione con il workflow di registrazione.
     *
     * @return HasOne
     */
    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class, 'doctor_id');
    }
}
```

### 3. Best Practices per l'Ereditarietà (Completato)

#### Evitare Duplicazione di Trait
È fondamentale evitare di ridichiarare trait già presenti nelle classi genitori:

```php
// ❌ ERRATO - Duplicazione del trait HasFactory
class Doctor extends User
{
    use HasFactory; // Già ereditato da BaseUser
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
}

// ✅ CORRETTO - Nessuna duplicazione
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
}
```

#### Regole da Seguire
1. **MAI ridichiarare trait già presenti nelle classi genitori**
2. **Prima di aggiungere un trait, verificare SEMPRE la catena di ereditarietà completa**
3. **Esaminare il codice delle classi genitori per comprendere quali trait e metodi sono già disponibili**
4. **Documentare chiaramente la catena di ereditarietà nei file di documentazione**

### 4. Workflow di Registrazione Doctor (Completato)

Il modello `DoctorRegistrationWorkflow` gestisce il processo di registrazione dei dottori:

```php
// Modules\Patient\Models\DoctorRegistrationWorkflow.php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Patient\Enums\DoctorRegistrationStatus;

class DoctorRegistrationWorkflow extends Model
{
    use HasUuids;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'doctor_id',
        'current_step',
        'status',
        'started_at',
        'last_interaction_at',
        'completed_at',
        'session_id',
        'moderation_notes',
    ];

    /**
     * Gli attributi che devono essere convertiti in tipi nativi.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'last_interaction_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => DoctorRegistrationStatus::class,
        ];
    }

    /**
     * Relazione con il dottore.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
```

### 5. Enum per lo Stato di Registrazione (Completato)

L'enum `DoctorRegistrationStatus` definisce gli stati possibili per il workflow di registrazione:

```php
// Modules\Patient\Enums\DoctorRegistrationStatus.php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

/**
 * Enum per gli stati del workflow di registrazione del dottore.
 */
enum DoctorRegistrationStatus: string
{
    /**
     * Bozza - Il processo di registrazione è stato iniziato ma non completato.
     */
    case DRAFT = 'draft';
    
    /**
     * In attesa di moderazione - Il dottore ha completato la registrazione e sta attendendo l'approvazione.
     */
    case PENDING_MODERATION = 'pending_moderation';
    
    /**
     * Approvato dalla moderazione - La registrazione del dottore è stata approvata.
     */
    case MODERATION_APPROVED = 'moderation_approved';
    
    /**
     * Rifiutato dalla moderazione - La registrazione del dottore è stata rifiutata.
     */
    case MODERATION_REJECTED = 'moderation_rejected';
    
    /**
     * Completato - Il processo di registrazione è stato completato con successo.
     */
    case COMPLETED = 'completed';
    
    /**
     * Restituisce una descrizione leggibile dello stato.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Bozza',
            self::PENDING_MODERATION => 'In attesa di moderazione',
            self::MODERATION_APPROVED => 'Approvato',
            self::MODERATION_REJECTED => 'Rifiutato',
            self::COMPLETED => 'Completato',
        };
    }
}
```

### 6. Action per la Registrazione (Completato)

La classe `RegisterAction` gestisce la logica di registrazione dei dottori:

```php
// Modules\Patient\Actions\Doctor\RegisterAction.php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Modules\Patient\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Patient\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Patient\Datas\DoctorData;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Patient\Enums\DoctorStatus;
use Illuminate\Validation\ValidationException;
use Modules\Patient\Enums\DoctorRegistrationStatus;
use Modules\Patient\Models\DoctorRegistrationWorkflow;

class RegisterAction
{
    /**
     * Esegue l'azione di registrazione di un nuovo dottore.
     *
     * @param array<string, mixed> $data
     * @return Doctor
     */
    public function execute(array $data): Doctor
    {
        // Verifica se esiste già un utente con questa email
        $existingUser = Doctor::where('email', $data['email'])->first();
        if ($existingUser) {
            $error = ValidationException::withMessages([
                'email' => ['Un dottore con questa email è già registrato.'],
            ]);
            throw $error;
        }
        
        $doctor = Doctor::create($data);
        
        // Creazione del workflow di registrazione
        DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            'current_step' => 'personal-info',
            'status' => 'pending',
            'started_at' => now(),
            'last_interaction_at' => now(),
            'session_id' => session()->getId(),
        ]);
        
        // Invio email di conferma
        $this->sendConfirmationEmail($doctor);
        
        return $doctor;
    }

    /**
     * Invia l'email di conferma della registrazione.
     *
     * @param Doctor $doctor
     * @return void
     */
    protected function sendConfirmationEmail(Doctor $doctor): void
    {
        // Verifica se esiste già il template, altrimenti crealo
        if (!MailTemplate::where('slug', 'doctor_registration_pending')->exists()) {
            MailTemplate::create([
                'mailable' => SpatieEmail::class,
                'slug' => 'doctor_registration_pending',
                'subject' => 'Benvenuto, {{ first_name }}',
                'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.</p>',
                'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.'
            ]);
        }
        
        $email = new SpatieEmail($doctor, 'doctor_registration_pending');
        Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
    }
    
    /**
     * Ottiene lo stato di registrazione del dottore.
     *
     * @return string
     */
    private function getDoctorRegistrationStatus(): string
    {
        if (!class_exists(DoctorRegistrationStatus::class)) {
            return 'pending';
        }
        
        try {
            $cases = DoctorRegistrationStatus::cases();
            foreach ($cases as $case) {
                if (strtolower($case->name) === 'pending') {
                    return $case->value;
                }
            }
            return 'pending';
        } catch (\Exception $e) {
            return 'pending';
        }
    }
}
```

## Documentazione Aggiuntiva

Per maggiori dettagli sull'implementazione, consultare i seguenti documenti:

- [Single Table Inheritance](../../laravel/Modules/Patient/docs/SINGLE_TABLE_INHERITANCE.md)
- [Best Practices per l'Ereditarietà](../../laravel/Modules/Patient/docs/INHERITANCE_BEST_PRACTICES.md)
- [Gestione delle Eccezioni di Validazione](../../laravel/Modules/Patient/docs/VALIDATION_EXCEPTIONS.md)
- [Best Practices per gli Enum](../../laravel/Modules/Patient/docs/ENUMS_BEST_PRACTICES.md)
- [Best Practices per le Actions](../../laravel/Modules/Patient/docs/ACTIONS_BEST_PRACTICES.md)

## Test Implementati

Sono stati implementati test automatizzati per verificare il corretto funzionamento del processo di registrazione:

```php
// Modules\Patient\Tests\Feature\Actions\Doctor\RegisterActionTest.php
<?php

namespace Modules\Patient\Tests\Feature\Actions\Doctor;

use Tests\TestCase;
use Modules\Patient\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Patient\Actions\Doctor\RegisterAction;
use Illuminate\Validation\ValidationException;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_register_a_new_doctor()
    {
        // Arrange
        $action = new RegisterAction();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'specialization' => 'Cardiology',
        ];
        
        // Act
        $doctor = $action->execute($data);
        
        // Assert
        $this->assertInstanceOf(Doctor::class, $doctor);
        $this->assertEquals('John', $doctor->first_name);
        $this->assertEquals('Doe', $doctor->last_name);
        $this->assertEquals('john.doe@example.com', $doctor->email);
        $this->assertNotNull($doctor->workflow);
    }
    
    /** @test */
    public function it_throws_validation_exception_for_duplicate_email()
    {
        // Arrange
        $action = new RegisterAction();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ];
        
        // Create a doctor with the same email
        Doctor::create([
            'first_name' => 'Existing',
            'last_name' => 'Doctor',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Act & Assert
        $this->expectException(ValidationException::class);
        $action->execute($data);
    }
}
```

## Prossimi Passi
- Migliorare la gestione degli stati di registrazione
- Implementare notifiche in tempo reale per gli aggiornamenti di stato
- Aggiungere validazione più robusta per i dati dei dottori
- Estendere i test per coprire più casi d'uso
