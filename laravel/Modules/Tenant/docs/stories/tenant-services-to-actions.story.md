---
tags: [documentation]
qmd: "tenant services to actions.story"
issues: []
discussions: []
title: "Tenant: eliminazione app/Services, conversione a QueueableAction"
type: story
module: Tenant
slug: tenant-services-to-actions
status: done
created: 2026-09-04
updated: 2026-09-04
owned_scope:
  - "laravel/Modules/Tenant/app/Services/**" (deleted entirely)
  - "laravel/Modules/Tenant/tests/Unit/TenantCoverageBoostTest.php"
  - "laravel/Modules/Tenant/tests/Unit/TenantStatementCoverageTest.php"
  - "laravel/Modules/Tenant/tests/Unit/TenantGapsCoverageTest.php"
  - "laravel/Modules/Tenant/docs/coverage.md"
related:
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../concepts/tenant-service-to-actions-migration.md
  - ../../../../bashscripts/ai/wiki/rules/multi-agent-same-repo-race.md
  - ../../../../bashscripts/ai/wiki/rules/module-repos-huge-uncommitted-drift.md
---

# Tenant: eliminazione app/Services, conversione a QueueableAction

## Contesto

Regola di progetto: "RELIGION, NO EXCEPTIONS" —
`bashscripts/ai/wiki/rules/no-services-rule.md`. Nessuna classe `app/Services/*Service`
per business logic; tutto va in `app/Actions/**` come
`Spatie\QueueableAction\QueueableAction` con un singolo `execute(...)`. Una classe senza
un vero `execute()` non vive comunque in `Actions/`: va spostata altrove (Adapters,
Contracts, Datas) — o rimossa se e' morta.

`Modules/Tenant/app/Services/` conteneva 7 file. Questo documento registra la
classificazione file-per-file (Kind A = god-service facade da smontare in Action
dedicate; Kind B = collaboratore/Strategy che implementa un'interfaccia per un
registry), cosi' che nessuno debba rifare l'indagine.

## Stato di partenza (git status --short, prima di ogni modifica)

`Modules/Tenant` aveva ~87 file gia' modificati e non committati da una sessione
concorrente (docs, model, migration, quasi tutti i test — riformattazione Pint
`new Foo` → `new Foo()`, rename `mockService` → `TestCase::mockAppService`,
`shouldReceive` → `TestCase::expectMockery`). Non toccato ne' scartato nulla di
quel lavoro: gli unici file the cui contenuto e' stato modificato in questo task sono
quelli elencati in `owned_scope` sopra, e la modifica e' stata fatta *sopra* il
contenuto gia' presente (mai `git checkout`/`reset` per "ripulire" prima di editare).

## Classificazione file per file

| File | Kind | Callers reali (repo-wide grep) | Decisione | Perche' |
|---|---|---|---|---|
| `app/Services/TenantService.php` | A — facade gia' sottile | Solo test (`TenantCoverageBoostTest.php`, `TenantStatementCoverageTest.php`); 2 menzioni in `Modules/Notify`/`Modules/User` sono commenti morti, non call site | **Eliminata**. Ogni metodo delegava gia' 1:1 a un'Action esistente (`GetTenantNameAction`, `GetTenantFilePathAction`, `ResolveTenantConfigValueAction`, `GetTenantConfigPathAction`, `GetTenantConfigArrayAction`, `SaveTenantConfigAction`, `GetTenantConfigNamesAction`, `ResolveTenantModelClassAction`, `ResolveTenantModelInstanceAction`, `TranslateTenantKeyAction`, `GetTenantModulesAction`) — tutte gia' in `app/Actions/**`, tutte gia' `QueueableAction`. Caller aggiornati a `app(XxxAction::class)->execute(...)`. | Il lavoro vero era gia' fatto (vedi `docs/concepts/tenant-service-to-actions-migration.md`, 2026-07-21); restava solo ritirare il wrapper statico e i suoi ultimi due call site di test. |
| `app/Services/Config/ConfigResolverRegistry.php` | B — Registry/Strategy dispatcher | **Zero** in produzione: non istanziata, non bindata in `TenantServiceProvider`, non referenziata da `ResolveTenantConfigValueAction` (il vero path usa `FilterConfigStringKeysAction`+`MergeRecursiveStringKeyConfigAction`, implementazione indipendente). Solo test la usavano. | **Eliminata**, non rilocata sotto `Actions/Config/Strategies/`. | Codice morto verificato via grep repo-wide + lettura di `TenantServiceProvider`. Rilocare codice morto sotto `Actions/` avrebbe solo spostato l'anti-pattern di un livello, non l'avrebbe rimosso — la guida della regola ("una classe senza execute() non vive in Actions/") si applica a maggior ragione a una classe senza *nessun* chiamante reale. |
| `app/Services/Config/Contracts/ConfigResolverInterface.php` | B — Contract per il registry sopra | Solo il registry morto + i 3 resolver sotto + test | **Eliminata** (parte dello stesso sottoalbero morto). | Stesso motivo. |
| `app/Services/Config/Resolvers/DatabaseConfigResolver.php` | B — Strategy | Solo dal registry morto + test | **Eliminata**. | Stesso motivo. |
| `app/Services/Config/Resolvers/MorphMapConfigResolver.php` | B — Strategy | Solo dal registry morto + test (usava anche `TenantService::filePath()`, gia' morto) | **Eliminata**. | Stesso motivo. |
| `app/Services/Config/Resolvers/StandardConfigResolver.php` | B — Strategy (fallback) | Solo dal registry morto + test (usava anche `TenantService::getName()`) | **Eliminata**. | Stesso motivo. |
| `app/Services/Config/ConfigStringKeyFilter.php` | A — utility con 2 metodi statici indipendenti | Solo test | **Eliminata senza creare nuove Action**: `onlyStringKeys()` e `mergeRecursive()` sono duplicati byte-per-byte di `app/Actions/Config/FilterConfigStringKeysAction::execute()` e `app/Actions/Config/MergeRecursiveStringKeyConfigAction::execute()`, gia' esistenti, gia' `QueueableAction`, gia' usate dal path di produzione reale. | Non ha senso creare una Action duplicata quando l'equivalente gia' esiste — il caller di test e' stato ripuntato sulle Action reali. |

**Precedente reale nello stesso repo**: il commit `a85698f` ("Delete dead
ConfigResolverRegistry strategy-chain (zero callers)", 2026-07-02, stesso autore) aveva
gia' raggiunto la stessa conclusione per l'intero sottoalbero `ConfigResolverRegistry` +
`Resolvers/*` + `Contracts/ConfigResolverInterface` (verificato con
`git merge-base --is-ancestor a85698f HEAD` → si, e' un antenato di HEAD), con audit via
phpmd/phpinsights/grep. I file sono ricomparsi in un secondo momento tramite un commit
anonimo (`3b521d2`, messaggio `.`), verosimilmente un ripristino accidentale, non una
reintroduzione deliberata. Questa sessione ha **rifatto la verifica in modo indipendente**
(non si e' fidata del vecchio commit) e ha raggiunto la stessa conclusione con evidenza
fresca.

## Call site aggiornati

- `Modules/Tenant/tests/Unit/TenantCoverageBoostTest.php`:
  - rimossi gli `use` verso `Modules\Tenant\Services\*` (7 import)
  - `TenantService::xxx()` (10 chiamate) → `app(XxxAction::class)->execute(...)`
  - `ConfigStringKeyFilter::onlyStringKeys/mergeRecursive` rimossi (duplicato di un test
    gia' presente nello stesso file su `FilterConfigStringKeysAction`/
    `MergeRecursiveStringKeyConfigAction`)
  - test `'config resolver registry prefers matching resolvers...'` ridotto a
    `'DatabaseConfig model casts port and options correctly'` (unica parte non morta:
    la copertura del cast del model `DatabaseConfig`, indipendente dai resolver)
- `Modules/Tenant/tests/Unit/TenantStatementCoverageTest.php`:
  - rimossi gli `use` verso `Modules\Tenant\Services\*` (5 import) e `ReflectionClass`
    (usata solo nel describe rimosso)
  - rimosso l'intero describe `'Tenant statement coverage — resolvers'` (4 test sui
    resolver morti + registry)
  - `TenantService::model('tenant')` rimosso (duplicato della riga precedente nello
    stesso test, che gia' verifica `ResolveTenantModelInstanceAction` direttamente)
- `Modules/Tenant/tests/Unit/TenantGapsCoverageTest.php`:
  - rimossi gli `use` verso `Modules\Tenant\Services\Config\Resolvers\*`,
    `Illuminate\Http\Request as HttpRequest`, `Illuminate\Support\Facades\Request`,
    `Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction` (tutti usati solo nei
    blocchi rimossi)
  - rimossi 3 test dedicati ai resolver morti (`MorphMapConfigResolver`,
    `DatabaseConfigResolver`, `StandardConfigResolver`)
  - rimossa la coda del test `'TenantServiceProvider load user connection and filter
    model classes'` che istanziava `DatabaseConfigResolver` per una asserzione scollegata
    dallo scopo del test

**Cross-module**: nessun call site reale fuori da `Modules/Tenant`. Trovate solo 2
menzioni in commenti morti (`Modules/Notify/app/Datas/SMS/AgiletelecomData.php:38`,
`Modules/User/resources/views/pages/index.blade.php:17`), non funzionali — lasciate
intatte, nessun modulo esterno da committare.

## Collisione con un'altra sessione (scoperta durante il lavoro)

Durante la verifica PHPStan sono comparsi 7 file **non tracciati** (`??`), non creati da
questa sessione, con lo stesso obiettivo (stessa migrazione Services→Actions) ma con un
template rotto (parentesi graffa raddoppiata, nome classe non rinominato):

```
Modules/Tenant/app/Actions/Config/ConfigResolverInterfaceAction.php
Modules/Tenant/app/Actions/Config/ConfigResolverRegistryAction.php
Modules/Tenant/app/Actions/Config/ConfigStringKeyFilterAction.php
Modules/Tenant/app/Actions/Config/DatabaseConfigResolverAction.php
Modules/Tenant/app/Actions/Config/MorphMapConfigResolverAction.php
Modules/Tenant/app/Actions/Config/StandardConfigResolverAction.php
Modules/Tenant/app/Actions/TenantAction.php
```

`mtime` di questi file e' rimasto invariato per oltre 5 minuti di osservazione (nessuna
scrittura attiva rilevata) — probabile sessione concorrente andata in errore/arrestata a
meta' di uno script di trasformazione automatica, non ripulita. **Non toccati** (mai
`rm`/edit su file non miei), per rispetto della regola "non scartare il lavoro in corso
di un'altra sessione". Bloccano `phpstan analyse Modules/Tenant` con 6 errori
`phpstan.parse` non ignorabili. Verifica alternativa eseguita: analisi esplicita di
tutti i 134 file `.php` del modulo **esclusi questi 7** → `[OK] No errors`. Se un'altra
sessione legge questa story: i file sopra sono da correggere o rimuovere autonomamente,
non fanno parte di questo lavoro.

## Verifica

- **PHPStan**: baseline vera (`clear-result-cache` + `analyse Modules/Tenant
  --no-progress --error-format=table`) → 0 errori. Dopo il diff, stesso comando bloccato
  dalla collisione sopra (6 errori, tutti nei 7 file estranei); verifica alternativa sui
  134 file del modulo esclusi quelli → 0 errori. Nessun nuovo errore introdotto da questo
  diff.
- **PHPMD**: run sull'intero modulo va in crash su una classe anonima pre-esistente
  (noto, vedi `quality-tooling-real-commands.md`). Run mirato sui 3 file di test
  modificati: nessuna violazione.
- **Pest**: `./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml
  --no-coverage --filter "TenantCoverageBoostTest|TenantStatementCoverageTest|TenantGapsCoverageTest"`
  → 29 passed, 12 failed. Tutti i 12 fallimenti sono `RuntimeException: Unexpected
  mockery expectation type.` in `tests/TestCase.php:208` (`expectMockery()`), helper
  pre-esistente e gia' modificato-non-committato dalla sessione concorrente prima
  dell'inizio di questo task; nessuno dei fallimenti cade su una riga toccata da questo
  diff (verificato riga per riga) e il nuovo blocco di test aggiunto da questa sessione
  passa.

## File toccati da questa sessione (per il commit)

```
D  app/Services/TenantService.php
D  app/Services/Config/ConfigResolverRegistry.php
D  app/Services/Config/ConfigStringKeyFilter.php
D  app/Services/Config/Contracts/ConfigResolverInterface.php
D  app/Services/Config/Resolvers/DatabaseConfigResolver.php
D  app/Services/Config/Resolvers/MorphMapConfigResolver.php
D  app/Services/Config/Resolvers/StandardConfigResolver.php
M  tests/Unit/TenantCoverageBoostTest.php
M  tests/Unit/TenantStatementCoverageTest.php
M  tests/Unit/TenantGapsCoverageTest.php
M  docs/coverage.md
A  docs/stories/tenant-services-to-actions.story.md
```
