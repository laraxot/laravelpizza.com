# Activity Coverage Plan

Date: 2026-03-06
Owner: multi-agent execution thread

## Mandatory rules

- Never run `php artisan migrate:fresh`.
- Use only `php artisan migrate --env=testing` for test DB bootstrap.

## Reliable coverage command

```bash
XDEBUG_MODE=coverage php -dpcov.enabled=0 ./vendor/bin/pest -c phpunit.activity.xml Modules/Activity/tests --coverage --compact
```

## Latest measured status

- Tests: `159 passed`
- Total coverage: `76.2%`
- Measurement date: 2026-03-06

## Completed in this batch

- Fixed listener test instability (no dirty user update on `last_login_at`).
- Added coverage tests for:
  - policy branches (`ActivityBasePolicy`, `ActivityPolicy`, `SnapshotPolicy`)
  - pagination trait branch coverage (`CanPaginateCoverageTest`)
  - provider method invocation (`EventServiceProviderTest`)
  - snapshot connection behavior (`SnapshotModelTest`)
  - action URL callback branch (`ListLogActivitiesActionTest`)

## Remaining uncovered files

1. `Modules/Activity/app/Filament/Pages/ListLogActivities.php` (0.0%)
2. `Modules/Activity/app/Models/BaseModel.php` (0.0%)

## Next implementation tasks

1. Add a concrete test harness page for `ListLogActivities` to execute:
   - `getBreadcrumb()`
   - `getTitle()`
   - `getFieldLabel()`
   - `canRestoreActivity()` and restore notification paths
2. Add a safe runtime harness for `BaseModel` that does not trigger unresolved EventSourcing container dependencies.
3. Re-run full Activity coverage command and update this file until 100% is achieved.
