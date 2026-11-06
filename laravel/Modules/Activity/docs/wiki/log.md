---
title: "Activity Log"
type: log
module: Activity
tags: [activity, phpstan, pest, qmd]
created: 2026-05-12
updated: 2026-06-13
qmd: "Activity log phpstan pest discipline"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/328"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/329"
status: draft
---

---

## [2026-10-28] phpstan | Modulo sovrascritto da un rebase fermo: 383 errori → 0

- Causa: repo del modulo in `interactive rebase in progress` (onto `7083148f`); l'auto-commit `36463864` ha fissato un conflitto a meta' (71 file mancanti, 135 tornati a fine settembre): LogViewer, `Adapters\ActivityLogger`, fixture `*Harness`, firme `UserContract`. Non erano rimozioni volute.
- Ricostruiti `lang/{it,en}/log_viewer.php`, download Folio `pages/api/log-download`, test `Unit/Actions/Log/*` e `LogDownloadPageTest`; `LogActivityAction` e `Actions\ActivityLogger` di nuovo su `UserContract`.
- Regola: con tanti `class.notFound` in un modulo guarda prima `git status` del modulo (rebase?) e confronta con l'albero `onto`, non riscrivere i test. Vedi [story](../stories/phpstan-zero-errors-activity.story.md) e [dev](../stories/phpstan-zero-errors-activity.dev.md).
- Aperto: rebase da concludere/abortire (lo decide l'utente); questo file ha ancora marcatori `<<<<<<< HEAD` del rebase piu' sotto.

## [2026-10-14] docs | Ingressi di `docs/` riallineati al codice

- Riscritti con fatti verificati su `app/`, `routes/`, `config/`, `database/migrations`, `tests/`: [README.md](../README.md), `../00-INDEX.md` (indice canonico: stato delle cartelle e famiglie della radice con conteggi), `../INDEX.md` (solo inventario numerico), [README.md](./README.md) di questa wiki. Corretti i link di `INDEX.md` della wiki e tolti da `../index.md` i 40 link a `tasks/` e `roadmap/tasks/` (file rimossi nel commit `7e00cedf` del 2026-10-08).
- Marcati `stale` senza cambiare il contenuto: `../ARCHITECTURE.md` (Repositories, Services e Projections inesistenti), `../API.md` (firma `execute(array $data)` inesistente), `../readme.md` (`ActivityStatsWidget` e `EventStore` inesistenti) e le copie di indice `../00-index.md`, `../00-index-documentation.md`, `00-INDEX.md`, `00-index.md`, `00-index-documentation.md`, `index.md`.
- Nel codice: `LoginListener::handle()` e' vuoto, nessuna rotta attiva, PHPStan su `Modules/Activity` esce con 0. Quattro migrazioni `create_activity_table` restano accanto a quella "unica" del 2026-06-10 (la voce del 2026-06-10 qui sotto cita `140000`, il file e' `141000`).
- Nota 2026-10-23: `../00-INDEX.md`, `../INDEX.md` e `INDEX.md` della wiki sono stati rimossi il 2026-10-22 (commit `7e2a1509`); restano citati qui come registro.
- Link non risolti sui file toccati e verifiche: [story](../stories/docs-ingressi-activity.story.md).

## [2026-06-13] phpstan | Gate chef — 7 file Actions → Assert

- Convertiti tutti i test `tests/Unit/Actions/*` da `expect()` a `Assert::assert*()` per eliminare `method.internalClass` (82 errori piattaforma → 0).
- Aggiunti [overviews/completion-status.md](overviews/completion-status.md) e aggiornato [PROJECT-ROADMAP.md](project-roadmap.md) scope Activity.
- Hub: [Xot platform-completion-roadmap](../../Xot/docs/wiki/overviews/platform-completion-roadmap.md) _(target mancante, verificato 2026-10-14)_.
- GitHub: [Activity#18](https://github.com/laraxot/module_activity_fila5/issues/18) / base [#372](https://github.com/laraxot/base_fixcity_fila5/issues/372).

## [2026-06-10] testcase | Brainstorm Activity + nWidart BaseTestCase

- Confermato: Activity `TestCase` già estende `XotBaseTestCase`.
- `Nwidart\Modules\Tests\BaseTestCase` esiste su GitHub (Orchestra Testbench) ma non è autoloadato in app — non usare come parent.
- Gap: solo Geo ancora su Laravel `TestCase` diretto.
- Chat: [docs/chat/testcase-brainstorm-activity-nwidart.md](../../../../../docs/chat/testcase-brainstorm-activity-nwidart.md)

## [2026-06-10] phpstan | Activity clean with Pest tests preserved

- `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity` passa con `[OK] No errors` usando `laravel/phpstan.neon`.
- Correzioni stabili: namespace prima degli import, niente `Tests\TestCase` duplicato, helper fixture array-shape per Pest invece di stato `$this` non risolto da PHPStan.
- Pest e' rimasto runner/test style; la verifica Pest locale e' bloccata da credenziali MySQL (`forge_mysql_25_1`) prima delle assertion.
- Aggiornato [concepts/phpstan-pest-discipline](concepts/phpstan-pest-discipline.md).

## [2026-06-10] phpstan | Pest discipline Activity

- Aggiunto `concepts/phpstan-pest-discipline.md`.
- Regola: `phpstan.neon` solo utente; test Activity restano Pest; usare bridge/helper/assertion pubbliche dentro closure Pest per `method.internalClass`.

## [2026-06-10] schema | activity_log — una migrazione, XotBaseMigration

- Consolidati add/fix/update in `2026_06_10_140000_create_activity_table.php`
- Duplicate in `_bak/`; vietato `extends Migration`
- Doc: [concepts/activity-log-single-migration-contract.md](concepts/activity-log-single-migration-contract.md)

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt) _(target mancante, verificato 2026-10-14)_
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
title: "Activity Log"
type: log
module: Activity
tags: [activity, phpstan, pest, qmd]
created: 2026-05-12
updated: 2026-06-13
qmd: "Activity log phpstan pest discipline"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/328"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/329"


## [2026-06-13] phpstan | Gate chef — 7 file Actions → Assert

- Convertiti tutti i test `tests/Unit/Actions/*` da `expect()` a `Assert::assert*()` per eliminare `method.internalClass` (82 errori piattaforma → 0).
- Aggiunti [overviews/completion-status.md](overviews/completion-status.md) e aggiornato [PROJECT-ROADMAP.md](project-roadmap.md) scope Activity.
- Hub: [Xot platform-completion-roadmap](../../Xot/docs/wiki/overviews/platform-completion-roadmap.md) _(target mancante, verificato 2026-10-14)_.
- GitHub: [Activity#18](https://github.com/laraxot/module_activity_fila5/issues/18) / base [#372](https://github.com/laraxot/base_fixcity_fila5/issues/372).

## [2026-06-10] testcase | Brainstorm Activity + nWidart BaseTestCase

- Confermato: Activity `TestCase` già estende `XotBaseTestCase`.
- `Nwidart\Modules\Tests\BaseTestCase` esiste su GitHub (Orchestra Testbench) ma non è autoloadato in app — non usare come parent.
- Gap: solo Geo ancora su Laravel `TestCase` diretto.
- Chat: [docs/chat/testcase-brainstorm-activity-nwidart.md](../../../../../docs/chat/testcase-brainstorm-activity-nwidart.md)

## [2026-06-10] phpstan | Activity clean with Pest tests preserved

- `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity` passa con `[OK] No errors` usando `laravel/phpstan.neon`.
- Correzioni stabili: namespace prima degli import, niente `Tests\TestCase` duplicato, helper fixture array-shape per Pest invece di stato `$this` non risolto da PHPStan.
- Pest e' rimasto runner/test style; la verifica Pest locale e' bloccata da credenziali MySQL (`forge_mysql_25_1`) prima delle assertion.
- Aggiornato [concepts/phpstan-pest-discipline](concepts/phpstan-pest-discipline.md).

## [2026-06-10] phpstan | Pest discipline Activity

- Aggiunto `concepts/phpstan-pest-discipline.md`.
- Regola: `phpstan.neon` solo utente; test Activity restano Pest; usare bridge/helper/assertion pubbliche dentro closure Pest per `method.internalClass`.

## [2026-06-10] schema | activity_log — una migrazione, XotBaseMigration

- Consolidati add/fix/update in `2026_06_10_140000_create_activity_table.php`
- Duplicate in `_bak/`; vietato `extends Migration`
- Doc: [concepts/activity-log-single-migration-contract.md](concepts/activity-log-single-migration-contract.md)

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt) _(target mancante, verificato 2026-10-14)_
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
title: "Activity Log"
module: "Activity"
---

# Activity Log — Activity

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

### Format

```text
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**

- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

[2026-05-12 08:19:00 UTC] [UPDATE] Aggiornati `index.md`, `rules/INDEX.md` e `skills/INDEX.md` per esporre davvero pattern XotBase, sorgenti core e skill condivise caricabili on-demand.

**Last Activity:** 2026-05-12 08:19:00 UTC  
**Total Operations:** 1

- 2026-06-10: activity_log consolidato in 2026_06_10_140000_create_activity_table.php; duplicate in _bak/

- 2026-06-10: activity_log — consolidate add/fix/update in 141000_create_activity_table; anti-pattern in _bak/


## 2026-09-20 — Pagina Log nel pannello Activity (`/activity/admin/log-viewer`)

- Nuova pagina `LogViewer` (voce Log, gruppo Monitoraggio) per consultare i file di `storage/logs` dal pannello, dove non c'è accesso SSH/FTP: elenco ricorsivo (anche `surveys/<id>/`) mostrato come albero di cartelle, lettura dalla coda del file, ricerca e filtro per livello, download in streaming da una pagina Folio (`/api/log-download`, nessun Controller). Solo super-admin o permesso `log.viewAny`, sola lettura.
- Percorsi validati da `ResolveLogFilePathAction` (solo `.log` dentro `storage/logs`, link simbolici risolti). 68 test, PHPStan pulito; non ancora verificata in produzione né nel browser.
- La risorsa `/xot/admin/logs` (modulo Xot) non è stata toccata: spostarla o rimuoverla resta una decisione del team.
- Secondo audit alle linee guida: story anche in Activity, registro `sprint-status.yaml` aggiornato; scostamenti aperti (CSS in linea, TestCase, PHPMD/PHPInsights, chiavi lang) elencati nel concept.
- Classi base di Xot: usata `XotBasePage` per `LogViewer`; per Action, Data ed eccezione non c'è una base applicabile (vedi il concept). Unico scostamento: i test usano `Tests\TestCase` della root e non il `TestCase` del modulo (manca `database/test_data.sqlite`).
- Dettagli: [concepts/log-viewer-page-no-ssh.md](concepts/log-viewer-page-no-ssh.md); la story di origine (`quaeris-admin-log-viewer-no-ssh`) sta nel repo di un altro progetto e non esiste qui.

---

## [2026-09-25] phpstan | CanPaginate template covariant fix
- `app/Filament/Pages/Concerns/CanPaginate.php`: added `@template TModel of Model` to `paginateQuery()` so callers passing `Builder<Activity>` satisfy the `Builder<Model>` parameter (template covariance).
- `tests/Fixtures/CanPaginateHarness.php` + `tests/fixtures/CanPaginateHarness.php`: aligned `exposePaginateQuery()` PHPDoc to `Builder<Model>` (removed own `@template` that shadowed the trait's).
- `app/Filament/Pages/ListLogActivities.php`: added `@var LengthAwarePaginator<int, Activity>` after the instanceof check to satisfy return-type covariance.
- Cleared 6 `argument.type` / `return.type` errors.