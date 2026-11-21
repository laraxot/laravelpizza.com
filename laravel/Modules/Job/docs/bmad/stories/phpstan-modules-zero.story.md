---
title: "PHPStan modules zero — Job"
module: Job
type: story
status: done
priority: high
created: 2026-11-16
updated: 2026-11-16
owner: quality-guardian
tags:
  - phpstan
  - quality-gate
  - job
qmd: "phpstan job modules zero variable unused AdminPanelProvider JobProvidersCoverageTest"
---

# Story: PHPStan modules zero — Job

## Scopo

Portare `Modules/Job` a **0 errori PHPStan**, senza ignore.

## Inventario (prima)

Sorgente: `/tmp/phpstan_ptvx_fila5/modules/Job.json` → **1** file error.

| File | Errore |
|------|--------|
| `tests/unit/providers/JobProvidersCoverageTest.php` | `Variable $provider is never read` (L136) |

## Root cause

Inventario allineato a una versione del test dove `$provider` veniva creato senza assert. Sul disco attuale il caso `AdminPanelProvider` usa `$provider` in `Assert::assertInstanceOf(...)` (blocco ~L130–133); la riga 136 è un `ReflectionProperty`, non una variabile inutilizzata.

## Fix

Nessuna modifica codice in questa passata. Verifica live:

```bash
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Job
```

**Dopo: 0 errori.**

## Lock

- Acquisito: `phpstan-Job` (task 40, agent quality-guardian)
- Rilasciato al gate verde

## Acceptance criteria

- [x] PHPStan `Modules/Job` = 0
- [x] Nessun ignore PHPStan aggiunto
- [x] Story in `docs/bmad/stories/` del modulo
