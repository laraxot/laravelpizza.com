---
tags: [documentation, phpstan]
qmd: "phpstan test wave tenant"
issues: []
discussions: []
title: "Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20"
type: story
module: Tenant
slug: phpstan-test-wave-tenant
phase: implementazione, quality gate
status: done
created: 2026-10-20
updated: 2026-10-20
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - 7.2.phpstan-test-harness-contracts.story.md
  - 7.1.phpstan-sushi-boundaries.story.md
  - tenant-services-to-actions.story.md
  - services-to-actions-tenant.story.md
  - sushitojson-test-fixtures.story.md
owned_scope:
  - "laravel/Modules/Tenant/tests/TestCase.php"
  - "laravel/Modules/Tenant/tests/Pest.php"
  - "laravel/Modules/Tenant/tests/**/*Test.php (9 file elencati sotto)"
  - "laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php"
  - "laravel/Modules/Tenant/app/Services/**"
---

# Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20

Lane `tenant` del run descritto in [phpstan-test-wave-regression](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md). Fase BMAD: implementazione e quality gate.

## Misura

| | File | Errori |
|---|---:|---:|
| Baseline 09:00 (bucket `tenant`) | 41 | 764 |
| Ri-misura prima di toccare (stessi file) | 41 | 733 |
| Dopo il passo 1 (`TestCase.php` e `Pest.php`) | 41 | 208 |
| Dopo il passo 2 (9 test riportati alla forma Pest tipizzata, `domaintest.php` rimosso) | 40 | 16 |
| Dopo il passo 3 (produzione) | 40 | **0** |

Le ri-misure dei passi 1 e 2 contano solo gli errori sui file del bucket. Il trait `SushiToJsons.php` ha 32 errori in baseline (inclusi nei 764) che non compaiono analizzando solo quei file: PHPStan li riporta "in context of class" e solo se analizza anche le classi che usano il trait. Per misurarli ho aggiunto in lettura le 8 classi utilizzatrici (Cms `Page`, `Menu`, `Section`, `PageContent`, `Attachment`, Tenant `BaseModelJsons` e le due fixture). Esito finale: 0 errori sui 48 file di misura e 0 su `phpstan analyse Modules/Tenant` intero. Misure: `phpstan analyse` mirato, config root immutata, nessuna baseline, nessun ignore.

## Causa del salto

Il merge `7c8e9e3` del repo Tenant (2026-10-20 09:07) ha preso il lato `40f7efe`, che riporta i test alla generazione del commit `d305547` (2026-10-18). Quella generazione:

- ha un `tests/TestCase.php` di 45 righe, senza gli helper statici che i test chiamano;
- ha test scritti come classi PHPUnit (`class ... extends Tests\TestCase`, `/** @test */`, `$this->mock(...)`), contro la regola "Pest resta Pest";
- ha un `tests/Pest.php` con funzioni libere che Pest non carica (legge un solo `Pest.php`, quello della root) e che puntano a `Modules\Tenant\Models\TenantUser`, classe che non esiste.

La generazione tipizzata, a 0 errori, e' quella del commit `3e7c8c0` (2026-10-16), la stessa documentata in [TENANT-7.2](7.2.phpstan-test-harness-contracts.story.md) ("75 test mantenuti, 0 file cancellati"). Non ho inventato nulla: ho riportato i file dalla storia.

## Cause corrette

### 1. `TestCase` senza helper: 525 errori

Scopo dei metodi statici ricreati (corpo identico a `3e7c8c0:tests/TestCase.php`):

| Helper | Cosa garantisce |
|---|---|
| `mockAppService($classe, $callback)` | crea un mock Mockery della Action/servizio e lo registra nel container con `app()->instance`, cosi' `app(X::class)` restituisce il mock |
| `expectMockery($mock, $metodo)` | espettativa tipizzata; il tipo di ritorno e' `ExpectationInterface` perche' a runtime `shouldReceive()` restituisce `CompositeExpectation`, non `Expectation` (la versione con `allows()` e `instanceof Expectation` lanciava sempre) |
| `sushiModel()`, `sushiJsonPath()`, `sushiTestDirectory()`, `sushiTestData()`, `sushiRowById()`, `jsonRecordAt()` | fixture del modello Sushi di test, con tipo reale invece di `mixed` |
| `createTenant()`, `tenantModel()`, `secondTenantModel()`, `tenantId()`, `setCurrentTenant()` | tenant di prova tipizzati |
| `setServerNameForTenantTest()` | imposta/rimuove `SERVER_NAME` per i test di risoluzione del tenant |
| `tenantDbUnavailable()` | oggi `true`: i test che scrivono sul DB tenant si saltano (il DB di test non esiste) |
| `skipCurrentTest()`, `readJsonFileAsArray()`, `decodeJsonString()`, `decodeTenantJsonFile()`, `runArtisanCommand()`, `assertDatabaseHasRow()` | utilita' tipizzate |
| proprieta' statiche `$testDirectory`, `$testJsonPath`, `$sushiModel`... | stato condiviso tra i test Sushi (prima davano `property.staticAccess`) |

Sparisce a cascata la valanga di `mixed`: `staticMethod.notFound` 162, `method.notFound` 30, `property.staticAccess` 28, e le catene `method.nonObject`/`property.nonObject`/`offsetAccess` derivate. `tests/Pest.php` e' tornato commento-only (19 errori: funzioni libere morte e `TenantUser` assente).

### 2. Nove file di test nella generazione PHPUnit: 192 errori

Riportati da `git -C laravel/Modules/Tenant show 3e7c8c0:<path>`. Il corpo precedente (generazione `d305547`) resta in git, per ogni path:

- `tests/Unit/Traits/SushiToJsonTest.php`
- `tests/Unit/SushiToJsonTraitTest.php`
- `tests/Unit/SushiToJsonTraitPestTest.php`
- `tests/Integration/SushiToJsonIntegrationTest.php`
- `tests/Integration/Traits/SushiToJsonIntegrationTest.php`
- `tests/Performance/SushiToJsonPerformanceTest.php`
- `tests/Feature/TenantBusinessLogicTest.php`
- `tests/Unit/DomainTest.php`
- `tests/Unit/Models/BaseModelTest.php`

`tests/Unit/domaintest.php` (variante di `DomainTest.php` che differisce solo per maiuscole) e' stato rimosso: testava le stesse due cose. Chiude la coppia divergente descritta in [case-variant-collisions](../case-variant-collisions.md). Corpo: `git -C laravel/Modules/Tenant show HEAD:tests/Unit/domaintest.php`.

Nessun file neutralizzato con `->skip(...)`: il SUT esiste per tutti.

### 3. Produzione: 48 errori

- **`SushiToJsons.php` (32, una causa)**: `getRowFromJsonFile()` non aveva tipo di ritorno e concatenava `$row['id']` (mixed). Ora restituisce `array<string, mixed>|null`, delega a `mapJsonFileToRow()` e il prefisso `a.b.` per id e slug delle righe in sottocartella sta in `prefixRowKeys()`. Effetto di comportamento, tutti voluti:
  - un JSON che non e' un array (per esempio il `bad.json` con contenuto `null` del test di copertura) ora viene saltato; prima `buildRowFromSchema()` riceveva `null` e lanciava `TypeError`;
  - directory `database/content/<tabella>` assente: ora restituisce `[]`. `File::allFiles()` lancia `DirectoryNotFoundException` (verificato), la vecchia `File::glob()` restituiva `[]`. E' il ritorno al comportamento precedente al `d305547`, non una novita';
  - id e slug vengono prefissati solo se sono string o int (prima concatenava anche `null`).
  Verifica a runtime: riga in `sub/deep/2.json` esposta come id `sub.deep.2`, `bad.json` e `note.txt` ignorati, directory assente senza eccezione.
- **`TenantService.php` (10)**: tipi array mancanti (`array<string, mixed>`, `array<int, array{id: int, name: string}>`, `SplFileInfo` sulle closure), un `@var array` superfluo, e un bug reale: il parametro si chiamava `$_default` ma il corpo leggeva `$default` (mai definita), quindi il blocco "default" era codice morto che comunque finiva in un `throw`. Ora `config($key, $default)` restituisce il default se la chiave manca, come fa `ResolveTenantConfigValueAction`.
- **Resolver di config (6)**: `ConfigResolverInterface`, `MorphMapConfigResolver`, `StandardConfigResolver` (`@param array<mixed>`, e `handleMissingConfig()` non calcola piu' un `Arr::set` che buttava via) e `DatabaseConfigResolver` (generics della `Collection`). Comportamento invariato: chiave assente con default esplicito lancia ancora `Configuration key not found`.

## File saltati per gate

Nessuno: ogni file ha superato lock e mtime (tutti fermi alle 08:57). Lock rilasciati a fine file.

## Blocchi cross-modulo

- `Modules/Geo/app/Services/HereService.php` chiama `TenantService::config('services.here.api_key')` e ha un errore suo (riga 17, `missingType.iterableValue` sul ritorno di `getDurationAndLength()`), non mio. E' il motivo per cui `TenantService` non e' stato eliminato.
- Nella prima ri-misura compariva `Modules/Cms/app/Models/Page.php:125` (`MultipleRecordsFoundException`): sparito alla seconda, quindi di un'altra lane.

## Debito rimasto, non visibile a PHPStan

I test girano (`XDEBUG_MODE=off ./vendor/bin/pest --no-coverage Modules/Tenant/tests`): **158 pass, 38 skip, 13 fail**. I 13 non c'entrano con i tipi e non li ho toccati:

| Test | Causa osservata |
|---|---|
| `TenantGapsCoverageTest` (3) | `ReflectionMethod` su metodi che il SUT non ha: `maxIdFromRows`, `maxIdFromDatabase`, `applyAuditFields`, `GetTenantNameAction::resolveFromDefaultHost` |
| `GetTenantNameActionTest` (4) | si aspetta `com/example/myapp` e `test/myapp`, l'Action restituisce `localhost`; con `APP_URL` vuoto si aspetta `localhost` e ottiene `''` |
| `ApplicationPublicPathCoverageTest` (1) | si aspetta `../public_html/foo/bar`, ottiene `public/foo/bar` |
| `TenantCoverageBoostTest` (1) | `DomainResource` non espone la colonna `updated_at` |
| `SushiToJsonTest`, `SushiToJsonTraitTest` (2) | "saving fails": `saveToJson()` restituisce `true` dove il test si aspetta `false` |
| `SushiConnectionByNameTest` (1) | file JSON vuoto: `Safe\json_decode` lancia `JsonException` in `SushiToJson::getRows` (trait singolare) |
| `TenantStatementCoverageTest` (1) | `SushiToJson::getRows` con contenuto `null`: `Assert::isArray` lancia |
| `SushiToJsonPerformanceTest` (1) | "scales efficiently with data size" e' a tempo: in 3 esecuzioni ha dato 2 pass e 1 fail, instabile |

## Decisioni aperte per l'utente

1. **`app/Services/` torna per la quarta volta** (`a85698f` 2026-07-02, archivio 2026-07-14, [story 2026-09-04](tenant-services-to-actions.story.md), ora il pull). Raccomando di eliminarlo di nuovo, ma serve prima portare `Geo\Services\HereService` su `Geo\Actions\Here\GetHereRouteSummaryAction`, che esiste gia'. Il registry e i resolver non hanno nessun chiamante fuori dai test. Corretti sul posto, come da regola di lane. Nota in [services-config-dead-code-retired](../services-config-dead-code-retired.md).
2. **I sync continuano a riportare la generazione `d305547`.** Se `laraxot/dev` non viene riallineato, alla prossima merge il problema si ripresenta identico.
3. I 13 test rossi sopra: allineare i test al comportamento reale o correggere il prodotto, caso per caso.
4. `tests/Feature/README.md` descrive un `TenantBusinessLogicTest.php.skip` che non esiste piu': e' fuori da `docs/`, non l'ho riscritto.

## Docs aggiornate

- `docs/00-index.md`: link rotto a una story inesistente rimosso, riga "Services eliminati" corretta, story nuova linkata, conteggio `stories/` portato a 22.
- `docs/case-variant-collisions.md`: esito della coppia `domaintest.php`; restano due coppie nei seeder (`DomainsSeeder.php`, `TestSushiSeeder.php`).
- `docs/testing.md`: elenco degli helper di `TestCase` e link a questa story.
- `docs/services-config-dead-code-retired.md`: aggiornamento 2026-10-20, i file sono tornati.

### Duplicati segnalati, non toccati

- Indici: `00-index.md`, `00-index.md`, `index.md`, `index.md`; generati: `index-generated-3.md`, `index-generated-3.md`, `index-generated-3.md`.
- Nomi troncati o con variante: `arr-first-vs-collect-first-decision.md` / `...-ision.md`, `runninginconsole-check-decision.md` / `...-ision.md`, `runninginconsole-check-removal-summary.md` / `...-sumy.md`.
- Conflitti: `conflict-resolution-2.md`, `conflict-resolution-fixes-2.md`, `conflict-resolution-fixes-2.md`, `conflict-resolutiones.md`.
- `confidence-guidelines-3.md` / `confidence-guidelines-3.md`.
