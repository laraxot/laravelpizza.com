# PHPStan Errors Summary - Global Analysis

## 📊 Current Status
- **Total Errors**: 138
- **PHPStan Level**: 10 (Maximum)
- **Progress**: 189 → 138 (-27%)

## 🎯 Error Breakdown by Priority

### HIGH Priority (89 errors)

#### 1. SushiToJsons Trait - Missing Methods (36 errors)
**Files Affected**:
- `Tenant/app/Models/Traits/SushiToJsons.php`

**Issues**:
- `getJsonFile()` method not found in 6 models (Attachment, Menu, Page, PageContent, Section)
- Called in boot callbacks: creating, updating, deleting

**Root Cause**: PHPStan doesn't see the method because it's defined in the trait itself

**Solution Strategy**:
1. Add PHPDoc to trait to help PHPStan discover the method
2. Add @method annotations to models using the trait
3. Ensure proper namespace resolution

**Learning**: Traits with public methods need explicit PHPDoc annotations for PHPStan Level 10

---

#### 2. SushiToJson Trait - Missing Methods (30 errors)
**Files Affected**:
- `Tenant/app/Models/Traits/SushiToJson.php`

**Issues**:
- 6 methods not found in 3 models (Comune, TestSushiModel, InformationSchemaTable):
  - `getJsonFile()`, `loadExistingData()`, `authId()`
  - `ensureDirectoryExists()`, `saveToJson()`, `findRowIndexById()`

**Solution Strategy**:
1. Add complete PHPDoc with all method signatures
2. Add @method annotations to using classes
3. Use @phpstan-require-extends Model constraint

**Learning**: Complex traits with private helper methods need comprehensive documentation

---

#### 3. Fixcity Module - Service Classes (10 errors)
**Files Affected**:
- `Fixcity/app/Services/NotificationService.php` (3 errors)
- `Fixcity/app/Services/TicketService.php` (2 errors)
- `Fixcity/app/Services/WorkflowService.php` (5 errors)

**Issues**:
- Missing Ticket methods: `setStatus()`, `comments()`, `activities()`
- Missing Ticket property: `$assignee`
- Type mismatches in return types

**Solution Strategy**:
1. **IMMEDIATE ACTION**: Replace Services with Spatie Queueable Actions
2. Add missing methods to Ticket model
3. Use Laraxot patterns: Actions instead of Services
4. Follow architectural rule: NO Service classes

**Learning**: Always follow Laraxot architectural rules - Actions over Services

---

#### 4. Cms Module - Missing Static Methods (3 errors)
**Files Affected**:
- `Cms/app/Models/Page.php` - `getMiddlewareBySlug()`, `getBlocksBySlug()`
- `Cms/app/Models/Section.php` - `getBlocksBySlug()`
- `Cms/app/View/Components/Page.php` - uses `getBlocksBySlug()`
- `Cms/app/View/Components/Section.php` - uses `getBlocksBySlug()`

**Root Cause Analysis**:
- `getMiddlewareBySlug()` EXISTS in Page model (line 105)
- `getBlocksBySlug()` EXISTS in HasBlocks trait (line 91)
- PHPStan doesn't see them due to loading issues

**Solution Strategy**:
1. Verify traits are properly included
2. Add @method annotations to PHPDoc
3. Check namespace resolution
4. Study base_laravelpizza for reference implementation

**Learning**: Static methods from traits need explicit @method annotations in class PHPDoc

---

#### 5. Fixcity Module - Missing Model Methods (5 errors)
**Files Affected**:
- `Fixcity/app/Actions/ChangeStatus.php` - `setStatus()` not found
- `Fixcity/app/Models/TicketActivity.php` - `withTrashed()` not found

**Solution Strategy**:
1. Add `setStatus()` method to Ticket model
2. Check if Ticket uses SoftDeletes trait
3. Add proper relationships if missing

---

#### 6. Fixcity Module - Type Safety Issues (20 errors)
**Files Affected**:
- `Fixcity/app/Actions/GenerateTicketsAction.php` (6 errors)
- `Fixcity/app/Livewire/Auth/Login.php` (1 error)
- `Fixcity/app/Livewire/TicketList.php` (2 errors)
- `Fixcity/app/Rules/FilterCoordinatesInRadius.php` (1 error)
- `Fixcity/database/seeders/ReportContentSeeder.php` (7 errors)
- `Fixcity/database/seeders/TicketDatabaseSeeder.php` (5 errors)

**Issues**:
- Missing property type declarations
- Mixed type returns in anonymous functions
- Cannot call methods on mixed types
- Cannot access offsets on mixed types

**Solution Strategy**:
1. Add type hints to all properties
2. Use proper type assertions in callbacks
3. Add @var annotations for mixed types
4. Use Safe library functions

**Learning**: PHPStan Level 10 requires explicit type annotations for ALL properties

---

### MEDIUM Priority (30 errors)

#### 1. Geo Module - Missing Static Methods (8 errors)
**Files Affected**:
- `Geo/app/Filament/Resources/AddressResource.php`

**Issues**:
- `Region::getOptions()` (2 calls)
- `Province::getOptions()` (2 calls)
- `Locality::getOptions()` (2 calls)
- `Locality::getPostalCodeOptions()` (2 calls)

**Solution Strategy**:
1. Add static helper methods to models
2. Or create Actions for these operations
3. Follow Laraxot patterns

---

#### 2. Xot Actions - Missing Static Methods (2 errors)
**Files Affected**:
- `Xot/app/Actions/ModelClass/CountAction.php`
- `Xot/app/Actions/ModelClass/UpdateCountAction.php`

**Issues**:
- `InformationSchemaTable::getModelCount()` - EXISTS but PHPStan doesn't see it
- `InformationSchemaTable::updateModelCount()` - EXISTS but PHPStan doesn't see it

**Root Cause**: Methods exist but PHPStan can't resolve them

**Solution Strategy**:
1. Add @method annotations to InformationSchemaTable
2. Verify namespace and autoload
3. Check if model is properly cached

---

#### 3. Blog Module - PHPDoc Issues (2 errors)
**Files Affected**:
- `Blog/app/Models/Transaction.php` - wrong PHPDoc path
- `Blog/app/View/Composers/ThemeComposer.php` - missing parameter

**Solution Strategy**:
1. Fix PHPDoc paths to use correct references
2. Add missing parameters to constructor calls

---

#### 4. Notify Module - Missing Class (1 error)
**Files Affected**:
- `Notify/app/Notifications/FirebaseAndroidNotification.php`

**Issues**:
- `NotificationChannels\Fcm\FcmChannel` not found

**Solution Strategy**:
1. Check if package is installed
2. Add missing dependency to composer.json
3. Or remove notification if not needed

---

#### 5. Rating Module - Template Type Issue (1 error)
**Files Affected**:
- `Rating/app/Models/Traits/HasRating.php`

**Issues**:
- MorphToMany template type covariance issue

**Solution Strategy**:
1. This is a known PHPStan limitation
2. Add @phpstan-ignore-next-line annotation
3. Or update to use proper type hints

---

#### 6. Fixcity Module - Missing Classes (16 errors)
**Files Affected**:
- `Fixcity/database/factories/ReportFactory.php` - Report model not found
- `Fixcity/database/factories/TicketFactory.php` - Category model not found
- `Fixcity/app/Models/Ticket.php` - belongsTo/belongsToMany type issues

**Solution Strategy**:
1. Create missing models or remove unused factories
2. Fix relationship type hints
3. Use proper class-string types

---

### LOW Priority (19 errors)

#### 1. Filament Components - Type Mismatches (4 errors)
**Files Affected**:
- `Fixcity/app/Filament/Widgets/CreateTicketWidget.php` (2 errors)
- `Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php` (1 error)
- `Blog/app/View/Composers/ThemeComposer.php` (2 errors)

**Issues**:
- Parameter type mismatches in component methods
- Missing parameters in constructor calls

**Solution Strategy**:
1. Fix type hints to match expected signatures
2. Add missing parameters
3. Use proper Filament type definitions

---

#### 2. Geo Module - Unresolvable Return Types (2 errors)
**Files Affected**:
- `Geo/app/Models/Address.php`

**Issues**:
- Collection::map() returns unresolvable type

**Solution Strategy**:
1. Add explicit return type annotations
2. Use @var annotations for mapped collections
3. Or simplify mapping logic

---

## 📋 Fix Priority Order

### Phase 1: Critical Infrastructure (30 errors)
1. ✅ UserContract exists() method - FIXED
2. ✅ User RegisterWidget Log import - FIXED
3. ⏳ SushiToJsons trait PHPDoc (36 errors)
4. ⏳ SushiToJson trait PHPDoc (30 errors)

### Phase 2: High Impact Modules (50 errors)
5. ⏳ Fixcity Services → Actions migration (10 errors)
6. ⏳ Cms module static methods (3 errors)
7. ⏳ Fixcity Ticket model methods (5 errors)
8. ⏳ Fixcity type safety issues (20 errors)
9. ⏳ Geo module static methods (8 errors)
10. ⏳ Xot Actions methods (2 errors)

### Phase 3: Remaining Issues (28 errors)
11. ⏳ Blog module PHPDoc (2 errors)
12. ⏳ Notify module missing class (1 error)
13. ⏳ Rating template types (1 error)
14. ⏳ Fixcity missing classes (16 errors)
15. ⏳ Filament type mismatches (4 errors)
16. ⏳ Geo unresolvable types (2 errors)

## 🎯 Success Criteria
- 0 PHPStan errors at Level 10
- All Services replaced with Actions
- All type safety issues resolved
- Complete PHPDoc coverage
- Follow Laraxot architectural patterns

## 📚 Reference Documentation
- `.windsurfrules` - Laraxot architectural rules
- `AGENTS.md` - Project guidelines
- Module-specific fix plans in each module's docs/