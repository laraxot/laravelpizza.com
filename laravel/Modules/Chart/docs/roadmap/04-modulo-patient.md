# Implementazione del Modulo Patient

## Descrizione del Modulo

Il modulo Patient è una componente fondamentale del progetto il progetto, incaricato di gestire tutte le informazioni relative alle pazienti gestanti che partecipano al programma. Questo modulo deve garantire:

1. Raccolta e gestione dei dati anagrafici delle pazienti
2. Verifica dei requisiti di eleggibilità (ISEE < 20.000€ e stato di gravidanza)
3. Archiviazione sicura dei documenti relativi (certificati di gravidanza, documentazione ISEE)
4. Gestione del percorso di cura e delle visite odontoiatriche
5. Conformità GDPR per dati sensibili e sanitari

## Struttura del Modulo

### 1. Modelli Dati

#### Patient (Paziente)

```php
// Modules/Patient/Models/Patient.php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\HasTenant;
use Modules\User\Models\User;
use Modules\Media\Traits\HasMedia;
use Modules\Gdpr\Traits\HasConsents;

class Patient extends Model
{
    use SoftDeletes, HasTenant, HasMedia, HasConsents;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'fiscal_code',
        'birth_date',
        'email',
        'phone',
        'address',
        'city',
        'zip_code',
        'province',
        'isee_value',
        'isee_expiry',
        'isee_document_id',
        'pregnancy_date',
        'pregnancy_document_id',
        'notes',
        'is_eligible',
        'eligibility_verified_at',
        'eligibility_verified_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'isee_expiry' => 'date',
        'pregnancy_date' => 'date',
        'is_eligible' => 'boolean',
        'eligibility_verified_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function iseeDocument()
    {
        return $this->belongsTo('Modules\Media\Models\Media', 'isee_document_id');
    }

    public function pregnancyDocument()
    {
        return $this->belongsTo('Modules\Media\Models\Media', 'pregnancy_document_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Business Logic
    public function checkEligibility()
    {
        // Verifica requisiti: ISEE < 20000 e gravidanza in corso
        $isEligible = $this->isee_value < 20000 && 
                      $this->pregnancy_date && 
                      $this->pregnancy_date->isFuture() &&
                      $this->pregnancyDocument && 
                      $this->iseeDocument;
        
        $this->is_eligible = $isEligible;
        $this->save();
        
        return $isEligible;
    }
}
```

#### MedicalRecord (Scheda Medica)

```php
// Modules/Patient/Models/MedicalRecord.php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\HasTenant;
use Modules\User\Models\User;

class MedicalRecord extends Model
{
    use SoftDeletes, HasTenant;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'record_date',
        'general_health_status',
        'ongoing_medications',
        'allergies',
        'previous_dental_issues',
        'pregnancy_trimester',
        'dental_examination_notes',
        'treatment_plan',
    ];

    protected $casts = [
        'record_date' => 'datetime',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function dentalExaminations()
    {
        return $this->hasMany(DentalExamination::class);
    }
}
```

#### Appointment (Appuntamento)

```php
// Modules/Patient/Models/Appointment.php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\HasTenant;
use Modules\User\Models\User;

class Appointment extends Model
{
    use SoftDeletes, HasTenant;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'appointment_date',
        'duration_minutes',
        'reason',
        'notes',
        'status', // scheduled, completed, cancelled, no_show
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function dentalExamination()
    {
        return $this->hasOne(DentalExamination::class);
    }
}
```

#### DentalExamination (Visita Odontoiatrica)

```php
// Modules/Patient/Models/DentalExamination.php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\HasTenant;
use Modules\User\Models\User;

class DentalExamination extends Model
{
    use SoftDeletes, HasTenant;

    protected $fillable = [
        'medical_record_id',
        'appointment_id',
        'dentist_id',
        'examination_date',
        'pufa_index',
        'bleeding_index',
        'plaque_index',
        'missing_teeth',
        'decayed_teeth',
        'filled_teeth',
        'diagnosis',
        'treatment_performed',
        'recommendations',
        'follow_up_needed',
        'follow_up_date',
    ];

    protected $casts = [
        'examination_date' => 'datetime',
        'follow_up_needed' => 'boolean',
        'follow_up_date' => 'date',
        'missing_teeth' => 'array',
        'decayed_teeth' => 'array',
        'filled_teeth' => 'array',
    ];

    // Relationships
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }
}
```

### 2. Migrazioni del Database

```php
// Modules/Patient/Database/Migrations/2024_04_01_000001_create_patients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Dati anagrafici
            $table->string('first_name');
            $table->string('last_name');
            $table->string('fiscal_code', 16)->unique();
            $table->date('birth_date');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('province', 2)->nullable();
            
            // Dati ISEE
            $table->decimal('isee_value', 10, 2)->nullable();
            $table->date('isee_expiry')->nullable();
            $table->foreignId('isee_document_id')->nullable()->constrained('media')->onDelete('set null');
            
            // Dati gravidanza
            $table->date('pregnancy_date')->nullable(); // data presunta parto
            $table->foreignId('pregnancy_document_id')->nullable()->constrained('media')->onDelete('set null');
            
            // Note e verifica eleggibilità
            $table->text('notes')->nullable();
            $table->boolean('is_eligible')->default(false);
            $table->timestamp('eligibility_verified_at')->nullable();
            $table->foreignId('eligibility_verified_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
```

```php
// Altre migrazioni per medical_records, appointments, dental_examinations ecc.
// ...
```

### 3. Service Provider

```php
// Modules/Patient/Providers/PatientServiceProvider.php

namespace Modules\Patient\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Patient\Services\EligibilityService;

class PatientServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Patient';
    protected $moduleNameLower = 'patient';

    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        
        // Registra i servizi
        $this->app->singleton(EligibilityService::class, function ($app) {
            return new EligibilityService();
        });
    }

    // Altre funzioni per registrazioni...
}
```

### 4. Servizi

```php
// Modules/Patient/Services/EligibilityService.php

namespace Modules\Patient\Services;

use Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\Log;

class EligibilityService
{
    /**
     * Verifica l'idoneità di un paziente per il programma
     */
    public function verifyEligibility(Patient $patient): bool
    {
        try {
            // Verifica ISEE
            $iseeValid = $patient->isee_value < 20000 && 
                         $patient->isee_expiry && 
                         $patient->isee_expiry->isFuture() &&
                         $patient->isee_document_id;
            
            if (!$iseeValid) {
                Log::info("Paziente {$patient->id} non idoneo: ISEE non valido");
                return false;
            }
            
            // Verifica gravidanza
            $pregnancyValid = $patient->pregnancy_date && 
                              $patient->pregnancy_date->isFuture() &&
                              $patient->pregnancy_document_id;
            
            if (!$pregnancyValid) {
                Log::info("Paziente {$patient->id} non idoneo: gravidanza non documentata");
                return false;
            }
            
            // Aggiorna stato eleggibilità
            $patient->is_eligible = true;
            $patient->eligibility_verified_at = now();
            $patient->eligibility_verified_by = auth()->id();
            $patient->save();
            
            return true;
        } catch (\Exception $e) {
            Log::error("Errore nella verifica di idoneità: " . $e->getMessage());
            return false;
        }
    }
}
```

### 5. Controllers

```php
// Modules/Patient/Http/Controllers/PatientController.php

namespace Modules\Patient\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Patient\Models\Patient;
use Modules\Patient\Services\EligibilityService;
use Modules\Patient\Http\Requests\PatientRequest;

class PatientController extends Controller
{
    protected $eligibilityService;
    
    public function __construct(EligibilityService $eligibilityService)
    {
        $this->eligibilityService = $eligibilityService;
    }
    
    public function index()
    {
        $patients = Patient::tenanted()->paginate(15);
        return view('patient::index', compact('patients'));
    }
    
    public function create()
    {
        return view('patient::create');
    }
    
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        
        // Verifica ISEE e gravidanza
        $this->eligibilityService->verifyEligibility($patient);
        
        return redirect()->route('patients.show', $patient)
            ->with('success', 'Paziente registrato con successo.');
    }
    
    // Altri metodi CRUD...
    
    public function verifyEligibility(Patient $patient)
    {
        $isEligible = $this->eligibilityService->verifyEligibility($patient);
        
        $message = $isEligible 
            ? 'La paziente è idonea per il programma.' 
            : 'La paziente non è idonea per il programma.';
        
        return back()->with('status', $message);
    }
}
```

### 6. Request Validation

```php
// Modules/Patient/Http/Requests/PatientRequest.php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code,' . $this->patient,
            'birth_date' => 'required|date|before:today',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'province' => 'nullable|string|size:2',
            'isee_value' => 'required|numeric|min:0|max:100000',
            'isee_expiry' => 'required|date|after:today',
            'isee_document_id' => 'required|exists:media,id',
            'pregnancy_date' => 'required|date|after:today',
            'pregnancy_document_id' => 'required|exists:media,id',
            'notes' => 'nullable|string',
        ];
    }
    
    public function messages()
    {
        return [
            'isee_value.max' => 'Il valore ISEE non può superare 100.000€.',
            'isee_value.required' => 'Il valore ISEE è obbligatorio per verificare l\'idoneità.',
            'pregnancy_date.required' => 'La data presunta del parto è obbligatoria.',
            'pregnancy_date.after' => 'La data presunta del parto deve essere futura.',
            'isee_document_id.required' => 'È necessario caricare il documento ISEE.',
            'pregnancy_document_id.required' => 'È necessario caricare il certificato di gravidanza.',
        ];
    }
}
```

### 7. Risorse Filament

```php
// App/Filament/Resources/PatientResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Patient\Models\Patient;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Gestione Pazienti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Schema dei form...
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Colonne tabella...
            ])
            ->filters([
                // Filtri...
            ])
            ->actions([
                // Azioni...
            ]);
    }

    // Altri metodi...
}
```

## Piano di Implementazione

### Fase 1: Preparazione e Setup

1. **Creazione delle migrazioni del database**
   - Creazione delle tabelle patients, medical_records, appointments, dental_examinations
   - Creazione delle relazioni tra tabelle
   - Definizione delle chiavi esterne e vincoli

2. **Implementazione dei modelli dati**
   - Creazione di modelli con relazioni, mutator e accessor
   - Implementazione di soft deletes
   - Configurazione delle proprietà fillable, casts, ecc.

3. **Setup dei service provider**
   - Registrazione delle migrazioni
   - Registrazione delle configurazioni
   - Registrazione dei servizi

### Fase 2: Implementazione della Logica di Business

1. **Implementazione del servizio di verifica eleggibilità**
   - Logica per validare ISEE < 20.000€
   - Logica per validare documentazione gravidanza
   - Sistema di notifica per idoneità/non idoneità

2. **Implementazione della gestione documenti**
   - Upload documenti ISEE
   - Upload certificati di gravidanza
   - Validazione documenti

3. **Implementazione della gestione appuntamenti**
   - Creazione appuntamenti
   - Calendario disponibilità
   - Notifiche e promemoria

4. **Implementazione della cartella clinica**
   - Registrazione visite
   - Schede anamnestiche
   - Trattamenti eseguiti

### Fase 3: Integrazione con altri Moduli

1. **Integrazione con Modulo GDPR**
   - Gestione consensi per dati sanitari
   - Politiche di conservazione dati
   - Funzionalità di esportazione dati

2. **Integrazione con Modulo User**
   - Collegamento pazienti agli utenti
   - Gestione dei permessi per accesso dati
   - Sistema di notifiche

3. **Integrazione con Modulo Tenant**
   - Isolamento dati per tenant
   - Filtri per visualizzazione dati per tenant
   - Configurazioni specifiche per tenant

### Fase 4: Interfaccia Utente con Filament

1. **Creazione risorse Filament per Patient**
   - Form di creazione/modifica
   - Tabelle per visualizzazione dati
   - Azioni personalizzate

2. **Implementazione dashboard pazienti**
   - Widget per statistiche
   - Visualizzazione appuntamenti
   - Notifiche e promemoria

3. **Implementazione pannello odontoiatri**
   - Calendario appuntamenti
   - Gestione schede cliniche
   - Sistema di refertazione

## Checklist di Implementazione

- [ ] Creazione delle migrazioni del database
- [ ] Implementazione dei modelli dati
- [ ] Setup dei service provider
- [ ] Implementazione del servizio di verifica eleggibilità
- [ ] Implementazione della gestione documenti
- [ ] Implementazione della gestione appuntamenti
- [ ] Implementazione della cartella clinica
- [ ] Integrazione con Modulo GDPR
- [ ] Integrazione con Modulo User
- [ ] Integrazione con Modulo Tenant
- [ ] Creazione risorse Filament per Patient
- [ ] Implementazione dashboard pazienti
- [ ] Implementazione pannello odontoiatri

## Considerazioni sulla Protezione dei Dati

Il modulo Patient gestisce dati sensibili e sanitari, pertanto richiede particolare attenzione alle normative GDPR:

1. **Minimizzazione dei dati**
   - Raccolta solo dei dati strettamente necessari
   - Separazione dati identificativi da dati sanitari

2. **Sicurezza dei dati**
   - Crittografia dei dati sensibili
   - Logging degli accessi ai dati
   - Permessi granulari per l'accesso

3. **Conservazione limitata**
   - Politiche di conservazione dei dati
   - Procedure di anonimizzazione dopo periodi definiti

4. **Consenso esplicito**
   - Acquisizione del consenso per il trattamento dei dati sanitari
   - Possibilità di revoca del consenso

## Risultato Atteso

Dopo la completa implementazione del modulo Patient, avremo un sistema che permette:

1. **Gestione completa del ciclo paziente**
   - Registrazione e verifica idoneità
   - Programmazione appuntamenti
   - Gestione visite
   - Follow-up

2. **Dati sicuri e conformi GDPR**
   - Protezione dei dati sensibili
   - Tracciabilità degli accessi
   - Gestione consensi

3. **Interfaccia intuitiva per utenti diversi**
   - Pannello per amministratori
   - Pannello per odontoiatri
   - Portale per pazienti 