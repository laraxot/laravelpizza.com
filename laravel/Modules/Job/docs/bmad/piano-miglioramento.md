---
title: "Piano di miglioramento — Job"
type: plan
status: review
updated: 2026-11-16
module: Job
qmd: "piano miglioramento Job P0 P1 P2 policy scheduler Livewire widget guard test sequenza criteri"
related:
  - ./audits/job-audit.md
  - ./epics.md
  - ./decision-log.md
---

# Piano di miglioramento — Job

Derivato dall'[audit profondo](./audits/job-audit.md). Epic e AC: [epics.md](./epics.md).

## P0

1. **E1** — **chiuso** policy deny-default + `JobResource` senza create/edit (D-5, D-3); Pest unit verde.
2. **E2** — scheduler: decidere D-2 (cablare o ritirare) con committente; se ritirare, togliere la UI che promette.

## P1

1. **E3** — cancellare `Http/Livewire` + `_components.json`, riaprire/chiudere story 12.1 (D-4).
2. **E4** — `SuperAdminOnlyTrait` su 4 widget; via il loop `queue:listen`.
3. **E5** — mock kernel in `ScheduleStatusWidgetTest` **fatto**; resta `Livewire::test` sulle superfici operative.
4. Docs: gap-fill fatto; resta frontmatter su 101 `.md` e 53 nomi non conformi.

## P2

1. `ScheduleService` → Action o cancellazione; unificare le 2 coppie di Action.
2. Junk fuori dall'albero (`.aaa`, `queue.pid`, `.backup*`, `Untitled`, `webpack.mix.js`, `psalm.xml`, `tests/feature`/`unit`).
3. i18n dei titoli notifica.
4. Allineare le Resource Filament a `XotBase*` e le traduzioni a Lang (zero etichette letterali).
5. Dipendenze verso altri moduli: `TaskComment.php:11` e `Traits/TaskCommentRelations.php:9` importano `Modules\User\Models\User` concreto (usare `XotData`/`UserContract`); verificare con `rg` che non ci siano altre dipendenze inverse.
6. Profiling N+1 sulle Resource e sui widget di stato.

## Sequenza e gate

1. Story disgiunte + lock (`bashscripts/lock/`).
2. PHPStan `Modules/Job` = 0.
3. Pest mirato su scratch DB: nessun `migrate:fresh`/`RefreshDatabase`/`--force`.
4. Aggiornare [ECC](../ecc/00-index.md) e `qmd update`.

## Criteri di completamento

- [x] Utente senza ruolo → `create()` false; rotta `/create` assente
- [ ] D-2 decisa e UI allineata al comportamento reale
- [ ] `rg 'dd\(|Artisan::call\(\$cmd\)' app` = 0 fuori allowlist
- [ ] PHPStan `Modules/Job` = 0
- [ ] ECC `00-index` aggiornato
