---
id: DCP-243
title: "DCP-243: test del model Module di Xot contro l'API reale"
type: story
epic: DCP-240
status: blocked
priority: P1
owner: module:Xot
module: Xot
created: 2026-10-15
updated: 2026-10-15
qmd: "Module Sushi nwidart ModuleTest phpstan test contro api inesistenti usesTimestamps slug enabled ModuleFactory No tests found @test PHPUnit 13"
related: [DCP-240, DCP-222]
tags: [phpstan, test, sushi, xot]
---

# DCP-243: test del model Module di Xot contro l'API reale

## Fase BMAD
Correzione alla sorgente e verifica. Stato: **bloccata dal lock di un altro agente** sul file di test. La riscrittura e' pronta e verificata in bozza, non applicata.

## Scopo ricostruito (una riga)
`Modules\Xot\Models\Module` e' un registry Sushi (sqlite in memoria) dei moduli nwidart: il test doveva garantire che le righe rispecchino i moduli nwidart, che `isEnabled()` scelga il flag giusto e che le scritture sul registro funzionino sulle colonne che esistono.

## Fatti misurati (2026-10-15)

1. **Originale** (versione in indice git, mai committata): classe PHPUnit con `Tests\TestCase` + `RefreshDatabase`, metodi `it_*` con `/** @test */`, colonne `alias` e `enabled`. 13 errori PHPStan (misura DCP-240 delle 13:34 UTC, non riprodotta da me: il file era gia' cambiato).
2. **13:37-13:40 un'altra sessione** (agente `xot-moduletest`, task `phpstan-swarm-coord`, lock del 13:37:13) ha sostituito `alias` con `slug`, `assertEquals` con `Assert::assert*`, e in `Modules/Xot/app/Models/Module.php` ha aggiunto `@property created_at/updated_at`, `@method whereSlug/whereEnabled` e la frase "i timestamp seguono BaseModel". PHPStan su quel file: `{"errors":0,"file_errors":0}`, exit 0.
3. **Quel verde non prova nulla.** Pest sul file: `INFO  No tests found.` PHPUnit e' 13.4.2 e non legge `@test` nei doc-comment; i metodi `it_*` non sono test. 0 test eseguiti.
4. **Se girassero fallirebbero.** Probe sul model reale (`php` che avvia l'app, nessuna scrittura sul DB di sviluppo):
   - `usesTimestamps=false` (il trait Sushi lo spegne per `Module`, che non dichiara `$timestamps`);
   - colonne dello schema: `id, name, description, status, priority, path, icon, colors` (le stesse chiavi di `getRows()`);
   - `Module::create(['name'=>'X','slug'=>'x','enabled'=>true])` => `QueryException: table modules has no column named slug`;
   - `Module::factory()->count(2)->create()` => `QueryException: table modules has no column named slug` (la `ModuleFactory` scrive `slug`, `version`, `is_active`);
   - `nwidart=19 sushi=19`: una riga per modulo.

## Causa radice
Il test e' stato scritto pensando a un model Eloquent su tabella `modules` con `slug`, `enabled`, timestamp e factory, senza leggere `Module.php` ne' il trait Sushi. In piu' non e' mai stato eseguito: nessuno se n'e' accorto perche' il runner non lo scopre. L'adattamento fatto alle 13:38 (rinominare le chiavi, allargare i docblock) fa tacere PHPStan ma non corregge ne' l'uno ne' l'altro difetto.

## Comportamenti testati: cosa esiste

| Comportamento del test originale | Esiste? | Prova |
|---|---|---|
| tabella `modules`, chiave `id` | si | `getTable()`, `getKeyName()` |
| create / update / delete | si, solo su colonne dello schema (`status`, non `enabled`) | probe + test verdi in bozza |
| enable / disable | si, via `status` e `isEnabled()` / `isDisabled()` | `Module.php`, precedenza `enabled` > `status` > `is_active` |
| ricerca per `name`, conteggio, limite | si | test verdi in bozza |
| ricerca per `slug` | **SENZA SORGENTE** | nessuna colonna `slug` in `getRows()`; `QueryException` |
| `created_at` / `updated_at` / `usesTimestamps()` | **SENZA SORGENTE** | `usesTimestamps=false`, colonne assenti |
| `Module::factory()->create()` | **SENZA SORGENTE** | `ModuleFactory::definition()` scrive colonne inesistenti |

I tre casi SENZA SORGENTE restano nella bozza come test saltati con motivo: non si cancellano e non si inventa produzione.

## Riscrittura verificata (non applicata)
Bozza: `/tmp/claude-1000/-mnt-nas07-var-www--bases-base-fixcity-fila5/5cf9209d-97a3-4f34-9a8e-a41d6622cc77/scratchpad/dcp243/ModuleTest.verified-draft.php` (stessa copia in `/tmp/claude-1000/dcp243draft/ModuleTest.php`: Pest rifiuta i percorsi con un segmento che inizia per cifra, per questo e' stata eseguita da li').

Scelte:
- Pest funzionale (`test(...)`) come i test fratelli, namespace `Modules\Xot\Tests\Unit\Models`, `uses(XotBaseTestCase::class)` come `Unit/Helpers/PathHelperTest.php`: il test non ha bisogno del database applicativo (Sushi usa sqlite in memoria) e `RefreshDatabase` e' tolto. `Modules\Xot\Tests\TestCase` non va: `DatabaseTransactions` apre una transazione sulla connessione `sqlite` prima del suo `setUp`, e sotto `pest-scratch-db.sh` esce con `SQLiteDatabaseDoesNotExistException` (stesso difetto di DCP-222; riprodotto su `BaseModelTest`: 5 failed, 0 assertions).
- Le attese vengono da nwidart (`ModuleFacade::all()`, `allEnabled()`, `getPath()`), non da costanti.
- Le righe create sono prefissate `Dcp243` e cancellate in `afterEach`, perche' la sqlite in memoria vive quanto il processo.
- `ModuleFactory::new()` e non `Module::factory()` (PHPStan vede `mixed`, vedi docblock di `HasXotFactory`).

## Verifica (output reale della bozza)

- `php -l`: `No syntax errors detected`.
- PHPStan (dalla cartella `laravel/`, `heavy-slot.sh`, config unica, `--error-format=json`): exit 0, `{"errors":0,"file_errors":0}`.
- Pest (`DB_DATABASE_LIMESURVEY= APP_CONFIG_CACHE=/nonexistent/config.php`, `pest-scratch-db.sh`): `Tests:    3 skipped, 14 passed (124 assertions)`, scratch eliminato.
- Stato del file nel repo, per confronto: PHPStan `{"errors":0,"file_errors":0}` ma Pest `INFO  No tests found.`

## Perche' non e' applicata
`bash bashscripts/lock/check.sh laravel/Modules/Xot/tests/Unit/Models/ModuleTest.php` => `LOCKED at 2026-10-15T13:37:13+00:00, Agent: xot-moduletest`, ancora attivo alle 13:55 (eta' 17m 52s); ultima scrittura del file 13:40:37. Il lock non e' mio e la soglia per considerarlo stantio e' 60 minuti: non l'ho rubato.

## Task
- [ ] T1. Quando il lock e' libero: sostituire `Modules/Xot/tests/Unit/Models/ModuleTest.php` con la bozza, rieseguire `php -l`, PHPStan sul file e Pest come sopra.
- [ ] T2. Correggere i docblock di `Module.php` aggiunti alle 13:38: dichiarano `created_at`, `updated_at`, `whereSlug`, `whereEnabled` e "timestamp seguono BaseModel", tutti falsi per la misura sopra. Lo fa chi ha il file in mano.
- [ ] T3. Decisione dell'utente: o la produzione cresce (colonne `slug`/`version`/`is_active`/timestamp nel registry, factory coerente) e i tre test saltati si attivano, oppure `$fillable` e `ModuleFactory::definition()` si riducono allo schema reale. Fino ad allora sono SENZA SORGENTE.
- [ ] T4. Rimisurare con un run completo di `analyse Modules` a swarm fermo (typeCoverage solo li').

## Riferimenti
- Epic: `bmad-output/epic-phpstan-modules-test-contro-api-inesistenti.md` (DCP-240).
- Strumenti di prova che non girano: `dcp-222-strumenti-di-prova-che-non-girano-o-non-dicono-la-verita.story.md`.
