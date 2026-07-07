---
title: Policy modello — contratto Laravel (Job)
type: concept
module: Job
confidence: high
updated: 2026-06-30
tags: [job, policy, laravel, filament]
related:
  - ../../../../../../docs/wiki/concepts/model-policy-laravel-contract.md
  - ../../../Xot/docs/wiki/concepts/policy-inheritance-strategy.md
  - ../../ponytail-audit-over-engineering.md
  - ./policy-restoration-incident.md
---

# Policy modello — contratto Laravel (Job)

Delta modulo. Hub progetto: [docs/wiki/concepts/model-policy-laravel-contract.md](../../../../../../docs/wiki/concepts/model-policy-laravel-contract.md).

## Scopo

Ogni modello Eloquent/Filament con autorizzazione deve avere la propria classe `Modules\Job\Models\Policies\{Model}Policy`.

## Perché non sono «vuote» o eliminabili

Laravel risolve la policy per **convenzione di naming** (`Export` → `ExportPolicy`) quando si chiama:

- `$this->authorize()` / `Gate::authorize()`
- Filament `->authorize()` su Resource e azioni
- `$user->can('update', $export)`

Un file che estende solo `JobBasePolicy` senza metodi propri **non è codice morto**: è il **binding** tra modello e gerarchia policy del modulo.

## Inventario Job (2026-06-30)

15 policy modello + `JobBasePolicy`: `Export`, `Import`, `FailedImportRow`, `Frequency`, `JobManager`, `JobsWaiting`, `Parameter`, `Result`, `Schedule`, `ScheduleHistory`, `Task`, `TaskComment`, `Job`, `JobBatch`, `FailedJob`.

## Pattern canonico

```php
abstract class JobBasePolicy
{
    public function before(UserContract $user, string $_ability): ?bool { /* … */ }
}

// OBBLIGATORIO per Laravel — forma minima valida
class ExportPolicy extends JobBasePolicy {}
```

Variante con permessi espliciti: metodi `viewAny`, `create`, … con `hasPermissionTo()`.

## Anti-pattern (vietato)

- ❌ Cancellare `ExportPolicy` perché «sembra stub»
- ❌ Unificare tutte le policy in un solo file
- ❌ Rinominare in `.bak` senza sostituire il mapping Gate

## Collegamenti

- [policy-inheritance-strategy.md](../../../Xot/docs/wiki/concepts/policy-inheritance-strategy.md)
- [policy-restoration-incident.md](./policy-restoration-incident.md)
