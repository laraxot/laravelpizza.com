# Struttura del Database

## Tabelle Principali

### users
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->foreignId('tenant_id')->nullable();
    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();
});
```

### tenants
```php
Schema::create('tenants', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->string('province')->nullable();
    $table->string('postal_code')->nullable();
    $table->string('vat_number')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});
```

### patients
```php
Schema::create('patients', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id');
    $table->string('fiscal_code')->unique();
    $table->string('name');
    $table->string('surname');
    $table->date('birth_date');
    $table->string('birth_place');
    $table->string('gender');
    $table->string('address');
    $table->string('city');
    $table->string('province');
    $table->string('postal_code');
    $table->string('phone')->nullable();
    $table->string('email')->nullable();
    $table->decimal('isee', 10, 2)->nullable();
    $table->date('isee_expiry')->nullable();
    $table->boolean('is_pregnant')->default(false);
    $table->date('pregnancy_start_date')->nullable();
    $table->date('expected_delivery_date')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### visits
```php
Schema::create('visits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id');
    $table->foreignId('patient_id');
    $table->foreignId('doctor_id');
    $table->dateTime('visit_date');
    $table->string('visit_type');
    $table->text('anamnesis')->nullable();
    $table->text('clinical_examination')->nullable();
    $table->text('diagnosis')->nullable();
    $table->text('treatment_plan')->nullable();
    $table->text('notes')->nullable();
    $table->json('dental_status')->nullable();
    $table->json('treatment_data')->nullable();
    $table->boolean('is_completed')->default(false);
    $table->timestamps();
    $table->softDeletes();
});
```

### medical_files
```php
Schema::create('medical_files', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id');
    $table->foreignId('patient_id');
    $table->foreignId('visit_id')->nullable();
    $table->string('file_name');
    $table->string('file_path');
    $table->string('file_type');
    $table->integer('file_size');
    $table->string('mime_type');
    $table->text('description')->nullable();
    $table->date('expiry_date')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### consents
```php
Schema::create('consents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id');
    $table->foreignId('patient_id');
    $table->string('purpose');
    $table->text('description');
    $table->boolean('is_accepted');
    $table->string('ip_address');
    $table->string('user_agent');
    $table->timestamp('accepted_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### audit_logs
```php
Schema::create('audit_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id');
    $table->foreignId('user_id')->nullable();
    $table->string('event');
    $table->string('auditable_type');
    $table->unsignedBigInteger('auditable_id');
    $table->json('old_values')->nullable();
    $table->json('new_values')->nullable();
    $table->string('url')->nullable();
    $table->string('ip_address')->nullable();
    $table->string('user_agent')->nullable();
    $table->timestamps();
});
```

## Relazioni

### Patient
```php
class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'fiscal_code',
        'name',
        'surname',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'isee',
        'isee_expiry',
        'is_pregnant',
        'pregnancy_start_date',
        'expected_delivery_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'isee_expiry' => 'date',
        'pregnancy_start_date' => 'date',
        'expected_delivery_date' => 'date',
        'is_pregnant' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function medicalFiles()
    {
        return $this->hasMany(MedicalFile::class);
    }

    public function consents()
    {
        return $this->hasMany(Consent::class);
    }
}
```

### Visit
```php
class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'doctor_id',
        'visit_date',
        'visit_type',
        'anamnesis',
        'clinical_examination',
        'diagnosis',
        'treatment_plan',
        'notes',
        'dental_status',
        'treatment_data',
        'is_completed',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'dental_status' => 'array',
        'treatment_data' => 'array',
        'is_completed' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medicalFiles()
    {
        return $this->hasMany(MedicalFile::class);
    }
}
```

## Indici e Ottimizzazioni

### Indici Principali
```php
// patients
$table->index(['tenant_id', 'fiscal_code']);
$table->index(['tenant_id', 'is_pregnant']);
$table->index('isee');

// visits
$table->index(['tenant_id', 'patient_id']);
$table->index(['tenant_id', 'doctor_id']);
$table->index('visit_date');

// medical_files
$table->index(['tenant_id', 'patient_id']);
$table->index(['tenant_id', 'visit_id']);
$table->index('expiry_date');
```

### Ottimizzazioni Query
```php
// Eager Loading
$patient = Patient::with(['visits', 'medicalFiles'])
    ->where('tenant_id', $tenantId)
    ->find($patientId);

// Chunking per operazioni massive
Patient::where('tenant_id', $tenantId)
    ->chunk(100, function ($patients) {
        foreach ($patients as $patient) {
            // Process patient
        }
    });
```

## Migrazioni e Seeding

### Comandi per l'Installazione
```bash

# Creare le migrazioni
php artisan make:migration create_tenants_table
php artisan make:migration create_patients_table
php artisan make:migration create_visits_table
php artisan make:migration create_medical_files_table
php artisan make:migration create_consents_table
php artisan make:migration create_audit_logs_table

# Eseguire le migrazioni
php artisan migrate

# Creare i seeder
php artisan make:seeder TenantSeeder
php artisan make:seeder PatientSeeder
php artisan make:seeder VisitSeeder

# Eseguire i seeder
php artisan db:seed
```

### Factory per i Test
```php
// PatientFactory.php
class PatientFactory extends Factory
{
    public function definition()
    {
        return [
            'tenant_id' => Tenant::factory(),
            'fiscal_code' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'birth_place' => $this->faker->city(),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'isee' => $this->faker->randomFloat(2, 0, 20000),
            'isee_expiry' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_pregnant' => $this->faker->boolean(),
            'pregnancy_start_date' => $this->faker->dateTimeBetween('-9 months', 'now'),
            'expected_delivery_date' => $this->faker->dateTimeBetween('now', '+9 months'),
        ];
    }
}
``` 

## Collegamenti tra versioni di database.md
* [database.md](docs/tecnico/database/database.md)
* [database.md](laravel/Modules/Xot/docs/install/database.md)
* [database.md](laravel/Modules/Tenant/docs/it/config/database.md)

