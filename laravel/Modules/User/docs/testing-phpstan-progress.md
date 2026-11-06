---
title: "User Module - PHPStan Testing Progress"
type: concept
tags: [testing, phpstan, progress]
created: 2026-07-14
updated: 2026-10-20
qmd: "testing-phpstan-progress user module - phpstan testing progress"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./stories/phpstan-user-zero.story.md"
  - "./stories/phpstan-test-wave-user-b.story.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# User Module - PHPStan Testing Progress

**Stato modulo (2026-10-20):** `./vendor/bin/phpstan analyse Modules/User` → **0 errori** (test: assertion su payload eventi/regole, return type su `Login`/`ResetPasswordWidget`/`FakeAgent`, `Safe\parse_url` nel flusso OAuth).

**Date**: 2025-12-15
**Objective**: Fix PHPStan errors in test files
**Priority**: Tier 1 Critical (Authentication & Authorization)

---

## Philosophy Reminder

> **"The site works. If a test references missing elements, FIX THE TEST, not create the elements."**

This is the core principle: tests must reflect ACTUAL production code, not imaginary constructs.

---

## Work in Progress

### Current Status

> **Aggiornamento 2026-10-20**: la causa e' stata corretta alla sorgente e il workaround qui sotto non va piu' usato.
> `User::factory()->create()` era `mixed` perche' Larastan risolve `Model::factory()` con `Factory::resolveFactoryName()`,
> che per i modelli `Modules\*\Models\X` puntava a `Database\Factories\XFactory` (inesistente) e restituiva `ErrorType`.
> `XotServiceProvider::registerFactoryNameResolver()` registra ora `Factory::guessFactoryNamesUsing()` con la convenzione
> di `GetFactoryAction::getFactoryClass()`: `User::factory()->create()` e' `User`, senza `assert()` ne' `ModelFactory::new()`.
> Dettagli: [stories/phpstan-test-wave-user-b.story.md](./stories/phpstan-test-wave-user-b.story.md).
>
> **Chiusura 2026-10-20**: `phpstan analyse Modules/User` → **0 errori** (56 residuali nei soli Unit tests inventariati).
> Null-safety `TeamContract`, SoftDeletes allineato a trait commentato, Permission via getter pubblici.
> Story: [stories/phpstan-user-zero.story.md](./stories/phpstan-user-zero.story.md).

Storico (2025-12-15, superato):
- Working on adding `\assert()` type narrowing to factory calls
- Main issue: `User::factory()->create()` returns `mixed` for PHPStan
- Solution: Add `\assert($var instanceof User);` after each factory call

### Pattern Identified (storico, non replicare)
```php
// BEFORE (PHPStan errors)
$user = User::factory()->create([...]);
expect($user->email)->toBe('test@example.com'); // Error: Cannot access property $email on mixed

// AFTER (PHPStan compliant)
$user = User::factory()->create([...]);
\assert($user instanceof User);
expect($user->email)->toBe('test@example.com'); // OK
// AFTER (workaround storico: oggi vietato, `assert()` non puo' correggere il tipo inferito)
$user = User::factory()->create([...]);
\assert($user instanceof User);
expect($user->email)->toBe('test@example.com');
```

### Files Being Fixed
- `Feature/Authentication/UserAuthenticationTest.php` - IN PROGRESS

---

## Next Steps

1. Complete UserAuthenticationTest.php assertions
2. Apply same pattern to all User test files
3. Run PHPStan on all Modules to identify test errors
4. **Remember**: If test references non-existent class/method → FIX TEST (don't create fake classes)

---

## Rules to Remember

### 1. NO RefreshDatabase
- ✅ Tests use `.env.testing` with SQLite in-memory
- ✅ Use `DatabaseTransactions` if needed
- ✅ Never `RefreshDatabase` (too slow)

### 2. Always Pest, Never PHPUnit
- ✅ Use `it()` and `test()` functions
- ✅ Use `expect()` assertions
- ❌ No PHPUnit class-based tests

### 3. Tests Reflect Reality
- ✅ Test ACTUAL code behavior
- ❌ Don't create missing classes to make tests pass
- ❌ Don't test imaginary functionality

### 4. PHPStan Configuration
- ✅ Use `phpstan.neon` AS-IS (never modify)
- ✅ Level is configured in phpstan.neon
- ✅ Run: `./vendor/bin/phpstan analyse Modules` (no level parameter)

---

🤖 Generated with [Claude Code](https://claude.com/claude-code)

## business logic unit tests (2026-10)

I test `UserBusinessLogicTest` e `AuthenticationBusinessLogicTest` usano solo `PHPUnit\Framework\Assert` (niente higher-order Pest) per compatibilità con `pest-plugin-phpstan`. Le asserzioni restano orientate al contratto di dominio utente/autenticazione.
