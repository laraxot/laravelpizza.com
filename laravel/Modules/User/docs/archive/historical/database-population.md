# Popolamento Database - Modulo User

## Panoramica

Questo documento descrive come popolare il database del modulo User utilizzando le factories e i seeders disponibili. Il popolamento è essenziale per:
- Testing e sviluppo
- Popolamento dati iniziali
- Generazione di dataset per performance testing
- Verifica della coerenza dei dati

## Factories Disponibili

### 1. UserFactory
**File**: `database/factories/UserFactory.php`
**Scopo**: Generazione di utenti base con dati realistici

```php
// Generazione singola
$user = \Modules\User\Models\User::factory()->create();

// Generazione multipla
$users = \Modules\User\Models\User::factory()->count(100)->create();

// Generazione con stato specifico
$admin = \Modules\User\Models\User::factory()->admin()->create();
$doctor = \Modules\User\Models\User::factory()->doctor()->create();
$patient = \Modules\User\Models\User::factory()->patient()->create();
```

**Campi Generati**:
- `name` - Nome completo generato con Faker
- `email` - Email unica e valida
- `password` - Password hashata (default: 'password')
- `email_verified_at` - Timestamp di verifica
- `type` - Tipo utente (admin, doctor, patient)
- `is_otp` - Flag per autenticazione OTP

### 2. RoleFactory
**File**: `database/factories/RoleFactory.php`
**Scopo**: Generazione di ruoli per il sistema di autorizzazione

```php
// Generazione ruolo base
$role = \Modules\User\Models\Role::factory()->create();

// Generazione con nome specifico
$adminRole = \Modules\User\Models\Role::factory()->create(['name' => 'admin']);
$doctorRole = \Modules\User\Models\Role::factory()->create(['name' => 'doctor']);
```

### 3. PermissionFactory
**File**: `database/factories/PermissionFactory.php`
**Scopo**: Generazione di permessi per il controllo degli accessi

```php
// Generazione permesso base
$permission = \Modules\User\Models\Permission::factory()->create();

// Generazione con guard specifico
$webPermission = \Modules\User\Models\Permission::factory()->create(['guard_name' => 'web']);
```

### 4. TeamFactory
**File**: `database/factories/TeamFactory.php`
**Scopo**: Generazione di team per organizzazioni multi-team

```php
// Generazione team base
$team = \Modules\User\Models\Team::factory()->create();

// Generazione con owner specifico
$team = \Modules\User\Models\Team::factory()->create([
    'owner_id' => $user->id
]);
```

### 5. TenantFactory
**File**: `database/factories/TenantFactory.php`
**Scopo**: Generazione di tenant per architettura multi-tenant

```php
// Generazione tenant base
$tenant = \Modules\User\Models\Tenant::factory()->create();

// Generazione con dominio specifico
$tenant = \Modules\User\Models\Tenant::factory()->create([
    'domain' => 'example.com'
]);
```

## Seeders Disponibili

### 1. UserDatabaseSeeder
**File**: `database/seeders/UserDatabaseSeeder.php`
**Scopo**: Seeder principale che coordina tutti gli altri seeders

```bash
# Esecuzione completa
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserDatabaseSeeder"
```

**Sequenza di Esecuzione**:
1. `RolesSeeder` - Crea ruoli base
2. `PermissionsSeeder` - Crea permessi base
3. `UserSeeder` - Crea utenti amministratori
4. `UserMassSeeder` - Crea dataset di test

### 2. UserSeeder
**File**: `database/seeders/UserSeeder.php`
**Scopo**: Creazione di utenti amministratori e di sistema

```bash
# Esecuzione singola
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserSeeder"
```

**Utenti Creati**:
- Super Admin (email: admin@example.com)
- System User (email: system@example.com)
- Test User (email: test@example.com)

### 3. RolesSeeder
**File**: `database/seeders/RolesSeeder.php`
**Scopo**: Creazione di ruoli standard del sistema

```bash
# Esecuzione singola
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\RolesSeeder"
```

**Ruoli Creati**:
- `super-admin` - Accesso completo al sistema
- `admin` - Amministratore modulo
- `doctor` - Dottore/operatore sanitario
- `patient` - Paziente
- `user` - Utente base

### 4. PermissionsSeeder
**File**: `database/seeders/PermissionsSeeder.php`
**Scopo**: Creazione di permessi base per il controllo degli accessi

```bash
# Esecuzione singola
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\PermissionsSeeder"
```

**Permessi Creati**:
- `view-users` - Visualizzazione utenti
- `create-users` - Creazione utenti
- `edit-users` - Modifica utenti
- `delete-users` - Eliminazione utenti
- `manage-roles` - Gestione ruoli
- `manage-permissions` - Gestione permessi

### 5. UserMassSeeder
**File**: `database/seeders/UserMassSeeder.php`
**Scopo**: Creazione di dataset massivi per testing e sviluppo

```bash
# Esecuzione singola
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserMassSeeder"
```

**Dataset Generati**:
- 100 utenti base
- 50 dottori
- 50 pazienti
- 25 amministratori
- Relazioni e team associati

## Utilizzo con Tinker

### Popolamento Rapido
```bash
php artisan tinker
```

```php
// Generazione utenti
\Modules\User\Models\User::factory()->count(100)->create();

// Generazione con relazioni
$users = \Modules\User\Models\User::factory()
    ->count(50)
    ->has(\Modules\User\Models\Profile::factory())
    ->create();

// Generazione team con utenti
$teams = \Modules\User\Models\Team::factory()
    ->count(10)
    ->has(\Modules\User\Models\User::factory()->count(5))
    ->create();

// Verifica dati generati
\Modules\User\Models\User::count(); // Dovrebbe essere > 100
\Modules\User\Models\Team::count(); // Dovrebbe essere > 10
```

### Generazione Dati Specifici
```php
// Utenti con tipo specifico
$doctors = \Modules\User\Models\User::factory()
    ->count(25)
    ->state(['type' => 'doctor'])
    ->create();

$patients = \Modules\User\Models\User::factory()
    ->count(75)
    ->state(['type' => 'patient'])
    ->create();

// Team con owner specifico
$user = \Modules\User\Models\User::factory()->create();
$team = \Modules\User\Models\Team::factory()->create([
    'owner_id' => $user->id
]);

// Relazioni team-user
$team->users()->attach($user);
```

## Best Practices

### 1. Generazione Dati
- Utilizzare sempre le factories invece di creare dati manualmente
- Verificare la coerenza dei dati generati con lo schema del database
- Utilizzare stati factory per varianti specifiche
- Generare relazioni in modo realistico

### 2. Performance
- Utilizzare `count()` per generare grandi quantità di dati
- Utilizzare `create()` per persistenza, `make()` per oggetti in memoria
- Considerare l'uso di `chunk()` per dataset molto grandi
- Monitorare l'uso della memoria durante la generazione

### 3. Testing
- Generare sempre dati di test con le factories
- Utilizzare stati factory per scenari specifici
- Verificare che i dati generati rispettino i vincoli del database
- Testare le relazioni tra modelli

### 4. Sicurezza
- Non utilizzare factories in produzione
- Verificare che i dati generati non contengano informazioni sensibili
- Utilizzare password sicure per utenti di test
- Verificare i permessi e i ruoli assegnati

## Troubleshooting

### Errori Comuni

#### 1. Violazione Vincoli Unici
```php
// ERRORE: Duplicate entry for key 'users_email_unique'
// SOLUZIONE: Utilizzare faker per email uniche
'email' => $this->faker->unique()->safeEmail(),
```

#### 2. Relazioni Mancanti
```php
// ERRORE: Foreign key constraint fails
// SOLUZIONE: Creare prima i modelli dipendenti
$user = \Modules\User\Models\User::factory()->create();
$team = \Modules\User\Models\Team::factory()->create([
    'owner_id' => $user->id
]);
```

#### 3. Campi Obbligatori
```php
// ERRORE: Column 'name' cannot be null
// SOLUZIONE: Verificare che tutti i campi obbligatori siano definiti
'name' => $this->faker->name(),
'email' => $this->faker->unique()->safeEmail(),
```

### Verifica Integrità
```php
// Controllo conteggi
echo "Users: " . \Modules\User\Models\User::count() . "\n";
echo "Teams: " . \Modules\User\Models\Team::count() . "\n";
echo "Roles: " . \Modules\User\Models\Role::count() . "\n";

// Controllo relazioni
$user = \Modules\User\Models\User::first();
echo "User teams: " . $user->teams()->count() . "\n";
echo "User roles: " . $user->roles()->count() . "\n";
```

## Collegamenti

- [README Modulo User](./README.md)
- [Factory Best Practices](./factory-best-practices.md)
- [Testing Guidelines](./testing.md)
- [Database Schema](./database-schema.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Autore**: Sistema Laraxot





