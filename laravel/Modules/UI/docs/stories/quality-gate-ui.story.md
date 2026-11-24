---
qmd: "ui stories quality gate ui story md"
title: Quality gate closure — Modules/UI (phpmd MissingImport cleanup)
slug: quality-gate-2026-09-04-ui
status: done
scope: module:UI
---

# Quality gate closure — Modules/UI

BMAD phases covered by this story: **Build** (5 mechanical phpmd fixes) + **Measure**
(phpstan/phpmd/pest verification, coverage doc, git sync). Standing order pillar 5
(quality-gate closure) for `Modules/UI`, run 2026-09-04.

## Context

PHPStan on `Modules/UI` was already verified at 0 errors earlier the same day (documented
in `docs/coverage.md`'s "Mixed type reduction" entry). Scope for this pass: phpmd, pest,
coverage, git — with a phpstan baseline re-check.

## Build — what was fixed

`./tools/phpmd.sh Modules/UI/app text ../docs/phpmd.ruleset.xml` reported 64 findings.
5 were `MissingImport` (FQCN `throw new \X(...)` / `new \X(...)` instead of a `use`
statement) — mechanical, zero-behavior-change fixes, applied to:

1. `app/Actions/Block/ResolveLocalizedBlockDataAction.php` — `use UnexpectedValueException;`.
2. `app/Actions/Icon/GetAllIconsAction.php` — `use ReflectionClass;`.
3. `app/Datas/ThemeMetadataData.php` — `use InvalidArgumentException;`.
4. `app/Filament/Forms/Components/EnumSelect.php` — `use InvalidArgumentException;` (covers
   2 occurrences).
5. `app/Filament/Forms/Components/InlineDatePicker.php` — `use RuntimeException;`.

Result: 64 → 58 findings, 0 regressions (phpstan and pest both re-verified clean/unchanged
after each edit — see `docs/coverage.md`, "Quality gate closure" entry, for the full
per-finding triage of what was intentionally left alone and why, e.g. framework-mandated
callback signatures, `SliderData`'s external-JSON-key snake_case properties, and
`RouteServiceProvider`/`UIServiceProvider`'s parent-class-inherited `$module_dir`/
`$module_ns` property names).

phpinsights is not installed in this repo (removed, incompatible with Pest 5) — not run.

## Measure — verification

- `find Modules/UI -name "*.php" -exec php -l {} \;` → clean, 0 syntax errors.
- PHPStan (`clear-result-cache` + `analyse Modules/UI --no-progress`): **0 errors** baseline,
  **0 errors** final. One transient bootstrap crash was hit and root-caused mid-session to a
  concurrent, uncommitted, out-of-scope session actively rewriting
  `Modules/Xot/app/View/Components/_components.json` (confirmed via mtime + `git status` in
  `Modules/Xot`) — not a `Modules/UI` regression, not touched, resolved itself ~3 minutes
  later when re-verified.
- Pest (`./vendor/bin/pest -c Modules/UI/phpunit.xml --no-coverage`): **197 passed, 8 failed,
  1 risky, 109 skipped** (645 assertions, 211.62s) — identical to the same-day prior baseline,
  confirming no regression. The 8 failures are pre-existing and unrelated to the files touched
  here (see `docs/coverage.md` for the full list).
- Coverage: no new test added — the fixes were pure mechanical import substitutions with
  verified-identical pest pass/fail counts before/after, so there was no real gap or dead
  code this pass uncovered to justify a new test (per the "no fake tests just to move the
  number" rule). Full baseline documented in `docs/coverage.md`.

## Git

`Modules/UI` has its own git repo (remote `laraxot`, `git@github.com:laraxot/module_ui_fila5.git`).
`git status --short` at task start showed large pre-existing uncommitted drift (~30 files)
from an earlier, unrelated session — not touched, not staged. Only the 5 files listed above
plus this story and `docs/coverage.md` were added and committed by this session.

## Follow-up (not in scope for this pass)

- Cyclomatic/NPath/method-length complexity debt on `GetUserDataAction::execute()`,
  `GetAllIconsAction::execute()`, `IconStateColumn::setUp()`,
  `IconStateGroupColumn::stateClass()`, `IconStateSplitColumn`, `SelectStateColumn::setUp()`,
  `SelectState::setUp()`, `InlineDatePicker::generateCalendarData()` — needs a dedicated
  extract-method refactor story with characterization tests written first (4 of these 8
  classes currently have no test file at all).
