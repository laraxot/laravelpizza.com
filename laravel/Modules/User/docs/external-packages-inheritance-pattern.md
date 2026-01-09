# Pattern di Ereditarietà per Pacchetti Esterni

## 📋 Panoramica

Questo documento descrive il pattern corretto per estendere modelli di pacchetti esterni (Spatie, Laravel, etc.) invece di estendere `BaseModel`.

## 🎯 Principio Fondamentale

**Quando un pacchetto esterno fornisce un modello completo con logica interna complessa, estendere direttamente quel modello, NON `BaseModel`.**

## ✅ Casi Corretti Attuali

### 1. Permission e Role (Spatie Permission)

**File**: `Modules/User/app/Models/Permission.php` e `Modules/User/app/Models/Role.php`

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Modules\Xot\Models\Traits\RelationX;

class Permission extends SpatiePermission
{
    use RelationX;

    /** @var string */
    protected $connection = 'user';

    // Solo aggiunte specifiche del modulo
    // MAI sovrascrivere metodi core Spatie
}
```

**Perché**:
- Spatie Permission è un ecosistema completo con logica interna complessa
- Estendere `BaseModel` creerebbe conflitti imprevedibili
- Spatie ha propri test e garanzie che verrebbero invalidate

### 2. BaseUser (Laravel Authenticatable)

**File**: `Modules/User/app/Models/BaseUser.php`

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class BaseUser extends Authenticatable implements UserContract
{
    // Caso speciale: autenticazione richiede Authenticatable
}
```

**Perché**:
- Laravel richiede `Authenticatable` per l'autenticazione
- È un caso speciale architetturale, non un modello business

## ❌ Casi da Evitare

### Violazione: Estendere BaseModel per Classi Esterne

```php
// ❌ VIETATO
use Spatie\Permission\Models\Permission;

class Permission extends BaseModel  // ERESIA ARCHITETTURALE
{
    // Conflitto tra logica Spatie e logica Laraxot
}
```

**Problemi**:
1. Conflitti tra logiche diverse
2. Upgrade impossibile del pacchetto esterno
3. Test complessi e bug subdoli
4. Documentazione confusa

## 📐 Pattern Standard

### 1. Import con Alias Esplicito

```php
// ✅ CORRETTO
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;

// ❌ ERRATO (quando si estende)
use Spatie\Permission\Models\Permission;  // Confuso
```

### 2. Estensione Diretta

```php
class Permission extends SpatiePermission
{
    // Solo enhancement, mai sovrascritture core
}
```

### 3. Configurazione Minima

```php
protected $connection = 'user';  // Solo connection specifica

// NON sovrascrivere metodi core
// NON aggiungere traits in conflitto
// NON modificare la logica principale
```

### 4. Enhancement con Traits

```php
use RelationX;  // ✅ OK - Enhancement Laraxot
// MAI traits che modificano comportamento core
```

## 🔍 Come Identificare Casi Simili

**Domande da Porsi**:

1. Il pacchetto esterno fornisce un modello completo?
2. Il modello ha logica interna complessa?
3. Il pacchetto ha propri test e garanzie?
4. Estendere `BaseModel` creerebbe conflitti?

**Se tutte le risposte sono SÌ** → Estendere classe esterna con alias

**Se NO** → Usare `BaseModel` e aggiungere trait del pacchetto

## 📚 Riferimenti

- [Filosofia Spatie Permission](./spatie-permission-philosophy.md)
- [Architettura Modelli](../Xot/docs/models/model-architecture.md)
- [Regole Critiche Architettura](../Xot/docs/critical-architecture-rules.md)

---

*Pattern verificato e documentato: 2025-01-XX*
