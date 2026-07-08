---
title: "Sigma — Model Contracts Placement"
type: rule
module: Sigma
tags: [contract, placement, models, architecture]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma model contracts placement sigmadate​range​fields"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/3"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/5"
related:
  - ../../../../docs/wiki/rules/contract-placement-nested-scoping.md
  - ../../../../docs/wiki/memories/contract-placement-nested-scoping.md
  - ../index.md
---

# Sigma — Model Contracts Placement

## Standard Sigma

```
Modules\Sigma\
├── app/
│   ├── Models/Contracts/         ← Model-level contracts
│   │   └── DateRangeFieldsContract   ✅ Implemented by BaseDateRangeModel
│   ├── Models/
│   │   ├── BaseDateRangeModel (implements DateRangeFieldsContract)
│   │   ├── Qua03f (extends BaseDateRangeModel)
│   │   ├── Qua00f (extends BaseDateRangeModel)
│   │   └── ...
│   └── Contracts/                ← Module-level contracts (if any)
│       └── (exposed to other modules)
```

## DateRangeFieldsContract

**Location:** `Modules\Sigma\Models\Contracts\DateRangeFieldsContract`

**Naming:** suffisso `Contract` (vietato `SigmaDateRangeFields`). Vedi [contract-naming-suffix](../../../../../../docs/wiki/rules/contract-naming-suffix.md).

**Implementers:**
- `Modules\Sigma\Models\BaseDateRangeModel` (unico punto)

Concrete date-range models (`Qua03f`, `Qua00f`, `Asz00f`, `Asz00k1`, `Rep00f`, `Sto00f`, `Dipt00f`) extend `BaseDateRangeModel` **senza ridichiarare `implements`** — l'interfaccia si eredita. Vedi [contract-inheritance-no-redeclare](./contract-inheritance-no-redeclare.md).

**Why `Models/Contracts/`?**
- Governs **models specifically**, not module-level
- Implementers are all in `Models/` folder
- Cognitive proximity: when reading `Qua03f`, you find contract in `Models/Contracts/`

**Import in Base Implementation:**
```php
namespace Modules\Sigma\Models;

use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;

class BaseDateRangeModel extends BaseModel 
    implements DateRangeFieldsContract { }
```

## Contract Stacking (Composite Contract)

I contratti compositi estendono più contratti base. Il model implementa solo il contratto di dominio.

```php
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}

abstract class BaseScheda extends BaseModel implements SchedaContract { }
```

Vedi [contract-interface-stacking](../../../../../../docs/wiki/rules/contract-interface-stacking.md).

## Regola Placement

**Template per futuri contracts Sigma:**
- Model-level contract? → `Models/Contracts/[Name].php`
- Action-level contract? → `Actions/Contracts/[Name].php` (if layer exists)
- Filament-level contract? → `Filament/Contracts/[Name].php` (if layer exists)
- Module-level contract? → `Contracts/[Name].php` (exposed to other modules)

---

**Pattern:** Nested Scoping (DDD)
**Compliance:** ✅ DateRangeFieldsContract correctly placed
**Reference:** `docs/wiki/rules/contract-placement-nested-scoping.md`
