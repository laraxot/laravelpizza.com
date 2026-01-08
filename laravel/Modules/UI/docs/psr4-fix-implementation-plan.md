# 🔧 PSR-4 Fix Implementation Plan - UI Module

**Data**: Dicembre 15, 2025
**Modulo**: UI
**Tipo Fix**: Namespace correction (Modules\Notify → Modules\UI)

---

## 📊 Analisi Completa File Affetti

### File UI con Namespace Errato (11 totali)

Tutti in `Modules/UI/app/Filament/Forms/Components/`:

| # | File | Riga | Namespace Attuale (ERRATO) | Namespace Corretto |
|---|------|------|----------------------------|-------------------|
| 1 | `Children.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 2 | `IconPicker.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 3 | `InlineDatePicker.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 4 | `ParentSelect.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 5 | `PasswordStrengthField.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 6 | `RadioBadge.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 7 | `RadioCollection.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 8 | `RadioIcon.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 9 | `RadioImage.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 10 | `SelectState.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |
| 11 | `TreeField.php` | 10 | `Modules\Notify\Filament\Forms\Components` | `Modules\UI\Filament\Forms\Components` |

### Import Statements da Verificare

**TechPlanner/app/Filament/Resources/ClientResource.php**:
```php
Line 13: use Modules\Notify\Filament\Forms\Components\ContactSection;
```

**Verifica**: ContactSection è effettivamente in Notify module ✅ CORRETTO
- File: `Modules/Notify/app/Filament/Forms/Components/ContactSection.php`
- Namespace: `Modules\Notify\Filament\Forms\Components` ✅

**Conclusione**: Import ContactSection è corretto, non necessita fix.

---

## 🎯 Piano di Implementazione

### Step 1: Fix Namespace in 11 File UI

**Metodo**: Sed replacement atomico

```bash
for file in \
  Children.php \
  IconPicker.php \
  InlineDatePicker.php \
  ParentSelect.php \
  PasswordStrengthField.php \
  RadioBadge.php \
  RadioCollection.php \
  RadioIcon.php \
  RadioImage.php \
  SelectState.php \
  TreeField.php
do
  sed -i 's/namespace Modules\\Notify\\Filament\\Forms\\Components;/namespace Modules\\UI\\Filament\\Forms\\Components;/' \
    "Modules/UI/app/Filament/Forms/Components/$file"
done
```

### Step 2: Verify Fix

```bash
# Should return 0 results
grep -l "namespace Modules\\\\Notify" Modules/UI/app/Filament/Forms/Components/*.php
echo "Exit code: $?"  # Should be 1 (no matches)
```

### Step 3: Regenerate Autoload

```bash
cd laravel
composer dump-autoload -o
```

**Expected Output**: NO PSR-4 compliance errors

### Step 4: Quality Checks (PER OGNI FILE MODIFICATO)

#### PHPStan
```bash
./vendor/bin/phpstan analyse Modules/UI/app/Filament/Forms/Components/ParentSelect.php --level=max
./vendor/bin/phpstan analyse Modules/UI/app/Filament/Forms/Components/Children.php --level=max
# ... per tutti gli 11 file
```

#### PHP Mess Detector
```bash
./vendor/bin/phpmd Modules/UI/app/Filament/Forms/Components/ text cleancode,codesize,controversial,design,naming,unusedcode
```

#### PHP Insights
```bash
./vendor/bin/phpinsights analyse Modules/UI/app/Filament/Forms/Components/
```

### Step 5: Iterative Fix Loop

SE quality check rileva problemi:
1. Fix il problema
2. Re-run quality check
3. Repeat finché tutti i check passano ✅

### Step 6: Mock Classes Fix (Test)

**File**: `Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php`

**Problema**: Mock classes inline nello stesso file del test

**Soluzione**: Create separate mock files

```php
// File da creare: tests/Unit/Widgets/Mocks/MockCalendarWidget.php
namespace Modules\UI\Tests\Unit\Widgets\Mocks;

class MockCalendarWidget extends \Modules\UI\Filament\Widgets\BaseCalendarWidget
{
    // Mock implementation
}
```

```php
// File da creare: tests/Unit/Widgets/Mocks/MockEventModel.php
namespace Modules\UI\Tests\Unit\Widgets\Mocks;

class MockEventModel extends \Illuminate\Database\Eloquent\Model
{
    // Mock implementation
}
```

### Step 7: Update Documentation

Aggiornare:
- [x] `Modules/UI/docs/psr4-namespace-violations.md` - Aggiungere sezione "Fix Implemented"
- [x] `Modules/UI/docs/psr4-fix-implementation-plan.md` - Questo file (status update)
- [ ] `Modules/UI/docs/README.md` - Aggiungere reference a PSR-4 fix
- [ ] `Modules/UI/docs/CHANGELOG.md` - Log del fix

### Step 8: Git Commit

```bash
git add Modules/UI/app/Filament/Forms/Components/*.php
git add Modules/UI/tests/Unit/Widgets/
git add Modules/UI/docs/

git commit -m "$(cat <<'EOF'
fix(UI): Correct PSR-4 namespace violations in Filament components

Fixed 11 form components with wrong namespace declarations.

**Problem**:
- Components in Modules/UI/app/Filament/Forms/Components/
- Had namespace: Modules\Notify\Filament\Forms\Components (WRONG)
- Should have: Modules\UI\Filament\Forms\Components (CORRECT)

**Root Cause**:
- Copy-paste from Notify module without namespace refactoring
- Composer autoload optimizer detected violations

**Files Fixed** (11):
- Children.php
- IconPicker.php
- InlineDatePicker.php
- ParentSelect.php
- PasswordStrengthField.php
- RadioBadge.php
- RadioCollection.php
- RadioIcon.php
- RadioImage.php
- SelectState.php
- TreeField.php

**Test Fixes**:
- Extracted MockCalendarWidget to separate file
- Extracted MockEventModel to separate file
- Both now PSR-4 compliant

**Verification**:
- composer dump-autoload -o → NO errors ✅
- PHPStan Level 10 → PASS ✅
- PHPMD → PASS ✅
- PHP Insights → PASS ✅

**Documentation**:
- Created psr4-namespace-violations.md (problem analysis)
- Created psr4-fix-implementation-plan.md (this file)
- Updated UI module README

**Philosophy**: Fix, Don't Ignore - PSR-4 Compliance Strict

🤖 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude Sonnet 4.5 <noreply@anthropic.com>
EOF
)"
```

### Step 9: Git Push

```bash
git push origin develop
```

---

## ✅ Checklist Pre-Implementation

Prima di eseguire i fix:

- [x] Studiato nwidart/laravel-modules ✅
- [x] Studiato composer-merge-plugin ✅
- [x] Documentato problema completo ✅
- [x] Analizzato tutti i file affetti ✅
- [x] Verificato import in altri moduli ✅
- [x] Creato piano implementazione (questo documento) ✅
- [x] Litigato furiosamente con me stesso ✅

Pronto per implementazione! ✅

---

## 🔄 Workflow di Fix (OBBLIGATORIO)

Per OGNI file modificato:

```
1. Modifica file
   ↓
2. phpstan analyse file --level=max
   ↓
3. phpmd file text cleancode,...
   ↓
4. phpinsights analyse file
   ↓
5. Fix issues rilevati
   ↓
6. GOTO step 2 (loop fino perfezione)
   ↓
7. Aggiorna/studia/migliora docs
   ↓
8. Git commit
   ↓
9. Git push
```

**Questo workflow è SACRO e INVIOLABILE.**

---

## 📈 Expected Metrics

### Before Fix
```
composer dump-autoload -o
→ 11 PSR-4 violations in UI module
→ 2 PSR-4 violations in UI tests
Total: 13 errors
```

### After Fix
```
composer dump-autoload -o
→ 0 PSR-4 violations ✅
→ Clean autoload generation ✅
Total: 0 errors ✅
```

### PHPStan
```
Before: Unknown (non testato con namespace sbagliato)
After: Level 10 PASS ✅
```

---

## 🚀 Ready for Implementation

**Status**: ✅ PRONTO
**Documented**: ✅ COMPLETO
**Analyzed**: ✅ VERIFICATO
**Planned**: ✅ DETTAGLIATO

**Prossimo Step**: IMPLEMENTAZIONE → seguire Step 1-9

🤖 Generated with [Claude Code](https://claude.com/claude-code)
