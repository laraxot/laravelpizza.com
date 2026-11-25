---
title: "phpstan-modules-zero"
type: story
status: done
module: "Tenant"
tags:
  - phpstan
  - bmad
  - quality-gate
qmd: "phpstan module Tenant zero errors quality guardian swarm"
updated: "2026-11-16"
---

# Story: PHPStan zero — Tenant

## Scopo

Portare `Modules/Tenant` a **0 errori** PHPStan (level max progetto) senza ignore, senza `mixed` di comodo, rispettando Filament/XotBase e array PHP una chiave per riga.

## Metriche

| | |
|---|---|
| Errori iniziali | **111** |
| Errori finali | **0** |
| Data gate | 2026-11-16 |

## Cosa e' stato fatto

Root cause: commit 3e548fe aveva cancellato fixture/test helper ancora referenziati. Ripristinati da git + Safe\tempnam/file_put_contents/unlink nel test CreateJsonFileByRecordActionStringId.

## Verifica

```bash
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Tenant --no-progress
```

Esito: **0 file_errors**.

## Note operative

- Lock: `bash bashscripts/lock/lock.sh phpstan-Tenant 40`
- Activity/User/Xot non toccati (marker/bootstrap altri agenti)
- Filament 5.11 `Filters\Concerns\HasForm`: `form()` canonico; `schema()` e' `@deprecated Use form()`
- Se PHPStan inverte form↔schema: svuotare `/tmp/phpstan` prima di fidarsi

## Collegamenti

- Standing order BMAD / Pest / array PHP
- Swarm quality-guardian sessione 2026-11-16
