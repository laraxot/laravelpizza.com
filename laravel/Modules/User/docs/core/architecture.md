# Architettura Modulo User

## 🏗️ Panoramica Architetturale

Il modulo User è il **modulo fondamentale** per la gestione degli utenti, autenticazione e autorizzazione nel sistema Laraxot.

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Classe Base Unica:** Ogni modello estende solo il proprio BaseModel
- **Service Provider Centralizzati:** Funzionalità comuni in XotBaseServiceProvider
- **Template Standardizzati:** Strutture uniformi per tutti i componenti

### **KISS (Keep It Simple, Stupid)**
- **Ereditarietà Lineare:** Struttura semplice e prevedibile
- **Convenzioni Uniche:** Una sola convenzione per tutto il sistema
- **Interfacce Minimali:** Solo i metodi essenziali nelle classi base

## 🏛️ Struttura delle Classi Base

### **BaseModel (Modulo User)**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    // Funzionalità specifiche per tutti i modelli del modulo User
}
```

### **User Model**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User model.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Team> $teams
 * @property-read Collection<int, Permission> $permissions
 */
class User extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get user teams.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Team>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withTimestamps();
    }

    /**
     * Get user permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Permission>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
```

## 🔄 Flusso di Ereditarietà

```
XotBaseModel → BaseModel (User) → User concreto
XotBaseResource → Resource (User) → UserResource concreta
XotBaseRelationManager → RelationManager (User) → RelationManager concreto
XotBaseServiceProvider → ServiceProvider (User) → UserServiceProvider concreto
```

## 📋 Regole di Implementazione

### **1. Estensione Obbligatoria**
- **MAI** estendere direttamente `Illuminate\Database\Eloquent\Model`
- **MAI** estendere direttamente `Filament\Resources\Resource`
- **SEMPRE** estendere le classi base appropriate del modulo

### **2. Naming Conventions**
- **File:** lowercase con hyphens (`user-model.md`)
- **Cartelle:** lowercase con hyphens (`filament-resources/`)
- **Classi:** PascalCase (`UserModel`)
- **Metodi:** camelCase (`getUserData`)

### **3. Struttura Standard**
```
app/
├── models/          # Modelli dati
├── services/        # Servizi business
├── actions/         # Azioni specifiche
├── traits/          # Trait e comportamenti
├── notifications/   # Notifiche
├── mail/            # Mail e comunicazioni
├── datas/           # DTO e oggetti dati
├── enums/           # Enum e costanti
├── view/            # View e componenti
├── http/            # Controller e middleware
├── console/         # Comandi console
└── providers/       # Service provider
```

## 🚫 Anti-pattern da Evitare

### **1. Estensione Diretta**
```php
// MAI fare questo
class User extends \Illuminate\Database\Eloquent\Model
{
    // ...
}
```

### **2. Duplicazione Funzionalità**
```php
// MAI duplicare funzionalità già presenti nelle classi base
class CustomUser extends BaseModel
{
    public function getTableName() // Già presente in XotBaseModel
    {
        return $this->table;
    }
}
```

### **3. Convenzioni Inconsistenti**
```php
// MAI usare convenzioni diverse
class UserModel extends BaseModel // ✅ Corretto
class user_model extends BaseModel // ❌ Sbagliato
```

## ✅ Best Practices

### **1. Utilizzo Classi Base**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\BaseModel;

class Profile extends BaseModel
{
    // Implementazione specifica del modulo User
}
```

### **2. Override Metodi Base**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\BaseModel;

class Profile extends BaseModel
{
    /**
     * Override del metodo base per personalizzazione
     */
    protected function getTableName(): string
    {
        return 'user_profiles';
    }
}
```

### **3. Estensione Funzionalità**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\BaseModel;

class Profile extends BaseModel
{
    /**
     * Nuova funzionalità specifica del modulo User
     */
    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
```

## 🔧 Configurazione e Setup

### **1. Autoload Composer**
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\User\\": "Modules/User/"
        }
    }
}
```

### **2. Service Provider Registration**
```php
// config/app.php
'providers' => [
    // ...
    Modules\User\Providers\UserServiceProvider::class,
],
```

### **3. Configurazione Modulo**
```php
// Modules/User/config/config.php
return [
    'name' => 'User Module',
    'version' => '1.0.0',
    // ...
];
```

## 📊 Metriche di Qualità

### **PHPStan Compliance**
- **Livello Minimo:** 9
- **Livello Target:** 10
- **Tipizzazione:** 100% esplicita
- **PHPDoc:** Completo per tutte le classi

### **Code Coverage**
- **Test Unitari:** 100% delle classi base
- **Test di Integrazione:** 100% delle funzionalità core
- **Test di Regressione:** Dopo ogni modifica

## 🔗 Collegamenti

- [Best Practices Sistema](../../../docs/core/best-practices.md)
- [Convenzioni Sistema](../../../docs/core/conventions.md)
- [Template Modulo](../../../docs/templates/module-template.md)
- [PHPStan Guide](../development/phpstan-guide.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
