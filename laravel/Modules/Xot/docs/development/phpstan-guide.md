# Guida PHPStan - Modulo Xot

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Configurazione Unica:** Una sola configurazione PHPStan per tutto il sistema
- **Template Standardizzati:** Strutture uniformi per tutte le classi
- **Regole Centralizzate:** Regole comuni in un unico posto

### **KISS (Keep It Simple, Stupid)**
- **Configurazione Semplice:** Impostazioni essenziali e chiare
- **Livelli Progressivi:** Avanzamento graduale dei livelli
- **Errori Gestibili:** Risoluzione sistematica dei problemi

## 📊 Livelli PHPStan

### **Livello 9 (Minimo Richiesto)**
- Tipizzazione esplicita per tutti i metodi
- PHPDoc completo per proprietà e metodi
- Gestione corretta dei tipi nullable

### **Livello 10 (Target)**
- Tipizzazione generics per collezioni
- Annotazioni avanzate per relazioni
- Controlli di tipo più rigorosi

## 🔧 Configurazione PHPStan

### **1. File di Configurazione**
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
    checkMissingCallableSignature: true
    checkUnusedFunctionParameters: true
```

### **2. Esecuzione Comando**
```bash
# Esecuzione dalla root del progetto Laravel
cd /var/www/html/_bases/base_ptvx_fila3_mono/laravel

# Analisi modulo specifico
./vendor/bin/phpstan analyze Modules/Xot --level=9

# Analisi completa
./vendor/bin/phpstan analyze Modules --level=9 --memory-limit=2G
```

## 📝 Tipizzazione Richiesta

### **1. Tipi di Ritorno Espliciti**
```php
// ✅ CORRETTO
public function getUserData(): array
{
    return $this->data;
}

// ❌ ERRATO
public function getUserData() // Manca tipo di ritorno
{
    return $this->data;
}
```

### **2. Tipi Parametri Espliciti**
```php
// ✅ CORRETTO
public function processUser(int $id, string $name): void
{
    // ...
}

// ❌ ERRATO
public function processUser($id, $name): void // Manca tipizzazione parametri
{
    // ...
}
```

### **3. PHPDoc Completo**
```php
/**
 * Get user by ID.
 *
 * @param int $id
 * @return UserModel|null
 */
public function getUserById(int $id): ?UserModel
{
    return UserModel::find($id);
}
```

## 🚫 Errori Comuni e Soluzioni

### **1. Undefined Property**
```php
// ❌ ERRATO
class UserModel extends BaseModel
{
    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name; // first_name non definito
    }
}

// ✅ CORRETTO
/**
 * @property string $first_name
 * @property string $last_name
 */
class UserModel extends BaseModel
{
    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
```

### **2. Missing Return Type**
```php
// ❌ ERRATO
public function calculateScore()
{
    return $this->points * 2;
}

// ✅ CORRETTO
public function calculateScore(): int
{
    return $this->points * 2;
}
```

### **3. Method Not Found**
```php
// ❌ ERRATO
use Modules\User\Models\User; // Namespace errato

// ✅ CORRETTO
use Modules\User\Models\User; // Namespace corretto
```

## 🔗 Collegamenti

- [Architettura Modulo Xot](../core/architecture.md)
- [Convenzioni di Naming](../core/naming-conventions.md)
- [Best Practices Sistema](../../../docs/core/best-practices.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
