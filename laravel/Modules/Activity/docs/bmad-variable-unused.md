---
title: "Activity: PHPStan variable.unused BMAD"
type: note
status: draft
updated: 2026-10-20
tags: [docs, activity]
qmd: "activity   phpstan variable.unused bmad activity"
---
# Activity: PHPStan variable.unused BMAD

**Module purpose:** Activity log / event tracking (listeners, actions, subscribers); production = logs/actions, tests = feature + unit coverage.

**Why variables dead:** Empty test bodies (instantiate only, no assertions) after merge of test skeletons; variables like `$action`, `$listener`, `$model`, `$policy` assigned but never read.

**Fix applied:** Removed dead assignment in test bodies, kept minimal `new Class;` where chain/instantiation is the test intent; did NOT drop assertions that were missing (out of scope: only variable cleanup per instruction).

**Files edited (random order):**
1. `tests/Unit/Actions/RestoreActivityActionTest.php`
2. `tests/Unit/Listeners/ActivityListenersTest.php`
3. `tests/Unit/Models/Policies/ActivityPolicyTest.php`
4. `tests/Unit/Actions/LogActivityActionTest.php`

Verifica lane: `cd laravel && ./vendor/bin/phpstan analyse Modules/Activity/tests --no-progress`.
