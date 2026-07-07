# PHPStan Global Error Summary - 2026-03-02

## 📊 Total Errors: 138

### Error Distribution by Type

| Error Type | Count | Percentage |
|------------|-------|------------|
| method.notFound | 47 | 34% |
| offsetAccess.nonOffsetAccessible | 21 | 15% |
| staticMethod.notFound | 13 | 9% |
| argument.type | 12 | 9% |
| class.notFound | 8 | 6% |
| return.type | 5 | 4% |
| property.notFound | 1 | 1% |
| missingType.property | 1 | 1% |
| Other | 30 | 22% |

---

## 🎯 Error Distribution by Module

| Module | Errors | Priority | Complexity | Status |
|--------|--------|----------|-------------|--------|
| **Tenant** | 50+ | CRITICAL | HIGH | 🔴 Pending |
| **Fixcity** | 30+ | HIGH | HIGH | 🔴 Pending |
| **Cms** | 18 | MEDIUM | MEDIUM | 🟡 Pending |
| **Geo** | 8 | MEDIUM | MEDIUM | 🟢 Partially Fixed |
| **Notify** | 5 | LOW | LOW | 🟢 Pending |
| **Xot** | 5 | LOW | LOW | 🟢 Pending |
| **Blog** | 3 | LOW | LOW | 🟢 In Progress |
| **Rating** | 1 | LOW | LOW | 🟢 Pending |

---

## 🔧 Error Categories

### 1. method.notFound (47 errors - 34%)

**Root Causes**:
- Missing methods in models (setStatus, comments, activities)
- Missing methods in SushiToJson trait (getJsonFile, loadExistingData, etc.)
- Missing static methods in models

**Affected Modules**: Tenant (25+), Fixcity (10+), Xot (2), Rating (1)

**Solution Strategy**:
- Add missing methods to models
- Create SushiModelHelper trait
- Add @method annotations to PHPDoc

### 2. offsetAccess.nonOffsetAccessible (21 errors - 15%)

**Root Causes**:
- Array access on mixed types in seeders
- Missing type assertions before array access

**Affected Modules**: Fixcity (13), Tenant (8)

**Solution Strategy**:
- Add type assertions: `$value = $data['key'] ?? throw new InvalidArgumentException()`
- Add @var annotations before array access

### 3. staticMethod.notFound (13 errors - 9%)

**Root Causes**:
- Missing getOptions() methods in Geo models
- Missing static methods in Xot models

**Affected Modules**: Geo (8), Xot (5)

**Solution Strategy**:
- Add getOptions() methods to Region, Province, Locality
- Add getModelCount() and updateModelCount() to InformationSchemaTable
- Add @method annotations to PHPDoc

### 4. argument.type (12 errors - 9%)

**Root Causes**:
- Wrong type for Filament schema components
- Wrong type for credentials in Auth
- Wrong type for Collection::merge()

**Affected Modules**: Fixcity (6), Cms (4), Blog (2)

**Solution Strategy**:
- Fix schema component types
- Add type assertions for credentials
- Use ->all() on Collections

### 5. class.notFound (8 errors - 6%)

**Root Causes**:
- Missing factory classes (TransactionFactory)
- Missing data classes (BlockData)
- Missing notification channels (FcmChannel)

**Affected Modules**: Blog (1), Cms (1), Notify (2), Rating (4)

**Solution Strategy**:
- Create missing factory classes
- Create missing data classes
- Check package dependencies

### 6. return.type (5 errors - 4%)

**Root Causes**:
- Anonymous functions without return type
- Methods with wrong return type

**Affected Modules**: Fixcity (2), Xot (1), Cms (2)

**Solution Strategy**:
- Add return types to anonymous functions
- Fix method return type annotations

---

## 🚀 Implementation Roadmap

### Phase 1: Quick Wins (Low Complexity)

**Target**: Blog, Notify, Rating modules (9 errors total)

**Timeline**: Week 1

**Tasks**:
1. ✅ Create TransactionFactory for Blog
2. ⏭️ Fix MailTemplateVersionFactory for Notify
3. ⏭️ Fix FcmChannel issue in Notify
4. ⏭️ Fix Rating errors

**Expected Result**: 138 → 129 errors (-9 errors)

### Phase 2: Medium Complexity

**Target**: Geo, Xot modules (13 errors total)

**Timeline**: Week 2

**Tasks**:
1. ⏭️ Resolve Geo staticMethod.notFound (8 errors)
2. ⏭️ Add getModelCount() to InformationSchemaTable
3. ⏭️ Add updateModelCount() to InformationSchemaTable

**Expected Result**: 129 → 121 errors (-8 errors)

### Phase 3: High Complexity Part 1

**Target**: Cms module (18 errors)

**Timeline**: Week 3

**Tasks**:
1. ⏭️ Create BlockData class
2. ⏭️ Fix getBlocksBySlug() static method
3. ⏭️ Fix ThemeComposer arguments
4. ⏭️ Fix Section component types

**Expected Result**: 121 → 103 errors (-18 errors)

### Phase 4: High Complexity Part 2

**Target**: Fixcity module (30+ errors)

**Timeline**: Week 4-5

**Tasks**:
1. ⏭️ Add missing methods to Ticket model
2. ⏭️ Fix relationship types
3. ⏭️ Fix type safety in seeders
4. ⏭️ Fix anonymous functions

**Expected Result**: 103 → 73 errors (-30 errors)

### Phase 5: Critical Complexity

**Target**: Tenant module (50+ errors)

**Timeline**: Week 6-7

**Tasks**:
1. ⏭️ Create SushiModelHelper trait
2. ⏭️ Add trait to all Sushi models
3. ⏭️ Fix method.notFound errors

**Expected Result**: 73 → 0 errors (-73 errors)

---

## 📊 Progress Tracking

| Phase | Errors Before | Errors After | Reduction | Status |
|-------|---------------|--------------|------------|--------|
| Baseline | 155+ | 138 | 17 | ✅ Complete |
| Phase 1 | 138 | 129 | 9 | ⏭️ In Progress |
| Phase 2 | 129 | 121 | 8 | ⏭️ Pending |
| Phase 3 | 121 | 103 | 18 | ⏭️ Pending |
| Phase 4 | 103 | 73 | 30 | ⏭️ Pending |
| Phase 5 | 73 | 0 | 73 | ⏭️ Pending |
| **Total** | **155+** | **0** | **155+** | **🎯 Target** |

---

## 🎯 Success Metrics

- **Primary Goal**: 0 PHPStan Level 10 errors
- **Secondary Goals**:
  - 100% factory coverage
  - 100% relationship type coverage
  - 100% method type coverage
  - 90% code coverage
  - <5% overhead from logging

---

## 📝 Notes

- All error counts are approximate based on current analysis
- Some errors may be interdependent - fixing one may resolve multiple
- Complex modules may require multiple iterations
- Always verify fixes with `./vendor/bin/phpstan analyse Modules --level=10`

---

**Last Updated**: 2026-03-02  
**Current Status**: Phase 1 In Progress  
**Target Completion**: 2026-04-15 (6 weeks)  
**Analyst**: iFlow CLI