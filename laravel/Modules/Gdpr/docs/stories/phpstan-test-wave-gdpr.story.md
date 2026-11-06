---
title: PHPStan Gdpr, test riespansi dal pull
type: story
module: Gdpr
phase: implementazione, quality gate
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, test, pull, gdpr]
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - phpstan-cleanup-gdpr.story.md
  - phpstan-Gdpr-fix.md
---

# PHPStan Gdpr: test riespansi dal pull

Lane `gdpr-lang-ai` del run PHPStan del 2026-10-20. Coordinamento, regole di lane e scala delle decisioni: [phpstan-test-wave-regression.story.md](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md).

## Misura

- Baseline delle 09:00: 240 errori in 9 file (`tests/Pest.php` 24, `tests/TestCase.php` 1, `GdprBusinessLogicTest` 182, `GdprConsentTest` 19, `BaseModelTest` 4, `ConflictResolutionTest` 4, `conflictresolutiontest` 4, `Auth/RegisterPageTest` 1, `DeleteAccountAction` 1).
- La ri-misura prima di toccare e' stata interrotta da un `Internal error: Class Modules\Gdpr\Models\GdprConsent was not found` su `GdprConsentTest.php`: PHPStan non completa l'analisi finche' un file cita un SUT che non esiste.
- Dopo: 0 errori sui 9 file. Controllo esteso ai 43 file di `tests/` e a tutti i file di `app/`, `routes/`, `database/` (batch da 8 file): 0 errori.

## Scopo capito

Il modulo registra consensi (`Consent`), trattamenti (`Treatment`), eventi di audit (`Event`) e profili (`Profile`). I test devono garantire che questi quattro model reali si creino, si colleghino e rispettino i campi della tabella. `tests/Pest.php` lega Pest a `Modules\Gdpr\Tests\TestCase` e carica gli helper di `PestHelpers.php` e `PestStubs.php` (`gdprAssertDatabaseAvailable()`, `assertGdprTableHas()`). `TestCase` estende `XotBaseTestCase` con `DatabaseTransactions`, e offre `assertDatabaseHasRow`, `expectApplicationException`, `uniqueTreatmentName`.

## Causa

Il commit `82efe7d` del repo del modulo (2026-10-20 09:03, sync del pull) ha sovrascritto 7 file con le bozze di `laraxot/dev`, anteriori al ciclo PHPStan chiuso l'8 ottobre:

- `Pest.php` definiva helper e expectation (`createGdprConsent()`, `toBeGdprConsent()`, `createGdprRequest()`) su `Modules\Gdpr\Models\GdprConsent` e `GdprRequest`, che non esistono. Neppure `GdprDataExport` e `GdprDataDeletion`, usati da `GdprBusinessLogicTest`, esistono: `rg` su `app/` non trova nessuna delle quattro classi. Erano specifiche fantasma.
- `TestCase.php` era uno stub di 45 righe su `Illuminate\Foundation\Testing\TestCase` con `module:seed`, senza gli helper che gli altri test chiamano.
- `GdprBusinessLogicTest.php` (479 righe) pilotava i quattro model fantasma via `::factory()`: da solo 182 errori (`class.notFound`, `property.nonObject`, `method.nonObject` su `mixed`).

Non sono stati inventati modelli, tabelle o migration.

## Correzione

I blob pre-pull (verificati a 0 errori l'8 ottobre, identici a `a02dd4c` del 2026-10-08) sono stati riscritti su file con `git show cb7ded6:<path>`, dopo gate lock e mtime, senza `checkout` ne' `restore`. `cb7ded6` e' il merge del 2026-10-13 13:23, padre di `82efe7d`.

| File (sotto `Modules/Gdpr/`) | Righe prima | Righe dopo |
|---|---|---|
| `tests/Pest.php` | 66 | 21 |
| `tests/TestCase.php` | 45 | 90 |
| `tests/Feature/GdprBusinessLogicTest.php` | 479 | 393 |
| `tests/Unit/Models/GdprConsentTest.php` | 50 | 47 |
| `tests/Unit/Models/BaseModelTest.php` | 40 | 42 |
| `tests/Feature/ConflictResolutionTest.php` | 25 | 28 |
| `tests/Feature/conflictresolutiontest.php` | 25 | 25 |

Sorgenti toccati, perche' il resto (1 errore) nasceva li:

- `app/Actions/Account/DeleteAccountAction.php` (arrivato col pull): `Auth::user()` e' tipizzato da Larastan come `Modules\Quaeris\Models\User`, mentre `execute()` chiedeva `Modules\User\Models\User`. I due model sono fratelli: estendono entrambi `BaseUser`. L'action usa solo `id`, `getMorphClass()`, `deleted_at`, `deleted_by` e `save()`, tutti dichiarati su `BaseUser`. Parametro portato a `BaseUser` in `execute()` e `recordDeletionConsent()`.
- `app/Actions/Consent/RevokeGdprConsentsAction.php`: stesso parametro portato a `BaseUser`; l'unico chiamante e' `DeleteAccountAction`.

## Controprova

- `rg -P "Models\\\\Gdpr(Consent|Request|DataExport|DataDeletion)\b|GdprConsent::|GdprRequest::" tests app`: nessun risultato.
- `php -l` sui 9 file: nessun errore di sintassi.
- Pest non e' stato eseguito: il DB di test `quaeris_data_test` non esiste. La verifica e' PHPStan piu' lint.

## Non fatto e decisioni aperte

- `TestCase` verificato dell'8 ottobre usa `prepareSharedSqliteForTesting()` di `XotBaseTestCase` e `$connectionsToTransact = ['sqlite']`, in tensione con la regola di progetto "test su MySQL, mai sqlite". E' lo stato verificato e non e' stato cambiato; la decisione e' del modulo Xot.
- `tests/Feature/conflictresolutiontest.php` e `ConflictResolutionTest.php` sono la stessa specifica con nomi che differiscono solo per le maiuscole, entrambi tracciati. Su un filesystem insensibile alle maiuscole collidono. Segnalato, non cancellato.
- `ConflictResolutionTest.php` ripristinato verifica che i costruttori dei model reali non abbiano parametri obbligatori e che `getFillable()` non sia vuoto. La versione del pull asseriva `toBeInstanceOf` su `new X` e `toBeArray` su un valore gia' tipizzato `array`: asserzioni che per costruzione non possono fallire, e che Pest segnala come ridondanti.

## Seconda passata: ignore, probe e helper dei test

Fase BMAD: implementazione e quality gate. Sessione parallela della stessa lane, aperta mentre la prima ripristinava i blob; la ri-misura ha confermato 0 errori sui file gia' sistemati (PHPStan mirato su `tests/Feature/GdprBusinessLogicTest.php`, `tests/Pest.php`, `tests/PestHelpers.php`, `tests/TestCase.php`, `tests/Unit/Models`, `tests/Feature/Auth/RegisterPageTest.php`, `app/Actions` e i due `ConflictResolution`: esito 0). Il lavoro gia' fatto non e' stato rifatto. Restavano due scorciatoie sul codice del modulo, non segnalate come errori ma vietate dalle regole di lane.

### Scopo e causa

- `tests/PestHelpers.php`, `gdprTest()`: le funzioni `gdprGet()`, `gdprPost()`, `gdprActingAs()`, `gdprSkipTest()` vivono fuori dalla closure Pest e non hanno `$this`. Per ottenere il test in corso la funzione usava `test()` di Pest, che restituisce `HigherOrderTapProxy`, classe `@internal`: per aprirla serviva un `@phpstan-ignore-next-line`. La storia [01.Gdpr-phpstan-fix.story.md](./01.Gdpr-phpstan-fix.story.md) lo dichiarava "ancora necessario". Era un silenziatore di una dipendenza da un'API interna di Pest, non un falso positivo.
- `app/Models/GdprPhpstanTraitProbe.php`: modello finto che ospitava `HasGdpr` solo perche' PHPStan lo analizzasse. Vietato da `bashscripts/ai/wiki/rules/phpstan-no-probes-rule.md`. Era stato cancellato il 2026-09-24 (`6b72891`), poi riportato da `a02dd4c` (re-import dell'8 ottobre). Nessun file di `Modules`, `Themes`, `app`, `config`, `database` lo cita; il trait resta in scope grazie a `tests/Fixtures/HasGdprDummy.php`.

### Correzione

- `tests/TestCase.php`: `public static ?self $currentTest`, impostato in `setUp()` dopo `parent::setUp()` e azzerato in `tearDown()`. Il docblock aveva quattro righe duplicate dai merge ("Uses shared fixcity_data.sqlite" e "Uses shared sqlite" ripetute due volte): ridotte a una riga vera e a una nota su `$currentTest`.
- `tests/PestHelpers.php`: `gdprTest()` restituisce `TestCase::$currentTest` oppure lancia `LogicException` se chiamata fuori da un test. Tolti l'import di `Pest\Support\HigherOrderTapProxy`, l'`instanceof`, l'`assertInstanceOf` e l'ignore. Equivalenza a runtime: Pest chiama `TestCase::setUp()` prima dei `beforeEach`, e `test()` restituiva comunque la stessa istanza.
- `app/Models/GdprPhpstanTraitProbe.php` cancellato (resta in `a02dd4c`). Nota in [phpstan-probe-model-removal.md](../concepts/phpstan-probe-model-removal.md) e in 01.Gdpr-phpstan-fix.

### Verifica

| Prova | Esito |
|---|---|
| `php -l tests/PestHelpers.php tests/TestCase.php` | nessun errore |
| `rg 'phpstan-ignore\|HigherOrderTapProxy' laravel/Modules/Gdpr -g '*.php'` (solo `tests/TestCase.php` cita la classe, nel docblock) | nessun ignore attivo |
| `phpstan analyse Modules/Gdpr --memory-limit=2G --no-progress --error-format=raw` (cwd `laravel/`, dopo i due edit e dopo il sync del modulo) | exit 0, nessun errore |

Il run completo e' sul solo modulo, non su `Modules`: `typeCoverage.*` si misura solo con `analyse Modules`, a cura del coordinatore.

### Cosa resta

- Pest non eseguito: serve il DB di test. `gdprTest()` non e' stato provato a runtime; la verifica e' statica. Se un test chiamasse un helper `gdpr*` senza estendere `Modules\Gdpr\Tests\TestCase`, ora fallisce con `LogicException` invece di restituire il proxy.
- `TestCase` usa ancora `prepareSharedSqliteForTesting()` e `$connectionsToTransact = ['sqlite']`: decisione di Xot (vedi sopra).
- `tests/Feature/conflictresolutiontest.php`: duplicato per maiuscole di `ConflictResolutionTest.php`, con asserzioni piu' deboli (`expect(new Treatment())->not->toBeNull()`). Non cancellato; decide l'utente.
- Link rotti in `00-INDEX.md` verso `../../Fixcity/docs/...`: il modulo Fixcity non esiste in questo progetto (i moduli sono condivisi fra progetti). Non toccati.
- Nessun `*Service` ne' componente Livewire toccato in questa lane.

## Esito della lane gdpr-lang-ai

| Momento | Errori sui 9 file del bucket |
|---|---|
| Baseline delle 09:00 | 240 |
| Dopo i ripristini e i due `BaseUser` (09:41) | 0 |
| Ri-misura dopo la ripresa (12:39, PHPStan mirato a batch da 8 file, `tests/` 43 file e `app/` 83 file) | 0 |

Gli ultimi due controlli sono su file che altre sessioni della stessa ondata hanno toccato nel frattempo (`TestCase.php`,
`PestHelpers.php`, probe cancellato): lo 0 vale per lo stato del disco a quell'ora, non per i blob scritti da questa lane.
`tests/Pest.php`, `GdprBusinessLogicTest.php` e `GdprConsentTest.php` sono ancora byte per byte quelli di `cb7ded6`.
Quanto al gate: nessun file di questa lane e' stato saltato; le due Action sono state scritte dopo `check.sh` e mtime oltre 120 s.
Il `phpstan-baseline.neon` del modulo non e' stato usato ne' toccato; non e' stata creata nessuna configurazione alternativa.
I due link di `00-INDEX.md` verso `../../Fixcity/docs/` restano rotti (il modulo Fixcity non e' in questo progetto).

Misura ripetuta fra le 12:49 e le 12:59, dietro il gate `flock` condiviso, su `app/` e `tests/` dei tre moduli (Gdpr 83+43 file, AI 64+15, Lang 59+45): 0 errori in tutti i batch, nessun messaggio anomalo (PHPStan lanciato solo su file, mai `analyse Modules`, senza `-c` ne' `--level`).

## Wave swarm Media/Gdpr/UI (lane Gdpr)

TSV: `.cursor-scratch/phpstan-wave/Gdpr.tsv` — **17** errori iniziali (`variable.unused` su `$action`/`$baseModel`/`$provider`/`$profile`/`$treatment`/`$consent`, `pest.test.emptyClosure` sulle Resource che dovevano estendere `XotBaseResource`).

### Scopo (1 frase)

I test Gdpr devono verificare il contratto delle Action di registrazione/consenso (`execute` pubblico) e che Resource/Provider/Model ereditino le basi Xot/User, non `new` senza lettura della variabile.

### Causa → fix

| Famiglia | Causa | Fix |
|---|---|---|
| `variable.unused` `$action` | Istanziazione senza assert sul contratto | Un solo test: `new` + `ReflectionMethod::execute` (pubblico, arity) |
| `pest.test.emptyClosure` Resource | Closure vuota «extends XotBase» | `Safe\class_parents` + `assertArrayHasKey(XotBaseResource::class, …)` |
| `variable.unused` model/provider | `new` senza assert | `class_parents` Safe, `getTable`/`getConnectionName`/`module` property |
| `is_a` always true | PHPStan conosce gia' la gerarchia | Solo `Safe\class_parents` (niente `is_a` ridondante) |

### Misura finale lane

Path TSV Gdpr (+ Media/UI nella stessa verifica flock): **0** `file_errors`, exit **0**. Nessun ignore/baseline/neon.
