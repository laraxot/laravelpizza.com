# User Module - PHPStan Testing Progress

**Date**: [DATE]
**Objective**: Fix PHPStan errors in test files
**Priority**: Tier 1 Critical (Authentication & Authorization)

---

## Philosophy Reminder

> **"The site works. If a test references missing elements, FIX THE TEST, not create the elements."**

This is the core principle: tests must reflect ACTUAL production code, not imaginary constructs.

---

## Work in Progress

### Current Status
- Working on adding `\assert()` type narrowing to factory calls
- Main issue: `User::factory()->create()` returns `mixed` for PHPStan
- Solution: Add `\assert($var instanceof User);` after each factory call

### Pattern Identified
```php
// BEFORE (PHPStan errors)
$user = User::factory()->create([...]);
expect($user->email)->toBe('test@example.com'); // Error: Cannot access property $email on mixed

// AFTER (PHPStan compliant)
$user = User::factory()->create([...]);
\assert($user instanceof User);
expect($user->email)->toBe('test@example.com'); // OK
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
