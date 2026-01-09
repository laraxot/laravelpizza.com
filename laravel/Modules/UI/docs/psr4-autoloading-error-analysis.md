# PSR-4 Autoloading Error Analysis and Resolution Plan

**Date**: 2025-12-15
**Status**: Analysis Complete, Implementation Pending
**Related Errors**: `composer dumpautoload -o` PSR-4 compliance warnings

## 🚨 Error Analysis

### Error Messages Summary
```
Class Modules\UI\Tests\Unit\Widgets\MockCalendarWidget located in ./Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php does not comply with psr-4 autoloading standard (rule: Modules\UI\Tests\ => ./Modules/UI/tests). Skipping.
Class Modules\UI\Tests\Unit\Widgets\MockEventModel located in ./Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php does not comply with psr-4 autoloading standard (rule: Modules\UI\Tests\ => ./Modules/UI/tests). Skipping.
Class Modules\Notify\Filament\Forms\Components\ParentSelect located in ./Modules/UI/app/Filament/Forms/Components/ParentSelect.php does not comply with psr-4 autoloading standard (rule: Modules\UI\ => ./Modules/UI/app). Skipping.
[10 more similar errors...]
```

### Root Cause Analysis

#### 1. **Test File Contains Multiple Classes (Violates PSR-4)**
- **File**: `Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php`
- **Issue**: Contains two classes (`MockCalendarWidget`, `MockEventModel`) in a test file
- **PSR-4 Rule**: Each class must be in its own file with matching filename
- **Current**: `BaseCalendarWidgetTest.php` contains `MockCalendarWidget` and `MockEventModel`
- **Violation**: Filename doesn't match class names

#### 2. **Wrong Namespace in UI Module Files**
- **Files**: Multiple files in `Modules/UI/app/Filament/Forms/Components/`
- **Issue**: Classes declare `Modules\Notify\Filament\Forms\Components\` namespace
- **Actual Location**: Files are in `Modules/UI/app/Filament/Forms/Components/`
- **PSR-4 Rule**: Namespace must match directory structure
- **Violation**: `Notify` namespace in `UI` module directory

#### 3. **Composer Merge Plugin Context**
- **Plugin**: `wikimedia/composer-merge-plugin`
- **Function**: Merges module `composer.json` files into root
- **Current Configuration**:
  - UI module: `"Modules\\UI\\": "app/"`
  - Notify module: `"Modules\\Notify\\": "app/"`
- **Issue**: UI module files declaring Notify namespace confuse autoloader

## 📚 Project Philosophy Context

### Xot Philosophy Principles Violated

#### 1. **Religious Principle #8: PSR-4: Solo `app/` Directory**
> "Tutto il codice PHP deve stare in `app/`. Mai in `tests/`, `database/`, `docs/`."

**Violation**: Test classes in test files are being autoloaded as production classes.

#### 2. **Political Principle #2: Consistency Over Flexibility**
> "Consistency è più importante di flexibility."

**Violation**: Inconsistent namespace declarations across modules.

#### 3. **Zen Principle #1: Semplicità nell'Infrastruttura**
> "L'infrastruttura deve essere semplice e trasparente."

**Violation**: Complex autoloading issues from namespace mismatches.

## 🛠️ Proposed Solution

### Phase 1: Fix Test File Structure

#### Option A: Separate Mock Classes into Individual Files
```
Modules/UI/tests/Unit/Widgets/MockCalendarWidget.php
Modules/UI/tests/Unit/Widgets/MockEventModel.php
Modules/UI/tests/Unit/Widgets/BaseCalendarWidgetTest.php (test only)
```

#### Option B: Use Anonymous Classes in Tests
```php
// In BaseCalendarWidgetTest.php
$mockWidget = new class extends BaseCalendarWidget {
    // anonymous class implementation
};
```

**Recommendation**: Option A for clarity and maintainability.

### Phase 2: Fix Namespace Declarations

#### Files to Correct:
1. `ParentSelect.php` - Change namespace from `Modules\Notify\Filament\Forms\Components` to `Modules\UI\Filament\Forms\Components`
2. `TreeField.php` - Same correction
3. `Children.php` - Same correction
4. `PasswordStrengthField.php` - Same correction
5. `RadioIcon.php` - Same correction
6. `RadioCollection.php` - Same correction
7. `RadioBadge.php` - Same correction
8. `InlineDatePicker.php` - Same correction
9. `RadioImage.php` - Same correction
10. `IconPicker.php` - Same correction
11. `SelectState.php` - Same correction

### Phase 3: Update Module Dependencies

#### Notify Module `composer.json`:
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../UI"
        }
    ]
}
```

**Issue**: Notify module references UI module as path repository, but UI module files declare Notify namespace.

**Solution**: Either:
1. Move files to Notify module (correct location)
2. Change namespace to UI (current location)
3. Update autoloading configuration

## 🔍 Technical Analysis

### PSR-4 Autoloading Rules
1. **One class per file** (except for traits, interfaces in same file)
2. **Filename must match class name** (`MyClass` → `MyClass.php`)
3. **Namespace must match directory structure** (`Modules\UI\Filament\Forms\Components` → `Modules/UI/app/Filament/Forms/Components/`)
4. **Case-sensitive** on case-sensitive filesystems

### Composer Merge Plugin Behavior
- Merges `autoload` sections from module `composer.json` files
- Creates combined PSR-4 mapping
- Errors when mappings conflict or don't match actual files

### Laravel Modules Integration
- Modules have own `composer.json` with PSR-4 mappings
- Root `composer.json` uses merge plugin to include them
- Autoloader expects consistency across all merged configurations

## 📋 Implementation Plan

### Step 1: Create Mock Class Files
```
mkdir -p Modules/UI/tests/Unit/Widgets/Mocks/
mv MockCalendarWidget class to Modules/UI/tests/Unit/Widgets/Mocks/MockCalendarWidget.php
mv MockEventModel class to Modules/UI/tests/Unit/Widgets/Mocks/MockEventModel.php
Update BaseCalendarWidgetTest.php to import mock classes
```

### Step 2: Fix Namespace Declarations
For each file in `Modules/UI/app/Filament/Forms/Components/`:
```bash
sed -i 's/namespace Modules\\\\Notify\\\\Filament\\\\Forms\\\\Components;/namespace Modules\\\\UI\\\\Filament\\\\Forms\\\\Components;/g' *.php
```

### Step 3: Update Autoload Configuration
Check if UI module `composer.json` needs:
```json
"autoload": {
    "psr-4": {
        "Modules\\UI\\": "app/",
        "Modules\\UI\\Tests\\": "tests/"
    }
}
```

### Step 4: Verify Dependencies
- Ensure Notify module can access UI components via proper imports
- Check if any Notify module code references these UI components
- Update imports in Notify module if needed

## 🧪 Testing Strategy

### Pre-Implementation Tests
1. `composer dumpautoload -o` - Verify current errors
2. `php -l` on all affected files - Syntax check
3. Run UI module tests - Ensure functionality preserved

### Post-Implementation Tests
1. `composer dumpautoload -o` - Should have zero PSR-4 errors
2. `./vendor/bin/phpstan analyse Modules/UI` - PHPStan compliance
3. `./vendor/bin/pest Modules/UI` - All tests pass
4. Manual testing of affected components

## ⚠️ Risks and Mitigations

### Risk 1: Breaking Notify Module
**Mitigation**:
- Check all Notify module imports of these components
- Update imports to use correct namespace
- Test Notify module functionality

### Risk 2: PHPStan Errors
**Mitigation**:
- Run PHPStan after each change
- Fix any new type errors
- Maintain level 10 compliance

### Risk 3: Test Failures
**Mitigation**:
- Run tests after mock class separation
- Update test imports
- Ensure anonymous classes work correctly

## 📚 References

1. **PSR-4 Specification**: https://www.php-fig.org/psr/psr-4/
2. **Composer Autoloading**: https://getcomposer.org/doc/04-schema.md#autoload
3. **Wikimedia Composer Merge Plugin**: https://github.com/wikimedia/composer-merge-plugin
4. **nWidart Laravel Modules**: https://nwidart.com/laravel-modules/
5. **Xot Philosophy**: `../Xot/docs/philosophy-complete.md`

## 🎯 Success Criteria

1. ✅ `composer dumpautoload -o` produces zero PSR-4 errors
2. ✅ All PHP files have correct namespace declarations
3. ✅ All tests pass (UI and Notify modules)
4. ✅ PHPStan level 10 compliance maintained
5. ✅ No functionality regression

## 🔄 Alternative Approaches Considered

### Approach A: Move Files to Notify Module
**Pros**: Correct namespace/location alignment
**Cons**: Breaks UI module structure, requires major refactoring

### Approach B: Update Autoloader Configuration
**Pros**: Minimal code changes
**Cons**: Complex configuration, violates PSR-4 standards

### Approach C: Current Plan (Fix Namespaces)
**Pros**: Maintains current structure, fixes standards compliance
**Cons**: Requires updating all references to these components

**Decision**: Approach C aligns with project philosophy of consistency and standards compliance.

---

**Next Step**: Begin implementation with Phase 1 (mock class separation)
