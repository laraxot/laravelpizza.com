---
title: "PHPUnit — config centrale monorepo"
type: rule
module: Xot
tags: [testing, pest, phpunit, modules]
created: 2026-06-11
updated: 2026-06-11
qmd: "xot pest phpunit central laravel phpunit.xml module tests configuration"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/345"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../../../docs/wiki/bmad/architecture-phpunit-central-config.md
  - ../concepts/module-testcase-xotbase-hierarchy.md
  - ../../testing/pest-setup-guide.md
---

# PHPUnit — config centrale monorepo

Owner test bootstrap: **Xot** (`XotBaseTestCase`). Owner config PHPUnit: **`laravel/phpunit.xml`** (root app), non i moduli.

## Esecuzione

```bash
cd laravel
./vendor/bin/pest Modules/Xot/tests/ --configuration phpunit.xml
```

## Legacy

`Modules/*/phpunit.xml.dist` = scaffold nWidart, `export-ignore` — **non** usare per CI o agenti.

## Audit

```bash
bash bashscripts/tools/audit-phpunit-central-config.sh
bash bashscripts/tools/audit-module-pest.sh
```
