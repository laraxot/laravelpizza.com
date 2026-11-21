---
title: "testing"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "testing"
issues: []
discussions: []
---

# Cms Module Testing Guide

## Overview

This module follows the project's [testing rules](testing-rules.md) and uses Pest PHP as the testing framework.

## Test Structure

```
tests/
  Feature/    # Feature tests
  Unit/       # Unit tests
  Pest.php    # Solo helper: nessun binding del TestCase (vedi sotto)
  PestHelpers.php # Helper globali (autoload-dev.files, senza namespace)
  TestCase.php # Base test case for the module
```

## Binding del TestCase

Ogni file di test che usa l'applicazione o i metodi di `Modules\Cms\Tests\TestCase` lo lega da solo:

```php
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
```

Mai `uses(...)->in(...)` in `tests/Pest.php`: il runner di root non lo esegue (i test restano senza
applicazione) e con `--test-directory` raddoppia il binding (`TestCaseAlreadyInUse`). Decisione e guardia:
[ADR pest-testcase-binding-per-file](../../Xot/docs/adr/pest-testcase-binding-per-file.md).

## PestHelpers (PHPStan + merge)

- Funzioni in `tests/PestHelpers.php` sono **globali** (`cmsActingAsGet`, `cmsGet`, …).
  Non usare `use function Modules\Cms\Tests\...`: quel namespace non esiste sul file.
- Ogni helper e' dietro `function_exists(...)`: evita `Cannot redeclare` se un merge
  o un doppio autoload ripete la definizione.
- Homepage blocchi: fonte di verità `TestCase::homepageJsonForBlocksArchitecture()`
  (PSR-4, non si perde nei merge). Wrapper globale opzionale:
  `loadHomepageJsonForBlocksArchitectureTest()`. Story [ROOT-17.10](../../../../docs/stories/17-10-helper-e-blocchi-persi-nella-bonifica.md).
- Prima di rimuovere un helper: `grep -rn '\bnomeHelper(' Modules --include='*.php'`.

## Writing Tests

### Authentication Tests

Authentication tests are located in `tests/Feature/Auth/`. These tests cover:

- User registration
- Login/logout
- Password reset
- Email verification
- Profile management

### Example Authentication Test

```php
test('users can login with valid credentials', function () {
    $user = User::factory()->create();
    
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});
```

## Running Tests

Run all Cms module tests:
```bash
./vendor/bin/pest Modules/Cms/tests
```

Run a specific test file:
```bash
./vendor/bin/pest Modules/Cms/tests/Feature/Auth/AuthenticationTest.php
```

## Best Practices

1. **Use Factories**: Always use factories to create test data
2. **Test Edge Cases**: Include tests for validation errors and edge cases
3. **Keep Tests Focused**: Each test should verify one specific behavior
4. **Use Descriptive Names**: Test names should clearly indicate what's being tested
