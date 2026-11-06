---
title: "phpstan Geo fix"
type: note
tags: [documentation]
updated: 2026-09-26
qmd: "phpstan Geo fix"
issues: []
discussions: []
id: phpstan-Geo-fix
slug: phpstan-Geo
scope: [module:Geo, project:base_workorder_fila5]
status: done
priority: High
created: 2026-09-06
---

## Problema
PHPStan errors in Modules/Geo

## Solution

Scope test 17 file completato: vedi [phpstan-geo-unit-tests-scope.story.md](./phpstan-geo-unit-tests-scope.story.md).

1. Analyze with phpstan
2. Fix pattern errors alla sorgente (DTO/trait/factory)
3. Verify per-file con `nice -n 10 ./vendor/bin/phpstan analyse Modules/Geo/tests/...`
4. Pest mirato sui file toccati (opzionale post-merge)
