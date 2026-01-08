# Violazioni Architetturali e Correzioni - Pattern XotData

## 🚨 **Violazioni Architetturali Critiche**

### **Problema Identificato: Import Diretti tra Moduli**

Durante lo sviluppo è stata identificata una **violazione architetturale critica** nel `LoginTest.php` del modulo Cms:

```php
// ❌ VIOLAZIONE CRITICA
use Modules\SaluteOra\Models\User;

/** @var User $user */
$user = User::factory()->create([...]);
```

### **Perché è un Errore Grave**

1. **Accoppiamento Stretto**: Cms conosce SaluteOra → viola principio di disaccoppiamento
2. **Configurabilità Persa**: La classe User è **dinamica** e configurabile
3. **Multi-tenancy Rotta**: XotData supporta tenant con User diverse
4. **Pattern Ignorato**: XotData è il **core** dell'architettura Laraxot

## ✅ **Pattern Corretto: XotData Architecture**

### **Principio Fondamentale**
> **"Non fare mai riferimento diretto alla classe specifica di implementazione dell'utente"**

### **Implementazione Corretta**
```php
// ✅ ARCHITETTURA CORRETTA
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

// Risoluzione dinamica
$userClass = XotData::make()->getUserClass();

// Creazione tramite factory dinamica
/** @var UserContract */
$user = $userClass::factory()->create($attributes);
```

## 🏗️ **Architettura XotData Spiegata**

### **1. Configurabilità del Sistema**
```php
// config/auth.php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => \Modules\SaluteOra\Models\User::class, // CONFIGURABILE!
    ],
],
```

### **2. Risoluzione Dinamica XotData**
```php
public function getUserClass(): string
{
    $class = config('auth.providers.users.model');
    
    // Validazioni automatiche
    Assert::stringNotEmpty($class, 'check config auth');
    Assert::classExists($class, '['.$class.'] check config auth');
    Assert::implementsInterface($class, UserContract::class, '...');
    Assert::isAOf($class, Model::class, '...');

    return $class;
}
```

### **3. Multi-Tenancy e Tipi Utente**
```php
// Supporta diversi tipi di utente per progetto
$patientClass = XotData::make()->getUserClassByType('patient');
$doctorClass = XotData::make()->getUserClassByType('doctor');
$adminClass = XotData::make()->getUserClassByType('admin');
```

### **4. Contracts per Type Safety**
```php
// UserContract garantisce interfaccia comune
interface UserContract
{
    public function getKey();
    public function getAuthIdentifierName();
    public function getAuthIdentifier();
    // ... altri metodi essenziali
}
```

## 📋 **Regole di Implementazione**

### **Regola 1: Risoluzione Dinamica**
```php
// ✅ SEMPRE così
$userClass = XotData::make()->getUserClass();

// ❌ MAI così  
use Modules\SpecificModule\Models\User;
```

### **Regola 2: Type Hints con Contracts**
```php
// ✅ SEMPRE UserContract
public function processUser(UserContract $user): void

// ❌ MAI implementazione specifica
public function processUser(\Modules\SaluteOra\Models\User $user): void
```

### **Regola 3: Factory tramite XotData**
```php
// ✅ Factory dinamica
$userClass = XotData::make()->getUserClass();
$user = $userClass::factory()->create($attributes);

// ❌ Factory hardcoded
$user = User::factory()->create($attributes);
```

### **Regola 4: Safe Casting per Eloquent**
```php
// ✅ Cast sicuro per metodi Model
if ($user instanceof \Illuminate\Database\Eloquent\Model) {
    $user->refresh();
    $user->save();
}

// ❌ Chiamata diretta su Contract
$user->refresh(); // Error: UserContract non ha refresh()
```

## 🔧 **Helper Functions Raccomandati**

### **Test Helper Pattern**
```php
// Helper per ottenere classe User dinamicamente
function getUserClass(): string
{
    return XotData::make()->getUserClass();
}

// Helper per creare utenti nei test
function createTestUser(array $attributes = []): UserContract
{
    $userClass = getUserClass();
    
    $defaultAttributes = [
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password123'),
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
    ];
    
    $attributes = array_merge($defaultAttributes, $attributes);
    
    /** @var UserContract */
    $user = $userClass::factory()->create($attributes);
    
    return $user;
}
```

### **Action Pattern**
```php
class CreateUserAction
{
    public function execute(UserData $data): UserContract
    {
        $userClass = XotData::make()->getUserClass();
        
        /** @var UserContract */
        $user = $userClass::create([
            'name' => $data->name,
            'email' => $data->email,
        ]);
        
        return $user;
    }
}
```

## 🎯 **Esempi di Utilizzo Corretto**

### **1. Migrazioni con XotData**
```php
// XotBaseMigration usa XotData automaticamente
public function timestamps(Blueprint $table, bool $hasSoftDeletes = false): void
{
    $xot = XotData::make();
    $userClass = $xot->getUserClass();

    $table->timestamps();
    $table->foreignIdFor($userClass, 'user_id')->nullable();
    $table->foreignIdFor($userClass, 'updated_by')->nullable();
    $table->foreignIdFor($userClass, 'created_by')->nullable();
}
```

### **2. Relazioni con XotData**
```php
trait IsTenant
{
    public function users(): BelongsToMany
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        return $this->belongsToManyX($userClass, null, 'tenant_id', 'user_id');
    }
}
```

### **3. Commands con XotData**
```php
class ChangeTypeCommand extends Command
{
    public function handle(): void
    {
        $email = text('User email?');
        
        /** @var UserContract */
        $user = XotData::make()->getUserByEmail($email);
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return;
        }
        
        // Continua elaborazione...
    }
}
```

## ⚠️ **Errori da Evitare Assolutamente**

### **1. Import Diretti**
```php
// ❌ VIETATO
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;

// ✅ CONSENTITO
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
```

### **2. Hardcoding Classi**
```php
// ❌ VIETATO
$user = \Modules\SaluteOra\Models\User::find($id);

// ✅ CONSENTITO  
$userClass = XotData::make()->getUserClass();
$user = $userClass::find($id);
```

### **3. Type Hints Specifici**
```php
// ❌ VIETATO
function updateUser(\Modules\SaluteOra\Models\User $user): void

// ✅ CONSENTITO
function updateUser(UserContract $user): void
```

### **4. Factory Hardcoded**
```php
// ❌ VIETATO
User::factory()->create();

// ✅ CONSENTITO
$userClass = XotData::make()->getUserClass();
$userClass::factory()->create();
```

## 📊 **Benefits dell'Architettura XotData**

### **1. Flessibilità**
- Configurazione User dinamica per progetto
- Supporto multi-tenancy nativo
- Cambio implementazione senza impatto

### **2. Manutenibilità**
- Disaccoppiamento tra moduli
- Refactoring sicuro
- Test isolati per modulo

### **3. Scalabilità**
- Aggiunta nuovi tipi utente semplice
- Configurazioni specifiche per tenant
- Architettura modulare estendibile

### **4. Type Safety**
- Contratti garantiscono interfaccia
- Validazioni automatiche XotData
- PHPStan compliance migliorato

## 🔄 **Migration Plan per Codice Esistente**

### **Fase 1: Identificazione Violazioni**
```bash

# Cerca import diretti tra moduli
grep -r "use Modules\.*Models\User" --include="*.php" ./

# Cerca type hints specifici
grep -r "function.*\\\Modules\\\.*\\\Models\\\User" --include="*.php" ./
```

### **Fase 2: Sostituzione Pattern**
1. Sostituire import diretti con XotData
2. Cambiare type hints con UserContract  
3. Aggiornare factory calls
4. Implementare helper functions

### **Fase 3: Testing e Validazione**
1. Test che XotData risolve correttamente
2. Verify dei contratti implementati
3. PHPStan level 9+ compliance
4. Test di regressione

## 📚 **Link e Riferimenti**

### **Documentazione Core**
- [XotData API Reference](xotdata-api.md)
- [UserContract Specification](contracts/user-contract.md)  
- [Best Practices](best-practices.md)
- [Module Architecture](module-architecture.md)

### **Esempi Implementazione**
- [CreateUserAction](../app/Actions/Socialite/CreateUserAction.php)
- [XotBaseMigration](../app/Database/Migrations/XotBaseMigration.php)
- [IsTenant Trait](../../User/app/Models/Traits/IsTenant.php)

### **Documentazione Moduli**
- [Cms Architecture](../../Cms/project_docs/architecture-xotdata-pattern.md)
- [User Module Traits](../../User/project_docs/traits_complete_guide.md)
- [Testing Strategy](../../SaluteOra/project_docs/testing/real-data-testing-strategy.md)

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Stato**: ✅ Pattern Documentato e Implementato  
