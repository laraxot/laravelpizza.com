---
type: story
tags: [documentation, merge, conflict-markers, bmad, notify]
created: 2026-10-21
updated: 2026-10-21
status: in-progress
scope: module:Notify
story_id: "resolve-conflict-markers-notify"
title: "Notify: resolve git conflict markers in the template version model test"
module: Notify
related:
  - ./4.25.git-conflict-marker-remediation.story.md
issues: []
discussions: []
---

# Notify: resolve git conflict markers

**BMAD phase:** Dev (conflict resolution, verification)
**Owner module:** Notify
**Scope:** `tests/Unit/Models/NotificationTemplateVersionTest.php`.

## Per-file decisions

### tests/Unit/Models/NotificationTemplateVersionTest.php

- Two full versions of the test were in conflict.
  - Side A: flat `it()` tests. It asserted `Modules\Xot\Traits\HasFactory`, a `HasUuids` trait and a `HasMedia` trait. The model uses `HasXotFactory`, has no `HasUuids`, and `HasMedia` is an interface. Side A also contained a duplicated "has media relationship" test and no real check for `template()`.
  - Side B: grouped `describe()` block that states it is aligned to the real model (`restoreTemplate()`, `HasXotFactory`, `HasMedia` as interface, no `HasUuids`).
- Decision: side B is kept. It matches the model in `app/Models/NotificationTemplateVersion.php`.
- Change made while verifying: the test "belongs to a notification template through template_id" called `template()` on an unbooted model, which needs a database connection resolver. It failed with `Call to a member function connection() on null`. It was replaced with a reflection check that `template()` declares a `BelongsTo` return type. The `BelongsTo` import was kept for it.
- Pint removed one unused import (`BelongsTo`) before the reflection check was added. It was restored.

## Verification

| Check | Command | Result |
| --- | --- | --- |
| Syntax | `php -l tests/Unit/Models/NotificationTemplateVersionTest.php` | No syntax errors detected |
| Style | `./vendor/bin/pint --test --config pint.json <file>` | passed |
| Pest | `./vendor/bin/pest Modules/Notify/tests/Unit/Models/NotificationTemplateVersionTest.php` | Tests: 8 passed (22 assertions) |

## Open items

- None for this file.
