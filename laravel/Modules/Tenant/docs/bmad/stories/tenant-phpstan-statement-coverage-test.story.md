---
title: "Tenant: PHPStan TenantStatementCoverageTest loadExistingData"
type: story
module: Tenant
status: blocked
phase: quality-gates
priority: P1
related:
  - 8.2-phpstan-l10-tenant-sushi-fixes.story.md
tags: [tenant, phpstan, sushi-to-json, test]
qmd: "tenant phpstan statement coverage loadexistingdata assert"
updated: 2026-10-21
---

# Tenant: PHPStan TenantStatementCoverageTest

## Scopo funzionale

`TenantStatementCoverageTest` esercita il trait `SushiToJson` sul fixture `SushiToJsonCoverageModel`: lettura/scrittura JSON tenant, `getSushiRows()` con filtri schema, audit e helper privati.

## Problema PHPStan (noto)

`TenantStatementCoverageTest.php:334`: `Assert::assertSame([], $model->loadExistingData())` ridondante: il ritorno è già `array` stretto; dopo `File::put($jsonPath, 'null')` e `getSushiRows()` che lancia, l’assert non aggiunge vincolo utile a PHPStan (`assertSame` con `[]` sempre vero sul lato destro inferito).

## Fix previsto (non applicato)

Sostituire con assert comportamentale, ad esempio:

- `expect(fn (): array => $model->loadExistingData())->toThrow(...)` se JSON `null` non è array valido per `loadExistingData()`, oppure
- assert sul contenuto decodificato / assenza file dopo il branch che testa `getSushiRows()`.

Nessun `@phpstan-ignore`.

## STOP: lock modulo

**Data:** 2026-10-21

`bashscripts/lock/Tenant.lock` attivo:

- Task: `phpstan-cluster1-20261006`
- Agent: `swarm-cluster1-tenant-sigma-pdnd`
- LOCKED at: 2026-10-06T09:56:48+02:00

Regola brief: non forzare edit su Tenant finché il lock non è rilasciato dall’orchestratore/proprietario.

## Prossimo step

1. `bash bashscripts/lock/unlock.sh bashscripts/lock/Tenant.lock '<reason>'` (solo owner)
2. Patch riga ~334 in `TenantStatementCoverageTest.php`
3. `phpstan analyse Modules/Tenant` + Pest mirato sul file test
