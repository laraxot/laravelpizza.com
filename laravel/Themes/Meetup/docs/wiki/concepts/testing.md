---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "testing"
issues: []
discussions: []
status: stale
---

> Nota 2026-10-08 (docs-audit): descrive test in tests/Unit e tests/Feature e comandi su laravel/Themes/Meetup/tests, cartella che non esiste. Contenuto non riscritto, verificare prima di usarlo.

# Testing in Meetup

Questo componente segue lo standard globale di progetto per il testing.

## Pest PHP

Tutti i test devono essere scritti utilizzando **Pest PHP**. L'uso di classi PHPUnit è vietato.

### Convenzioni locali

- Ogni test deve dichiarare `uses()` con la classe TestCase appropriata.
- I test risiedono in `tests/Unit/` e `tests/Feature/`.

### Quality Gate

Prima di ogni commit, i test devono passare i seguenti controlli:
1. Pest: `cd laravel && ./vendor/bin/pest laravel/Themes/Meetup/tests`
2. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse laravel/Themes/Meetup/tests --level=5`
3. PHPMD: `phpmd laravel/Themes/Meetup/tests text phpmd.xml`
