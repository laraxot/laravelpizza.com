---
title: "phpstan Cms fix"
type: note
tags: [documentation]
updated: 2026-09-26
qmd: "phpstan Cms fix"
issues: []
discussions: []
id: phpstan-Cms-fix
slug: phpstan-Cms
scope: [module:Cms, project:base_workorder_fila5]
status: Pending
priority: High
created: 2026-09-06
---

## Problema
PHPStan errors in Modules/Cms

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Fix applicato — subagent-ai-gdpr-cms (2026-09-10)

- File: `Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php` (righe 19 e 23)
- Errore: `ignore.unmatchedIdentifier` (non-ignorable) — due commenti
  `@phpstan-ignore method.notFound` sopra `$this->skipTest(...)` non coprivano più
  nessun errore reale: `skipTest()` è un metodo reale definito in
  `Modules/Xot/tests/XotBaseTestCase.php:130`, quindi l'ignore era diventato stale.
- Fix: rimossi i due commenti `@phpstan-ignore method.notFound` ormai inutili, lasciato
  invariato il codice sottostante (le due chiamate a `skipTest(...)`).
- Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php --no-progress --memory-limit=-1` → `[OK] No errors`.
- Scope di questa sessione era limitato a questo file; il resto del modulo Cms non è
  stato toccato (fuori scope).
