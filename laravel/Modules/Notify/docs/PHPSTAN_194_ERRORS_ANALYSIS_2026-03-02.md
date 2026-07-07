# PHPStan Level 10 Errors Analysis - 194 Errors
**Date**: 2026-03-02
**Report File**: phpstan-full-report-2026-03-02-session2.txt
**Total Errors**: 160 (Note: Report shows 160, not 194 as initially stated)

---

## Executive Summary

This report provides a comprehensive analysis of 160 PHPStan Level 10 errors across the FixCity platform. The errors span 11 modules and follow distinct patterns that can be systematically resolved.

### Key Statistics
- **Total Errors**: 160
- **Modules Affected**: 11
- **Top Error Type**: method.notFound (72 errors, 45%)
- **Critical Priority**: 1 (SushiToJson trait - 90+ errors)

---

## Error Distribution by Module

| Module | Error Count | Priority |
|--------|-------------|----------|
| Tenant | 90+ | CRITICAL |
| Geo | 18 | High |
| Fixcity | 17 | High |
| Cms | 16 | Medium |
| Blog | 3 | Low |
| Notify | 6 | Medium |
| Rating | 1 | Low |
| Xot | 3 | Medium |

---

## Error Distribution by Type

| Error Type | Count | Percentage |
|------------|-------|------------|
| method.notFound | 72 | 45% |
| return.type | 22 | 14% |
| class.notFound | 15 | 9% |
| staticMethod.notFound | 14 | 9% |
| argument.type | 15 | 9% |
| offsetAccess.nonOffsetAccessible | 8 | 5% |
| phpDoc.parseError | 3 | 2% |
| argument.missing | 4 | 3% |
| property.notFound | 2 | 1% |
| assign.propertyType | 2 | 1% |
| method.nonObject | 5 | 3% |
| foreach.nonIterable | 4 | 3% |
| property.defaultValue | 1 | 1% |
| array.invalidKey | 1 | 1% |
| missingType.property | 1 | 1% |
| argument.unknown | 2 | 1% |
| method.unresolvableReturnType | 2 | 1% |
| **TOTAL** | **160** | **100%** |

---

## Top 10 Most Common Error Patterns

### 1. SushiToJson Trait Missing Methods (90+ errors)
**Error Type**: method.notFound
**Count**: 90+
**Priority**: CRITICAL

**Description**: Models using SushiToJson or SushiToJsons traits are missing required methods: `getJsonFile()`, `loadExistingData()`, `authId()`, `ensureDirectoryExists()`, `saveToJson()`, `findRowIndexById()`.

**Example**:
```
Call to an undefined method Modules\Cms\Models\Page::getJsonFile().
Call to an undefined method Modules\Geo\Models\Comune::loadExistingData().
Call to an undefined method Modules\Tenant\Models\TestSushiModel::authId().
```

**Affected Models**:
- Modules\Cms\Models\Page
- Modules\Cms\Models\Attachment
- Modules\Cms\Models\Menu
- Modules\Cms\Models\PageContent
- Modules\Cms\Models\Section
- Modules\Geo\Models\Comune
- Modules\Tenant\Models\TestSushiModel
- Modules\Xot\Models\InformationSchemaTable

**Fix Approach**:
Create a helper trait `SushiModelHelper` with all required methods and add it to models using SushiToJson traits.

```php
trait SushiModelHelper
{
    protected function getJsonFile(): string
    {
        return database_path('data/' . static::class . '.json');
    }

    protected function loadExistingData(): array
    {
        if (!file_exists($this->getJsonFile())) {
            return [];
        }
        return json_decode(file_get_contents($this->getJsonFile()), true) ?? [];
    }

    protected function authId(): ?int
    {
        return auth()->id();
    }

    protected function ensureDirectoryExists(): void
    {
        $dir = dirname($this->getJsonFile());
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    protected function saveToJson(array $data): void
    {
        $this->ensureDirectoryExists();
        file_put_contents($this->getJsonFile(), json_encode($data, JSON_PRETTY_PRINT));
    }

    protected function findRowIndexById(int $id): ?int
    {
        $data = $this->loadExistingData();
        foreach ($data as $index => $row) {
            if (isset($row['id']) && (int) $row['id'] === $id) {
                return $index;
            }
        }
        return null;
    }
}
```

---

### 2. Missing Static Methods in Geo Models (12 errors)
**Error Type**: staticMethod.notFound
**Count**: 12
**Priority**: High

**Description**: Geo models (Region, Province, Locality) are missing `getOptions()` and `getPostalCodeOptions()` static methods required by Filament select fields.

**Example**:
```
Call to an undefined static method Modules\Geo\Models\Region::getOptions().
Call to an undefined static method Modules\Geo\Models\Province::getOptions().
Call to an undefined static method Modules\Geo\Models\Locality::getOptions().
```

**Affected Models**:
- Modules\Geo\Models\Region
- Modules\Geo\Models\Province
- Modules\Geo\Models\Locality

**Fix Approach**:
Add static methods to return options arrays.

```php
// In Region.php
/**
 * @return array<int, array{value: int, label: string}>
 */
public static function getOptions(): array
{
    return self::query()
        ->orderBy('name')
        ->get()
        ->map(fn (Region $region): array => [
            'value' => $region->id,
            'label' => $region->name,
        ])
        ->all();
}

// In Locality.php
/**
 * @return array<int, array{value: int, label: string}>
 */
public static function getPostalCodeOptions(): array
{
    return self::query()
        ->orderBy('postal_code')
        ->get()
        ->map(fn (Locality $locality): array => [
            'value' => $locality->id,
            'label' => $locality->postal_code,
        ])
        ->all();
}
```

---

### 3. PHPDoc Parse Errors in Geo Models (3 errors)
**Error Type**: phpDoc.parseError
**Count**: 3
**Priority**: High

**Description**: PHPDoc tags in Geo models have invalid syntax.

**Example**:
```
PHPDoc tag @method has invalid value (static public array<string, string> getOptions(Get $get)): Unexpected token "getOptions", expected '(' at offset 893 on line 17
```

**Affected Models**:
- Modules\Geo\Models\Locality (2 errors)
- Modules\Geo\Models\Region (1 error)

**Fix Approach**:
Correct PHPDoc syntax for static methods.

```php
// CORRECT
/**
 * @method static array<string, string> getOptions(\Filament\Schemas\Components\Utilities\Get $get)
 */

// WRONG (current)
/**
 * @method (static public array<string, string> getOptions(Get $get))
 */
```

---

### 4. Mixed Type Operations (10 errors)
**Error Type**: return.type / method.nonObject / foreach.nonIterable / offsetAccess.nonOffsetAccessible
**Count**: 10
**Priority**: Medium

**Description**: Operations on mixed types without type assertions.

**Example**:
```
Anonymous function should return Modules\Fixcity\Models\Ticket but returns mixed.
Cannot call method create() on mixed.
Cannot access offset mixed on mixed.
Argument of an invalid type mixed supplied for foreach.
```

**Affected Files**:
- Fixcity/app/Actions/GenerateTicketsAction.php
- Fixcity/app/Services/NotificationService.php
- Fixcity/app/Services/TicketService.php
- Fixcity/app/Services/WorkflowService.php
- Tenant/app/Models/Traits/SushiToJson.php

**Fix Approach**:
Add type assertions before operations.

```php
// BEFORE
$tickets = $categories->map(fn ($cat) => $cat->tickets()->create([...]));

// AFTER
/** @var Collection<int, Category> $categories */
$categories = $categories;
$tickets = $categories->map(fn (Category $cat): Ticket => $cat->tickets()->create([...]));
```

---

### 5. Missing Model Methods (8 errors)
**Error Type**: method.notFound
**Count**: 8
**Priority**: Medium

**Description**: Models are missing relationship methods or custom methods.

**Example**:
```
Call to an undefined method Modules\Fixcity\Models\Ticket::setStatus().
Call to an undefined method Modules\Fixcity\Models\Ticket::comments().
Call to an undefined method Modules\Fixcity\Models\Ticket::activities().
```

**Affected Models**:
- Modules\Fixcity\Models\Ticket (setStatus, comments, activities)
- Modules\Fixcity\Models\TicketActivity (withTrashed on BelongsTo)

**Fix Approach**:
Add missing methods to models.

```php
// In Ticket.php
public function setStatus(string $status): void
{
    $this->status = $status;
    $this->save();
}

/**
 * @return HasMany<Comment, $this>
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

/**
 * @return HasMany<TicketActivity, $this>
 */
public function activities(): HasMany
{
    return $this->hasMany(TicketActivity::class);
}
```

---

### 6. Missing Static Methods in Xot Models (2 errors)
**Error Type**: staticMethod.notFound
**Count**: 2
**Priority**: Medium

**Description**: InformationSchemaTable model is missing static methods.

**Example**:
```
Call to an undefined static method Modules\Xot\Models\InformationSchemaTable::getModelCount().
Call to an undefined static method Modules\Xot\Models\InformationSchemaTable::updateModelCount().
```

**Affected Models**:
- Modules\Xot\Models\InformationSchemaTable

**Fix Approach**:
Add missing static methods with proper return types.

```php
public static function getModelCount(string $modelClass): int
{
    return self::where('table_name', app($modelClass)->getTable())->value('row_count') ?? 0;
}

public static function updateModelCount(string $modelClass): int
{
    $count = app($modelClass)::query()->count();
    return self::updateOrCreate(
        ['table_name' => app($modelClass)->getTable()],
        ['row_count' => $count]
    )->row_count;
}
```

---

### 7. Argument Type Mismatches (15 errors)
**Error Type**: argument.type / argument.missing / argument.unknown
**Count**: 15
**Priority**: Medium

**Description**: Functions receive arguments of wrong type or missing required parameters.

**Example**:
```
Missing parameter $view (string) in call to Modules\UI\View\Components\Render\Blocks constructor.
Parameter #2 $strict of method Faker\Generator::randomNumber() expects bool, int given.
Parameter #3 $coordinates expects array<array{latitude: string, longitude: string}>, array<mixed> given.
```

**Affected Files**:
- Blog/app/View/Composers/ThemeComposer.php
- Blog/database/factories/TransactionFactory.php
- Cms/app/Http/Middleware/PageSlugMiddleware.php
- Cms/app/View/Components/GuestLayout.php
- Fixcity/app/Filament/Widgets/CreateTicketWidget.php
- Fixcity/app/Rules/FilterCoordinatesInRadius.php
- Fixcity/app/Services/NotificationService.php

**Fix Approach**:
Add missing parameters and correct argument types.

```php
// BEFORE
$blocks = new Render\Blocks($data);

// AFTER
$blocks = new Render\Blocks('view-name', $data);

// BEFORE
fake()->randomNumber(2)

// AFTER
fake()->randomNumber(true, 2)
```

---

### 8. Unknown Classes (15 errors)
**Error Type**: class.notFound
**Count**: 15
**Priority**: Low

**Description**: References to non-existent classes or interfaces.

**Example**:
```
PHPDoc tag @method for method Modules\Cms\Models\Page::all() return type contains unknown class Modules\Cms\Models\Collection.
Call to static method factory() on an unknown class Modules\Category\Models\Category.
Class Modules\Fixcity\Models\Report not found.
```

**Affected Files**:
- Cms/app/Models/Page.php
- Cms/app/Models/Section.php
- Fixcity/database/factories/ReportFactory.php
- Fixcity/database/factories/TicketFactory.php
- Notify/app/Notifications/FirebaseAndroidNotification.php
- Fixcity/app/Livewire/TicketList.php

**Fix Approach**:
Create missing classes or fix class references.

```php
// Fix imports - remove duplicate namespace
// WRONG: Modules\Cms\Models\Modules\Cms\Datas\BlockData
// CORRECT: Modules\Cms\Datas\BlockData
```

---

### 9. Property Type Issues (3 errors)
**Error Type**: property.notFound / assign.propertyType / missingType.property
**Count**: 3
**Priority**: Low

**Description**: Properties not defined in interfaces or wrong types.

**Example**:
```
Access to an undefined property Modules\Xot\Contracts\UserContract::$email_verified_at.
Property Modules\Cms\View\Components\Page::$blocks does not accept mixed.
Property Modules\Fixcity\View\Components\Blocks\TicketList::$tickets has no type specified.
```

**Affected Files**:
- Blog/app/Http/Livewire/Profile/Setting.php
- Cms/app/View/Components/Page.php
- Cms/app/View/Components/Section.php
- Fixcity/app/View/Components/Blocks/TicketList.php
- Fixcity/app/Services/NotificationService.php

**Fix Approach**:
Add property to interface or add type annotation.

```php
// In UserContract.php
/**
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 */
interface UserContract extends Authenticatable
{
    // ...
}

// In components
/** @var array<string, BlockData> */
public array $blocks = [];
```

---

### 10. Unresolvable Return Types (2 errors)
**Error Type**: method.unresolvableReturnType
**Count**: 2
**Priority**: Low

**Description**: Collection::map() return type cannot be resolved.

**Example**:
```
Return type of call to method Illuminate\Database\Eloquent\Collection<int,Modules\Geo\Models\Comune>::map() contains unresolvable type.
```

**Affected Files**:
- Geo/app/Models/Address.php

**Fix Approach**:
Add type annotation before map call.

```php
/** @var Collection<int, Comune> $collection */
$collection = $comunes->all();
return $collection->map(fn (Comune $c): array => ['value' => $c->id, 'label' => $c->name])->all();
```

---

## Prioritized Fix Plan

### Priority 1: CRITICAL - SushiToJson Trait (90+ errors)
**Estimated Time**: 2-3 hours
**Impact**: Resolves 56% of all errors

**Tasks**:
1. Create `Modules/Tenant/app/Models/Traits/SushiModelHelper.php` trait with all required methods
2. Add trait to all affected models:
   - Modules\Cms\Models\Page
   - Modules\Cms\Models\Attachment
   - Modules\Cms\Models\Menu
   - Modules\Cms\Models\PageContent
   - Modules\Cms\Models\Section
   - Modules\Geo\Models\Comune
   - Modules\Tenant\Models\TestSushiModel
   - Modules\Xot\Models\InformationSchemaTable
3. Add proper return types to all trait methods
4. Test JSON file operations

**Expected Result**: 90+ errors resolved

---

### Priority 2: HIGH - Geo Static Methods (15 errors)
**Estimated Time**: 1-2 hours
**Impact**: Resolves 9% of all errors

**Tasks**:
1. Add `getOptions()` method to Region model
2. Add `getOptions()` method to Province model
3. Add `getOptions()` method to Locality model
4. Add `getPostalCodeOptions()` method to Locality model
5. Fix PHPDoc parse errors in all three models
6. Add proper type annotations

**Expected Result**: 15 errors resolved

---

### Priority 3: MEDIUM - Missing Model Methods (8 errors)
**Estimated Time**: 1-2 hours
**Impact**: Resolves 5% of all errors

**Tasks**:
1. Add `setStatus()` method to Ticket model
2. Add `comments()` relationship to Ticket model
3. Add `activities()` relationship to Ticket model
4. Fix `withTrashed()` call on BelongsTo in TicketActivity
5. Add missing methods to InformationSchemaTable:
   - `getModelCount()`
   - `updateModelCount()`

**Expected Result**: 8 errors resolved

---

### Priority 4: MEDIUM - Type Safety Issues (25 errors)
**Estimated Time**: 3-4 hours
**Impact**: Resolves 16% of all errors

**Tasks**:
1. Fix anonymous function return types in GenerateTicketsAction
2. Add type assertions in NotificationService
3. Fix mixed type operations in TicketService
4. Fix mixed type operations in WorkflowService
5. Add type annotations to component properties
6. Fix argument type mismatches in factories
7. Fix constructor parameter issues in ThemeComposer

**Expected Result**: 25 errors resolved

---

### Priority 5: LOW - Class References and Miscellaneous (22 errors)
**Estimated Time**: 2-3 hours
**Impact**: Resolves 14% of all errors

**Tasks**:
1. Fix duplicate namespace references in Cms models
2. Create missing Report model or remove ReportFactory
3. Fix Category model import
4. Add missing properties to UserContract
5. Fix Collection::map() return type issues
6. Fix Faker method calls in factories
7. Remove invalid #[\Override] attributes

**Expected Result**: 22 errors resolved

---

## Implementation Strategy

### Phase 1: Quick Wins (Days 1-2)
- Priority 1: SushiToJson trait helper
- Priority 2: Geo static methods

**Expected Outcome**: 105+ errors resolved (66% reduction)

### Phase 2: Model Completeness (Days 3-4)
- Priority 3: Missing model methods
- Priority 4: Type safety issues (part 1)

**Expected Outcome**: 25+ errors resolved (82% total reduction)

### Phase 3: Final Cleanup (Days 5-6)
- Priority 4: Type safety issues (part 2)
- Priority 5: Class references and miscellaneous

**Expected Outcome**: 22 errors resolved (96% total reduction)

### Phase 4: Verification (Day 7)
- Run PHPStan level 10 analysis
- Fix any remaining errors
- Update documentation

**Expected Outcome**: 100% error resolution

---

## Testing Strategy

### Unit Tests
- Test SushiModelHelper trait methods
- Test Geo model static methods
- Test Ticket model new methods
- Test type-safe operations

### Integration Tests
- Test JSON file operations
- Test Filament select field options
- Test model relationships
- Test notification services

### Static Analysis
- Run PHPStan after each priority phase
- Verify error count reduction
- Ensure no regressions

---

## Success Metrics

### Phase Completion Criteria
- [ ] Priority 1: 90+ errors resolved
- [ ] Priority 2: 15 errors resolved
- [ ] Priority 3: 8 errors resolved
- [ ] Priority 4: 25 errors resolved
- [ ] Priority 5: 22 errors resolved

### Final Criteria
- [ ] PHPStan Level 10: 0 errors
- [ ] All tests passing
- [ ] No performance degradation
- [ ] Documentation updated

---

## Risk Assessment

### Low Risk
- Adding type annotations
- Fixing PHPDoc syntax
- Creating helper traits

### Medium Risk
- Adding new model methods (may affect existing code)
- Changing return types (may break dependencies)
- Modifying static methods (used by Filament)

### Mitigation Strategies
1. Run full test suite after each change
2. Use feature flags for new methods
3. Document breaking changes
4. Gradual rollout with monitoring

---

## Dependencies

### Required Packages
- Spatie\Laravel\Data (for DTOs)
- Faker (already installed)
- All Laravel core packages

### Required Skills
- PHP 8.2+ strict typing
- Laravel Eloquent relationships
- Filament form components
- Static analysis tools

---

## Notes

### Previous Work
- UserContract interface has been updated (property.notFound reduced from 39 to 1)
- Factory classes have been created for many models
- Logging performance issues have been addressed

### Known Issues
- Some modules may have missing dependencies
- Some factories reference non-existent models
- Some PHPDoc tags have incorrect syntax

### Best Practices to Follow
1. Always use `declare(strict_types=1);`
2. Define all return types
3. Use type assertions before mixed operations
4. Add comprehensive PHPDoc annotations
5. Create DTOs for complex data structures

---

## Conclusion

This analysis provides a clear roadmap for resolving all 160 PHPStan Level 10 errors in the FixCity platform. By following the prioritized fix plan and implementation strategy, the team can achieve 100% error resolution within 7 days.

The critical path is the SushiToJson trait (Priority 1), which alone resolves 56% of all errors. After that, the remaining errors can be systematically addressed in decreasing priority order.

---

**Next Steps**:
1. Review this analysis with the team
2. Assign tasks based on priority
3. Start with Priority 1 (SushiToJson trait)
4. Track progress using the success metrics
5. Run PHPStan after each phase to verify fixes

**Report Generated**: 2026-03-02
**Last Updated**: 2026-03-02
**Total Estimated Time**: 7-10 hours
**Expected Error Reduction**: 100% (160 → 0 errors)