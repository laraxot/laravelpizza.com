---
title: "contract aggregation pattern"
type: rule
module: Progressioni
tags: [contract, aggregation, dry, architecture, ptv]
created: 2026-06-15
updated: 2026-06-15
qmd: "SchedaContract EnteMatrFieldsContract DateRangeFieldsContract aggregation stacking BaseScheda Progressioni"
issues:
  - "https://github.com/provtv/module_progressioni_fila5/issues/1"
discussions:
  - "https://github.com/provtv/module_progressioni_fila5/discussions/1"
related:
  - ../../../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md
  - ../database-connection-progressione.md
  - ../../../../../../docs/wiki/rules/contract-interface-stacking.md
  - ../../../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md
  - ../../Sigma/docs/wiki/rules/contract-inheritance-no-redeclare.md
---

# Progressioni — Contract Aggregation Pattern

## Regola

Il contratto composito e il base model **vivono in Ptv**. Progressioni **estende** senza ridichiarare `implements`.

```
EnteMatrFieldsContract + DateRangeFieldsContract (Sigma)
        ↑ extends
SchedaContract (Ptv\Models\Contracts)
        ↑ implements (solo BaseScheda)
BaseScheda (Ptv\Models)
        ↑ extends (solo)
Progressioni\Models\Scheda
```

## Corretto

```php
// Ptv — owner contratto
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}

abstract class BaseScheda extends BaseModel implements SchedaContract {}

// Progressioni — solo dominio
class Scheda extends BaseScheda
{
    protected $connection = 'progressione';
}
```

## Vietato

```php
// ❌ contratto o base duplicati in Progressioni
namespace Modules\Progressioni\Models\Contracts;
interface SchedaContract extends SigmaEnteMatrFields, SigmaDateRangeFields {}

// ❌ implements multiplo sul model
abstract class BaseScheda implements SchedaContract, EnteMatrFieldsContract, DateRangeFieldsContract {}
```

## Perché

| Motivo | Effetto |
|--------|---------|
| DRY | Un solo `asz()`, un solo `SchedaContract` |
| KISS | Progressioni aggiunge solo logica dominio |
| PHPStan | Type-hint `SchedaContract` nelle action Ptv/Progressioni |

## Audit

```bash
bash bashscripts/tools/audit-scheda-contract-inheritance.sh
```

## Collegamenti

- Owner: [scheda-contract-inheritance](../../../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md)
- Root: [contract-interface-stacking](../../../../../../docs/wiki/rules/contract-interface-stacking.md)
