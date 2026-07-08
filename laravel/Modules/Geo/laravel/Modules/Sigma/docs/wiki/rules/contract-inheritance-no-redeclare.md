---
title: "Sigma — Contract Inheritance: No Re-declare"
type: rule
module: Sigma
tags: [contract, inheritance, dry, oop, architecture]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma contract inheritance no redeclare implements child class extends base"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/3"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/5"
related:
  - ./model-contracts-placement.md
  - ./basemodel-hierarchy.md
  - ../concepts/sigma-model-inheritance.md
  - ../../../../../docs/wiki/rules/module-model-base-inheritance.md
---

# Sigma — Contract Inheritance: No Re-declare

## Regola

**Un child class NON deve mai ripetere `implements ContractInterface` se il parent class già lo fa.**

```php
// ✅ CORRETTO — BaseDateRangeModel implements, figlio eredita
abstract class BaseDateRangeModel extends BaseModel implements DateRangeFieldsContract { }

class Qua00f extends BaseDateRangeModel { }  // eredita l'implementazione

// ❌ SBAGLIATO — ridondante, fuorviante
class Qua00f extends BaseDateRangeModel implements Contracts\DateRangeFieldsContract { }
```

## Perché

| Ragione | Spiegazione |
|---------|-------------|
| **DRY** | L'implementazione è già nella catena di ereditarietà |
| **Fuorviante** | Chi legge pensa che `BaseDateRangeModel` _non_ implementi l'interfaccia |
| **Manutenzione** | Se l'interfaccia cambia, due punti da aggiornare invece di uno |
| **PHP** | L'interfaccia si eredita — ridichiararla è solo rumore lessicale |

## Casi noti (fixati)

| File | Prima | Dopo |
|------|-------|------|
| `Qua00f.php:135` | `extends BaseDateRangeModel implements Contracts\DateRangeFieldsContract` | `extends BaseDateRangeModel` |
| `Rep00f.php:143` | `extends BaseDateRangeModel implements Contracts\DateRangeFieldsContract` | `extends BaseDateRangeModel` |

Altri 5 modelli (`Asz00k1`, `Asz00f`, `Qua03f`, `Dipt00f`, `Sto00f`) erano già corretti.

## Principio generale (valido anche fuori Sigma)

> Un'interfaccia implementata da un parent class non va mai ridichiarata sul child.
> Questo vale per qualsiasi catena: `BaseModel implements X` -> figli NON ripetono `implements X`.

Vedi anche regole globali:
- [class-inheritance-principles](../../../../../../docs/wiki/rules/class-inheritance-principles.md)
- [inheritance-composition-no-duplication](../../../../../../docs/wiki/rules/inheritance-composition-no-duplication.md)

## Audit

```bash
# Cerca child class che ridichiarano interfacce del parent
rg 'extends.*implements' laravel/Modules/Sigma/app/Models/ --include='*.php'
```

Il comando deve restituire solo `BaseDateRangeModel` e `BaseModel` (le radici della catena).

## Eccezioni (NON applicabili qui)

- `@phpstan-require-implements` nei trait non è una dichiarazione ma un contratto static analysis.
- `implements` su classi che estendono una classe che implementa già = sempre da evitare.
