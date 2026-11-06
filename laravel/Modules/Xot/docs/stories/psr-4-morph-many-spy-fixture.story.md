---
title: "Xot - PSR-4 morph many spy fixture"
module: Xot
bmad: true
status: done-with-blocker
parent: docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md
tags: [docs, xot, bmad, psr-4, tests]
---

# PSR-4 morph many spy fixture

- **Parent plan**: [5.301 PSR-4 autoload compliance fleet](../bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md), task 5.301.x (Xot test doubles in a file that is not named after its class).
- **Owner module**: Xot.
- **Status**: code moved and syntax checked. Pest run blocked by the test database guard (see Verification).

## Problem

`composer dump-autoload` warned that `tests/Unit/Actions/Model/Update/MorphManyActionTest.php` does not comply with PSR-4. The file declared `final class MorphManyRelationSpy` next to the test, but the mapping `Modules\Xot\Tests\` points to `tests/`, so the class must live in its own file.

## Purpose of the spy

`MorphManyRelationSpy` is a test double for the relation returned by `$model->comments()`. It is not production code.

- `calls` (int): incremented on each `saveMany()` call.
- `saved` (list of models): the rows received by the last `saveMany()` call.

Only `MorphManyActionTest` references it. Its two cases read it:

1. "passes the rows updated by UpdateAction to saveMany": asserts `calls === 1`, the bodies `['a', 'b']`, and the keys `[1, 2]`.
2. "does not update anything when the payload is empty": asserts `saved === []`.

## Change

| File | Change |
|------|--------|
| `Modules/Xot/tests/Fixtures/MorphManyRelationSpy.php` | New. Same class body, namespace `Modules\Xot\Tests\Fixtures`, `declare(strict_types=1)`, short docblock. |
| `Modules/Xot/tests/Unit/Actions/Model/Update/MorphManyActionTest.php` | Class removed. Added `use Modules\Xot\Tests\Fixtures\MorphManyRelationSpy;`. The regression docblock moved above the first `it()`. Test bodies unchanged. |

The folder `tests/Fixtures` already exists with that casing. No file named `MorphManyRelationSpy.php` existed before the change.

Behavior is unchanged: the class body is identical, and the action under test (`Modules/Xot/app/Actions/Model/Update/MorphManyAction.php`) was not touched.

## Verification

- `php -l` on both touched files: `No syntax errors detected` for each.
- `cd laravel && composer dump-autoload`: no line mentions `Modules/Xot/tests` or `Modules\Xot\Tests`, and no line mentions `MorphMany`.
- `./vendor/bin/pest Modules/Xot/tests/Unit/Actions/Model/Update/MorphManyActionTest.php`: not green. Both tests abort in `Modules/Xot/tests/Support/TestDatabaseGuard.php:100`:

```
Test abortiti: connessioni verso database non usa-e-getta (il nome deve finire per "_test"): "ptv" (mysql) -> database "ptv_lara"; ...
Cause tipiche: DB_DATABASE* gia' esportati nella shell, .env.testing mancante, DB_URL impostato, bootstrap/cache/config.php obsoleto.
Tests: 2 failed (0 assertions)
```

The guard blocks the run before any spy assertion executes. The `.env` file and the guard were not changed. The assertions have not been executed in this session.

## Open items

- Pest must be rerun in an environment where the testing connections point to databases whose names end in `_test`, or after `.env.testing` is set up as the guard expects.
- The parent story `docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md` contains unresolved git merge-conflict markers (`<<<<<<<`, `=======`, `>>>>>>>`, 12 lines). It needs a separate fix before it can be trusted as the parent plan.