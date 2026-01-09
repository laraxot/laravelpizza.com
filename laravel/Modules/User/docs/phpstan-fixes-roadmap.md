# PHPStan Level 10 Compliance - Resolution Roadmap

**Data**: 2026-01-09
**Agente AI**: Claude Code (Sonnet 4.5)
**Status**: 🔴 **35 ERRORS FOUND** (Regression since December 2025)
**Priority**: **HIGH - Code Quality Degradation**

---

## 🚨 CRITICAL SITUATION

### Previous Status (December 2025)
According to `phpstan-compliance-status.md`:
- **Status**: ✅ FULLY COMPLIANT (0 errors)
- **Date**: 2025-12-10

### Current Status (January 2026)
**NEW PHPStan Analysis**:
- **Errors Found**: 35
- **Regression**: Code quality has degraded since December
- **Root Cause**: New code added OR existing code modified

**Conclusion**: Someone introduced errors after December 2025 compliance.

---

## 📊 ERROR CATEGORIZATION

### Error Types Breakdown

| Error Type | Count | Severity | Fix Priority |
|-----------|-------|----------|--------------|
| `class.notFound` | 11 | 🔴 CRITICAL | P0 - Immediate |
| `varTag.variableNotFound` | 14 | 🟡 MEDIUM | P1 - High |
| `return.type` | 10 | 🟠 HIGH | P0 - Immediate |
| **TOTAL** | **35** | | |

---

## 🔍 DETAILED ERROR ANALYSIS

### Category 1: `class.notFound` (11 errors) - CRITICAL

**Problem**: PHPStan cannot find class `Modules\User\Filament\Widgets\Auth\Model`

**Affected Files**:
1. `app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php` (4 errors)
   - Line 119: Call to `setAttribute()` on unknown class
   - Line 119: PHPDoc @var contains unknown class
   - Line 120: Call to `setRememberToken()` on unknown class
   - Line 121: Call to `save()` on unknown class

2. `app/Filament/Widgets/Auth/ResetPasswordWidget.php` (3 errors)
   - Line 91: Call to `forceFill()` on unknown class
   - Line 91: Call to `save()` on unknown class
   - Line 91: PHPDoc @var contains unknown class

**Root Cause**:
- Someone wrote `@var Model` instead of `@var User` or full class name
- `Model` is ambiguous - could be `Illuminate\Database\Eloquent\Model` or other

**Resolution Strategy**:
1. Find all occurrences of `@var Model` in Widgets
2. Replace with proper class name (likely `@var \Modules\User\Models\User`)
3. Verify class exists and is imported

**Estimated Effort**: 15 minutes

---

### Category 2: `varTag.variableNotFound` (14 errors) - MEDIUM

**Problem**: PHPDoc `@var` tag references non-existent variables

**Pattern Example**:
```php
/**
 * @var mixed $result  // ← Variable $result doesn't exist!
 */
$response = someFunction();
```

**Affected Files**:
1. `app/Actions/Socialite/CreateUserAction.php` (Line 67)
   - Variable `$refreshedUser` in PHPDoc doesn't exist

2. `app/Filament/Pages/Tenancy/RegisterTenant.php` (Line 59)
   - Variable `$schema` in PHPDoc doesn't exist

3. `app/Filament/Resources/PermissionResource/Pages/ListPermissions.php` (Line 113)
   - Variable `$options` in PHPDoc doesn't exist

4. `app/Filament/Widgets/EditUserWidget.php` (Lines 129, 169, 176)
   - Variables `$result`, `$user` in PHPDoc don't exist

5. `app/Filament/Widgets/PasswordExpiredWidget.php` (Line 69)
   - Variable `$result` in PHPDoc doesn't exist

6. `app/Filament/Widgets/RegistrationWidget.php` (Lines 77, 94)
   - Variable `$model` in PHPDoc doesn't exist

7. `app/Http/Livewire/Auth/Passwords/Confirm.php` (Line 41)
   - Variable `$result` in PHPDoc doesn't exist

**Root Cause**:
- Copy-paste PHPDoc from another function
- Variable was renamed but PHPDoc wasn't updated
- PHPDoc added before code, never corrected

**Resolution Strategy**:
1. Find each occurrence
2. Check actual variable name in code
3. Either:
   - Fix variable name in PHPDoc, OR
   - Remove PHPDoc if not needed (Laravel convention: type hint is enough)

**Estimated Effort**: 30 minutes

---

### Category 3: `return.type` (10 errors) - HIGH

**Problem**: Method signature says return `X`, but code returns `mixed` or incompatible type

**Affected Files**:

#### 3.1. Method Returns `mixed` Instead of Specific Type

**Example**: `getFormSchema()` should return `array<Component>` but returns `mixed`

1. `app/Filament/Pages/Tenancy/RegisterTenant.php` (Line 59)
   - Method signature: `array<Filament\Schemas\Components\Component>`
   - Actual return: `mixed`

2. `app/Filament/Widgets/EditUserWidget.php` (Line 129)
   - Method signature: `array<int|string, Component>`
   - Actual return: `array` (generic, not typed)

**Root Cause**:
- Dynamic array construction without type hints
- Using `array_merge()`, `array_map()` without preserving types
- Returning result of Action that returns `mixed`

**Resolution**:
```php
// BEFORE (returns mixed)
public function getFormSchema(): array
{
    $schema = SomeAction::execute();  // Returns mixed
    return $schema;
}

// AFTER (returns proper type)
public function getFormSchema(): array
{
    $schema = SomeAction::execute();
    /** @var array<string, Component> $schema */
    return $schema;  // Type narrowing via PHPDoc
}
```

#### 3.2. Method Returns Incompatible Type

1. `app/Filament/Widgets/EditUserWidget.php` (Lines 169, 195)
   - Signature: `Illuminate\Database\Eloquent\Model`
   - Returns: `mixed`

2. `app/Filament/Widgets/RegistrationWidget.php` (Lines 77, 94)
   - Signature: `Illuminate\Database\Eloquent\Model`
   - Returns: `mixed`

3. `app/Http/Livewire/Auth/Passwords/Confirm.php` (Line 41)
   - Signature: `Factory|View`
   - Returns: `mixed`

**Resolution Strategy**:
1. Check what the code ACTUALLY returns
2. Add type assertions: `assert($model instanceof Model)`
3. Or add PHPDoc type narrowing
4. Or change return type if signature is wrong

**Estimated Effort**: 45 minutes

---

## 🎯 RESOLUTION PLAN (Step-by-Step)

### Phase 1: Fix CRITICAL Errors (P0) - 30 minutes

**Target**: `class.notFound` (11 errors) + `return.type` critical (5 errors)

#### Step 1.1: Fix Unknown Class `Model` References (15 min)
1. Read `PasswordResetConfirmWidget.php` lines 115-125
2. Find `@var Model $user`
3. Replace with `@var \Modules\User\Models\User $user`
4. Add import: `use Modules\User\Models\User;`
5. Repeat for `ResetPasswordWidget.php`
6. Run PHPStan on these files only to verify

#### Step 1.2: Fix Critical Return Type Mismatches (15 min)
1. `RegisterTenant.php` - Line 59
   - Add type assertion for `$schema`
2. `EditUserWidget.php` - Lines 169, 195
   - Add `assert($user instanceof Model)`
3. Run PHPStan to verify

### Phase 2: Fix MEDIUM Errors (P1) - 30 minutes

**Target**: `varTag.variableNotFound` (14 errors)

#### Step 2.1: Remove/Fix Wrong PHPDoc Variables
For each file:
1. Read the specific line
2. Check actual variable name
3. Either fix PHPDoc OR remove it (if type hint exists)

**Files to fix** (in order):
1. `CreateUserAction.php:67`
2. `RegisterTenant.php:59`
3. `ListPermissions.php:113`
4. `EditUserWidget.php:129,169,176`
5. `PasswordExpiredWidget.php:69`
6. `RegistrationWidget.php:77,94`
7. `Confirm.php:41`

### Phase 3: Fix Remaining Return Types - 15 minutes

**Target**: Remaining `return.type` errors

1. `Verify.php` errors
2. `Reset.php` errors
3. Final PHPStan run to verify all fixed

### Phase 4: Verification & Documentation - 15 minutes

1. Run full PHPStan analysis on User module
2. Verify 0 errors
3. Update `phpstan-compliance-status.md` with new date
4. Document all fixes in this file
5. Commit with message: "fix(User): Restore PHPStan Level 10 compliance - 35 errors fixed"

---

## 📋 EXECUTION CHECKLIST

### Before Starting
- [x] PHPStan analysis run (35 errors confirmed)
- [x] Errors categorized by type
- [x] Priority assigned
- [ ] Reviewed existing docs (no duplicate roadmap)
- [ ] Ready to proceed with fixes

### Phase 1 - Critical Fixes
- [ ] Fix `class.notFound` in PasswordResetConfirmWidget.php
- [ ] Fix `class.notFound` in ResetPasswordWidget.php
- [ ] Fix return types in RegisterTenant.php
- [ ] Fix return types in EditUserWidget.php
- [ ] Run PHPStan on fixed files
- [ ] All P0 errors resolved?

### Phase 2 - Medium Fixes
- [ ] Fix varTag in CreateUserAction.php
- [ ] Fix varTag in RegisterTenant.php
- [ ] Fix varTag in ListPermissions.php
- [ ] Fix varTag in EditUserWidget.php
- [ ] Fix varTag in PasswordExpiredWidget.php
- [ ] Fix varTag in RegistrationWidget.php
- [ ] Fix varTag in Confirm.php
- [ ] Run PHPStan on fixed files
- [ ] All P1 errors resolved?

### Phase 3 - Remaining Fixes
- [ ] Fix remaining return types
- [ ] Run full PHPStan analysis
- [ ] 0 errors confirmed?

### Phase 4 - Documentation & Commit
- [ ] Update phpstan-compliance-status.md
- [ ] Document fixes in this file
- [ ] Run phpmd on changed files
- [ ] Run phpinsights on changed files
- [ ] Git commit with detailed message

---

## 🔗 REFERENCES

- [PHPStan Documentation](https://phpstan.org/user-guide/discovering-symbols)
- [Previous Fix: phpstan-fixes-gennaio.md](./phpstan-fixes-gennaio.md)
- [Previous Status: phpstan-compliance-status.md](./phpstan-compliance-status.md)
- [PHPStan Configuration](../../phpstan.neon)

---

## 📝 NOTES & LESSONS LEARNED

### Why Did Errors Reappear?

**Hypothesis 1**: New widgets added without proper type hints
- `PasswordResetConfirmWidget.php` uses `@var Model` (wrong)
- Someone unfamiliar with PHPStan best practices

**Hypothesis 2**: Copy-paste programming
- Many errors are identical patterns
- `@var $result` copied between files
- No validation before committing

**Hypothesis 3**: No CI/CD PHPStan Check
- If PHPStan ran on CI, these wouldn't be committed
- Need to add PHPStan to GitHub Actions

### Prevention Strategies

1. **Add PHPStan to CI/CD**:
   ```yaml
   # .github/workflows/phpstan.yml
   - name: Run PHPStan
     run: ./vendor/bin/phpstan analyse Modules
   ```

2. **Add Pre-commit Hook**:
   ```bash
   # .git/hooks/pre-commit
   ./vendor/bin/phpstan analyse --error-format=table
   ```

3. **Educate Developers**:
   - Document PHPStan best practices
   - Review PRs for type safety
   - Use `@var` only when necessary

---

**Next Step**: Begin Phase 1 - Fix Critical Errors (class.notFound)
**Time Estimate**: 90 minutes total
**Expected Result**: 0 PHPStan errors, Level 10 compliant
