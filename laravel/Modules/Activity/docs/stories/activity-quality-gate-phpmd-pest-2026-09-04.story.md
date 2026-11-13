# Story: Quality gate — phpmd + pest + coverage — Activity

**Modulo**: Activity
**Tipo**: quality-gate (Build+Measure)
**Data**: 2026-09-04

## Contesto

PHPStan sul modulo era già verificato a 0 errori (sessione precedente dello stesso
giorno, "Mixed type reduction — 2026-09-04" in `docs/coverage.md`). Questo task chiude
il resto del gate di chiusura modulo: phpmd, phpinsights (non installato, vedi sotto),
pest, coverage, git.

Lock preso su `laravel/Modules/Activity` via `bashscripts/lock/lock.sh` prima di
qualunque edit, rilasciato a fine sessione. Nessuna nota bloccante trovata in
`docs/chat/` per Activity (le note esistenti, `activity-sync-in-sync.md` e
`activity-legacy-activitylogger-recurring-revert.md`, sono del 2026-07-20 e già
superate).

## Cosa ho trovato

### PHPStan (baseline)
Confermato 0 errori, sia `analyse Modules/Activity` sia (una volta, con retry per via di
un'altra sessione che stava editando `Modules/Xot` in parallelo — vedi sotto) senza path
arg. Durante il task, due `clear-result-cache` + `analyse Modules/Activity` sono falliti
con "Application bootstrap failed" per errori transitori in `Modules/Xot`
(`ComponentFileData::$name` non inizializzata, poi `GetComponentsAction::hasCurrentSchema()`
non trovato) — non file di Activity, non miei; al retry immediato sono spariti. Prova
diretta di editing concorrente non coordinato su Xot da un'altra sessione nello stesso
periodo (vedi anche il processo `pest -c Modules/Media/phpunit.xml` visto attivo durante
questo task).

### PHPMD (`./tools/phpmd.sh Modules/Activity/app text ../docs/phpmd.ruleset.xml`)
5 finding iniziali:
1. `app/Actions/ActivityLogger.php:22` — CouplingBetweenObjects 14 (soglia 13)
2. `app/Actions/ActivityLogger.php:264` — UnusedFormalParameter `$_key`
3. `app/Adapters/ActivityLogger.php:29` — CouplingBetweenObjects 19 (soglia 13)
4. `app/Filament/Pages/Concerns/CanPaginate.php:18` — LongVariable
   `$defaultRecordsPerPageSelectOption` (34 char, soglia 20)
5. `app/Filament/Pages/ListLogActivities.php:43` — CouplingBetweenObjects 19 (soglia 13)

### Pest — bloccante grave, non solo finding di stile
`Modules/Activity/phpunit.xml` dichiarava `bootstrap="vendor/autoload.php"` (relativo,
punta a un `vendor/` locale al modulo che non esiste — il monorepo ha un solo `vendor/`
in `laravel/`). Già rilevato nella sessione precedente dello stesso giorno (vedi
`docs/coverage.md`, sezione "Mixed type reduction") ma lasciato non corretto perché "non
un file toccato da questa sessione". Effetto: **0 test eseguibili**, Pest fallisce subito
con `Cannot open bootstrap script`.

Dopo aver corretto il bootstrap path (pattern già documentato in
`Modules/{Lang,Notify,Tenant,UI,Xot}/phpunit.xml`: `../../vendor/autoload.php` +
invocazione con `--test-directory` per caricare `Pest.php`/helper del modulo), la suite
si è bloccata su un secondo bug, questa volta fatale a runtime: PHP Fatal error
`Declaration of Illuminate\Database\Eloquent\Factories\HasFactory::newFactory() must be
compatible with Modules\Xot\Models\XotBaseModel::newFactory(): Factory` — in
`tests/Feature/TestActivityModel.php`, la classe usava contemporaneamente
`HasFactory` (Laravel, `newFactory()` non tipizzato) e `HasXotFactory` (Xot, già
ereditato da `BaseModel extends XotBaseModel`, `newFactory(): Factory` tipizzato) senza
risolvere la collisione tra i due trait. Verificato via grep sull'intero monorepo: **nessun
altro modello che estende `XotBaseModel`/`BaseModel` in nessun modulo combina `HasFactory`
con `HasXotFactory`** — pattern univoco, introdotto (non da me, working tree già `M` prima
del mio lock) insieme all'aggiunta del supporto factory a `TestActivityModel`.

## Cosa ho fatto

1. **`app/Actions/ActivityLogger.php`**: rimosso il parametro `$_key` non usato dalla
   closure di `mapWithKeys()` — sicuro, le closure PHP possono accettare meno parametri
   di quanti il chiamante ne passi.
2. **`app/Filament/Pages/Concerns/CanPaginate.php`** (+ `tests/Fixtures/CanPaginateHarness.php`,
   `tests/Feature/FilamentTest.php`): rinominata la property `$defaultRecordsPerPageSelectOption`
   → `$defaultPerPageOption`. Fix già proposto in 3 documenti di sessioni passate
   (`docs/phpmd-analysis.md`, `docs/PHPMD-ANALYSIS.md`, `docs/code-quality-analysis.md`)
   ma mai applicato perché un test verifica il nome della property via reflection
   (`FilamentTest.php`) — aggiornato in lockstep, nessuna regressione.
3. **`phpunit.xml`**: bootstrap `vendor/autoload.php` → `../../vendor/autoload.php`,
   con commento che documenta l'invocazione canonica (stesso pattern di Lang/Notify/
   Tenant/UI/Xot).
4. **`tests/Feature/TestActivityModel.php`**: risolta la collisione tra trait con
   `insteadof` esplicito:
   ```php
   use HasFactory, HasXotFactory {
       HasXotFactory::newFactory insteadof HasFactory;
   }
   ```
   Mantiene `HasFactory::factory()` (usato in `tests/Feature/BaseModelBusinessLogicPestTest.php:70`)
   ma usa la `newFactory()` tipizzata di `HasXotFactory` (compatibile con l'antenato),
   eliminando il fatal error.

I 3 finding CouplingBetweenObjects residui **non sono stati toccati**: sono tutti su
classi "coordinatore" che delegano esplicitamente a QueueableAction singole (pattern
architetturale imposto da questo repo, no-Services) o su una Filament Resource Page che
aggrega form/tabella/notifiche/paginazione (glue code di framework). Ridurre il coupling
lì significherebbe o violare il pattern coordinator-delega-ad-Action, o spezzare
artificialmente una classe che Filament si aspetta monolitica. Documentato, non forzato.

phpinsights: **non installato in questo repo** (rimosso, incompatibile con Pest 5 — vedi
memoria second-brain `pest5-incompatibile-con-phpinsights.md`). Verificato con
`composer show nunomaduro/phpinsights` → "not found". Step saltato coerentemente.

## Come l'ho verificato

- **PHPStan**: `clear-result-cache` + `analyse Modules/Activity` → 0 errori, sia prima sia
  dopo tutti i fix.
- **PHPMD**: rieseguito su `app/` dopo i fix → 5 finding → 3 (i 2 real fixati spariti, i 3
  CouplingBetweenObjects documentati sopra restano, invariati).
- **Pest**: `php -d xdebug.mode=coverage ./vendor/bin/pest --test-directory
  Modules/Activity/tests -c Modules/Activity/phpunit.xml` (invocazione canonica, cfr.
  commento in `phpunit.xml`). Da **0 test eseguibili** (fatal crash) a **340 passed / 92
  failed / 6 risky su 432 test totali (5679 assertion)**, risultato identico e
  deterministico su 3 run separate (durate 560s, 266s, 156s). Verificato in isolamento
  (singolo file, processo separato) che:
  - `ActivityLoggerTest.php` (15/16 failed nella run intera) → **16/16 passed** in
    isolamento: conferma che il fallimento è inquinamento di stato statico tra test nello
    stesso processo (`Model::$booting` mai resettato dopo un'eccezione precoce in un test
    precedente), non un bug del codice né dei miei fix.
  - Il rename `defaultRecordsPerPageSelectOption` → `defaultPerPageOption` non causa
    nessun fallimento (il test dedicato passa).
  - Il fix `mapWithKeys` non causa nessun fallimento (`mapWithKeys`/`_key` non compare in
    nessun log di fallimento).
  - Senza `--test-directory` (solo `-c phpunit.xml`): 330 passed / 102 failed — 10 test in
    più falliscono per `Call to undefined function Modules\Activity\Tests\Unit\mockeryExpect()`,
    helper definito solo in `Modules/User/tests/Helpers.php` — conferma che
    `--test-directory` è necessario (come già documentato per Lang/Notify/Tenant/UI/Xot) e
    che l'invocazione canonica è quella coi meno fallimenti.
- **Coverage**: `XDEBUG_MODE=coverage` (env var) risultava ignorato da Xdebug 3.5.3 in
  questo ambiente (`ini_get('xdebug.mode')` restava `develop` nonostante
  `getenv('XDEBUG_MODE')` restituisse `coverage`) — bypassato con `php -d
  xdebug.mode=coverage`, che funziona. `--coverage`/`--coverage-text` non stampavano
  nulla su stdout (anche su singolo file, run 100% passed) ma `--coverage-clover` genera
  correttamente il report su file: **781 statement, 450 coperti (57.62%)**; 134 metodi,
  71 coperti (52.99%); 67 file, 3519 loc / 2699 ncloc, 55 classi. Vedi
  `docs/coverage.md` per il dettaglio.

## Bloccanti

**Git**: unico remote `laraxot` (`git@github.com:laraxot/module_activity_fila5.git`).
`git fetch laraxot` + `git rev-list --left-right --count HEAD...laraxot/dev` → `5 1289`
(locale 5 avanti — i miei fix committati in `af7bda04` più 4 preesistenti — remoto 1289
avanti). `git merge laraxot/dev --no-edit` **abortito da git stesso** prima di iniziare:
`error: Your local changes to the following files would be overwritten by merge:
.gitattributes` — la working tree del modulo ha **142 file modificati non miei**
(docs/*.md, Filament Resources, Models, `.gitattributes`, `.gitignore`, README.md, ecc.),
lavoro concorrente di altre sessioni non ancora committato. Non ho toccato/stashato
nessuno di questi file (non miei, regola esplicita del task). `git push laraxot dev
--dry-run` → rejected, non-fast-forward, come atteso essendo 1289 commit indietro.
**Il mio commit `af7bda04` resta locale, non pushato**, in attesa che il drift di working
tree venga risolto centralmente (fuori scope di questo task).

## Note

- I 92 fallimenti Pest residui sono in stragrande maggioranza (43/92) cascata di
  `LogicException: Model::bootIfNotBooted ... while it is being booted` — inquinamento di
  stato statico tra file di test nello stesso processo, verificato non riproducibile in
  isolamento. Altri 26 sono `BindingResolutionException` (`Target class [session]/[config]
  does not exist` — binding container mancanti per test non agganciati alla `TestCase` del
  modulo) e ~14 `Error` di vario tipo (helper cross-modulo mancante, registrazione
  nwidart/modules non disponibile in questo bootstrap). Tutti pre-esistenti,
  non introdotti da questo diff, non forzati a fix per restare dentro lo scope del task
  (phpmd/pest/coverage/git, non un audit completo dell'infrastruttura di test).
