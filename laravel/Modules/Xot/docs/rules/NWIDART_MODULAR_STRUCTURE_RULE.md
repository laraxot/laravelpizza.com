---
title: "NWIDART MODULAR STRUCTURE - CRITICAL RULE"
type: note
status: unverified
created: 2026-10-20
updated: 2026-10-20
module: Xot
tags: [xot, rules]
qmd: "NWIDART MODULAR STRUCTURE - CRITICAL RULE"
---
# NWIDART MODULAR STRUCTURE - CRITICAL RULE

**STATUS**: MANDATORY - Violation = Architect Error  
**Last Updated**: 2026-10-19  
**Severity**: CRITICAL

## The rule

Tests owned by a Nwidart module live inside that module:
`laravel/Modules/<Module>/tests/`.

```
CORRECT: laravel/Modules/Xot/tests/
WRONG:   laravel/tests/Modules/Xot/
WRONG:   laravel/Modules/Xot/Tests/
```

The module's own `composer.json`, Pest bootstrap and PHPUnit configuration define
its test boundary. `laravel/tests/` remains valid for application-wide,
cross-module and theme tests, but it is not the owner of module tests.

## Why

Nwidart modules are independently testable package boundaries. Keeping tests,
fixtures and `TestCase.php` next to the module prevents a second tree from
drifting and keeps module-specific setup with its owner.

## Verification

```bash
cd laravel
./vendor/bin/pest Modules/Xot/tests
./vendor/bin/pest Modules/Xot/tests --coverage
```

## Incident history

On 2026-10-15/19, contradictory repository documentation alternated between
module-local and central tests. A historical commit also centralized some tests.
The current module tree and module `phpunit.xml` files establish the authoritative
rule above. Do not use or create `laravel/tests/Modules/<Module>/` for new module
tests.
