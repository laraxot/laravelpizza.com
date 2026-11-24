---
qmd: "ui stories ui services to actions story md"
title: Convert app/Services to QueueableAction (no-services-rule)
slug: ui-services-to-actions
status: done
scope: module:UI
---

# Convert app/Services to QueueableAction (no-services-rule)

Enforce the repo-wide "no `app/Services/*Service` classes" rule (`bashscripts/ai/wiki/rules/no-services-rule.md`, status RELIGION) inside `Modules/UI`.

## Census

`find Modules/UI/app/Services -name "*.php"` → exactly one active file: `app/Services/UIService.php`.

Also present but explicitly out of scope (not `.php`, dead archives from an earlier, never-fully-executed 2026-07 migration attempt — see `docs/wiki/concepts/ui-services-support-to-actions.md`): `ComponentService.php.bak`, `ThemeService.php.bak`, `UIService.php.bak`, `Map/NullMapService.php.bak`, `Map/NullGeocodingService.php.bak`. Left untouched — not requested by this task, and renaming/deleting `.bak` files is not a call-site-bearing change.

## Classification table

| Old path / class | Kind | Reasoning | New path / class | Call sites updated |
|---|---|---|---|---|
| `app/Services/UIService.php` (`Modules\UI\Services\UIService::asset(string): string`) | A — already-thin-facade | Entire method body was `return app(AssetAction::class)->execute($asset);`, a 1:1 passthrough to the pre-existing `Modules\Xot\Actions\File\AssetAction`. Repo-wide grep (`Modules/`, `Themes/`, root `app/`) for `UIService::asset`, `Modules\UI\Services\UIService`, `use Modules\UI\Services`, `new UIService`, `UIService::class` found **zero production call sites** — only self-references in the file itself and unrelated doc mentions. Per the task's own carve-out for a Service that is "ALREADY just a thin facade whose methods only call existing Actions" (mirroring the `Modules/Tenant/app/Services/TenantService.php` precedent): there is no logic to migrate (it already lives in `AssetAction`), and wrapping it in a new `UI\Actions\*` class whose `execute()` body would be nothing but `app(AssetAction::class)->execute(...)` adds a redundant indirection layer with zero behavioral value — this is exactly the anti-pattern the rule's own carve-out for "a class without a real execute() doesn't live in Actions/" warns against creating one level down. Two prior docs (`ui-services-support-to-actions.md`, `no-app-support-queueable-actions.md`) had already reached this same conclusion in 2026-07 but the deletion was never actually completed — the `.php` file was still live (byte-identical to its own already-existing `.bak` sibling, i.e. it was resurrected after archiving, likely by a concurrent-session merge). | *(deleted, no replacement class — call `app(\Modules\Xot\Actions\File\AssetAction::class)->execute($path)` directly if ever needed)* | None — zero call sites existed anywhere in the repo. |

`app/Providers/UIServiceProvider.php` is **not** in scope: it is a Laravel `Illuminate\Support\ServiceProvider` subclass (framework bootstrap construct registered in `config/config.php`), unrelated to the `app/Services/*Service` business-logic anti-pattern this rule targets.

<<<<<<< HEAD
=======
## Arch debt (#247)

`tests/Arch/debt.php` tiene `'services' => []` con commento #247: ThemeService/ComponentService vuoti, UIService facade di AssetAction, Null*Service duplicati degli adapter — nessuno legato al container. Merge risolto tenendo l'array vuoto (non la lista storica delle classi).

>>>>>>> laraxot/dev
## Verification

- PHPStan, `clear-result-cache` before each run, `Modules/UI` scope: baseline **0 errors** → final **0 errors** (no regression).
- PHPMD (`./tools/phpmd.sh Modules/UI text ../docs/phpmd.ruleset.xml`): crashes on the whole module (`No node to visit provided for visitAnonymousClass`), a documented pre-existing tooling limitation, unrelated to this change. Nothing new to lint per-file since this task was a pure deletion.
- Pest (`./vendor/bin/pest Modules/UI/tests -c Modules/UI/phpunit.xml --no-coverage`): 197 passed, 8 failed, 1 risky, 109 skipped. All 8 failures are pre-existing (`TestCase::expectMethod()` Mockery `CompositeExpectation` mismatch, missing `ui::components.render.blocks.ui::empty` view, an `OpeningHoursColumn` assertion), none reference `UIService` or `AssetAction`.
<<<<<<< HEAD
=======
- `php -l tests/Arch/debt.php`: OK; zero marker `<<<<<<<` nei PHP UI.
>>>>>>> laraxot/dev

## Git

`git rm app/Services/UIService.php` in `Modules/UI`'s own repo (remote `laraxot/module_ui_fila5.git`), committed and pushed separately — no other module repos required changes since there were no cross-module call sites.
<<<<<<< HEAD
=======

## Boy scout 2026-11-23 (residuo on-disk)

I cinque `app/Services/**/*.php` sono riapparsi. Stub SUPERSEDED (no-delete):
`UIService` → AssetAction; `ComponentService`/`ThemeService` vuoti; `Map/Null*` →
`Adapters/Map/Null*ServiceAdapter`. Zero caller, zero binding. `debt.php` resta
`services => []` (#247). Aperto: auth per `git rm` dei residui.
>>>>>>> laraxot/dev
