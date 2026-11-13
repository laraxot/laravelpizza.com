---
title: "[STORY] PHPStan cleanup — Tenant"
type: story
module: Tenant
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, tenant]
---

# [STORY] PHPStan cleanup — Tenant

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Tenant. Errori di partenza: 1 `foreach.unusedKey`, 5 `missingType.iterableValue` (TenantGapsCoverageTest), 4 (TenantCoverageBoostTest) e 16 in `SushiToCsv.php` 'in context of class@anonymous'.

## Analysis

**Scopo del codice.** I trait `SushiToCsv/SushiToJson/SushiToJsons/SushiToPhpArray` rendono modelli Eloquent in sola lettura/scrittura su file (CSV/JSON) del tenant
tramite Sushi. I test li esercitano con modelli "finti".

- **Trait `SushiToCsv`**: i docblock sono gia' corretti (`array<int, array<string, mixed>>`, `list<string>`, ...). Le 16 segnalazioni 'in context of
  `Model@anonymous/.../TenantCoverageBoostTest.php:283`' derivano dalla classe anonima del test (vedi Lessons). Soluzione: modelli con nome.
  Analizzato in contesto con nome (come gia' fanno le sonde `tests/Fixtures/Traits/SushiToCsvPhpstanProbe`) emerge l'unico punto davvero debole:
  `handleCsvCreating()` calcola il prossimo `id` da `$model->max('id')` (`mixed`) con un `@var int` non verificato (durante il lavoro un altro processo l'aveva sostituito con
  `filter_var` + `(int)`, che PHPStan rifiuta: `cast.int`). Ora `(is_numeric($maxId) ? (int) $maxId : 0) + 1`: stesso risultato (massimo numerico + 1, 1 se vuoto), nessun `@var`;
  rimossi anche i tre `@var` ridondanti in `normalizeRowsForCsv()` (i tipi vengono gia' dal docblock dell'argomento).
- **`TenantCoverageBoostTest`** / **`TenantGapsCoverageTest`**: le classi anonime (modello `catalog` JSON e CSV, stub di `ResolveTenantConfigValueAction` x2, modello `tenant_configs`)
  sono diventate fixture in `tests/Unit/Fixtures/` (come gia' `SushiToCsvCoverageModel`, `SushiToJsonsCoverageModel`, ...). Riusata `SushiToPhpArrayCoverageModel` (identica all'anonima di `tenant_configs`).
  I test conservano dati e asserzioni.
- **`SushiToJsonPerformanceTest`**: `$category` (small/medium/large/xlarge) era citata solo in un commento. L'intento era identificare il dataset nel messaggio d'errore:
  ora `Assert::assertLessThan(max, tempo, "Salvataggio dataset {$category} oltre il benchmark")` (Pest `toBeLessThan` non accetta un messaggio).

## Acceptance Criteria

- [x] Nessuna classe anonima con membri iterabili nei test segnalati
- [x] `$category` usata nei messaggi dei benchmark
- [x] Il prossimo id del CSV e' calcolato senza `@var` bugiardi e con lo stesso risultato di prima
- [x] PHPStan: 0 errori sul modulo Tenant (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [phpstan-cleanup-tenant.dev.md](./phpstan-cleanup-tenant.dev.md)
