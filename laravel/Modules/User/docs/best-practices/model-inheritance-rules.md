# Regole di Ereditarietà dei Modelli - Modulo User

**Data**: 2025-10-15
**Contesto**: Refactoring per garantire la corretta gerarchia di ereditarietà dei modelli

## Regola Fondamentale

**NESSUN modello all'interno dei moduli deve estendere `Illuminate\Database\Eloquent\Model` direttamente.**

Tutti i modelli devono estendere una delle seguenti classi base:

### Eccezione Obbligatoria: Spatie Permission/Role

Per mantenere allineata la logica interna di `spatie/laravel-permission` (registrazione delle policy, caching dei permessi, guard name dinamico, sincronizzazione delle pivot), **i modelli `Permission` e `Role` del modulo User DEVONO estendere direttamente le classi Spatie** usando alias espliciti:

```php
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;

class Permission extends SpatiePermission
{
    // connection/table override, factory, ecc.
}

class Role extends SpatieRole
{
    // connection/table override, regole multi-tenant, ecc.
}
```

> ⚠️ RAZIONALE: Estendere una classe custom (es. `BaseModel`) disattiva gli hook interni del pacchetto (registrazione cache, observer per `forgetCachedPermissions`, macro dei guard). Tutti i bug storici sul sync dei ruoli derivavano da questa violazione.

Quando servono personalizzazioni (connessione dedicata, factory Laraxot, relazioni aggiuntive), si usano **trait** e **override puntuali** mantenendo l'ereditarietà da Spatie.

### 1. BaseModel (per modelli standard)

I modelli Eloquent standard devono estendere `Modules\User\Models\BaseModel`:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * Tenant Model
 */
class Tenant extends BaseModel
{
    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'domain',
        'database',
        'is_active',
    ];
}
```

**Quando usare**: Modelli che rappresentano entità di business con proprie tabelle nel database.

**Esempi corretti**:
- `Tenant extends BaseModel` ✅
- `Team extends BaseModel` ✅
- `SsoProvider extends BaseModel` ✅
- `Authentication extends BaseModel` ✅

### 2. BasePivot (per tabelle pivot)

I modelli che rappresentano tabelle pivot (molti-a-molti) devono estendere `Modules\User\Models\BasePivot`:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * TeamUser Pivot Model
 */
class TeamUser extends BasePivot
{
    protected $table = 'team_user';

    protected $fillable = [
        'team_id',
        'user_id',
        'role',
    ];
}
```

**Quando usare**: Tabelle che collegano due modelli in una relazione molti-a-molti.

**Come riconoscerle**:
- Nome tabella di solito è `model1_model2` (es. `team_user`, `tenant_user`)
- Contiene almeno due foreign keys
- Può avere colonne aggiuntive (es. `role`, `permissions`)

**Esempi corretti**:
- `TeamUser extends BasePivot` ✅
- `TenantUser extends BasePivot` ✅
- `DeviceUser extends BasePivot` ✅
- `Membership extends BasePivot` ✅

### 3. BaseMorphPivot (per tabelle pivot polimorfiche)

I modelli che rappresentano relazioni polimorfiche devono estendere `Modules\User\Models\BaseMorphPivot`:

```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;

/**
 * ModelHasRole Polymorphic Pivot
 */
class ModelHasRole extends BaseMorphPivot
{
    protected $table = 'model_has_role';

    protected $fillable = [
        'id',
        'role_id',
        'model_type',
        'model_id',
        'team_id',
    ];
}
```

**Quando usare**: Tabelle pivot che collegano modelli tramite relazioni polimorfiche.

**Come riconoscerle**:
- Contengono colonne `*_type` e `*_id` (es. `model_type`, `model_id`)
- Permettono di collegare un modello a diversi tipi di modelli

**Esempi corretti**:
- `ModelHasRole extends BaseMorphPivot` ✅
- `ModelHasPermission extends BaseMorphPivot` ✅

## Gerarchia Completa

```
Illuminate\Database\Eloquent\Model
├── Modules\Xot\Models\XotBaseModel
│   └── Modules\User\Models\BaseModel
│       ├── Tenant
│       ├── Team
│       ├── SsoProvider
│       └── ... (altri modelli standard)
│
├── Illuminate\Database\Eloquent\Relations\Pivot
│   └── Modules\Xot\Models\XotBasePivot
│       └── Modules\User\Models\BasePivot
│           ├── TeamUser
│           ├── TenantUser
│           ├── DeviceUser
│           └── ... (altri pivot)
│
└── Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            ├── ModelHasRole
            ├── ModelHasPermission
            └── ... (altri morph pivot)
```

## Benefici dell'Approccio

### 1. Configurazione Centralizzata
- `BaseModel` imposta automaticamente `$connection = 'user'`
- Fornisce traits comuni: `HasXotFactory`, `RelationX`, `Updater`
- Cast standard per `created_at`, `updated_at`, `deleted_at`, ecc.

### 2. Coerenza
- Tutti i modelli del modulo seguono le stesse convenzioni
- Comportamento prevedibile e uniforme
- Facilita la manutenzione

### 3. DRY (Don't Repeat Yourself)
- Evita duplicazione di configurazioni
- Modifiche centralizzate nel BaseModel si propagano a tutti i modelli

### 4. Type Safety
- PHPStan livello 9+ compliant
- Migliore autocompletamento negli IDE

## Modifiche Effettuate (2025-10-15)

### Modelli Corretti

1. **Tenant**
   - Prima: `extends Model` ❌
   - Dopo: `extends BaseModel` ✅
   - Rimosse configurazioni duplicate (`$connection`, `HasXotFactory`)

2. **TeamUser**
   - Prima: `extends Model` ❌
   - Dopo: `extends BasePivot` ✅
   - Rimosse configurazioni duplicate (`$connection`)

3. **TenantUser**
   - Prima: `extends Model` ❌ (già in BasePivot ma importava Model)
   - Dopo: `extends BasePivot` ✅
   - Pulito imports non necessari

## Checklist per Nuovi Modelli

Prima di creare un nuovo modello, verifica:

- [ ] Il modello rappresenta un'entità di business? → Estendi `BaseModel`
- [ ] Il modello è una tabella pivot (molti-a-molti)? → Estendi `BasePivot`
- [ ] Il modello è una tabella pivot polimorfica? → Estendi `BaseMorphPivot`
- [ ] Il modello usa `Sushi` (dati in-memory)? → Può estendere `BaseModel` con trait `Sushi`
- [ ] Hai rimosso configurazioni duplicate già presenti nella base?
- [ ] Hai verificato con PHPStan livello 9+?

## Link Correlati

- [Documentazione Xot BaseModel](../../Xot/docs/model-inheritance-rules.md)
- [Documentazione Geo Model Pattern](../../Geo/docs/model-inheritance-pattern.md)
- [Laravel Eloquent Documentation](https://laravel.com/docs/eloquent)

## Note Tecniche

### Perché Non Estendere Model Direttamente?

1. **Perdita di funzionalità comuni**: Traits come `Updater`, `RelationX`, `HasXotFactory`
2. **Duplicazione**: Ogni modello dovrebbe ridefinire `$connection`, cast, etc.
3. **Manutenzione**: Cambiamenti globali richiederebbero modifiche a tutti i modelli
4. **Convenzione**: L'intero monorepo segue questo pattern

### Cosa Fornisce BaseModel?

```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user';

    // Ereditato da XotBaseModel:
    // - Traits: HasXotFactory, RelationX, Updater
    // - $incrementing = true
    // - $timestamps = true
    // - $primaryKey = 'id'
    // - $keyType = 'string'
    // - Cast standard per date e audit fields
}
```

### Eccezioni Legittime

**TestSushiModel** nel modulo Tenant estende ancora `Model` direttamente perché:
- È un modello di test
- Usa il trait `Sushi` che richiede configurazioni speciali
- Non è un modello di produzione

## Validazione

Verifica che non ci siano violazioni:

```bash
# Trova modelli che estendono Model direttamente (escludendo Base*)
grep -r "extends Model$" Modules/*/app/Models/*.php | grep -v "BaseModel\|XotBase"
```

Il comando dovrebbe restituire solo:
- `XotBaseModel` (corretto, è la base di tutti)
- `XotBasePivot` (corretto, è la base dei pivot)
- `XotBaseMorphPivot` (corretto, è la base dei morph pivot)
- `TestSushiModel` (accettabile, è per test)
- `BaseModel` di ogni modulo (corretto, sono le basi modulo-specifiche)

---

*Ultimo aggiornamento: 15 ottobre 2025*
*Autore: Refactoring automatico con Claude Code*

## Aggiornamento 2025-11

- `Modules\User\Models\Extra` usa ora `getConnectionName()` pubblico per forzare la connection `user` senza violare le proprietà @final ereditate.
- PHPStan L10 ✅, PHPMD ✅, PHPInsights ✅ (nessun avviso dopo refactor).
- Regola: quando serve una connection custom, override tramite metodo, mai riscrivere `$connection` nelle sottoclassi.

