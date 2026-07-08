---
title: "handoff — contract stacking BaseScheda"
type: handoff
module: Ptv
status: completed
completed: 2026-06-15
related:
  - ../wiki/rules/contract-interface-stacking.md
  - ../wiki/rules/module-hierarchy-inheritance-pattern.md
---

# Handoff — Contract stacking su BaseScheda

## Regola

```php
// ❌
abstract class BaseScheda extends BaseModel
    implements SchedaContract, EnteMatrFieldsContract, DateRangeFieldsContract {}

// ✅
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}
abstract class BaseScheda extends BaseModel implements SchedaContract {}
```

## Stato codice

- `BaseScheda.php` — già `implements SchedaContract` solo
- `SchedaContract.php` — già `extends EnteMatrFieldsContract, DateRangeFieldsContract`
- `Progressioni\Scheda` — `extends BaseScheda` senza implements

## Wiki creato/aggiornato

- `docs/wiki/rules/contract-interface-stacking.md` (nuovo)
- `docs/wiki/rules/module-hierarchy-inheritance-pattern.md` (nuovo)
- memories + audit step 6 stacking

## Audit

```bash
bash bashscripts/tools/audit-scheda-contract-inheritance.sh
```
