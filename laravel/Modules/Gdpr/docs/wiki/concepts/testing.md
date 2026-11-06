---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-28
qmd: "testing"
issues: []
discussions: []
status: draft
---

# Testing in Gdpr

Questo componente segue lo standard globale di progetto per il testing.

## Pest PHP

Tutti i test devono essere scritti utilizzando **Pest PHP**. L'uso di classi PHPUnit è vietato.

### Convenzioni locali

- Ogni test deve dichiarare `uses()` con la classe TestCase appropriata.
- I test risiedono in `tests/Unit/` e `tests/Feature/`.

### Quality Gate

Prima di ogni commit, i test devono passare i seguenti controlli:
1. Pest: `cd laravel && ./vendor/bin/pest laravel/Modules/Gdpr/tests`
2. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse laravel/Modules/Gdpr/tests --level=5`
3. PHPMD: `phpmd laravel/Modules/Gdpr/tests text phpmd.xml`

### Helper `gdpr*()` e `TestCase::$currentTest`

- `tests/PestHelpers.php` (`gdprTest()`, `gdprGet()`, `gdprPost()`, `gdprActingAs()`, `gdprSkipTest()`) dipende da `Modules\Gdpr\Tests\TestCase::$currentTest`: valorizzata in `setUp()` (dopo `parent::setUp()`), azzerata in `tearDown()`. Se manca, PHPStan segnala `property.staticAccess` e `return.type` su `gdprTest()` e a runtime nessun helper funziona.
- Dopo la risoluzione di un conflitto di merge in `tests/TestCase.php` o in un test: confrontare gli `use` e i membri con `git show <commit-prima-del-merge>:<file>`. Il 2026-10-28 il merge ha fatto sparire `$currentTest`, `use PHPUnit\Framework\Assert` (`ConflictResolutionTest`) e `use ...\IconColumn` (`TreatmentsTable`): tre errori a runtime (proprieta' statica non dichiarata, `Class "Assert" not found`, `Class IconColumn not found`).
