---
title: "code quality commands"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_b3JFnl
<<<<<<< .merge_file_2TH1sX
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_CNOwEM
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_b3JFnl
>>>>>>> .merge_file_1RhF0e
=======
>>>>>>> .merge_file_CNOwEM
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
