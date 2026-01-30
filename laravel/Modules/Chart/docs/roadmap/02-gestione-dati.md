# Fase 2: Gestione Dati

## Stato di Avanzamento
- [x] Definizione delle entità principali
- [x] Mappatura delle relazioni tra entità
- [ ] Implementazione dei modelli
- [ ] Creazione delle migrazioni
- [ ] Implementazione delle Factory per il testing
- [ ] Sviluppo dei repository pattern
- [ ] Implementazione della business logic nei service

## Obiettivi
- Creare un'architettura dati solida e scalabile
- Implementare tutte le entità necessarie per il progetto
- Definire relazioni coerenti tra le entità
- Sviluppare repository pattern per un accesso ai dati standardizzato
- Implementare validazione robusta dei dati
- Configurare il sistema per gestire correttamente i dati GDPR-sensibili

## Entità Principali e Relazioni

### Modulo Patient

#### Entità Patient
Il paziente è l'entità centrale del sistema e contiene dati personali sensibili che richiedono protezione GDPR.

```php
// Modules/Patient/Models/Patient.php
namespace Modules\Patient\Models;

use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Modules\Dental\Models\Treatment;
use Modules\Dental\Models\Visit;
use Modules\Gdpr\Traits\HasConsents;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\User\Models\User;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Traits\HasEncryptedAttributes;
use Modules\Activity\Traits\LogsActivity;

class Patient extends XotBaseModel
{
    use HasUuids;
    use SoftDeletes;
    use BelongsToTenant;
    use HasConsents;
    use HasEncryptedAttributes;
    use LogsActivity;
    
    protected $table = 'patients';
    
    /**
     * I campi che possono essere assegnati in massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        // Dati anagrafici (saranno crittografati tramite trait)
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'gender',
        'fiscal_code', // Codice fiscale (crittografato)
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'phone',
        'email',
        
        // Dati di stato
        'status',
        'active',
        'verified',
        
        // Riferimenti esterni
        'tenant_id',
        'user_id',
        
        // Dati clinici specifici
        'pregnancy_week',
        'estimated_delivery_date',
        'notes',
        
        // Campi GDPR e consensi
        'has_full_consent',
        'gdpr_consent_at',
        'consent_source_ip',
        'consent_user_agent',
    ];

    /**
     * Gli attributi che devono essere crittografati.
     * Il trait HasEncryptedAttributes gestirà automaticamente la crittografia.
     *
     * @var array<string>
     */
    protected array $encryptedAttributes = [
        'first_name',
        'last_name',
        'fiscal_code',
        'email',
        'phone',
        'birth_place',
        'address',
        'notes'
    ];
    
    /**
     * Gli attributi che devono essere convertiti in tipi nativi.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'estimated_delivery_date' => 'date',
        'status' => 'string',
        'pregnancy_week' => 'integer',
        'active' => 'boolean',
        'verified' => 'boolean',
        'has_full_consent' => 'boolean',
        'gdpr_consent_at' => 'datetime',
    ];
    
    /**
     * Attributi da nascondere nelle serializzazioni.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'consent_source_ip',
        'consent_user_agent',
        'fiscal_code_hash',
        'email_hash',
        'phone_hash',
    ];
    
    /**
     * Attributi virtuali da aggiungere alle serializzazioni.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'full_name',
        'age',
        'has_valid_isee'
    ];
    
    /**
     * Le attività che devono essere registrate nel log.
     *
     * @var array<string>
     */
    protected static array $logAttributes = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'active',
    ];
    
    /**
     * Descrizione per il log di attività.
     *
     * @var string
     */
    protected static string $logName = 'patient';
    
    /**
     * Ritorna il nome completo del paziente.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    
    /**
     * Calcola l'età del paziente in base alla data di nascita.
     *
     * @return int|null
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }
        
        return $this->birth_date->age;
    }
    
    /**
     * Verifica se il paziente ha un ISEE valido.
     *
     * @return bool
     */
    public function getHasValidIseeAttribute(): bool
    {
        if (!$this->relationLoaded('iseeDocuments')) {
            $this->load('iseeDocuments');
        }
        
        return $this->iseeDocuments
            ->where('expiry_date', '>', now())
            ->where('status', 'verified')
            ->isNotEmpty();
    }
    
    /**
     * Sovrascrive il metodo save per generare hash per la ricerca.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        // Genera hash per la ricerca efficiente (per indexing)
        if ($this->fiscal_code) {
            $this->fiscal_code_hash = Hash::make($this->fiscal_code);
        }
        
        if ($this->email) {
            $this->email_hash = Hash::make($this->email);
        }
        
        if ($this->phone) {
            $this->phone_hash = Hash::make($this->phone);
        }
        
        // Genera versione ricercabile del cognome
        if ($this->last_name) {
            $this->last_name_searchable = strtolower($this->last_name);
        }
        
        return parent::save($options);
    }
    
    /**
     * Genera un codice paziente anonimizzato per riferimenti esterni.
     *
     * @return string
     */
    public function generateAnonymousCode(): string
    {
        // Crea un codice che non rivela dati identificativi
        // ma permette di collegare i record tra loro
        return 'PAT-' . substr(md5($this->id), 0, 8);
    }
    
    /**
     * Pseudonimizza i dati personali sensibili per conformità GDPR.
     *
     * @return self
     */
    public function pseudonymize(): self
    {
        $this->first_name = 'PSEUDONYMIZED';
        $this->last_name = 'PATIENT';
        $this->fiscal_code = null;
        $this->email = null;
        $this->phone = null;
        $this->address = null;
        $this->birth_place = null;
        $this->fiscal_code_hash = null;
        $this->email_hash = null;
        $this->phone_hash = null;
        $this->last_name_searchable = null;
        $this->notes = 'Data pseudonymized as per GDPR requirements';
        
        return $this;
    }
    
    /**
     * Verifica se un paziente ha fornito consenso per una determinata finalità.
     *
     * @param string $consentType
     * @return bool
     */
    public function hasConsentFor(string $consentType): bool
    {
        if (!$this->relationLoaded('consents')) {
            $this->load('consents');
        }
        
        return $this->consents
            ->where('consent_type', $consentType)
            ->where('granted', true)
            ->whereNull('revoked_at')
            ->isNotEmpty();
    }
    
    /**
     * Relazione con il tenant (clinica).
     *
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    /**
     * Relazione con l'utente proprietario.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relazione con le visite dentali.
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
    
    /**
     * Relazione con i trattamenti.
     *
     * @return HasManyThrough
     */
    public function treatments(): HasManyThrough
    {
        return $this->hasManyThrough(Treatment::class, Visit::class);
    }
    
    /**
     * Relazione con i documenti ISEE.
     *
     * @return HasMany
     */
    public function iseeDocuments(): HasMany
    {
        return $this->hasMany(IseeDocument::class);
    }
    
    /**
     * Relazione con i consensi GDPR.
     *
     * @return HasMany
     */
    public function consents(): HasMany
    {
        return $this->hasMany(PatientConsent::class);
    }
    
    /**
     * Relazione con l'anamnesi del paziente.
     *
     * @return HasOne
     */
    public function anamnesis(): HasOne
    {
        return $this->hasOne(PatientAnamnesis::class);
    }
    
    /**
     * Filtra solo pazienti attivi.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    
    /**
     * Filtra i pazienti in base al loro stato.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Filtra i pazienti che hanno fornito consenso per specifiche finalità.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $consentType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithConsent($query, string $consentType)
    {
        return $query->whereHas('consents', function($q) use ($consentType) {
            $q->where('consent_type', $consentType)
              ->where('granted', true)
              ->whereNull('revoked_at');
        });
    }
}
```

#### Entità IseeDocument
Documenti ISEE associati al paziente.

```php
// Modules/Patient/app/Models/IseeDocument.php
namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Media\app\Models\Media;

class IseeDocument extends Model
{
    protected $fillable = [
        'patient_id',
        'issue_date',
        'expiry_date',
        'isee_value',
        'status',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'isee_value' => 'decimal:2',
        'status' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
```

### Modulo Dental

#### Entità Visit
Rappresenta una visita dentistica.

```php
// Modules/Dental/app/Models/Visit.php
namespace Modules\Dental\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Patient\app\Models\Patient;
use Modules\User\app\Models\User;

class Visit extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'status',
        'notes',
        'diagnosis',
        'follow_up_date',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'follow_up_date' => 'date',
        'status' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}
```

#### Entità Treatment
Rappresenta un trattamento dentale.

```php
// Modules/Dental/app/Models/Treatment.php
namespace Modules\Dental\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Patient\app\Models\Patient;
use Modules\User\app\Models\User;

class Treatment extends Model
{
    protected $fillable = [
        'patient_id',
        'visit_id',
        'doctor_id',
        'treatment_date',
        'treatment_type',
        'description',
        'notes',
        'teeth_area',
        'status',
    ];

    protected $casts = [
        'treatment_date' => 'datetime',
        'status' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
```

## Migrazioni Database

Le migrazioni andranno create per ogni modello. Di seguito le migrazioni principali:

### Migrazione Patient

```php
// Modules/Patient/database/migrations/2024_03_01_000001_create_patients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('gender', ['F', 'M', 'O']);
            $table->string('tax_code')->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('pregnancy_week')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
```

### Migrazione IseeDocument

```php
// Modules/Patient/database/migrations/2024_03_01_000002_create_isee_documents_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->decimal('isee_value', 10, 2);
            $table->enum('status', ['valid', 'expired', 'pending'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isee_documents');
    }
};
```

### Migrazione Visit

```php
// Modules/Dental/database/migrations/2024_03_01_000003_create_visits_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('visit_date');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('diagnosis')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
```

### Migrazione Treatment

```php
// Modules/Dental/database/migrations/2024_03_01_000004_create_treatments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained('visits')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('treatment_date');
            $table->string('treatment_type');
            $table->text('description');
            $table->text('notes')->nullable();
            $table->string('teeth_area')->nullable();
            $table->enum('status', ['planned', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
```

## Repository Pattern

Per standardizzare l'accesso ai dati, implementeremo il Repository Pattern:

### Interfaccia Repository Base

```php
// Modules/Xot/app/Repositories/RepositoryInterface.php
namespace Modules\Xot\app\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;
    public function create(array $data): Model;
    public function update(array $data, int $id): Model;
    public function delete(int $id): bool;
    public function find(int $id, array $columns = ['*']): ?Model;
    public function findBy(string $field, $value, array $columns = ['*']): ?Model;
    public function findOrFail(int $id, array $columns = ['*']): Model;
}
```

### Implementazione Repository Base

```php
// Modules/Xot/app/Repositories/BaseRepository.php
namespace Modules\Xot\app\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    public function findBy(string $field, $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, $value)->first($columns);
    }

    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }
}
```

### Repository specifico per Patient

```php
// Modules/Patient/app/Repositories/PatientRepository.php
namespace Modules\Patient\app\Repositories;

use Modules\Patient\app\Models\Patient;
use Modules\Xot\app\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class PatientRepository extends BaseRepository
{
    public function __construct(Patient $model)
    {
        parent::__construct($model);
    }

    public function findByTaxCode(string $taxCode): ?Patient
    {
        return $this->model->where('tax_code', $taxCode)->first();
    }

    public function findActivePatients(): Collection
    {
        return $this->model->where('status', 'active')->get();
    }

    public function findPregnantPatients(): Collection
    {
        return $this->model
            ->whereNotNull('pregnancy_week')
            ->whereNotNull('estimated_delivery_date')
            ->get();
    }
}
```

## Service Layer

Il Service Layer implementerà la business logic dell'applicazione:

### Service Base

```php
// Modules/Xot/app/Services/BaseService.php
namespace Modules\Xot\app\Services;

use Modules\Xot\app\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $columns);
    }

    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->repository->find($id, $columns);
    }

    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->repository->findOrFail($id, $columns);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(array $data, int $id): Model
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
```

### Patient Service

```php
// Modules/Patient/app/Services/PatientService.php
namespace Modules\Patient\app\Services;

use Modules\Patient\app\Repositories\PatientRepository;
use Modules\Xot\app\Services\BaseService;
use Modules\Patient\app\Models\Patient;
use Illuminate\Support\Collection;

class PatientService extends BaseService
{
    protected PatientRepository $repository;

    public function __construct(PatientRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function createPatient(array $data): Patient
    {
        // Generare codice paziente automaticamente
        if (!isset($data['code'])) {
            $data['code'] = $this->generateUniqueCode();
        }

        // Logica di business per la creazione del paziente
        return $this->repository->create($data);
    }

    public function findByTaxCode(string $taxCode): ?Patient
    {
        return $this->repository->findByTaxCode($taxCode);
    }

    public function getActivePatients(): Collection
    {
        return $this->repository->findActivePatients();
    }

    public function getPregnantPatients(): Collection
    {
        return $this->repository->findPregnantPatients();
    }

    private function generateUniqueCode(): string
    {
        $prefix = 'PT';
        $code = $prefix . date('Ymd') . rand(1000, 9999);
        
        // Verifica che il codice non esista già
        while ($this->repository->findBy('code', $code)) {
            $code = $prefix . date('Ymd') . rand(1000, 9999);
        }
        
        return $code;
    }
}
```

## Factory per Testing

Le factory verranno utilizzate per popolare il database durante i test:

### Patient Factory

```php
// Modules/Patient/database/factories/PatientFactory.php
namespace Modules\Patient\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Patient\app\Models\Patient;
use Modules\User\app\Models\User;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['F', 'M', 'O']);
        $isPregnant = $gender === 'F' ? $this->faker->boolean(30) : false;

        return [
            'code' => 'PT' . $this->faker->unique()->numerify('########'),
            'first_name' => $this->faker->firstName($gender === 'F' ? 'female' : 'male'),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date('Y-m-d', '-18 years'),
            'gender' => $gender,
            'tax_code' => $this->faker->unique()->regexify('[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'province' => $this->faker->regexify('[A-Z]{2}'),
            'postal_code' => $this->faker->numerify('#####'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'user_id' => User::factory(),
            'pregnancy_week' => $isPregnant ? $this->faker->numberBetween(1, 40) : null,
            'estimated_delivery_date' => $isPregnant ? $this->faker->dateTimeBetween('now', '+7 months') : null,
            'notes' => $this->faker->optional(0.7)->paragraph(),
        ];
    }

    public function pregnant(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => 'F',
                'pregnancy_week' => $this->faker->numberBetween(1, 40),
                'estimated_delivery_date' => $this->faker->dateTimeBetween('now', '+7 months'),
            ];
        });
    }

    public function active(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
            ];
        });
    }
}
```

## Validazione Dati

Per implementare una validazione robusta dei dati, creeremo Request personalizzate:

### Patient Request

```php
// Modules/Patient/app/Http/Requests/StorePatientRequest.php
namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:F,M,O'],
            'tax_code' => ['required', 'string', 'size:16', 'unique:patients,tax_code'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:2'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'pregnancy_week' => ['nullable', 'integer', 'min:1', 'max:45'],
            'estimated_delivery_date' => ['nullable', 'date', 'after:today'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Il nome è obbligatorio',
            'last_name.required' => 'Il cognome è obbligatorio',
            'birth_date.required' => 'La data di nascita è obbligatoria',
            'birth_date.before' => 'La data di nascita deve essere anteriore a oggi',
            'gender.required' => 'Il genere è obbligatorio',
            'tax_code.required' => 'Il codice fiscale è obbligatorio',
            'tax_code.size' => 'Il codice fiscale deve essere di 16 caratteri',
            'tax_code.unique' => 'Questo codice fiscale è già registrato nel sistema',
            'email.email' => 'Inserire un indirizzo email valido',
            'pregnancy_week.min' => 'La settimana di gravidanza non può essere inferiore a 1',
            'pregnancy_week.max' => 'La settimana di gravidanza non può essere superiore a 45',
            'estimated_delivery_date.after' => 'La data presunta di parto deve essere successiva a oggi',
        ];
    }
}
```

## Prossimi Passi per la Gestione Dati

1. **Implementazione dei modelli**: Creare tutti i modelli necessari secondo le specifiche sopra definite
2. **Migrazioni**: Implementare le migrazioni per creare le tabelle nel database
3. **Repository Pattern**: Implementare i repository per standardizzare l'accesso ai dati
4. **Service Layer**: Sviluppare i service che contengono la business logic
5. **Validazione**: Creare request personalizzate per validare i dati in input
6. **Factory e Seeder**: Implementare factory e seeder per popolare il database con dati di test
7. **Test**: Creare test automatizzati per verificare il corretto funzionamento dei modelli e della business logic

I passaggi successivi saranno l'implementazione dell'interfaccia utente (Fase 3) e delle funzionalità di reporting (Fase 4).

## 4. Protezione Dati Sensibili e Conformità GDPR

La conformità al GDPR è un requisito fondamentale del sistema il progetto. Implementeremo un modulo GDPR completo che fornirà tutte le funzionalità necessarie per garantire la protezione dei dati personali e sensibili.

### 4.1 Architettura del Modulo GDPR

Il modulo GDPR sarà responsabile della gestione dei consensi, della pseudonimizzazione dei dati, del diritto all'oblio e del tracciamento delle attività sui dati sensibili.

#### 4.1.1 Struttura del modulo

```
Modules/GDPR/
├── Actions/
│   ├── AnonymizeUserDataAction.php
│   ├── ExportUserDataAction.php
│   ├── ProcessRightToBeForgettenAction.php
│   └── ValidateConsentAction.php
├── Config/
│   └── gdpr.php
├── Console/
│   └── Commands/
│       ├── PurgeExpiredDataCommand.php
│       └── RotateEncryptionKeysCommand.php
├── Database/
│   ├── Migrations/
│   │   ├── create_consents_table.php
│   │   ├── create_data_retention_policies_table.php
│   │   └── create_data_access_logs_table.php
│   └── Seeders/
│       └── GdprSeeder.php
├── Enums/
│   ├── ConsentType.php
│   ├── DataCategory.php
│   └── DataRetentionPeriod.php
├── Http/
│   ├── Controllers/
│   │   ├── ConsentController.php
│   │   └── DataSubjectRightsController.php
│   └── Middleware/
│       ├── EnsureConsentMiddleware.php
│       └── LogDataAccessMiddleware.php
├── Models/
│   ├── Consent.php
│   ├── DataAccessLog.php
│   └── DataRetentionPolicy.php
├── Providers/
│   └── GdprServiceProvider.php
├── Resources/
│   ├── lang/
│   └── views/
│       ├── consent-forms/
│       ├── data-subject-requests/
│       └── settings/
├── Services/
│   ├── ConsentService.php
│   ├── DataProtectionService.php
│   └── EncryptionService.php
└── Traits/
    ├── HasConsents.php
    ├── IsDataSubject.php
    └── LogsDataAccess.php
```