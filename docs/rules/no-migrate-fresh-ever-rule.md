# NO `migrate:fresh` Ever Rule

Date: 2026-03-06

## Rule

In this repository, `php artisan migrate:fresh` is forbidden for normal development/testing workflows.

## Why

1. It destroys shared testing state used by multiple concurrent AI agents.
2. It invalidates cross-module assumptions and causes noisy, non-reproducible failures.
3. Project testing guidelines explicitly require external `migrate --env=testing` bootstrap, not destructive resets.

## Required command

Use only:

```bash
php artisan migrate --env=testing
```

## Coverage command standard (Activity scope)

When collecting module coverage, disable `pcov` and use xdebug coverage mode:

```bash
XDEBUG_MODE=coverage php -dpcov.enabled=0 ./vendor/bin/pest -c phpunit.activity.xml Modules/Activity/tests --coverage --compact
```
