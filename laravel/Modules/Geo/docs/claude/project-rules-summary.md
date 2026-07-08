# Project Rules Summary - Quick Reference

**Purpose**: Critical rules that must ALWAYS be followed  
**Status**: MANDATORY - Non-negotiable

---

## 🔴 The 7 Cardinal Rules

### 1. Forward-Only (Git & Migrations)

```
Philosophy: Like time, code only moves forward

Git: NEVER checkout/reset to old commits
Migrations: NEVER implement down() method
Fixes: ALWAYS new commit/migration, never rollback
```

**Why**: Data integrity, team collaboration, audit trail

---

### 2. Extend Xot Base Classes

```php
// ❌ NEVER
class MyPage extends Filament\Pages\Page
class MyResource extends Filament\Resources\Resource

// ✅ ALWAYS
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
```

**Why**: Centralized logic, consistency, Laraxot framework

---

### 3. No Hardcoded Strings

```php
// ❌ NEVER
TextInput::make('name')->label('Nome')
->placeholder('Inserisci nome')

// ✅ ALWAYS
TextInput::make('name')  // Auto-translated
```

**Why**: Localization, maintainability, DRY

---

### 4. Use Actions, Not Services

```php
// ❌ NEVER
class UserService { public function create() {} }

// ✅ ALWAYS
class CreateUserAction { 
    use QueueableAction;
    public function execute() {}
}
```

**Why**: Queueable, testable, Laraxot pattern

---

### 5. Scripts in bashscripts/ Only

```bash
# ❌ NEVER
laravel/analyze.sh
docs/scripts/fix.py
Modules/Rating/script.sh

# ✅ ALWAYS
bashscripts/analysis/analyze.sh
bashscripts/fix/fix.py
bashscripts/quality-assurance/check.sh
```

**Why**: Organization, separation, convention

---

### 6. Documentation Naming

```
# ❌ NEVER
Analysis.md  # Date in name
CODE_QUALITY.md         # Uppercase
MyDocument.md           # PascalCase

# ✅ ALWAYS
code-analysis.md        # kebab-case
best-practices.md       # no dates
troubleshooting.md      # lowercase

# EXCEPTIONS
README.md               # OK
CHANGELOG.md            # OK
```

**Why**: Consistency, searchability, convention

---

### 7. Focus on Business Logic

```markdown
# ❌ WRONG Documentation
## What the code does
Line 50 creates object
Line 51 calls method

# ✅ CORRECT Documentation
## Business Purpose
This calculates indennità because PA regulations require...
Formula used: X × Y because business rule Z
```

**Why**: Understanding, maintainability, onboarding

---

## 🎯 The Philosophy

### Logica

- Code solves business problems
- Understand the problem first
- Solution follows from understanding

### Filosofia

- Forward-only (time, git, migrations)
- DRY (one source of truth)
- KISS (simple is better)
- SOLID (well-designed)

### Politica

- No rollbacks (forward-only)
- No hardcoded strings (localization)
- Scripts in bashscripts/ (organization)
- Extend Xot bases (framework)

### Religione

- XotBase is sacred (always extend)
- down() is forbidden (no rollback)
- Business logic is holy (document WHY)
- Tests are prayers (must have)

### Zen

```
The path is forward, never back
Simple is profound
One truth, many expressions
Document the why, code shows the how
```

---

## 📚 Related Documentation

- [Git Forward-Only](../../.cursor/rules/git-forward-only.mdc)
- [Scripts Location](../../.cursor/rules/scripts-location-mandatory.mdc)
- [Documentation Naming](../../.cursor/rules/documentation-naming.mdc)
- [Documentation Philosophy](./documentation-philosophy.md)
- [Architecture Rules](./architecture-rules.md)

---

**Remember**: These are not suggestions, they are THE WAY. 🚀


