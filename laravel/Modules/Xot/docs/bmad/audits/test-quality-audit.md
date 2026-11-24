---
title: "Audit qualità suite di test — tutti i moduli"
type: audit
status: review
updated: 2026-11-16
module: Xot
qmd: "audit qualità test Pest moduli assert duplicati coverage sweep helper non caricati"
---

# Audit qualità suite di test — 18 moduli

Audit **statico** del codice test (nessuna esecuzione Pest). Scope: `laravel/Modules/*/tests`.
Totale file PHP sotto `tests/`: **~1841** (incluse fixture/helper). File che contengono
definizioni di test vere: ~1300. Config root: `laravel/phpunit.xml` scopre solo
`Modules/*/tests/Unit/**` e `Modules/*/tests/Feature/**` con suffisso `Test.php`.

## Tabella per modulo

| Modulo | File test* | % con assert reali (stima) | Layer coperti | Layer scoperti | Finding top 3 |
|---|---|---|---|---|---|
| Activity | 92 | ~95% | Unit 79, Feature 20, Filament 36 file | — | helper `tests/Helpers.php`+`PestHelpers.php` caricati solo via `Pest.php` modulo; docblock `@see Modules/Platform` stale; `mockeryExpect` duplicato (TestCase static + funzione libera) |
| Incentivi | 36 | ~90% | Unit 33, Feature 3 | Feature quasi assente | 2 sweep `*BusinessCoverage`/`DeepCoverage` delegano assert a Xot helper; 9 Resource Filament vs 11 file Filament-test |
| IndennitaCondizioniLavoro | 19 | ~90% | Unit 17, Feature 2 | Feature quasi assente | 2 sweep auto-generati; 8 Resource vs 6 test Filament |
| IndennitaResponsabilita | 41 | ~92% | Unit 36, Feature 5, Filament 28 | — | 3 sweep; 17 Resource Filament — la copertura Filament è la più ampia del repo |
| Job | 76 (+31 lowercase) | ~95% | Unit 39, Feature 10 | **albero `tests/unit`+`tests/feature` minuscolo duplicato** | stesse classi namespace `Modules\Job\Tests\Feature` in `Feature/` e `feature/` → doppia esecuzione/collisione in run scoped; non scoperti da phpunit.xml root |
| Lang | 29 | ~95% | Unit 23, Feature 4 | `tests/unit` minuscolo (3 file) | fixture 19 file; sweep minori |
| Media | 39 | ~95% | Unit 39, Feature 1 | **Feature quasi assente** | 2 `->todo()` in `MediaActionsCoverageTest`; solo 1 Feature test per 3 Resource |
| Notify | 142 | ~95% | Unit 123, Feature 17, Filament 21 | — | **2 duplicati lowercase** `jsoncomponentstest.php` + `emailtemplatestest.php` (varianti stale senza `uses(TestCase)`); 5 sweep |
| Pdnd | 15 | ~90% | Unit 13, Feature 2 | — | `usleep(50000)` in `PdndHundredPercentCoverageTest.php:305`; 3 sweep su soli 15 file |
| Performance | 21 | ~90% | Unit 20, Feature 1 | **Feature quasi assente; 22 Resource Filament vs 9 test Filament** | 2 sweep; gap Filament più marcato dopo User |
| Progressioni | 33 | ~92% | Unit 25, Feature 8, Filament 17 | — | 3 sweep incluso `ProgressioniExecuteCoverage50Test` |
| Ptv | 53 | ~95% | Unit 50, Feature 3, Filament 26 | — | 1 sweep; sbilanciato Unit/Feature |
| Rating | 30 | ~95% | Unit 29, Feature 1 | Feature quasi assente | 4 file con RefreshDatabase (eccezione rispetto al resto) |
| Sigma | 45 | ~92% | Unit 35, Feature 8 | — | 5 file senza `uses()`: 3 estendono `PHPUnit\Framework\TestCase` puro (superficiali); 2 sweep |
| Tenant | 45 | ~95% | Unit 35, Feature 6, Integration 3, Performance 1 | Integration/Performance **mai scoperti** da phpunit.xml root | 41/45 file senza `uses()` (OK solo grazie al binding globale `Pest.php` modulo) |
| UI | 56 | ~92% | Unit 32, Feature 22 | — | 12 Feature senza `uses()` (unit puri OK); assert su label hardcoded `'Order column'`; 2 fixture-probe contati come test |
| User | ~447 + 248 audit | ~66% file reali | Unit 127, Feature 70, Filament 62 | **`audit-coverage/` = 248 test finti** | vedi sotto — è il modulo più problematico |
| Xot | 231 | ~97% | Unit 205, Feature 18, Filament 110 | — | infra condivisa (`XotBaseTestCase`, `ModuleDeepCoverage`, helpers autoloaded); 6 file "senza assert" sono support/architettura |

\* "File test" = file con `test()`/`it()`/`describe()` o classi `*Test`. Esclude fixture,
`TestCase.php`, `Pest.php`, `CreatesApplication.php`, `helpers*.php`.

## Finding trasversali

### 1. `User/audit-coverage/` — 248 test che non testano nulla (CRITICO)
`laravel/Modules/User/audit-coverage/tests/NN-AuditBridgeTestNN.php` (248 file):
ognuno estende `PHPUnit\Framework\TestCase` e contiene una sola riga
`self::assertSame(true, filter_var('true', FILTER_VALIDATE_BOOLEAN));`
(o varianti equivalenti). Sono un padding di coverage: gonfiano il conteggio test
(~36% dei file-test di User) senza coprire codice. Non sono scoperti da
`phpunit.xml` root (path `User/audit-coverage/tests`, fuori da `Modules/*/tests/`),
ma sporcano analisi statiche, PHPStan e revisioni.

### 2. Scoperta test non uniforme — intere directory mai eseguite in run root
`laravel/phpunit.xml` copre solo `Modules/*/tests/Unit` e `Modules/*/tests/Feature`
(suffisso `Test.php`, case-sensitive). Di conseguenza **non girano** in un `vendor/bin/pest`
root:

- `Job/tests/unit/` + `Job/tests/feature/` (minuscoli, ~31 file — duplicati stale dei canonici)
- `Lang/tests/unit/` (3 file)
- `Tenant/tests/Integration/` (3), `Tenant/tests/Performance/` (1)
- `Activity/tests/Security/` (1), `Media/tests/Filament/` (1)
- `Sigma/tests/TestTraits|TestModels|Factories` (3)
- `User/tests/audit-coverage/` (248, vedi sopra)
- `User/tests/Feature/user-management-business-logic.php` — file Pest con `describe()`
  ma **senza suffisso `Test.php`** → non scoperto in root run; probabilmente duplicato
  di `UserManagementBusinessLogicTest.php`
- `Notify/tests/Feature/jsoncomponentstest.php`, `emailtemplatestest.php` — lowercase,
  non scoperti in root run **ma duplicano** i canonici `JsonComponentsTest.php` /
  `EmailTemplatesTest.php` in run scoped (stesse `describe`/test name, assertion diverse,
  nessun `uses(TestCase::class)`)

In pratica esistono **due regimi di run** non equivalenti: root `pest` (sotto-insieme)
vs scoped `pest Modules/X/tests` (tutto, inclusi i duplicati). Nessun modulo tranne
Activity, Job, Rating, UI, User ha `phpunit.xml` proprio.

### 3. Bootstrap Pest duplice e fragilità helper
I `tests/Pest.php` dei moduli contengono quasi tutti lo stesso commento:
"questo file NON viene caricato — Pest legge Pest.php/Helpers.php da un solo percorso
per run". Conseguenze:

- Le funzioni libere definite in `tests/Helpers.php`/`PestHelpers.php` (centinaia:
  `activityCreateUser`, `incentiviFakeUser`, `notifyBehaviorUser`, `userBehaviorUser`,
  `teamMgmtBiz*`, `mockeryExpect`, …) sono disponibili **solo** se il run è scoped
  sulla directory del modulo (Pest carica `Helpers.php` da lì) oppure se il file è
  `require_once`-ato dal test.
- **Solo User e Xot** registrano helper in `composer.json → autoload-dev.files`
  (`tests/Support/helpers.php`). Tutti gli altri moduli dipendono dal bootstrap Pest.
- **`User/tests/Helpers.php` definisce `mockeryExpect()` libera ma NON è autoloadata**
  (autoload-dev files = solo `tests/Support/helpers.php`) e non è `require`-ata:
  i ~4 file User che la chiamano (`UserGapAttackCoverageTest`, `UserExecuteCoverage50Test`,
  `UserPolicyBehaviorTest`, …) funzionano solo in run scoped dove Pest carica
  `tests/Helpers.php` come bootstrap. In run root → `Call to undefined function`.
  Activity ha risolto lo stesso problema con `TestCase::mockeryExpect()` statico
  (Activity/tests/TestCase.php:90) **ma ha mantenuto anche** la funzione libera
  identica in `tests/Helpers.php:48` → duplicato.
- `User/tests/Support/helpers-core.php` e `helpers-extended.php` (391 righe) **non sono
  referenziati da nessun file** (nessun require, nessun autoload) → dead code duplicato
  di `helpers.php` (stesse funzioni `createUser`, `createTeam`, `makeUser`…).
- `Activity/tests/Helpers.php:5` docblock `@see Modules/Platform/tests/PestHelpers.php`
  — il modulo Platform non esiste.

### 4. Suite "coverage sweep" auto-generate — assert reali ma superficiali
~30 file `*DeepCoverageTest`, `*BusinessCoverageTest`, `*ExecuteCoverage*Test`,
`*MassExecuteCoverageTest`, `*HundredPercentCoverageTest` in quasi tutti i moduli
delegano a helper condivisi `Modules\Xot\Tests\ModuleDeepCoverage` /
`ModuleBusinessCoverage` / `ModuleExecuteCoverage` (autoloadati via classmap in
`Xot/composer.json`). I test **hanno** asserzioni (quindi non sono "vuoti"), ma sono
reflection-sweep: istanziano classi, verificano `getTable()`/`getFillable()` non vuoti,
contano esecuzioni ≥ 0. Coprono "esiste e si istanzia", non comportamento. In moduli
piccoli (Pdnd: 3 sweep su 15 file; Performance: 2 su 21) rischiano di essere la
maggior parte del "segnale" pur essendo i test meno significativi.

### 5. Duplicazioni di logica test
- **Job**: albero `tests/unit` + `tests/feature` minuscolo parallelo a `tests/Unit` +
  `tests/Feature`; file omonimi con **stesso namespace** (`Modules\Job\Tests\Feature`)
  e test identici ma body diversi (`feature/SimpleTest.php` assert `assertSame('job','job')`
  vs `Feature/SimpleTest.php` assert su ServiceProvider). In run scoped Pest carica
  entrambi → descrizioni duplicate e potenziali collisioni.
- **Notify**: 2 file lowercase stale (v. finding 2).
- **User**: `helpers-core.php`/`helpers-extended.php` dead; `user-management-business-logic.php`
  probabile duplicato di `UserManagementBusinessLogicTest.php`.
- Helper `mockeryExpect` definito 3 volte (Activity TestCase, Activity Helpers, User Helpers).
- Pattern "createUser/createTeam/makeUser" riscritto in Activity, User, Tenant, Lang,
  Media, Notify, Performance, Progressioni, Ptv, Rating, Sigma, UI (ognuno col proprio
  prefisso) — duplicazione orizzontale massiccia ma almeno namespaced per modulo.

### 6. Fragilità
- **13 occorrenze di `->todo()`** (Xot ValueObjects/Parse, User Socialite/Passport,
  Media Actions) — test pendenti mai risolti.
- `sleep`/`usleep`: `Pdnd/tests/Unit/PdndHundredPercentCoverageTest.php:305`
  (`usleep(50000)` in loop), `Xot/tests/XotForkedInvoke.php:241` (`usleep(100_000)` —
  fork helper, accettabile).
- **Date hardcoded** in ~24 file (`'2024-…'`, `'2025-…'`): Ptv (6 file), Progressioni (2),
  Performance (2), IndennitaResponsabilita, Pdnd (2), Sigma, UI (2), User (2), Xot (4),
  Lang fixtures. Rischio: test che invecchiano ( finestre relative a `now()` )).
- Assert su testo UI hardcoded: `User/tests/Feature/LoginTranslationParityTest.php`
  `assertSee('Create an account')`, `assertSee('Forgot your password?')` (EN);
  `UI/tests/Feature/OrderColumnTest.php` e simili `assertSame('Order column', $column->getLabel())`
  — label auto-tradotta, fragile a cambi Lang.
- `base_path()`/`public_path()` in ~175 occorrenze nei test — OK dato l'override
  `public_html`, ma i test Notify (`_components.json`) dipendono dal path assoluto
  `Modules/Notify/app/...` che si rompe se il modulo viene spostato.

### 7. Cosa va bene
- **Nessun `RefreshDatabase`/`migrate:fresh`**: tutti i 18 `TestCase` usano
  `DatabaseTransactions` su connessioni esplicite — coerente col vincolo "dati sacri".
  Eccezione: Rating (4 file) usa RefreshDatabase — da verificare se su sqlite di test.
- **Infrastruttura TestCase condivisa**: tutti i moduli estendono
  `Modules\Xot\Tests\XotBaseTestCase` (che usa il trait `CreatesApplication` di Xot);
  nessun modulo riscrive il bootstrap applicazione.
- Ogni modulo ha `tests/Pest.php` + `tests/TestCase.php`; convenzione `uses(TestCase::class)`
  per file rispettata quasi ovunque (eccezioni elencate in tabella).
- PHP array one-key-per-line e `declare(strict_types=1)` rispettati nei file test.

## Top-10 priorità

1. **Rimuovere o escludere `User/audit-coverage/`** (248 test finti `assertSame(true, …)`).
2. **Deduplica Notify**: cancellare `jsoncomponentstest.php` + `emailtemplatestest.php`
   (o renderle sole canoniche rinominandole `*Test.php`).
3. **Deduplica Job**: cancellare `tests/unit/` + `tests/feature/` minuscoli (canonical =
   `Unit/`+`Feature/`).
4. **Spostare `mockeryExpect()` di User** in `tests/Support/helpers.php` (autoloadato) o
   in `TestCase::mockeryExpect()` statico come Activity; eliminare la copia libera.
5. **Decidere il run canonico** e allineare `phpunit.xml` root: o si aggiungono testsuite
   per `Integration/Performance/Security` e si rinominano i file non-`*Test.php`
   contenenti test (`user-management-business-logic.php`), o si documenta che Pest gira
   solo scoped per modulo (e si elenca quali directory sono incluse).
6. **Eliminare dead code User**: `tests/Support/helpers-core.php`, `helpers-extended.php`
   (non referenziati).
7. **Aggiungere suffisso `Test.php`** a `User/tests/Feature/user-management-business-logic.php`
   o fonderlo in `UserManagementBusinessLogicTest.php`.
8. **Risolvere i 13 `->todo()`** e l'`usleep` in `PdndHundredPercentCoverageTest`.
9. **Sostituire date hardcodate** con `Carbon::setTestNow()` / date relative nei ~24 file.
10. **Riduire gli assert su label/testo UI hardcoded** (LoginTranslationParityTest EN,
    `OrderColumn` `'Order column'`) → assert su chiavi di traduzione o rinomina-safe.

## Note metodo

- Conteggi via `find`/`grep` su `Modules/*/tests`; "% con assert reali" stimato:
  file che delegano a `ModuleDeepCoverage`/`ModuleBusinessCoverage`/`ModuleExecuteCoverage`
  contati come "con assert" ma segnalati come sweep superficiali.
- Non verificata l'esistenza a runtime di ogni classe referenziata dai test
  (richiederebbe esecuzione); i casi controllati a mano (Notify `_components.json`,
  helper Mockery, path public_html) sono coerenti.
- Dati sacri rispettati: nessuna esecuzione Pest, nessuna modifica codice.
