---
title: "Sigma BaseModel Hierarchy"
type: rule
module: Sigma
tags: [architecture, eloquent, models, basemodel, hierarchy]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma basemodel hierarchy xotbase eloquent"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/3"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/5"
related:
  - ../../../../../../docs/wiki/rules/module-model-base-inheritance.md
  - ../../../../../../docs/wiki/rules/models-contracts-placement.md
  - ../concepts/common-scope-date-range-ownership.md
  - ../index.md
---

# Sigma — BaseModel Hierarchy

## Gerarchia Obbligatoria

```
XotBaseModel (Modules\Xot\Models)
    ↑
BaseModel (Modules\Sigma\Models)
    ↑
BaseDateRangeModel (Modules\Sigma\Models — opzionale)
    ↑
ConcreteModel (Modules\Sigma\Models\[ModelName])
```

## Implementazione Sigma

### 1. BaseModel — Layer Intermedio

```php
// laravel/Modules/Sigma/app/Models/BaseModel.php

abstract class BaseModel extends XotBaseModel
{
    // Connessione module-specific
    protected $connection = 'generale';
    
    // Sigma-wide traits
    use SigmaCommonTrait;
}
```

**Responsabilità:**
- Connessione 'generale' per sistemi legacy
- Cast condivisi (date format, legacy timestamps)
- Scopes custom (scopeByEnte, scopeByYear, etc)

### 2. BaseDateRangeModel — Subtype Specializzato

```php
// laravel/Modules/Sigma/app/Models/BaseDateRangeModel.php

abstract class BaseDateRangeModel extends BaseModel
    implements \Modules\Sigma\Models\Contracts\DateRangeFieldsContract
{
    use CommonScope;
    public $timestamps = false;
}
```

**Responsabilità:**
- Centralizza il trait CommonScope
- Implementa contratto `Models\Contracts\DateRangeFieldsContract`
- Toglie i timestamps (legacy format)

Modelli che usano intervalli date → estendono BaseDateRangeModel:
- Qua03f, Qua00f, Asz00f, Asz00k1, Rep00f, Sto00f, Dipt00f

### 3. ConcreteModel — Implementazione

```php
// Sigma ha 100+ modelli di dati legacy
// Tutti estendono BaseModel (o BaseDateRangeModel)

class Qua03f extends BaseDateRangeModel {
    // Implementa i 3 metodi astratti di CommonScope
    public function rangeFromField(): string { return 'q32kd'; }
    public function rangeToField(): string { return 'q32ka'; }
    public function annFieldName(): string { return 'q3ann'; }
}

class Accina extends BaseModel {
    // Modello semplice senza date range
}
```

## Verificare Conformità

```bash
cd laravel/Modules/Sigma

# Check: nessun modello estende direttamente Model
grep -r "extends.*Eloquent\\Model\|extends Model" app/Models/*.php \
    ! -name "BaseModel.php"
# Deve restituire 0 matches
```

## Vantaggi in Sigma

| Aspetto | Beneficio |
|---------|-----------|
| **Legacy DB** | `$connection='generale'` centralizzato in BaseModel |
| **Timestamps** | BaseDateRangeModel disabilita `$timestamps` per tutti i modelli date-range |
| **CommonScope** | Trait riusabile su 5 modelli, no duplication |
| **Testing** | Mock BaseModel behaviors senza toccare Eloquent |
| **Manutenzione** | Cambi a BaseModel si propagano a 100+ modelli |

### Contract Stacking (Composite Contract)

I contratti compositi estendono contratti base. Il model implementa solo il contratto di dominio.

```php
// ✅ CORRETTO: contratto composito + model single-implements
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}
abstract class BaseScheda extends BaseModel implements SchedaContract { }
```

Vedi [contract-interface-stacking](../../../../../../docs/wiki/rules/contract-interface-stacking.md).

## Anti-Pattern (NEVER)

```php
// ❌ Violazione CARDINAL RULE
class Qua03f extends Model { }
class Qua03f extends Eloquent\Model { }

// ❌ ERRORE CRITICO: NON ridichiarare implements
// BaseDateRangeModel GIÀ implementa DateRangeFieldsContract!
class Qua00f extends BaseDateRangeModel implements Contracts\DateRangeFieldsContract { }

// ❌ Model implementa 3 contratti in riga (stacking violato)
abstract class BaseScheda extends BaseModel
    implements SchedaContract, EnteMatrFieldsContract, DateRangeFieldsContract { }

// ✅ Corretti
class Qua03f extends BaseDateRangeModel { }                    // Nessun implements
class BaseDateRangeModel extends BaseModel implements DateRangeFieldsContract { }
class BaseModel extends XotBaseModel implements EnteMatrFieldsContract { }
```

### Spiegazione Regola

**BaseDateRangeModel** è dichiarato così:

```php
abstract class BaseDateRangeModel extends BaseModel implements DateRangeFieldsContract
```

Estendendo `BaseDateRangeModel`, **automaticamente** si ottiene l'implementazione del contratto.
Aggiungere `implements DateRangeFieldsContract` è:
- **REDUNDANTE** (duplicazione inutile)
- **Violazione DRY**
- **Potenziale conflitto** se le firme dei metodi differiscono

**Regola CARDINAL:** Estendere `BaseDateRangeModel` → **non** aggiungere mai `implements` per `DateRangeFieldsContract`.

---

**Pattern:** CARDINAL RULE — Eloquent BaseModel Hierarchy
**Compliance:** ✅ 100% (audit run 2026-06-15)
**Verification:** `bash bashscripts/tools/audit-eloquent-basemodel-hierarchy.sh`
