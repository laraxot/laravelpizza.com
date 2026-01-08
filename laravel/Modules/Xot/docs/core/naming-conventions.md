# Convenzioni di Naming - Modulo Xot

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Convenzioni Uniche:** Una sola convenzione per tutto il sistema
- **Naming Standardizzato:** Regole uniformi in tutti i moduli
- **Eliminazione Ambiguità:** Nomi chiari e non confondibili

### **KISS (Keep It Simple, Stupid)**
- **Semplicità:** Nomi immediatamente comprensibili
- **Consistenza:** Pattern uniformi e prevedibili
- **Chiarezza:** Evitare abbreviazioni e acronimi oscuri

## 📁 Convenzioni per File e Cartelle

### **1. File di Documentazione**
```
✅ CORRETTO                    ❌ ERRATO
user-guide.md                 UserGuide.md
filament-resources.md         FilamentResources.md
phpstan-configuration.md      PHPStanConfiguration.md
naming-conventions.md         naming_conventions.md
```

### **2. Cartelle e Sottocartelle**
```
✅ CORRETTO                    ❌ ERRATO
filament-resources/           FilamentResources/
user-management/              UserManagement/
performance-evaluation/       PerformanceEvaluation/
mail-templates/               MailTemplates/
```

### **3. Struttura Standardizzata**
```
Modules/
├── Xot/                      # Modulo core
│   ├── docs/                 # Documentazione
│   │   ├── core/             # Architettura e convenzioni
│   │   ├── filament/         # Best practices Filament
│   │   ├── development/      # Guide sviluppo
│   │   ├── utils/            # Utilità e helper
│   │   └── templates/        # Template standardizzati
│   ├── app/                  # Codice applicazione
│   │   ├── models/           # Modelli dati
│   │   ├── services/         # Servizi business
│   │   ├── actions/          # Azioni specifiche
│   │   ├── traits/           # Trait e comportamenti
│   │   ├── notifications/    # Notifiche
│   │   ├── mail/             # Mail e comunicazioni
│   │   ├── datas/            # DTO e oggetti dati
│   │   ├── enums/            # Enum e costanti
│   │   ├── view/             # View e componenti
│   │   ├── http/             # Controller e middleware
│   │   ├── console/          # Comandi console
│   │   └── providers/        # Service provider
│   └── resources/            # Asset e risorse
│       ├── js/               # Script JavaScript
│       ├── lang/             # File traduzioni
│       └── views/            # Template Blade
```

## 🏷️ Convenzioni per Classi e Metodi

### **1. Naming Classi**
```php
✅ CORRETTO                    ❌ ERRATO
class UserModel               class user_model
class PerformanceEvaluation   class performance_evaluation
class MailTemplate           class MailTemplate
class XotBaseModel          class XotBaseModel
```

### **2. Naming Metodi**
```php
✅ CORRETTO                    ❌ ERRATO
public function getUserData() public function get_user_data()
public function calculateScore() public function calculate_score()
public function sendNotification() public function send_notification()
public function validateInput() public function validate_input()
```

### **3. Naming Proprietà**
```php
✅ CORRETTO                    ❌ ERRATO
protected $fillable           protected $fillable
protected $hidden             protected $hidden
protected $casts              protected $casts
protected $with               protected $with
```

## 🔤 Convenzioni per Namespace

### **1. Struttura Namespace**
```php
✅ CORRETTO                    ❌ ERRATO
namespace Modules\Xot\Models; namespace Modules\Xot\App\Models;
namespace Modules\User\Http\Controllers; namespace Modules\User\App\Http\Controllers;
namespace Modules\UI\Filament\Resources; namespace Modules\UI\App\Filament\Resources;
```

### **2. Import e Use Statements**
```php
✅ CORRETTO                    ❌ ERRATO
use Modules\Xot\Models\XotBaseModel; use App\Models\XotBaseModel;
use Modules\User\Models\User; use App\Models\User;
use Modules\UI\Filament\Resources\BaseResource; use App\Filament\Resources\BaseResource;
```

## 📝 Convenzioni per PHPDoc

### **1. Annotazioni Proprietà**
```php
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, RelatedModel> $relatedModels
 */
class UserModel extends BaseModel
{
    // ...
}
```

### **2. Annotazioni Metodi**
```php
/**
 * Get user data by ID.
 *
 * @param int $id
 * @return UserModel|null
 */
public function getUserById(int $id): ?UserModel
{
    // ...
}

/**
 * Get all active users.
 *
 * @return Collection<int, UserModel>
 */
public function getActiveUsers(): Collection
{
    // ...
}
```

### **3. Annotazioni Parametri**
```php
/**
 * Process user data.
 *
 * @param array<string, mixed> $data
 * @param bool $validate
 * @return UserModel
 */
public function processUserData(array $data, bool $validate = true): UserModel
{
    // ...
}
```

## 🚫 Anti-pattern da Evitare

### **1. Naming Inconsistente**
```php
// ❌ MAI mescolare convenzioni
class UserModel extends BaseModel
{
    public function get_user_data() // ❌ Underscore invece di camelCase
    {
        return $this->user_data; // ❌ Underscore invece di camelCase
    }
}
```

### **2. Abbreviazioni Oscure**
```php
// ❌ MAI usare abbreviazioni non chiare
class UsrMdl extends BaseModel // ❌ Usr = User, Mdl = Model
{
    public function getUsrData() // ❌ Usr = User
    {
        // ...
    }
}
```

### **3. Naming Non Descrittivo**
```php
// ❌ MAI usare nomi generici o non descrittivi
class Model extends BaseModel // ❌ Troppo generico
{
    public function get() // ❌ Non descrive cosa restituisce
    {
        // ...
    }
}
```

## ✅ Best Practices

### **1. Naming Descrittivo**
```php
// ✅ CORRETTO - Nomi chiari e descrittivi
class PerformanceEvaluation extends BaseModel
{
    public function calculateTotalScore(): float
    {
        // Calcola il punteggio totale
    }
    
    public function getEvaluatorName(): string
    {
        // Restituisce il nome del valutatore
    }
}
```

### **2. Consistenza nel Modulo**
```php
// ✅ CORRETTO - Consistenza in tutto il modulo
class UserProfile extends BaseModel
{
    public function getUserFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function getUserEmail(): string
    {
        return $this->email;
    }
}
```

### **3. Naming per Relazioni**
```php
// ✅ CORRETTO - Nomi chiari per le relazioni
class User extends BaseModel
{
    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }
    
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
    
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
```

## 🔧 Configurazione e Validazione

### **1. PHPStan Rules**
```neon
# phpstan.neon
parameters:
    level: 9
    paths:
        - Modules/Xot
    excludePaths:
        - Modules/Xot/docs
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
```

### **2. Composer Autoload**
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Xot\\": "Modules/Xot/"
        }
    }
}
```

### **3. IDE Configuration**
```json
// .vscode/settings.json
{
    "php.suggest.basic": false,
    "php.validate.enable": true,
    "php.validate.executablePath": "/usr/bin/php"
}
```

## 📊 Metriche di Qualità

### **1. Consistenza Naming**
- **File e Cartelle:** 100% lowercase con hyphens
- **Classi:** 100% PascalCase
- **Metodi:** 100% camelCase
- **Proprietà:** 100% camelCase

### **2. PHPStan Compliance**
- **Livello 9:** 100% delle classi
- **Livello 10:** Target per tutte le classi
- **Type Safety:** 100% esplicito
- **PHPDoc:** Completo per tutte le classi

## 🔗 Collegamenti

- [Architettura Modulo Xot](architecture.md)
- [Best Practices Sistema](../../../docs/core/best-practices.md)
- [Convenzioni Sistema](../../../docs/core/conventions.md)
- [PHPStan Guide](../development/phpstan-guide.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
