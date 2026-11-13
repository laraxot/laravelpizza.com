---
title: "[DEV] PHPStan cleanup — Tenant"
type: dev
module: Tenant
story: "./phpstan-cleanup-tenant.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, tenant]
---

# [DEV] PHPStan cleanup — Tenant

## Technical Plan

- Non cambiare il trait: l'errore e' nel modo in cui PHPStan legge le classi anonime
- Conservare tabella/schema/dati dei test (stessa semantica), solo classi con nome

## Files to Modify

- `app/Models/Traits/SushiToCsv.php` (`handleCsvCreating()`, `normalizeRowsForCsv()`)
- `tests/Unit/TenantCoverageBoostTest.php`, `tests/Unit/TenantGapsCoverageTest.php`, `tests/Performance/SushiToJsonPerformanceTest.php`
- `tests/Unit/Fixtures/CatalogSushiJsonsModel.php`, `CatalogSushiCsvModel.php`, `TenantConfigValueResolverStub.php`, `SqliteTenantConfigValueResolverStub.php` (nuovi)
- `docs/README.md` (write-back)

## Implementation Steps

- [x] Rilette le modifiche concorrenti a `SushiToCsv.php` e corretto l'ultimo `cast.int` residuo
- [x] Riprodotto: l'errore sopravvive a un run su singolo file ma sparisce rinominando il file o cancellando le voci di cache dei name-scope
- [x] Create le fixture con nome e sostituite le anonime
- [x] Rimossi gli import non piu' usati
- [x] Messaggi di benchmark con `$category`
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (i test Tenant scrivono su file temporanei e mockano i servizi, ma il DB di test non e' garantito isolato).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- PHPStan non risolve i docblock delle classi anonime in modo stabile: il cache dei name-scope e' indicizzato per file ma il nome della classe anonima contiene un percorso relativo alla radice dell'esecuzione (file singolo, sottoinsieme di moduli, run completo). Esecuzioni con radici diverse lasciano voci inconsistenti e compaiono falsi `missingType.iterableValue`/`missingType.generics` anche con docblock corretti. Fix deterministico: classi **con nome** in `tests/Fixtures/` (convenzione gia' usata nei moduli).
- Diagnosi riproducibile: stesso file copiato con altro nome -> 0 errori; originale -> 5; dopo aver rimosso le 2 voci di cache `FileTypeMapper` che lo citano -> 0.
- Prima di creare una fixture cercare quelle esistenti (`tests/Unit/Fixtures`): una delle quattro anonime (`tenant_configs`) aveva gia' un equivalente identico; `SushiToCsvCoverageModel` e `SushiToJsonsCoverageModel` hanno tabella/schema diversi e riusarle avrebbe cambiato i dati dei test.
- Un parametro/chiave di un ciclo usato solo in un commento e' un messaggio d'errore mancante, non codice morto.
- Togliere la classe anonima non nasconde gli errori veri: li rende deterministici (qui `cast.int` nel trait). Un `@var int` su un `mixed` e' una scorciatoia; `is_numeric()` + cast verifica davvero.
- `SushiToCsv.php` e' stato modificato da un altro processo mentre lavoravo (mtime 21:32): ho riletto lo stato attuale e completato la correzione senza sovrascrivere le altre modifiche.
