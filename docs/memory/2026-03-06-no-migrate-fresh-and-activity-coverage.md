# Memory: No `migrate:fresh` + Activity Coverage Baseline (2026-03-06)

## Hard constraint

`migrate:fresh` must never be used in this project workflow.
Use only `php artisan migrate --env=testing`.

## Coverage tooling gotcha

`pcov` configured globally caused false `0.0%` reports for module paths.
Reliable module coverage requires:

- `XDEBUG_MODE=coverage`
- `php -dpcov.enabled=0`
- dedicated config scope (`phpunit.activity.xml`)

## Activity current snapshot

Command:

`XDEBUG_MODE=coverage php -dpcov.enabled=0 ./vendor/bin/pest -c phpunit.activity.xml Modules/Activity/tests --coverage --compact`

Result:
- 159 tests passed
- Total coverage: 76.2%
- Remaining uncovered files:
  - `Modules/Activity/app/Filament/Pages/ListLogActivities.php`
  - `Modules/Activity/app/Models/BaseModel.php`
