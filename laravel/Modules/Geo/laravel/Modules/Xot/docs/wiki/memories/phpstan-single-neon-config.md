---
title: "Memoria — PHPStan solo laravel/phpstan.neon"
type: memory
module: Xot
tags: [phpstan, neon, agent-discipline]
created: "2026-06-18"
updated: "2026-06-18"
related:
  - ../../../../../../docs/wiki/rules/phpstan-single-neon-config.md
qmd: "memory phpstan single neon no phpstan-gate no wrapper config"
---

# Memoria — PHPStan solo `laravel/phpstan.neon`

## Trigger

Prima di PHPStan: `cd laravel` → `./vendor/bin/phpstan analyse …` **senza** `-c`.

## Vietato

- Creare `phpstan-gate.neon`, `phpstan-*.neon` alternativi
- `PHPSTAN_CONFIG=altro.neon`
- Modificare `phpstan.neon` (solo utente)

## OOM

`bash bashscripts/tools/phpstan-modules-gate.sh` + `--memory-limit=2G` (non `-1`).
