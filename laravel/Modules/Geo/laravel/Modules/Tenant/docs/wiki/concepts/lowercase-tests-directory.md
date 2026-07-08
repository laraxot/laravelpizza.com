---
title: "Lowercase Tests Directory"
type: concept
module: Tenant
tags: [tenant, tests, pest, phpstan, structure]
created: 2026-06-30
updated: 2026-06-30
qmd: "tenant lowercase tests directory no Tests duplicate pest phpstan"
related:
  - ../../../../../Xot/docs/wiki/concepts/composer-root-skeleton-modular.md
---

# Lowercase Tests Directory

Il modulo Tenant deve usare solo `tests/` come cartella dei test.

## Regola

- `laravel/Modules/Tenant/tests/` e' la cartella canonica.
- `laravel/Modules/Tenant/Tests/` non deve esistere.
- I test devono restare Pest/PHP sotto la cartella minuscola.

## Motivo

`nwidart/laravel-modules` e Composer PSR-4 lavorano meglio con un solo path canonico per namespace/test. La doppia cartella `Tests`/`tests` crea ambiguita' su filesystem case-sensitive, aumenta il rumore PHPStan e puo' duplicare classi di test gia' presenti.

## Applicazione

Il contenuto di `Tests/` era gia' presente in `tests/`; la directory duplicata maiuscola e' stata rimossa.
