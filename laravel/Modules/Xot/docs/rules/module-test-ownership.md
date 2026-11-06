---
title: "Module test ownership"
type: note
status: unverified
created: 2026-10-20
updated: 2026-10-20
module: Xot
tags: [xot, rules]
qmd: "Module test ownership"
---
# Module test ownership

**Status:** canonical repository rule

## Rule

Tests owned by a Nwidart module live in:

```text
laravel/Modules/<Module>/tests/
```

For example, Xot tests are under `laravel/Modules/Xot/tests/` and are executed
from the Laravel root with:

```bash
cd laravel
./vendor/bin/pest Modules/Xot/tests
```

The lowercase `tests` directory is intentional. `Feature`, `Unit`, `Integration`
and module-specific fixtures remain below that directory.

## What `laravel/tests/` is for

`laravel/tests/` remains valid for application-wide, cross-module, and theme
tests. Existing `laravel/tests/Modules/<Module>/` trees are legacy or
application-owned until individually inventoried; they are not a reason to
create new module tests there.

Do not automatically move, delete, or merge either tree. First identify the
owner, namespace, bootstrap, and composer/Pest configuration of each test.

## Why the previous guidance was wrong

Earlier documentation copied an assumption about a central Laravel test tree and
then promoted it to an absolute Nwidart rule. That contradicted the checked-out
module structure, which already contains module-local `tests/` directories and
module test bootstraps. The mistake was trusting historical prose before
checking filesystem ownership and execution configuration.

This page is the canonical correction. When another document conflicts with it,
update that document or mark it historical; never create a third convention.

## Change checklist

- [ ] Confirm the test belongs to one module.
- [ ] Put it in `laravel/Modules/<Module>/tests/`.
- [ ] Preserve the module namespace and local bootstrap.
- [ ] Use `laravel/phpstan.neon`; do not create another PHPStan config.
- [ ] Run the module's focused Pest command before broader suites.
