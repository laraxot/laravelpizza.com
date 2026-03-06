# Memory: Activity Coverage Source Scope Pollution

## Symptom

Running:

`cd laravel && ./vendor/bin/pest --testsuite=Activity --coverage`

may report files outside `Modules/Activity` and keep total at `0.0%`.

## Impact

Coverage percentage from that command cannot be used as module KPI until source filter is corrected.

## Required handling

1. Keep implementing tests for real Activity targets.
2. Track progress in `Modules/Activity/docs/coverage-plan.md`.
3. Treat root coverage output as diagnostic only until scope is fixed.

