---
title: "code quality commands"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "code quality commands"
issues: []
discussions: []
---

# Code quality commands

## Laravel Pint (formatting)

```bash
cd laravel && vendor/bin/pint
cd laravel && vendor/bin/pint --dirty
```

## PHPStan (static analysis)

Project rules:

- Use **only** `laravel/phpstan.neon` (do not edit it).
- Do **not** pass `--level`.
- Do **not** generate or use baselines.

```bash
cd laravel && vendor/bin/phpstan analyse Modules
```

## PHP Insights

```bash
cd laravel && php artisan insights
cd laravel && vendor/bin/phpinsights
```

## Rector

```bash
cd laravel && vendor/bin/rector process
cd laravel && vendor/bin/rector process --dry-run
```
