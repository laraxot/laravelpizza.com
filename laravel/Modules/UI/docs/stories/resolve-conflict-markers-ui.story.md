---
type: story
tags: [documentation, merge, conflict-markers, bmad, ui]
created: 2026-10-21
updated: 2026-10-21
status: in-progress
scope: module:UI
story_id: "resolve-conflict-markers-ui"
title: "UI: resolve git conflict markers in the gap closer test"
module: UI
related:
  - ./19.UI-merge-conflict-resolution.story.md
issues: []
discussions: []
---

# UI: resolve git conflict markers

**BMAD phase:** Dev (conflict resolution, verification)
**Owner module:** UI
**Scope:** `tests/Unit/UiGapCloser100Test.php`.

## Per-file decisions

### tests/Unit/UiGapCloser100Test.php

- Three conflict blocks. The side that was kept in each case:
  1. Import of `Modules\Ui\Http\Livewire\DarkModeSwitcher` dropped. The namespace is written with a lowercase `Ui` and the class does not exist in the module. The only Livewire file left is `app/Http/Livewire/Toast.php`. The `DarkModeSwitcher` class lives on as `app/View/Components/DarkModeSwitcher.php` and as the Filament widget `DarkModeSwitcherWidget`.
  2. The `DarkModeSwitcher` Livewire test was replaced by the widget test (`DarkModeSwitcherWidget ... (SSoT panel)`). The widget is the single source of truth.
  3. `Toast::render()` assertion uses `View::class`. The other side used `ViewContract::class`, which is not imported in this file.
- The test count is unchanged in intent: the retired Livewire test is replaced, not deleted.

## Verification

| Check | Command | Result |
| --- | --- | --- |
| Syntax | `php -l tests/Unit/UiGapCloser100Test.php` | No syntax errors detected |
| Style | `./vendor/bin/pint --test --config pint.json <file>` | passed |
| Pest | `./vendor/bin/pest Modules/UI/tests/Unit/UiGapCloser100Test.php` | BLOCKED: 14 failed, 0 assertions. Every failure is `Class "PHPStan\PhpDocParser\Parser\TypeParser" not found` (missing `phpstan/phpdoc-parser` in `laravel/vendor`). |

The Pest result is an environment failure. The tests have not run. See the Rating story for the vendor issue.

## Open items

- Rerun Pest after the vendor package is restored.
