# UserFactory Integration - Modulo User e SaluteOra

## Overview

Questo documento descrive l'integrazione tra la `UserFactory` del modulo SaluteOra e la base `BaseUser` del modulo User, evidenziando l'architettura Single Table Inheritance (STI) implementata con Parental.

## Architettura STI

### Gerarchia dei Modelli

```php
BaseUser (Modules\User\Models\BaseUser)
├── User (Modules\SaluteOra\Models\User) - Base for STI
    ├── Patient (Modules\SaluteOra\Models\Patient) - uses HasParent
    ├── Doctor (Modules\SaluteOra\Models\Doctor) - uses HasParent  
    └── Admin (Modules\SaluteOra\Models\Admin) - uses HasParent
```

### Database Connection Strategy

```php
// BaseUser (Modulo User)
protected $connection = 'user'; // Default connection

// User (Modulo SaluteOra) 
protected $connection = 'salute_ora'; // Override for healthcare domain
```

## Trait Distribution

### Modulo User (BaseUser)
Fornisce i trait base condivisi:

```php
// In BaseUser
use HasFactory;           // Laravel factory support
use Notifiable;          // Laravel notifications
use HasApiTokens;        // API authentication
use HasTeams;            // Team management
use HasRoles;            // Permission management
use HasAuthenticationLogTrait; // Authentication logging
```

### Modulo SaluteOra (User)
Aggiunge trait specifici per il dominio sanitario:

```php
// In SaluteOra\Models\User
use LogsActivity;        // Spatie Activity Log
use HasStates;           // Spatie Model States
use HasGdpr;             // GDPR compliance
use InteractsWithMedia;  // Spatie Media Library
```

### STI Children (Patient, Doctor, Admin)
Usano solo il trait necessario per STI:

```php
// In Patient, Doctor, Admin
use HasParent;           // Parental STI support
// InteractsWithMedia per Patient e Doctor (documents)
```

## Factory Strategy

### Factory Ownership

La `UserFactory` è implementata **nel modulo SaluteOra** perché:

1. **Domain Specificity**: I dati sono specifici del dominio sanitario
2. **Enum Integration**: Usa `UserTypeEnum` e `UserState` del modulo SaluteOra
3. **Business Logic**: Gestisce logica sanitaria (ISEE, pregnancy, certifications)
4. **Connection Override**: Usa database 'salute_ora'

### Integration Pattern

```php
// Factory nel modulo SaluteOra
namespace Modules\SaluteOra\Database\Factories;

class UserFactory extends Factory
{
    protected $model = \Modules\SaluteOra\Models\User::class;
    
    // Genera dati compatibili con tutti i modelli della gerarchia
    public function definition(): array
    {
        return [
            // Campi BaseUser (dal modulo User)
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            
            // Campi User SaluteOra (specifici dominio)
            'type' => UserTypeEnum::PATIENT,
            'state' => Pending::class,
            'is_active' => true,
            
            // Campi sanitari specifici
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'gender' => $this->faker->randomElement(['M', 'F', 'Other']),
            // ...
        ];
    }
}
```

## Type-Specific Data Generation

### Patient-Specific Data

```php
public function patient(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::PATIENT,
        
        // Dati anagrafici
        'fiscal_code' => $this->generateItalianFiscalCode(),
        'nationality' => 'Italian',
        
        // Dati sanitari
        'dental_problems' => $this->faker->optional()->sentence(),
        'last_dental_visit' => $this->faker->optional()->dateTimeBetween('-2 years'),
        
        // Dati socio-economici
        'family_members' => $this->faker->numberBetween(1, 6),
        'children_count' => $this->faker->numberBetween(0, 4),
        'years_in_italy' => $this->faker->numberBetween(0, 50),
    ]);
}
```

### Doctor-Specific Data

```php
public function doctor(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::DOCTOR,
        
        // Dati professionali
        'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
        'status' => 'active',
        
        // Specializzazioni odontoiatriche
        'certifications' => [
            'odontoiatria_generale' => true,
            'ortodonzia' => $this->faker->boolean(30),
            'implantologia' => $this->faker->boolean(20),
            'endodonzia' => $this->faker->boolean(25),
        ],
    ]);
}
```

### Admin-Specific Data

```php
public function admin(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::ADMIN,
        'state' => Active::class, // Admin sono sempre attivi
    ]);
}
```

## Cross-Module Compatibility

### Field Mapping

| BaseUser (User Module) | SaluteOra User | Usage |
|------------------------|----------------|-------|
| `name` | `name` | Full name compatibility |
| `email` | `email` | Authentication |
| `password` | `password` | Authentication |
| `email_verified_at` | `email_verified_at` | Email verification |
| `remember_token` | `remember_token` | Session management |
| N/A | `type` | STI discriminator |
| N/A | `state` | Model States |
| N/A | `first_name`, `last_name` | Detailed naming |
| N/A | Healthcare fields | Domain-specific |

### Cast Compatibility

```php
// BaseUser (User Module) - Generic casts
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

// SaluteOra User - Domain-specific casts
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => UserTypeEnum::class,       // STI discriminator
        'state' => UserState::class,         // Model States
        'certifications' => 'array',         // Professional data
        'moderation_data' => 'array',        // GDPR compliance
    ]);
}
```

## Factory Usage Patterns

### Basic User Creation

```php
// Creates a basic patient (default)
$user = User::factory()->create();

// Creates specific user types
$patient = User::factory()->patient()->create();
$doctor = User::factory()->doctor()->create();
$admin = User::factory()->admin()->create();
```

### Business Logic Testing

```php
// Healthcare-specific scenarios
$pregnantPatient = User::factory()
    ->patient()
    ->pregnant()
    ->create();

$eligiblePatient = User::factory()
    ->patient()
    ->eligibleForFreeServices()
    ->create();

$specialistDoctor = User::factory()
    ->doctor()
    ->active()
    ->withCertifications()
    ->create();
```

### State Management Testing

```php
// Test state transitions
$user = User::factory()->pending()->create();
$user->state->transitionTo(IntegrationRequested::class);
$user->state->transitionTo(Active::class);

expect($user->isActive())->toBeTrue();
```

## Best Practices

### 1. Modular Design

- **BaseUser**: Campi generici per autenticazione e autorizzazione
- **SaluteOra User**: Campi specifici del dominio sanitario
- **STI Children**: Campi altamente specializzati per tipo

### 2. Factory Responsibility

- **UserFactory in SaluteOra**: Genera dati completi per testing del dominio
- **Compatibility**: Rispetta i vincoli del BaseUser del modulo User
- **Extensibility**: Facilmente estendibile per nuovi tipi di utente

### 3. Testing Strategy

```php
// Test che BaseUser contracts siano rispettati
public function test_base_user_compatibility()
{
    $user = User::factory()->create();
    
    // Test authentication contracts
    expect($user->email)->toBeString();
    expect($user->password)->toBeString();
    expect($user->email_verified_at)->toBeNull()->or->toBeInstanceOf(Carbon::class);
}

// Test che STI funzioni correttamente
public function test_sti_functionality()
{
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    
    expect($patient)->toBeInstanceOf(Patient::class);
    expect($doctor)->toBeInstanceOf(Doctor::class);
    expect($patient->type)->toBe(UserTypeEnum::PATIENT);
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
}
```

### 4. Performance Considerations

```php
// Bulk creation con STI
public function test_bulk_sti_creation()
{
    // Efficiente: crea tutti nella stessa tabella
    $users = collect([
        ...User::factory()->patient()->count(50)->make(),
        ...User::factory()->doctor()->count(20)->make(),
        ...User::factory()->admin()->count(5)->make(),
    ]);
    
    User::insert($users->toArray());
    
    expect(User::count())->toBe(75);
    expect(Patient::count())->toBe(50);
    expect(Doctor::count())->toBe(20);
    expect(Admin::count())->toBe(5);
}
```

## Integration Benefits

### 1. Code Reuse
- Riutilizzo di tutta la logica di BaseUser
- Factory estende le funzionalità base senza duplicazioni
- Trait distribution ottimizzata

### 2. Domain Separation
- Modulo User: Generics per autenticazione/autorizzazione
- Modulo SaluteOra: Specifics per dominio sanitario
- Clear boundaries e responsibilities

### 3. Testing Flexibility
- Test generici nel modulo User
- Test specifici sanitari nel modulo SaluteOra
- Factory supporta entrambi i livelli

### 4. Maintenance
- Changes al BaseUser automaticamente ereditati
- Healthcare-specific changes isolati nel modulo SaluteOra
- Factory evolution indipendente

## Links to Documentation

### SaluteOra Module
- [UserFactory Improvements Analysis](../SaluteOra/docs/factories/UserFactory-improvements-analysis.md)
- [Model Architecture](../SaluteOra/docs/model-architecture.md)
- [STI Implementation](../SaluteOra/docs/model-inheritance.md)

### User Module
- [BaseUser Documentation](../User/docs/baseuser_conflicts.md)
- [Traits Complete Guide](../User/docs/traits_complete_guide.md)
- [Authentication Framework](../User/docs/authentication.md)

---

**Created**: January 2025  
**Purpose**: Document cross-module factory integration  
**Maintainer**: Development Team  
**Review Status**: Ready for implementation 