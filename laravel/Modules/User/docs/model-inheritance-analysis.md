# Analisi Ereditarietà Modelli - Modulo User

## Regola Fondamentale

**Nessun modello dentro i moduli deve estendere direttamente `Illuminate\Database\Eloquent\Model`.**

Ogni modulo deve avere le proprie classi base che estendono le classi `XotBase*` del modulo Xot:

### Gerarchia Corretta

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel (per modelli standard)

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot (per tabelle pivot)

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot (per tabelle pivot polimorfe)
```

## Motivazione

1. **Centralizzazione**: Comportamenti comuni e configurazioni specifiche del modulo
2. **Manutenibilità**: Modifiche in un solo punto invece di N modelli
3. **Coerenza**: Tutti i modelli del modulo seguono le stesse convenzioni
4. **PHPStan**: Evita errori di analisi statica con classi personalizzate

## Modelli Analizzati

### ✅ Corretti

- `ModelHasRole` → estende `BaseMorphPivot` ✓
- `PermissionUser` → estende `ModelHasPermission` (che a sua volta estende la base corretta) ✓

### ❌ Da Correggere

| Modello | Estende Attualmente | Deve Estendere | Tipo |
|---------|---------------------|----------------|------|
| `Tenant` | `Model` | `BaseModel` | Standard |
| `TeamUser` | `Model` | `BasePivot` | Pivot |
| `TeamInvitation` | `Model` | `BaseModel` | Standard |
| `TeamPermission` | `Model` | `BaseModel` | Standard |
| `Authentication` | `Model` | `BaseModel` | Standard |
| `SsoProvider` | `Model` | `BaseModel` | Standard |
| `OauthClient` | `Model` | `BaseModel` | Standard |

## Criteri di Classificazione

### BaseModel (Modelli Standard)
Modelli che rappresentano entità con tabella propria e non sono tabelle di relazione:
- `Tenant`: Entità tenant
- `TeamInvitation`: Inviti ai team
- `TeamPermission`: Permessi team
- `Authentication`: Log autenticazioni
- `SsoProvider`: Provider SSO
- `OauthClient`: Client OAuth

### BasePivot (Tabelle Pivot)
Tabelle di relazione many-to-many semplici:
- `TeamUser`: Relazione User ↔ Team (ha `team_id`, `user_id`, `role`)

### BaseMorphPivot (Tabelle Pivot Polimorfe)
Tabelle di relazione con colonne `*_type` e `*_id`:
- `ModelHasRole`: Ha `model_type` e `model_id` ✓ (già corretto)

## Benefici delle Classi Base

### BaseModel
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user'; // ✓ Automatico per tutti

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'verified_at' => 'datetime', // ✓ Cast specifici del modulo
        ]);
    }
}
```

### BasePivot
```php
abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i pivot
}
```

### BaseMorphPivot
```php
abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i morph pivot

    // ✓ Trait e configurazioni comuni
}
```

## Implementazione

### 1. Correzione Modelli Standard

```php
// Prima
class Tenant extends Model { ... }

// Dopo
class Tenant extends BaseModel { ... }
```

### 2. Correzione Pivot

```php
// Prima
class TeamUser extends Model { ... }

// Dopo
class TeamUser extends BasePivot { ... }
```

### 3. Rimozione Duplicazioni

Dopo l'estensione corretta, rimuovere:
- `protected $connection = 'user';` (già in BaseModel/BasePivot/BaseMorphPivot)
- Trait già presenti nelle classi base
- Cast già definiti nelle classi base

## Verifica PHPStan

Dopo le modifiche, eseguire:

```bash
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Collegamenti

- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../app/Models/BaseModel.php)
- [BasePivot](../app/Models/BasePivot.php)
- [BaseMorphPivot](../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../Xot/app/Models/XotBaseMorphPivot.php)
# Analisi Ereditarietà Modelli - Modulo User

## Regola Fondamentale

**Nessun modello dentro i moduli deve estendere direttamente `Illuminate\Database\Eloquent\Model`.**

Ogni modulo deve avere le proprie classi base che estendono le classi `XotBase*` del modulo Xot:

### Gerarchia Corretta

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel (per modelli standard)

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot (per tabelle pivot)

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot (per tabelle pivot polimorfe)
```

## Motivazione

1. **Centralizzazione**: Comportamenti comuni e configurazioni specifiche del modulo
2. **Manutenibilità**: Modifiche in un solo punto invece di N modelli
3. **Coerenza**: Tutti i modelli del modulo seguono le stesse convenzioni
4. **PHPStan**: Evita errori di analisi statica con classi personalizzate

## Modelli Analizzati

### ✅ Corretti

- `ModelHasRole` → estende `BaseMorphPivot` ✓
- `PermissionUser` → estende `ModelHasPermission` (che a sua volta estende la base corretta) ✓

### ❌ Da Correggere

| Modello | Estende Attualmente | Deve Estendere | Tipo |
|---------|---------------------|----------------|------|
| `Tenant` | `Model` | `BaseModel` | Standard |
| `TeamUser` | `Model` | `BasePivot` | Pivot |
| `TeamInvitation` | `Model` | `BaseModel` | Standard |
| `TeamPermission` | `Model` | `BaseModel` | Standard |
| `Authentication` | `Model` | `BaseModel` | Standard |
| `SsoProvider` | `Model` | `BaseModel` | Standard |
| `OauthClient` | `Model` | `BaseModel` | Standard |

## Criteri di Classificazione

### BaseModel (Modelli Standard)
Modelli che rappresentano entità con tabella propria e non sono tabelle di relazione:
- `Tenant`: Entità tenant
- `TeamInvitation`: Inviti ai team
- `TeamPermission`: Permessi team
- `Authentication`: Log autenticazioni
- `SsoProvider`: Provider SSO
- `OauthClient`: Client OAuth

### BasePivot (Tabelle Pivot)
Tabelle di relazione many-to-many semplici:
- `TeamUser`: Relazione User ↔ Team (ha `team_id`, `user_id`, `role`)

### BaseMorphPivot (Tabelle Pivot Polimorfe)
Tabelle di relazione con colonne `*_type` e `*_id`:
- `ModelHasRole`: Ha `model_type` e `model_id` ✓ (già corretto)

## Benefici delle Classi Base

### BaseModel
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user'; // ✓ Automatico per tutti

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'verified_at' => 'datetime', // ✓ Cast specifici del modulo
        ]);
    }
}
```

### BasePivot
```php
abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i pivot
}
```

### BaseMorphPivot
```php
abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i morph pivot

    // ✓ Trait e configurazioni comuni
}
```

## Implementazione

### 1. Correzione Modelli Standard

```php
// Prima
class Tenant extends Model { ... }

// Dopo
class Tenant extends BaseModel { ... }
```

### 2. Correzione Pivot

```php
// Prima
class TeamUser extends Model { ... }

// Dopo
class TeamUser extends BasePivot { ... }
```

### 3. Rimozione Duplicazioni

Dopo l'estensione corretta, rimuovere:
- `protected $connection = 'user';` (già in BaseModel/BasePivot/BaseMorphPivot)
- Trait già presenti nelle classi base
- Cast già definiti nelle classi base

## Verifica PHPStan

Dopo le modifiche, eseguire:

```bash
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Collegamenti

- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../app/Models/BaseModel.php)
- [BasePivot](../app/Models/BasePivot.php)
- [BaseMorphPivot](../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../Xot/app/Models/XotBaseMorphPivot.php)
# Analisi Ereditarietà Modelli - Modulo User

## Regola Fondamentale

**Nessun modello dentro i moduli deve estendere direttamente `Illuminate\Database\Eloquent\Model`.**

Ogni modulo deve avere le proprie classi base che estendono le classi `XotBase*` del modulo Xot:

### Gerarchia Corretta

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel (per modelli standard)

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot (per tabelle pivot)

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot (per tabelle pivot polimorfe)
```

## Motivazione

1. **Centralizzazione**: Comportamenti comuni e configurazioni specifiche del modulo
2. **Manutenibilità**: Modifiche in un solo punto invece di N modelli
3. **Coerenza**: Tutti i modelli del modulo seguono le stesse convenzioni
4. **PHPStan**: Evita errori di analisi statica con classi personalizzate

## Modelli Analizzati

### ✅ Corretti

- `ModelHasRole` → estende `BaseMorphPivot` ✓
- `PermissionUser` → estende `ModelHasPermission` (che a sua volta estende la base corretta) ✓

### ❌ Da Correggere

| Modello | Estende Attualmente | Deve Estendere | Tipo |
|---------|---------------------|----------------|------|
| `Tenant` | `Model` | `BaseModel` | Standard |
| `TeamUser` | `Model` | `BasePivot` | Pivot |
| `TeamInvitation` | `Model` | `BaseModel` | Standard |
| `TeamPermission` | `Model` | `BaseModel` | Standard |
| `Authentication` | `Model` | `BaseModel` | Standard |
| `SsoProvider` | `Model` | `BaseModel` | Standard |
| `OauthClient` | `Model` | `BaseModel` | Standard |

## Criteri di Classificazione

### BaseModel (Modelli Standard)
Modelli che rappresentano entità con tabella propria e non sono tabelle di relazione:
- `Tenant`: Entità tenant
- `TeamInvitation`: Inviti ai team
- `TeamPermission`: Permessi team
- `Authentication`: Log autenticazioni
- `SsoProvider`: Provider SSO
- `OauthClient`: Client OAuth

### BasePivot (Tabelle Pivot)
Tabelle di relazione many-to-many semplici:
- `TeamUser`: Relazione User ↔ Team (ha `team_id`, `user_id`, `role`)

### BaseMorphPivot (Tabelle Pivot Polimorfe)
Tabelle di relazione con colonne `*_type` e `*_id`:
- `ModelHasRole`: Ha `model_type` e `model_id` ✓ (già corretto)

## Benefici delle Classi Base

### BaseModel
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'user'; // ✓ Automatico per tutti

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'verified_at' => 'datetime', // ✓ Cast specifici del modulo
        ]);
    }
}
```

### BasePivot
```php
abstract class BasePivot extends XotBasePivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i pivot
}
```

### BaseMorphPivot
```php
abstract class BaseMorphPivot extends XotBaseMorphPivot
{
    protected $connection = 'user'; // ✓ Automatico per tutti i morph pivot

    // ✓ Trait e configurazioni comuni
}
```

## Implementazione

### 1. Correzione Modelli Standard

```php
// Prima
class Tenant extends Model { ... }

// Dopo
class Tenant extends BaseModel { ... }
```

### 2. Correzione Pivot

```php
// Prima
class TeamUser extends Model { ... }

// Dopo
class TeamUser extends BasePivot { ... }
```

### 3. Rimozione Duplicazioni

Dopo l'estensione corretta, rimuovere:
- `protected $connection = 'user';` (già in BaseModel/BasePivot/BaseMorphPivot)
- Trait già presenti nelle classi base
- Cast già definiti nelle classi base

## Verifica PHPStan

Dopo le modifiche, eseguire:

```bash
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Collegamenti

- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../app/Models/BaseModel.php)
- [BasePivot](../app/Models/BasePivot.php)
- [BaseMorphPivot](../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../Xot/app/Models/XotBaseMorphPivot.php)
