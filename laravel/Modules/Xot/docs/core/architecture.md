# Architettura Modulo Xot

## 🏗️ Panoramica Architetturale

Il modulo Xot è il **core del sistema Laraxot** che fornisce classi base e funzionalità comuni per tutti gli altri moduli.

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Classe Base Unica:** Ogni modulo estende solo il proprio BaseModel
- **Service Provider Centralizzati:** Funzionalità comuni in XotBaseServiceProvider
- **Template Standardizzati:** Strutture uniformi per tutti i moduli

### **KISS (Keep It Simple, Stupid)**
- **Ereditarietà Lineare:** Struttura semplice e prevedibile
- **Convenzioni Uniche:** Una sola convenzione per tutto il sistema
- **Interfacce Minimali:** Solo i metodi essenziali nelle classi base

## 🏛️ Struttura delle Classi Base

### **XotBaseModel**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;

abstract class XotBaseModel extends Model
{
    // Funzionalità comuni per tutti i modelli del sistema
}
```

### **XotBaseResource**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;

abstract class XotBaseResource extends Resource
{
    // Funzionalità comuni per tutte le risorse Filament
}
```

### **XotBaseRelationManager**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

abstract class XotBaseRelationManager extends RelationManager
{
    // Funzionalità comuni per tutti i relation manager
}
```

### **XotBaseServiceProvider**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Illuminate\Support\ServiceProvider;

abstract class XotBaseServiceProvider extends ServiceProvider
{
    // Funzionalità comuni per tutti i service provider
}
```

## 🔄 Flusso di Ereditarietà

```
XotBaseModel → BaseModel (Modulo) → Modello concreto
XotBaseResource → Resource (Modulo) → Resource concreta
XotBaseRelationManager → RelationManager (Modulo) → RelationManager concreto
XotBaseServiceProvider → ServiceProvider (Modulo) → ServiceProvider concreto
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
├── services/        # Logica di business
├── actions/         # Azioni specifiche
├── traits/          # Trait e comportamenti
├── notifications/   # Notifiche e avvisi
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
            "Modules\\Xot\\": "Modules/Xot/"
        }
    }
}
```

### **2. Service Provider Registration**
```php
// config/app.php
'providers' => [
    // ...
    Modules\Xot\Providers\XotServiceProvider::class,
],
```

### **3. Configurazione Modulo**
```php
// Modules/Xot/config/config.php
return [
    'name' => 'Xot Core Module',
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
