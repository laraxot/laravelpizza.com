---
title: "model: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "model   consolidated documentation user"
---

# model: Consolidated Documentation

Consolidated from **18** individual files.

## Table of Contents

- [---](#model-classification)
- [---](#model-inheritance-analysis-3)
- [---](#model-inheritance-analysis-4)
- [---](#model-inheritance-analysis-5)
- [---](#model-inheritance-analysis)
- [---](#model-inheritance-fixes-3)
- [---](#model-inheritance-fixes-4)
- [---](#model-inheritance-fixes-5)
- [---](#model-inheritance-fixes)
- [---](#model-inheritance-rules)
- [---](#model-inheritance)
- [---](#model-inheritancees)
- [Analisi Ereditarietà Modelli - Modulo User](#model_inheritance_analysis)
- [Correzioni Ereditarietà Modelli - Modulo User](#model_inheritance_fixes)
- [---](#modelli-factory-seeder-analisi)
- [Analisi Modelli, Factory e Seeder - Modulo User](#modelli_factory_seeder_analisi)
- [---](#models-analysis)
- [---](#models)

---

## model-classification

*Consolidated from: `model-classification.md`*

module: theme
topic: model-classification
canonical: ../../../Themes/docs/shared-components/model-classification-Modules.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/model-classification-Modules.md

---

## model-inheritance-analysis-3

*Consolidated from: `model-inheritance-analysis.md`*

title: "Analisi Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-analysis-3 analisi ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model-inheritance-analysis-4

*Consolidated from: `model-inheritance-analysis.md`*

title: "Analisi Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-analysis-4 analisi ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model-inheritance-analysis-5

*Consolidated from: `model-inheritance-analysis.md`*

title: "Analisi Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-analysis-5 analisi ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model-inheritance-analysis

*Consolidated from: `model-inheritance-analysis.md`*

title: "Analisi Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-analysis analisi ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model-inheritance-fixes-3

*Consolidated from: `model-inheritance-fixes.md`*

title: "Correzioni Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-fixes-3 correzioni ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd /var/www/_bases/base_<nome progetto>_fila4_mono/laravel/Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd /var/www/_bases/base_<nome progetto>_fila4_mono/laravel/Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)

---

## model-inheritance-fixes-4

*Consolidated from: `model-inheritance-fixes.md`*

title: "Correzioni Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-fixes-4 correzioni ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)

---

## model-inheritance-fixes-5

*Consolidated from: `model-inheritance-fixes.md`*
*Consolidated from: `model-inheritance-fixes-analisi-completa.md`*

title: "Model Inheritance Fixes 5"
type: concept
tags: [model, inheritance, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-fixes-5 model inheritance fixes 5"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
---
module: theme
topic: model_inheritance_fixes
canonical: ../../../Themes/docs/shared-components/model-inheritance-fixes.md
---

See canonical documentation: ../../../Themes/docs/shared-components/model-inheritance-fixes.md
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
---
module: theme
topic: model_inheritance_fixes
canonical: ../../../Themes/docs/shared-components/model-inheritance-fixes-analisi-completa.md
---

See canonical documentation: ../../../Themes/docs/shared-components/model-inheritance-fixes-analisi-completa.md
---

## model-inheritance-fixes

*Consolidated from: `model-inheritance-fixes.md`*

module: theme
topic: model-inheritance-fixes
canonical: ../../../Themes/docs/shared-components/model-inheritance-fixes.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/model-inheritance-fixes.md

---

## model-inheritance-rules

*Consolidated from: `model-inheritance-rules.md`*

title: "Regole di Ereditarietà dei Modelli - Modulo User"
type: rule
tags: [model, inheritance, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance-rules regole di ereditarietà dei modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Regole di Ereditarietà dei Modelli - Modulo User

**Data**: 2025-10-15
**Contesto**: Refactoring per garantire la corretta gerarchia di ereditarietà dei modelli

## Regola Fondamentale

**NESSUN modello all'interno dei moduli deve estendere `Illuminate\Database\Eloquent\Model` direttamente.**

Tutti i modelli devono estendere una delle seguenti classi base:

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

- [Documentazione Xot BaseModel](../../../../Xot/docs/model-inheritance-rules.md)
- [Documentazione Geo Model Pattern](../../../../Geo/docs/model-inheritance-pattern.md)
- [Documentazione Geo Model Pattern](../../../../Geo/docs/model-inheritance-pattern.md)
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

*Autore: Refactoring automatico con Claude Code*

## Aggiornamento 2025-11

- `Modules\User\Models\Extra` usa ora `getConnectionName()` pubblico per forzare la connection `user` senza violare le proprietà @final ereditate.
- PHPStan L10 ✅, PHPMD ✅, PHPInsights ✅ (nessun avviso dopo refactor).
- Regola: quando serve una connection custom, override tramite metodo, mai riscrivere `$connection` nelle sottoclassi.


---

## model-inheritance

*Consolidated from: `model-inheritance.md`*

title: "Analisi Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritance]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritance analisi ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model-inheritancees

*Consolidated from: `model-inheritancees.md`*

title: "Correzioni Ereditarietà Modelli - Modulo User"
type: concept
tags: [model, inheritancees]
created: 2026-07-14
updated: 2026-07-14
qmd: "model-inheritancees correzioni ereditarietà modelli - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [Analisi Completa](../../model-inheritance-analysis.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)

---

## model_inheritance_analysis

*Consolidated from: `model_inheritance_analysis.md`*


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
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [XotBaseModel](../../../../Xot/app/Models/XotBaseModel.php)
- [XotBasePivot](../../../../Xot/app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../../../../Xot/app/Models/XotBaseMorphPivot.php)

---

## model_inheritance_fixes

*Consolidated from: `model_inheritance_fixes.md`*


## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./MODEL_INHERITANCE_ANALYSIS.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)
- [BaseModel](../../../app/Models/BaseModel.php)
- [BasePivot](../../../app/Models/BasePivot.php)
- [BaseMorphPivot](../../../app/Models/BaseMorphPivot.php)

---

## modelli-factory-seeder-analisi

*Consolidated from: `modelli-factory-seeder-analisi.md`*

module: theme
topic: modelli-factory-seeder-analisi
canonical: ../../../Themes/docs/shared-components/modelli-factory-seeder-analisi-Modules.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/modelli-factory-seeder-analisi-Modules.md

---

## modelli_factory_seeder_analisi

*Consolidated from: `modelli_factory_seeder_analisi.md`*


## Panoramica
Questo documento analizza tutti i modelli del modulo User verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core Authentication (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **User** | ✅ UserFactory | ✅ UserSeeder | Core - Utente base del sistema |
| **Profile** | ✅ ProfileFactory | ❌ | Core - Profilo utente esteso |
| **Team** | ✅ TeamFactory | ❌ | Core - Team collaboration |
| **TeamUser** | ✅ TeamUserFactory | ❌ | Core - Relazione team-utente |
| **Tenant** | ✅ TenantFactory | ❌ | Core - Multi-tenancy |
| **TenantUser** | ✅ TenantUserFactory | ❌ | Core - Relazione tenant-utente |

### Modelli Permissions & Roles (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Permission** | ✅ PermissionFactory | ✅ PermissionsSeeder | Core - Sistema permessi |
| **Role** | ✅ RoleFactory | ✅ RolesSeeder | Core - Sistema ruoli |
| **ModelHasPermission** | ✅ ModelHasPermissionFactory | ❌ | Core - Permessi modello |
| **ModelHasRole** | ✅ ModelHasRoleFactory | ❌ | Core - Ruoli modello |
| **PermissionRole** | ✅ PermissionRoleFactory | ❌ | Core - Permessi-ruoli |
| **PermissionUser** | ✅ PermissionUserFactory | ❌ | Core - Permessi-utente |
| **RoleHasPermission** | ✅ RoleHasPermissionFactory | ❌ | Core - Ruoli-permessi |

### Modelli Authentication Logs (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Authentication** | ✅ AuthenticationFactory | ❌ | Security - Log autenticazione |
| **AuthenticationLog** | ✅ AuthenticationLogFactory | ❌ | Security - Log dettagliato auth |

### Modelli OAuth & Social (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **OauthAccessToken** | ✅ OauthAccessTokenFactory | ❌ | OAuth - Token accesso |
| **OauthAuthCode** | ✅ OauthAuthCodeFactory | ❌ | OAuth - Codici autorizzazione |
| **OauthClient** | ✅ OauthClientFactory | ❌ | OAuth - Client applicazioni |
| **OauthPersonalAccessClient** | ✅ OauthPersonalAccessClientFactory | ❌ | OAuth - Client personali |
| **OauthRefreshToken** | ✅ OauthRefreshTokenFactory | ❌ | OAuth - Token refresh |
| **SocialiteUser** | ✅ SocialiteUserFactory | ❌ | Social - Utenti social login |
| **SocialProvider** | ✅ SocialProviderFactory | ❌ | Social - Provider social |

### Modelli Utility (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **PasswordReset** | ✅ PasswordResetFactory | ❌ | Security - Reset password |
| **Notification** | ✅ NotificationFactory | ❌ | System - Notifiche utente |
| **Extra** | ✅ ExtraFactory | ❌ | System - Metadati extra |
| **Feature** | ✅ FeatureFactory | ❌ | System - Feature flags |

### Modelli Device Management (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Device** | ✅ DeviceFactory | ❌ | Security - Dispositivi utente |
| **DeviceUser** | ✅ DeviceUserFactory | ❌ | Security - Relazione device-user |
| **DeviceProfile** | ✅ DeviceProfileFactory | ❌ | Security - Profili dispositivi |

### Modelli Jetstream (Utilizzati Condizionalmente)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Membership** | ✅ MembershipFactory | ❌ | Jetstream - Membership team |
| **TeamInvitation** | ✅ TeamInvitationFactory | ❌ | Jetstream - Inviti team |
| **TeamPermission** | ✅ TeamPermissionFactory | ❌ | Jetstream - Permessi team |
| **ProfileTeam** | ✅ ProfileTeamFactory | ❌ | Jetstream - Profilo-team |

### Modelli Base (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseUser** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseProfile** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTeam** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTenant** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTeamUser** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BasePivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseMorphPivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseUuidModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |

### Modelli Trait/Behavior (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseInteractsWithExtra** | ❌ | ❌ | Trait - Non necessita factory/seeder |
| **BaseInteractsWithTenant** | ❌ | ❌ | Trait - Non necessita factory/seeder |
| **BaseIsTenant** | ❌ | ❌ | Trait - Non necessita factory/seeder |

## Modelli Non Utilizzati/Problematici

### File Jetstream Duplicati
| File | Stato | Motivazione |
|------|-------|-------------|
| **Membership.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |
| **Team.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |
| **TeamInvitation.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |

### File Test/Temporanei
| File | Stato | Motivazione |
|------|-------|-------------|
| **Project.test** | 🗑️ Test File | File di test da rimuovere |

## Seeder Mancanti Necessari

### Seeder Core da Creare
1. **ProfileSeeder** - Per profili utente di base
2. **TeamSeeder** - Per team di collaborazione
3. **TenantSeeder** - Per tenant multi-tenancy
4. **AuthenticationLogSeeder** - Per log autenticazione (opzionale)

### Seeder Pivot da Creare
1. **TeamUserSeeder** - Per relazioni team-utente
2. **TenantUserSeeder** - Per relazioni tenant-utente
3. **ModelHasPermissionSeeder** - Per permessi modello
4. **ModelHasRoleSeeder** - Per ruoli modello
5. **PermissionRoleSeeder** - Per permessi-ruoli
6. **PermissionUserSeeder** - Per permessi-utente

### Seeder OAuth da Creare (Opzionali)
1. **OauthClientSeeder** - Per client OAuth predefiniti
2. **SocialProviderSeeder** - Per provider social configurati

## Factory Mancanti (Nessuna)
Tutti i modelli attivi hanno le factory corrispondenti.

## Raccomandazioni

### Azioni Immediate
1. **Pulizia file duplicati**: Decidere quale versione Jetstream mantenere
2. **Rimozione file test**: Eliminare Project.test
3. **Creare seeder core**: Implementare ProfileSeeder, TeamSeeder, TenantSeeder
4. **Creare seeder pivot**: Implementare i seeder per le relazioni principali

### Azioni Future
1. **Seeder OAuth**: Valutare necessità seeder per OAuth se utilizzato
2. **Consolidamento**: Unificare seeder simili dove possibile
3. **Test coverage**: Assicurare test per tutti i modelli attivi
4. **Documentazione traits**: Documentare utilizzo dei trait base

## Struttura Seeder Esistenti

### Seeder Principali
- **UserDatabaseSeeder** - Seeder principale del modulo
- **UserSeeder** - Utenti base del sistema
- **PermissionsSeeder** - Permessi di sistema
- **RolesSeeder** - Ruoli di sistema

## Note Tecniche

### Pattern Factory Utilizzati
- **GetFactoryAction**: Pattern moderno per risoluzione automatica namespace
- **OAuth Support**: Factory per completo supporto OAuth2
- **Multi-tenancy**: Factory supportano architettura multi-tenant
- **Security Features**: Factory per autenticazione e logging sicurezza

### Architettura Multi-Tenant
Il modulo User implementa multi-tenancy attraverso:
- **Tenant Model**: Gestione tenant
- **TenantUser Pivot**: Relazioni utente-tenant
- **Trait Support**: BaseInteractsWithTenant per comportamenti comuni

### Sistema Permessi
Implementazione completa sistema permessi con:
- **Role-Based Access Control (RBAC)**
- **Permission-Based Access Control (PBAC)**
- **Model-Level Permissions**
- **Team-Level Permissions** (Jetstream)

### Validazione PHPStan
Tutti i file factory devono essere validati con PHPStan livello 9:
```bash
./vendor/bin/phpstan analyze Modules/User/database/factories --level=9
```

## Collegamenti

### Documentazione Correlata
- [Authentication System](./authentication_system.md)
- [Multi-Tenant Architecture](./multi_tenant_architecture.md)
- [Permissions & Roles](./permissions_roles.md)
- [OAuth Integration](./oauth_integration.md)
- [Jetstream Integration](./jetstream_integration.md)

### Moduli Collegati
- [SaluteOra Module](../../SaluteOra/docs/modelli_factory_seeder_analisi.md)
- [Tenant Module](../../Tenant/docs/modelli_factory_seeder_analisi.md)
- [Notify Module](../../../../Notify/docs/modelli_factory_seeder_analisi.md)
- [Notify Module](../../../../Notify/docs/modelli_factory_seeder_analisi.md)

*Ultimo aggiornamento: Gennaio 2025*
*Analisi completa di 35+ modelli attivi, sistema completo authentication/authorization*

---

## models-analysis

*Consolidated from: `models-analysis.md`*

title: "Models Analysis - User Module"
type: concept
tags: [models, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "models-analysis models analysis - user module"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Models Analysis - User Module

## Factory e Seeder Status

### Models con Factory ✅ (33/56) - Excellent Coverage
Core business models have factories. Missing factories are mainly abstract base classes and policies.

### Models senza Factory ❌ (23/56) - Correctly Missing
- All `Base*` classes (abstract infrastructure)
- All `*Policy` classes (authorization logic) 
- `UserBasePolicy` (base authorization)
- Infrastructure models that don't need testing

## Models Business Logic Analysis

### 🟢 Core Business Models (CRITICAL)
1. **User** - Core user entity ✅
2. **Profile** - User profiles ✅
3. **Team** - User teams ✅
4. **TeamUser** - Team membership ✅
5. **Permission** - Authorization permissions ✅
6. **Role** - User roles ✅
7. **Tenant** - Multi-tenancy ✅

### 🟡 Support Models (USEFUL)
1. **Authentication** - Auth tracking ✅
2. **Device** - Device management ✅
3. **SocialProvider** - Social auth ✅
4. **Notification** - User notifications ✅
5. **OAuth*** models - API authentication ✅

### 🔴 Non-Business Models (Infrastructure)
- All `Base*` classes - Abstract foundations
- All `*Policy` classes - Authorization rules
- Internal relationship models (ModelHasPermission, etc.)

## Recommendations

### ✅ Excellent Factory Coverage
All business models have factories. Infrastructure correctly excluded.

### Model Architecture Quality
- **Clean Separation**: Business vs Infrastructure models
- **Multi-tenancy Ready**: Tenant models present
- **Team Support**: Collaborative features
- **OAuth Ready**: API authentication support
- **Social Auth**: Modern auth patterns
- **Device Tracking**: Security features

## Usage in Healthcare Application
- **Multi-tenant**: Different healthcare organizations
- **Teams**: Medical teams, departments
- **Roles**: Doctor, Patient, Admin, Staff
- **Permissions**: Fine-grained access control
- **Social Auth**: Easy patient registration

## Notes
- **Comprehensive**: Covers all user management aspects
- **Security Focused**: Authentication, authorization, devices
- **Modern Architecture**: Multi-tenancy, teams, social auth
- **Healthcare Ready**: Role-based access for medical data
---

## models

*Consolidated from: `models.md`*

module: theme
topic: models
canonical: ../../../Themes/docs/shared-components/models-analysis.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/models-analysis.md

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04