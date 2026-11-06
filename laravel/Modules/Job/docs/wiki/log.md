---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-23
qmd: "log"
issues: []
discussions: []
module: "Job"
status: draft
---

## [2026-10-14] docs | Ingressi rivisti sul codice (DOC-010, DOC-002)

- `README.md` della cartella: aggiunte mappa del codice e limiti, tutti verificati con `ls`/`grep` su `laravel/Modules/Job`. Corretto: `ScheduleService` non esiste piu' (eliminato l'8 ottobre), `JobsWaiting` e' una sottoclasse di `Job` e non una vista.
- `00-INDEX.md`: tolta la "versione 2.3.0" senza fonte; corrette le descrizioni di `queueable-action.md`, `schedule.md`, `analysis.md`, `filament.md`, `soketi.md`, `roadmap.md` (appunti o segnaposto, non guide); dichiarate directory canoniche, evidence e le famiglie dei 250 file della radice, senza spostare nulla.
- `index.md` marcato `stale` (descrive classi inesistenti); `wiki/00-index.md` marcato `stale` (copia parziale di `../00-INDEX.md`, 5 link riscritti).
- Limite principale emerso: lo scheduler su DB non e' registrato (`JobServiceProvider::registerSchedule()` tutto commentato, `ScheduleObserver` non collegato), le chiavi `job::model`, `job::cache.*`, `jobs.pruning.*` non sono definite.
- Story: [2026-10-14-docs-ingressi-job](../stories/docs-ingressi-job.story.md). Nota durevole: `bashscripts/ai/wiki/memories/docs-notify-activity-media-job-studio.md`.

## [2026-06-30] docs | Second brain: policy incident consolidato

- Memoria datata rimossa; canon in [policy-restoration-incident.md](./concepts/policy-restoration-incident.md)
- Hub progetto: [sacred-artifacts-never-delete.md](../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md)
- Inventario repo-wide: [policy-module-inventory.md](../../../../../docs/wiki/concepts/policy-module-inventory.md) + `bashscripts/tools/audit-policy-inventory.sh`
- Job 15/15 policy: gold standard (`ExportPolicy extends JobBasePolicy {}`)
- Merge conflict risolto in [index.md](./index.md)

## [2026-06-05] docs | HackerNoon harness: tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), `llm-wiki.txt` (percorso `bashscripts/tools/prompts/llm-wiki.txt`: file non presente il 2026-10-14)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---

# Job - Wiki Activity Log

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD


---

## [2026-09-25] phpstan | TaskBusinessLogicTest staticMethod.alreadyNarrowedType fix
- `tests/Feature/TaskBusinessLogicTest.php`: replaced `Assert::assertSame(1, $task->is_active)` after `update(['is_active' => 1])` with `$reactivatedTask = $task->fresh()` + `Assert::assertNotNull()` + `Assert::assertSame(1, $reactivatedTask->is_active)` to avoid the "already narrowed type" false positive.
- Cleared `staticMethod.alreadyNarrowedType` error.
