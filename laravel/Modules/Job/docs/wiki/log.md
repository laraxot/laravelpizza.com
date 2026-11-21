---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
---

## [2026-06-30] docs | Second brain — policy incident consolidato

- Memoria datata rimossa; canon in [policy-restoration-incident.md](./concepts/policy-restoration-incident.md)
- Hub progetto: [sacred-artifacts-never-delete.md](../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md)
- Inventario repo-wide: [policy-module-inventory.md](../../../../../docs/wiki/concepts/policy-module-inventory.md) + `bashscripts/tools/audit-policy-inventory.sh`
- Job 15/15 policy — gold standard (`ExportPolicy extends JobBasePolicy {}`)
- Merge conflict risolto in [index.md](./index.md)

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
title: "Job Wiki Activity Log"
module: "Job"
---

# Job - Wiki Activity Log

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created index.md for each section
- Created module index.md
- Ready for on-demand loading via QMD


---

## [2026-09-25] phpstan | TaskBusinessLogicTest staticMethod.alreadyNarrowedType fix
- `tests/Feature/TaskBusinessLogicTest.php`: replaced `Assert::assertSame(1, $task->is_active)` after `update(['is_active' => 1])` with `$reactivatedTask = $task->fresh()` + `Assert::assertNotNull()` + `Assert::assertSame(1, $reactivatedTask->is_active)` to avoid the "already narrowed type" false positive.
- Cleared `staticMethod.alreadyNarrowedType` error.
