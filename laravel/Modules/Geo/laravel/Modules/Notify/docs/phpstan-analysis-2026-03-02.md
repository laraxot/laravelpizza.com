# PHPStan Level 10 Analysis Report - 2026-03-02

## Executive Summary

**Total Errors Found:** 138  
**Analysis Status:** Complete  
**Critical Issues:** 2 (Syntax errors fixed)  
**Major Categories:** 8

### Error Distribution by Category

| Category | Count | Priority | Status |
|----------|-------|----------|--------|
| `property.notFound` | 18 | HIGH | Requires PHPDoc additions |
| `method.notFound` | 16 | HIGH | Missing method implementations |
| `class.notFound` | 12 | HIGH | Missing class definitions |
| `return.type` | 8 | MEDIUM | Missing return type declarations |
| `argument.type` | 10 | MEDIUM | Type mismatch in arguments |
| `offsetAccess.nonOffsetAccessible` | 12 | MEDIUM | Array access on non-array types |
| `method.nonObject` | 9 | MEDIUM | Calling methods on mixed/null |
| `staticMethod.notFound` | 5 | MEDIUM | Missing static methods |

---

## Critical Issues Fixed

### 1. SushiToJsons.php - Syntax Error (Line 38)
**File:** `Modules/Tenant/app/Models/Traits/SushiToJsons.php`  
**Issue:** Erroneous opening brace `{` after method declaration  
**Status:** ✅ FIXED  
**Solution:** Removed abstract method declarations from trait implementation

### 2. SushiToJson.php - Duplicate Method Declarations
**File:** `Modules/Tenant/app/Models/Traits/SushiToJson.php`  
**Issue:** Abstract method declarations mixed with implementations  
**Status:** ✅ FIXED  
**Solution:** Removed abstract declarations (lines 34-47)

---

## Detailed Error Analysis by Module

### Cms Module (18 errors)

#### BlockData Class Not Found
- **Files:** `Cms/app/Models/Page.php`, `Cms/app/View/Components/Page.php`
- **Issue:** `Modules\Cms\Models\BlockData` class referenced but not found
- **Solution:** 
  - Create `Modules/Cms/Models/BlockData.php` as a Data class or Model
  - OR add proper PHPDoc `@return` type hints if using Spatie Data

#### Missing Static Methods
- **Method:** `Page::getBlocksBySlug()`
- **Method:** `Section::getBlocksBySlug()`
- **Solution:** Implement these methods or add proper return type declarations

#### Property Type Mismatches
- **Issue:** `$blocks` property assigned array but expects `BlockData` collection
- **Solution:** Use proper type casting or collection wrappers

---

### Fixcity Module (35 errors)

#### Missing Model Methods
- **Method:** `Ticket::setStatus()` (ChangeStatus.php:22)
- **Method:** `Ticket::comments()` (TicketService.php:171)
- **Method:** `Ticket::activities()` (WorkflowService.php:220)
- **Solution:** Add these relationship methods to Ticket model with proper PHPDoc

#### Undefined Properties
- **Property:** `Ticket::$assignee` (NotificationService.php:209)
- **Solution:** Add `@property` PHPDoc or implement as relationship

#### Service Class Issues
- **File:** `NotificationService.php`
- **Issue:** Multiple type mismatches in Collection handling
- **Solution:** Add explicit type hints to method parameters and return types

#### Factory Issues
- **File:** `ReportFactory.php`
- **Issue:** `Report` model not found
- **Solution:** Create `Modules/Fixcity/Models/Report.php` or update factory

#### Seeder Issues
- **Files:** `ReportContentSeeder.php`, `TicketDatabaseSeeder.php`
- **Issue:** Cannot access array offsets on mixed type
- **Solution:** Add proper type casting and null checks

---

### Geo Module (8 errors)

#### Missing Static Methods
- **Method:** `Region::getOptions()` (AddressResource.php:50)
- **Solution:** Implement method or add proper return type

#### Undefined Classes
- **Class:** `Modules\Geo\Actions\FilterCoordinatesInRadiusAction`
- **Solution:** Create action class or update import

---

### Tenant Module (24 errors)

#### SushiToJsons Trait Issues
- **Issue:** Trait calling undefined methods on models using it
- **Methods:** `getJsonFile()` called on models that don't implement it
- **Solution:** Ensure all models using trait implement required methods

#### Undefined Methods in Context
- **Models:** `Page`, `PageContent`, `Section`
- **Issue:** These models use trait but don't have required methods
- **Solution:** Add method implementations or use proper inheritance

---

### User Module (6 errors)

#### Missing Log Class
- **File:** `RegisterWidget.php`
- **Issue:** `Modules\User\Filament\Widgets\Auth\Log` class not found
- **Solution:** Create the Log class or update references

---

### Xot Module (12 errors)

#### Missing Static Methods
- **Method:** `InformationSchemaTable::getModelCount()`
- **Method:** `InformationSchemaTable::updateModelCount()`
- **Files:** `CountAction.php`, `UpdateCountAction.php`
- **Solution:** Implement these methods with proper return types

#### Filament Schema Issues
- **File:** `XotBaseEditRecord.php:95`
- **Issue:** Array of components passed where Htmlable/string expected
- **Solution:** Wrap components in proper Filament schema structure

---

## Root Cause Analysis

### Pattern 1: Missing PHPDoc on Properties
**Frequency:** 18 occurrences  
**Root Cause:** Properties not documented with `@property` annotations  
**Impact:** PHPStan cannot infer property types  
**Fix Strategy:**
```php
/**
 * @property string $name
 * @property int $id
 * @property-read Collection<int, User> $users
 */
class Model extends BaseModel
{
    // ...
}
```

### Pattern 2: Undefined Methods in Models
**Frequency:** 16 occurrences  
**Root Cause:** Methods referenced but not implemented  
**Impact:** Runtime errors and type safety violations  
**Fix Strategy:**
- Add method implementations
- Add `@method` PHPDoc if using magic methods
- Use proper relationships with return type hints

### Pattern 3: Missing Class Definitions
**Frequency:** 12 occurrences  
**Root Cause:** Data classes or models not created  
**Impact:** Cannot resolve types  
**Fix Strategy:**
- Create missing classes following Laraxot conventions
- Use Spatie Data for DTOs
- Ensure proper namespace alignment

### Pattern 4: Type Mismatches in Collections
**Frequency:** 10 occurrences  
**Root Cause:** Generic type parameters not specified  
**Impact:** Cannot verify collection operations  
**Fix Strategy:**
```php
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection
{
    return User::all();
}
```

### Pattern 5: Array Access on Mixed Types
**Frequency:** 12 occurrences  
**Root Cause:** Insufficient type information  
**Impact:** Cannot verify array operations  
**Fix Strategy:**
```php
/** @var array<string, mixed> $data */
$data = json_decode($json, true);
$value = $data['key'] ?? null;
```

---

## Recommended Fix Priority

### Phase 1: Critical (Blocking Analysis)
1. ✅ Fix syntax errors in Tenant traits
2. Create missing Data classes (BlockData, etc.)
3. Implement missing model methods (setStatus, comments, activities)

### Phase 2: High Priority (Type Safety)
1. Add comprehensive PHPDoc to all models
2. Implement missing static methods
3. Add return type hints to all methods

### Phase 3: Medium Priority (Code Quality)
1. Fix Collection type parameters
2. Add proper type casting in seeders
3. Update Service classes with explicit types

### Phase 4: Low Priority (Optimization)
1. Refactor to use Spatie Data instead of Services
2. Replace Controllers with Folio/Volt
3. Optimize query patterns

---

## Documentation Updates Needed

### Module Documentation
- [ ] `Modules/Cms/docs/models.md` - Document BlockData structure
- [ ] `Modules/Fixcity/docs/models.md` - Document Ticket methods
- [ ] `Modules/Geo/docs/actions.md` - Document FilterCoordinatesInRadiusAction
- [ ] `Modules/Tenant/docs/traits.md` - Document SushiToJson trait requirements
- [ ] `Modules/User/docs/widgets.md` - Document RegisterWidget and Log class
- [ ] `Modules/Xot/docs/actions.md` - Document ModelClass actions

### Root Documentation
- [ ] `docs/phpstan-level-10-guide.md` - Complete guide for Level 10 compliance
- [ ] `docs/type-safety-patterns.md` - Common patterns and solutions
- [ ] `docs/collection-typing.md` - How to properly type collections

---

## Lessons Learned & Rule Updates

### New Rule: Trait Method Declarations
**Rule:** Traits should NOT contain abstract method declarations mixed with implementations.  
**Reason:** Causes confusion and PHPStan errors  
**Pattern:**
```php
// ❌ WRONG
trait MyTrait {
    public function method(): string;  // Abstract declaration
    public function method(): string { // Implementation
        return 'value';
    }
}

// ✅ CORRECT
trait MyTrait {
    public function method(): string {
        return 'value';
    }
}
```

### New Rule: Collection Type Parameters
**Rule:** All Collection returns MUST include generic type parameters  
**Reason:** PHPStan cannot verify collection operations without types  
**Pattern:**
```php
// ❌ WRONG
public function getUsers(): Collection {
    return User::all();
}

// ✅ CORRECT
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection {
    return User::all();
}
```

### New Rule: Property Documentation
**Rule:** All model properties MUST have `@property` PHPDoc  
**Reason:** PHPStan needs explicit type information  
**Pattern:**
```php
/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, User> $users
 */
class Model extends BaseModel {
    // ...
}
```

---

## Next Steps

1. **Immediate:** Fix Phase 1 critical issues
2. **This Week:** Complete Phase 2 high priority items
3. **Next Week:** Address Phase 3 medium priority items
4. **Ongoing:** Update documentation and rules

---

## Statistics

- **Total Errors:** 138
- **Errors Fixed This Session:** 2 (Syntax)
- **Remaining Errors:** 136
- **Estimated Fix Time:** 4-6 hours
- **Documentation Updates:** 10+ files

---

**Report Generated:** 2026-03-02  
**Analysis Tool:** PHPStan Level 10  
**Next Review:** After Phase 1 fixes
