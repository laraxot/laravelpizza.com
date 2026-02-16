# 🏛️ PATTERN ESTENSIONE CLASSI VENDOR IN LARAXOT

## 📋 PRINCIPIO FONDAMENTALE

Quando si integra un pacchetto esterno (vendor) che fornisce modelli Eloquent, **NON si estende mai `BaseModel`**, ma si estende **direttamente la classe del vendor**.

## 🎯 ESEMPI NEL CODEBASE

### Spatie Permission (Modulo User)

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Modules\Xot\Models\Traits\RelationX;

class Permission extends SpatiePermission
{
    use RelationX;
    
    protected $connection = 'user';
    
    // Solo aggiunte specifiche del modulo
    // Nessuna sovrascrittura della logica Spatie core
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Modules\Xot\Models\Traits\RelationX;

class Role extends SpatieRole
{
    use HasFactory;
    use RelationX;
    
    protected $connection = 'user';
    protected $keyType = 'string';
    
    // Solo aggiunte specifiche del modulo
}
```

### Spatie Activity Log (Modulo Activity)

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Modules\Xot\Models\Traits\HasXotFactory;

class Activity extends SpatieActivity
{
    use HasXotFactory;
    
    protected $connection = 'activity';
}
```

### Spatie Media Library (Modulo Media)

```php
<?php

declare(strict_types=1);

namespace Modules\Media\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class Media extends SpatieMedia
{
    use HasXotFactory;
    use Updater;
    
    protected $connection = 'media';
}
```

### Spatie Database Mail Templates (Modulo Notify)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate implements MailTemplateInterface
{
    protected $connection = 'notify';
    
    // Implementazione interfaccia personalizzata
}
```

## 🧘 FILOSOFIA LARAXOT

### Principio: Separazione delle Responsabilità

1. **BaseModel** è per **modelli business domain-specific** del modulo
2. **Classi Vendor** sono per **funzionalità cross-cutting specializzate**
3. **Non si mescolano** per non violare la **Separazione delle Responsabilità**

### Scopo Profondo: Mantenere l'Integrità del Sistema

- **Pacchetti Vendor** hanno **ecosistemi completi** con logica interna complessa
- **BaseModel** aggiunge **comportamenti Laraxot specifici** (connection, traits, etc.)
- **Mescolare i due** crea **conflitti imprevedibili** e **bug subdoli**

## ⛩️ REGOLE OPERATIVE

### ✅ Cosa Fare

1. **Estendere direttamente la classe vendor** con alias esplicito
2. **Aggiungere solo traits Laraxot** (`RelationX`, `HasXotFactory`, `Updater`)
3. **Configurare connection specifica** del modulo
4. **Aggiungere metodi/relazioni specifiche** del dominio business
5. **Implementare interfacce personalizzate** se necessario

### ❌ Cosa NON Fare

1. **NON estendere BaseModel** quando si usa un vendor
2. **NON sovrascrivere metodi core** del pacchetto vendor
3. **NON aggiungere traits in conflitto** con la logica vendor
4. **NON modificare la logica principale** del vendor
5. **NON mescolare logiche** Laraxot e vendor

## 📝 PATTERN STANDARD

```php
<?php

declare(strict_types=1);

namespace Modules\[Module]\Models;

use Vendor\Package\Models\VendorModel as VendorModelAlias;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Models\Traits\HasXotFactory;

class CustomModel extends VendorModelAlias
{
    use RelationX;        // Opzionale: se serve RelationX
    use HasXotFactory;    // Opzionale: se serve factory
    
    /** @var string */
    protected $connection = '[module]';
    
    // Solo aggiunte specifiche del modulo
    // Nessuna sovrascrittura della logica vendor core
}
```

## 🔍 LISTA COMPLETA MODELLI VENDOR NEL CODEBASE

### Modulo User
- `Permission` → `Spatie\Permission\Models\Permission`
- `Role` → `Spatie\Permission\Models\Role`

### Modulo Activity
- `Activity` → `Spatie\Activitylog\Models\Activity`
- `Snapshot` → `Spatie\Activitylog\Models\Snapshot`
- `StoredEvent` → `Spatie\EventSourcing\StoredEvents\Models\StoredEvent`

### Modulo Media
- `Media` → `Spatie\MediaLibrary\MediaCollections\Models\Media`

### Modulo Notify
- `MailTemplate` → `Spatie\MailTemplates\Models\MailTemplate`

### Modulo Xot
- `BaseActivity` → `Spatie\Activitylog\Models\Activity` (classe base astratta)

## ✅ BENEFICI

1. **Stabilità**: Vendor rimane stabile e testato
2. **Manutenibilità**: Bug separati per dominio
3. **Upgradeability**: Vendor può essere aggiornato senza conflitti
4. **Testabilità**: Test separati per logiche separate
5. **Prevedibilità**: Comportamento coerente e documentato

## 🚨 CONSEGUENZE DELLA VIOLAZIONE

1. **Bug Imprevedibili**: Conflitti tra logiche diverse
2. **Upgrade Impossibile**: Vendor non può essere aggiornato
3. **Test Complessi**: Difficile isolare le cause dei bug
4. **Documentazione Confusa**: Comportamento non documentato
5. **Debito Tecnico**: Costo di manutenzione esponenziale

## 📚 RIFERIMENTI

- [Spatie Permission Philosophy](spatie-permission-philosophy.md)
- [BaseModel Philosophy](../Xot/docs/basemodel-philosophy.md)
- [External Package Integration](../Xot/docs/external-packages.md)
- [Class Responsibility Separation](../Xot/docs/class-responsibility.md)

---

*Questa è la Via Laraxot: Rispettare la natura di ogni cosa, non forzarla in forme innaturali.*

