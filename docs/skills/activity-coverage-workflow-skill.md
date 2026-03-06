# Skill: Activity Coverage Workflow

## Trigger
Use this when asked to reach high/100% coverage for `Modules/Activity`.

## Steps
1. Run non-destructive DB bootstrap only:
   - `php artisan migrate --env=testing`
2. Run real coverage with pcov disabled:
   - `XDEBUG_MODE=coverage php -dpcov.enabled=0 ./vendor/bin/pest -c phpunit.activity.xml Modules/Activity/tests --coverage --compact`
3. Target missing files by writing focused tests.
4. Re-run full Activity coverage after each batch.
5. Update `Modules/Activity/docs/coverage-plan.md` with numbers, tested files, and blockers.

## Never do
- Never run `php artisan migrate:fresh`.
