---
title: "Epic: cricchetto di qualita' del codice"
type: epic
status: planned
created: 2026-10-20
updated: 2026-10-20
module: Xot
scope: cross-module (Modules/)
tags: [bmad, epic, code-quality, ratchet, test-safety, filament-blueprint, second-brain, swarm]
qmd: "epic cricchetto qualita codice ratchet phpstan zero non prova test mai eseguiti suffisso Test.php case sensitive RefreshDatabase guardia db quaeris_data_test wave W0 W1 W2 W3 W4 W5 contatore che puo solo scendere filament blueprint tests/Architecture"
related:
  - ./code-quality-wave.md
  - ./filament-blueprint.md
  - ../stories/docs-organization-xot.story.md
  - ../stories/debug-leftovers-cleanup-xot.story.md
  - ../stories/test-database-guard.story.md
  - ../../../../../bmad-output/epic-services-to-queueable-actions.md
  - ../../../../../bashscripts/ai/wiki/rules/data-sacred-no-destructive-db.md
  - ../../../../../bashscripts/ai/wiki/rules/no-refresh-database-in-tests.md
  - ../../../../../bashscripts/docs/prompts/10-test.md
  - ../../../../../bashscripts/docs/prompts/11-phpstan.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
  - ../../../../tests/Architecture/ModulesArchitectureTest.php
---

# Epic: cricchetto di qualita' del codice

Fase BMAD: planning (epic). Questo file e' solo un piano: nessun PHP toccato, nessun test eseguito. Tutte le cifre sono di una misura del **2026-10-20** e sono **volatili** (altre sessioni editano senza lock): si rileggono con i comandi della sezione 8 prima di usarle.

## 1. Richiesta

Ordine permanente dell'utente (2026-10-20): "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint" (testo originale in [code-quality-wave.md](./code-quality-wave.md)). Lo leggo cosi':

- **BMAD**: ogni wave ha una story nel modulo owner (`laravel/Modules/<M>/docs/stories/`, [policy](../../../../../bashscripts/docs/modular-bmad-story-policy.md)); questo epic e' trasversale e sta in Xot. Collegamenti: [docs-organization-xot](../stories/docs-organization-xot.story.md), [debug-leftovers-cleanup-xot](../stories/debug-leftovers-cleanup-xot.story.md), [epic dei Service](../../../../../bmad-output/epic-services-to-queueable-actions.md) e [test-database-guard](../stories/test-database-guard.story.md) (sezione 3). Le story di wave stanno nel modulo owner, `laravel/Modules/<M>/docs/stories/`.
- **Second brain**: a fine di ogni wave memoria (`memory/`) e wiki; l'indicizzazione QMD la lancia l'owner, non questo piano.
- **Filament blueprint**: nel repo e' il contratto scritto a mano `laravel/Modules/<M>/docs/bmad/filament-blueprint.md` (13 moduli su 19 ce l'hanno, [esempio Xot](./filament-blueprint.md)). Il pacchetto `filament/blueprint` **non e' installato** (assente da `composer.json`, `composer.lock` e `vendor/filament`).

## 2. Perche': PHPStan a 0 non dimostra che il codice funzioni

`phpstan analyse Modules` a 0 su 19 moduli ([phpstan-status](./phpstan-status.md)) dice che i tipi sono coerenti. PHPStan non esegue nulla. Cio' che la suite dovrebbe provare e non prova (censimento 2026-10-20 13:21, sola lettura):

- **1148 file di test** (circa 6882 test, stima per regex) in `Modules/*/tests` **mai eseguiti in questa sessione**: il DB di test e' assente o vuoto (le tabelle di Activity e User mancavano gia' alle 09:35, `SQLSTATE[42S02]`; se i database `*_test` esistano non e' verificato).
- **23 file con test reali non girano mai.** `laravel/phpunit.xml:11-12` usa `suffix="Test.php"` e il confronto e' case-sensitive: 17 file in minuscolo (`*test.php`, 10 in Cms), 4 `*.pest.php`, 2 senza suffisso (`User/tests/Feature/user-management-business-logic.php`, `User/tests/Feature/Passport/ClientCredentials.php`). Nelle coppie divergenti (8 gruppi su 18) **il corpo originale sta nel file in minuscolo e quello che gira e' lo stub `skip`**: Cms `loginvolttest.php` ha 24 test e 50 asserzioni, `LoginVoltTest.php` un solo skip che rimanda al primo; Geo `comunetest.php` 4 test contro 2 skip.
- **Test che non provano:** 323 `skip`; 86 test finti (`assertTrue(true)` vivi e tautologie `>= 0`, piu' 26 svuotati con `catch` che inghiotte); 32 test "Coverage" che chiamano `execute()` di tutte le Action dentro `catch (\Throwable) { continue; }` e chiudono con `assertGreaterThanOrEqual(0, ...)`; 157 `catch` vuoti in 26 file di test.
- **Endpoint che non esistono:** Notify `NotificationApiTest` (8 test su `/api/notify/*`, `routes/api.php` e' tutto commentato) e Geo `GeoApiTest` (7 test su `/api/geo/*`): corpo pieno, PHPStan verde, runtime 404.
- **Copertura Action:** solo 238 Action su 637 hanno un test omonimo.
- **L'autorizzazione e' spenta nei test:** i rami `environment('testing')` di Quaeris (sezione 4, W1) fanno ritornare `true` alla policy, quindi la suite non prova mai l'autorizzazione vera.

Le 5 cifre piu' citate, riverificate il 2026-10-20 alle 13:3x (comandi in sezione 8):

| Voce | Censimento 13:21 | Riverifica 13:3x | Nota |
|------|------------------|------------------|------|
| file `*Test.php` in `Modules/*/tests` | 1148 | 1145 | altre lane hanno toccato i test |
| `@phpstan-ignore` in `Modules/*/app` | 69 | 69 | Xot 44, di cui `HasXotTable.php` 25 |
| file con `RefreshDatabase` attivo | 18 | 18 | Geo 4, Notify 4, User 8, Xot 2 |
| test reali mai eseguiti per nome | 17 + 4 + 2 | 17 + 4 (+ 2 presenti) | minuscolo, `.pest.php`, senza suffisso |
| Action con test omonimo (stesso modulo) | 238 su 637 | 238 su 639 | la definizione conta: per solo nome file escono 267 su 681 |

Cifre non riverificate qui (restano del censimento): 323 skip, 86 test finti, 32 test "Coverage", 1106 `@var` inline, 467 `mixed`, 301 file Pint. Due cifre sono cambiate per fatti noti: `FileAction.php` (1093 righe) e' stato **eliminato** dalla lane debug (stato `D` nel repo del modulo Xot, quindi i file sopra 500 righe sono 11 e non 12) e `Hash::make` sotto `User/app/Filament` conta 23 occorrenze in 13 file (il censimento diceva 13 in 10): per questo il contatore, non il numero, e' la fonte.

## 3. Sicurezza dei test (P0)

Priorita' massima, prima di qualunque run di Pest. Stato alle 13:3x: **la guardia e' scritta** (story [test-database-guard](../stories/test-database-guard.story.md)), ma **non e' stata provata a runtime** (nessun Pest eseguito) e la difesa vera, l'account di test, e' ancora una decisione dell'utente. Qui il quadro che l'ha motivata.

**Verdetto statico prima della guardia: INCERTO.** Nel caso normale (`pest` o `artisan test` da `laravel/`, shell senza `APP_ENV` ne' `DB_*`) `phpunit.xml:27` imposta `APP_ENV=testing`, si carica `.env.testing` e tutte le connessioni vanno su `quaeris_data_test`, `quaeris_user_test`, `quaeris_survey_test`. Ma:

- stesso server MySQL, **stesso account e stessa password del DB reale** (`.env.testing` e' tracciato in git), account con `DROP`; nessun segnaposto `FIXCITY_TEST_*`;
- **all'inizio della misura nessuna guardia nel codice**: `laravel/tests/TestCase.php` era vuoto; `App\Application::environmentFile()` (riga 36) ripiega in silenzio su `.env` se `.env.testing` manca; i fallback di `config/database.php` sono i nomi reali;
- tre rotture possibili portano al DB reale `quaeris_data`: (1) `APP_ENV` gia' esportato diverso da `testing` (`phpunit.xml` non ha `force="true"`, `PhpHandler.php:167`), (2) `DB_DATABASE`/`_USER`/`_LIMESURVEY` gia' esportati (l'ambiente di processo batte `.env.testing`), (3) `.env.testing` assente;
- **18 file con `RefreshDatabase`** (Geo 4, Notify 4, User 8, Xot 2): `migrate:fresh` sulla connessione di default, cioe' DROP di tutte le tabelle del DB configurato.

**Cosa e' successo davvero (log di 64 invocazioni pest/phpunit di tutti gli agenti).** Tutti i comandi erano `cd laravel; ./vendor/bin/pest [--no-coverage] <file|dir>`, senza `--env` e senza `artisan migrate`; `phpunit.xml` forza `APP_ENV=testing`, quindi `.env.testing` (mysql 127.0.0.1:3306; default e `activity` su `quaeris_data_test`, `user` su `quaeris_user_test`, `limesurvey` su `quaeris_survey_test`). **In nessun output compare un database senza suffisso `_test`: nessuna evidenza di contatto con i DB reali.** Il caso piu' serio: la lane user-a ha eseguito alle 09:58 un bucket di 39 file User (9 a rischio), poi un ciclo file per file, e alle 12:26 `BaseUserTest.php`, che ha `uses(TestCase::class, RefreshDatabase::class)` alla riga 12; errore visto: `SQLSTATE[42000] 1061 Duplicate key name 'extras_model_id_index' (Connection: limesurvey, Database: quaeris_survey_test)`. Il DROP di `quaeris_data_test` e' **dedotto** dal comportamento di `RefreshDatabase`, non osservato (nessun `Migrating:` nei risultati). Non si sa se `quaeris_data_test` contenesse dati da conservare prima delle 09:58. Le lane Tenant, Media, Job, Geo, Activity, Notify non hanno eseguito file a rischio. Lettura corretta: **incidente sui DB di test designati, non su quelli reali, sul solo dato osservato**; resta il rischio strutturale sopra. Ogni run di uno degli 8 file User attivi droppa `quaeris_data_test`.

**La guardia scritta** (`Modules/Xot/tests/Support/TestDatabaseGuard.php`, `assertApplication($app)`): una sola implementazione, chiamata dopo il boot da `Modules/Xot/tests/CreatesApplication.php:64` (TestCase di modulo) **e** da `laravel/tests/TestCase.php:19` (radice, che copre i 14 file `RefreshDatabase` su `Tests\TestCase`). Legge la config effettiva, non le variabili d'ambiente; aborta se l'ambiente non e' `testing` o se una connessione non-sqlite ha un database che non finisce per `_test`; sqlite e' sempre ammesso; non stampa password. Due eccezioni nel codice: il prefisso `claude_scratch_pest_` dei DB creati e poi eliminati da `bashscripts/tools/pest-scratch-db.sh`, e la connessione `liveuser_general`, che legge `DB_DATABASE_LU` (nessun `.env*` lo definisce) con fallback fisso `forge13`. Residuo: i fallback di `laravel/config/database.php` (righe 126, 144, 161, 178: `quaeris_data`, `quaeris_user`, `quaeris_survey`) restano i nomi reali; con la guardia fanno abortire il test invece di colpire il reale, ma il default sbagliato resta.

**La vera difesa** e' un account di test con grant solo su `*_test` (decisione 7.1): la guardia nel codice e' la seconda linea, perche' protegge solo dai processi che passano da `TestCase`.

## 4. Wave in ordine di rischio

Sessione A (coordinatore): Notify, AI, Lang, Xot, Cms, UI, Gdpr, Activity, Geo. Sessione B (peer): User, Quaeris, Setting, Media, Job, Tenant, DbForge, Limesurvey, Chart, CloudStorage. Una lane per modulo.

**W0: guardia DB e probe Pest.** (a) Guardia di sezione 3: scritta, da provare con un controllo senza DB (la funzione `TestDatabaseGuard::assert($env, $connections)` e' pura e si puo' esercitare con array, vedi la story) e dopo il via dell'utente. (b) Probe senza DB per il binding Pest di modulo: `cd laravel && ./vendor/bin/pest --test-directory=Modules/Chart/tests --list-tests`. Dubbio: `laravel/tests/Pest.php` e' l'unico `Pest.php` caricato di default; quelli di modulo solo con `--test-directory`, e `TestRepository.php:163-165` lancia `TestCaseAlreadyInUse` se un file ha gia' un TestCase e ne riceve un altro (moduli con binding **e** `uses()` nei file: Xot 179/200, User 139/159, Quaeris 61/64, Cms 11/134, Chart 6/7, Limesurvey 3/3, Notify 2/131). **Solo dopo la guardia e dopo il via esplicito dell'utente: nessun Pest prima.** Uscita: un solo meccanismo di binding per modulo.

**W1: difetti S1 di produzione, con owner.**

| # | Difetto (verificato sul disco 13:3x) | Fix in una riga | Owner |
|---|------|-----|-------|
| 1 | Quaeris: rami `environment('testing')` che spengono l'autorizzazione: `SurveyPdfPolicy.php:23,51,172`, `SurveyController.php:53,82,111` | togliere i rami, test con `actingAs` e permessi veri | B, Quaeris |
| 2 | User `BaseTenant.php:36-56`: niente `casts()` per `settings` e `trial_ends_at`, `$fillable` incompleto | aggiungere `casts()` e completare `$fillable`; poi Tenant cancella il doppione `Modules\Tenant\Models\Tenant` | B, User poi Tenant |
| 3 | Notify `EsendexSendAction.php:47,83` TLS disattivato, `:88` credenziali in query string | `Http::post` con verifica TLS e credenziali nel body | A, Notify |
| 4 | AI: `MakeAIRequestAction.php:27-30` legge `ai.openai_api_key`, `ai.openai_base_url`, `ai.timeout`, `ai.retry_attempts`, assenti da `AI/config/ai.php` (chiave sempre vuota) | un solo punto di config in `config/ai.php`, le Action leggono solo `ai.*` | A, AI |
| 5 | Lang `SaveTransAction.php:30` scrive file di traduzione a runtime senza lock (`dddx` gia' tolto dal disco) | spento di default fuori da local, scrittura atomica con lock | A, Lang |
| 6 | Xot `FileAction`: 10 `dd` e 4 `dddx` nei `catch` | **chiuso**: la lane debug ha eliminato la classe con i suoi test (zero riferimenti); resta da registrarlo nella story [debug-leftovers-cleanup-xot](../stories/debug-leftovers-cleanup-xot.story.md) | A, Xot |
| 7 | Geo: `getCities`, `comuni.json`, `GeoServiceFacade` senza binding, classmap | note della lane Geo, non riverificate: `GeoServiceFacade.php` e `resources/json/comuni.json` esistono, `function getCities` non compare in `Geo/app`; la lane Geo riconferma prima di toccare | A, Geo |

Ogni fix W1 nasce con il suo test (TDD), ma i test girano solo dopo W0.

**W2: verita' dei test.**

- I 23 file mai eseguiti: per ogni coppia, diff e corpo nel file con il nome giusto (`*Test.php`), scala di [10-test.md](../../../../../bashscripts/docs/prompts/10-test.md) quando il SUT manca (stub `->skip('<X> not implemented')` piu' story); il file in minuscolo si toglie solo dopo il diff. Per i file senza controparte basta rinominarli.
- Skip e test finti: 7 `assertTrue(true)` vivi in Cms, 26 svuotati in User, 79 tautologie `>= 0`, 32 file harness. Sostituire con un'asserzione sul comportamento o con `skip` dichiarato; l'harness non conta come copertura.
- Endpoint inesistenti (Notify `NotificationApiTest`, Geo `GeoApiTest`): stub `skip`, mai creare route per far passare un test.
- `RefreshDatabase` (18 file) verso `DatabaseTransactions` del TestCase di modulo ([no-refresh-database-in-tests](../../../../../bashscripts/ai/wiki/rules/no-refresh-database-in-tests.md)); sqlite al posto di MySQL (Xot 9 file inline e 9 TestCase, Lang 2) contro [data-sacred-no-destructive-db](../../../../../bashscripts/ai/wiki/rules/data-sacred-no-destructive-db.md): dipende dalla decisione 7.4.
- Cms `FolioRoutesTest.php:56,64,67`: `markTestSkipped` su 404 e 5xx dentro un loop nasconde errori.

**W3: contratto Filament.**

- Password e registrazione scritte nei widget: 13 file con `Hash::make` sotto `User/app/Filament` (23 occorrenze), Gdpr `RegisterWidget.php:136` e `GdprConsentForm.php:90` (`DB::connection('user')->transaction`). Una Action Queueable in User (cambio password, registrazione) chiamata dai widget. Percorso auth: test prima.
- Circa 400 stringhe hardcoded (413 primarie, 58 extra, 55 proprieta' statiche; User 154, Quaeris 106) verso chiavi in `lang/<locale>/` del modulo.
- 21 `extends` diretti di classi Filament verso `XotBase*` (i 3 `AdminPanelProvider` doppioni di AI, Cms, Gdpr non sono registrati: si cancellano).
- Blueprint mancanti in Chart, CloudStorage, Limesurvey, Quaeris, Setting (202 file Filament, tutti sessione B): si scrive il contratto prima del refactor.
- Livewire/Volt legacy (circa 31): resta nell'epic [livewire-to-filament-widgets](./livewire-to-filament-widgets-objective.md).

**W4: silenziamenti.** 69 `@phpstan-ignore` (HasXotTable 25, Xot 44) verso 0 correggendo la causa, mai con altri ignore; 24 trait zombie (`trait.unused`) da cancellare con i loro test (regola 25), non da silenziare; 1106 `@var` inline, di cui 190 restringono a una classe (euristica; `treatPhpDocTypesAsCertain: false` li rende meno pericolosi); 11 Service travestiti da Action (`execute(): void` vuoto) nell'[epic dei Service](../../../../../bmad-output/epic-services-to-queueable-actions.md); 25 `catch` vuoti, i peggiori nell'autorizzazione (`SurveyPdfPolicy.php:35,63,144`, `UserPermissionBasePolicy.php:38`).

**W5: stile, per ultimo.** Pint su 301 file, 12 file oltre 500 righe (ora 11), 467 `mixed`. Solo su file fermi da oltre 30 minuti, mai in parallelo a un'altra lane sullo stesso modulo: e' la wave che genera piu' diff e piu' conflitti.

## 5. Cricchetto

Ogni wave lascia due cose:

1. **Una guardia senza DB** in `laravel/tests/Architecture/` (pattern esistente: [ModulesArchitectureTest.php](../../../../tests/Architecture/ModulesArchitectureTest.php), legge solo i file sotto `Modules/*/app` con `Symfony\Finder`, non avvia Laravel, non usa il DB).
2. **Un contatore che puo' solo scendere**: il test confronta il conteggio con una baseline nel file e fallisce sia se sale sia se scende senza che la baseline sia stata abbassata (stessa regola dei cicli noti: "quando ne risolvi uno, toglilo da qui").

| Contatore | Baseline 2026-10-20 | Scende in | Metodo |
|-----------|---------------------|-----------|--------|
| `@phpstan-ignore` in `Modules/*/app` | 69 | W4 | commenti, anche con `token_get_all` |
| chiamate a `dd(` e `dddx(` | dd 11 e dddx 29 alle 13:21 (poi calati) | W1/W4 | **token PHP, non regex**: il grezzo da' 106 `dddx` perche' conta commenti e docblock |
| rami `environment('testing')` in `Modules/*/app` | 15 righe (Quaeris 6, Tenant 3, Cms 2, User 2, Gdpr 1, Lang 1) | W1 | token o regex; i 6 di Quaeris sono S1 |
| `RefreshDatabase` attivo in `Modules/*/tests` | 18 | W2 | `uses(...)` o trait nella classe, non l'import |
| file `.php` in `tests/` con test ma senza suffisso `Test.php` | 23 | W2 | cerca `it(` e `test(` fuori dai file `*Test.php`, `Pest.php`, `TestCase.php` |
| `assertGreaterThanOrEqual(0` nei test | 79 | W2 | regex |
| `catch` vuoti in `Modules/*/app` | 25 | W4 | token |
| file `app/**/*.php` oltre 500 righe | 11 (12 al censimento) | W5 | `file()` e conteggio |

I contatori sono misure di **cosa e' vietato**, non di cosa e' bello: una baseline che sale e' un errore di processo, non una scelta.

Due cricchetti esistono gia' e non vanno duplicati: `ModulesArchitectureTest.php` ha i test "has no Modules/*/app/Services directory", "has no applicative *Service.php" e il cricchetto anti-resurrezione dei Service (nessuna `app/Services` su disco al 2026-10-20), piu' la baseline dei cicli tra moduli; la `TestDatabaseGuard` e' una guardia di avvio, non un contatore. I nuovi contatori vanno in un file nuovo accanto (per esempio `tests/Architecture/QualityRatchetTest.php`, da scrivere da una lane PHP), non dentro quello dei moduli.

## 6. Regole di esecuzione

- Una lane per modulo; **mai due lane che editano PHP nello stesso modulo**. Split tra le due sessioni come in sezione 4.
- PHPStan mirato in coda `flock` ([11-phpstan.md](../../../../../bashscripts/docs/prompts/11-phpstan.md)); **un solo run completo**, a swarm fermo e a RAM libera (il 2026-10-20 33 processi `phpstan analyse` pesavano circa 33 GiB e un worker e' stato ucciso dal kernel).
- **Nessun Pest/PHPUnit** finche' la guardia DB non e' dentro e l'utente non ha deciso sul DB di test (7.1, 7.2, 7.4). Un brief che dice solo "Pest non eseguibile" non basta: va scritto il divieto e nominati i file a rischio (`rg -l 'RefreshDatabase|DatabaseMigrations|migrate:fresh' Modules/*/tests`).
- Gate di concorrenza nel codice al primo tocco di ogni file, con `/usr/bin/find` o `stat` ([03-quality-gates.md](../../../../../bashscripts/docs/prompts/03-quality-gates.md#trappole-di-shell-di-questa-macchina)); rileggere prima di ogni Edit; marker di conflitto = non toccare.
- Niente commit, checkout, reset, restore, stash. `phpstan.neon` non si tocca.
- Chiusura di ogni wave: story aggiornata con finding, causa, fix e output reale; memoria e wiki.

## 7. Decisioni aperte per l'utente

1. **Account DB di test** con grant solo su `*_test` (la difesa vera, sezione 3).
2. **Creare i DB `*_test`**: la regola chiede di chiedere prima; e confermare se `quaeris_*_test` sono davvero usa-e-getta (oggi un run di un file User attivo li svuota).
3. **`APP_ENV=testing` e' mai impostato fuori dai test** (produzione, CI, IDE)? Decide quanto sono gravi i rami `environment('testing')` di W1 e se la guardia puo' fidarsi dell'ambiente.
4. **sqlite o MySQL per i test.** La regola dice MySQL; nei moduli ci sono 11 file e 9 TestCase con wiring sqlite.
5. **`phpstan.neon`**: esclude `Lime*.php` (50 file, 4897 righe di produzione non analizzate) e il 2026-10-20 e' stato aggiunto e tolto un `ignoreErrors` su `typeCoverage` (commit `3951a9ca5` alle 10:21 e `606a380b6` alle 10:28). Solo l'umano modifica il neon: serve sapere chi e perche'.
6. **Dove stanno gli epic cross-modulo.** La [policy](../../../../../bashscripts/docs/modular-bmad-story-policy.md) dice `bmad-output/`, ma un hook rifiuta i nuovi file li'; questo epic e' in `Xot/docs/bmad/` per quel motivo. Va deciso uno solo dei due.
7. **`DB_DATABASE_LU`**: la connessione `liveuser_general` ha oggi un fallback fisso `forge13` e la guardia la esclude per nome (`IGNORED_CONNECTIONS`). Definire `DB_DATABASE_LU=<nome>_test` in `.env.testing` e togliere l'esclusione, oppure confermare che l'esclusione resta.
8. **Db scratch di `pest-scratch-db.sh`**: la guardia lo ammette per prefisso (`claude_scratch_pest_`), perche' non finisce per `_test`. Rinominarlo con suffisso `_test` e togliere il prefisso dalla guardia riduce le eccezioni a una sola regola.
9. **Fallback reali in `laravel/config/database.php`** (righe 126, 144, 161, 178: `quaeris_data`, `quaeris_user`, `quaeris_survey`): con la guardia un `.env.testing` mancante fa abortire il test, ma il default resta un nome reale. Lasciarli o sostituirli con un valore che non esiste (file di config di produzione: decide l'utente).

## 8. Verifica

Comandi riproducibili dalla radice del repo (`/usr/bin/find`, mai il `find` della shell; ogni zero va controprovato):

```bash
# 1. file *Test.php nei moduli (13:3x: 1145)
/usr/bin/find laravel/Modules -path '*/tests/*' -name '*Test.php' -not -path '*/vendor/*' | wc -l
# 2. @phpstan-ignore in app (13:3x: 69; HasXotTable 25)
rg -o --hidden '@phpstan-ignore' laravel/Modules/*/app -g '*.php' | wc -l
# 3. RefreshDatabase attivo, non l'import (13:3x: 18)
rg -l --hidden -P '(uses\([^;]*\bRefreshDatabase\b|^\s+use\s+[^\\;]*\bRefreshDatabase\b[^\\]*;)' laravel/Modules/*/tests -g '*.php' | wc -l
# 4. test mai eseguiti per nome (13:3x: 17 e 4)
/usr/bin/find laravel/Modules -path '*/tests/*' -type f -name '*test.php' ! -name '*Test.php' -not -path '*/vendor/*' | wc -l
/usr/bin/find laravel/Modules -path '*/tests/*' -type f -name '*.pest.php' -not -path '*/vendor/*' | wc -l
# 5. Action con test omonimo nello stesso modulo (13:3x: 238 su 639)
bash -c 'export LC_ALL=C; tot=0; hit=0; for m in laravel/Modules/*/; do [ -d "$m/app/Actions" ] || continue; a=$(/usr/bin/find "$m/app/Actions" -name "*Action.php" -type f -printf "%f\n" | sed "s/\.php$//" | sort -u); t=""; [ -d "$m/tests" ] && t=$(/usr/bin/find "$m/tests" -name "*Test.php" -type f -printf "%f\n" | sed "s/Test\.php$//" | sort -u); tot=$((tot + $(printf "%s\n" "$a" | grep -c .))); hit=$((hit + $(comm -12 <(printf "%s\n" "$a") <(printf "%s\n" "$t") | grep -c .))); done; echo "Action $tot, con test omonimo $hit"'
# 6. il suffisso di phpunit e' quello atteso
rg -n 'suffix=' laravel/phpunit.xml
# 7. link relativi di questo file
cd laravel/Modules/Xot/docs/bmad && bash -c 'for p in $(rg -o --no-filename -P "(?:\]\(|^\s+- )\K\.{1,2}/[^)#\s]+" epic-code-quality-ratchet.md); do realpath -e "$p" >/dev/null || echo "ROTTO $p"; done'
```

Prova di chiusura di questo epic: ogni contatore di sezione 5 e' in un test di `laravel/tests/Architecture/`, la baseline e' scesa almeno una volta per wave, e nessun run di Pest e' avvenuto prima del via sulla guardia DB.
