# Cyclomatic Complexity Refactoring Plan - Module Xot

**Created:** 2025-10-01  
**Status:** In Progress  
**Priority:** High

---

## 📋 Overview

This document outlines the refactoring plan for methods with high cyclomatic complexity (>10) in the Xot module.

## 🎯 Objectives

1. Reduce cyclomatic complexity to ≤10 for all methods
2. Improve code maintainability and testability
3. Follow SOLID principles and DRY/KISS patterns
4. Ensure all changes pass PHPStan level 3+ validation
5. Add comprehensive Pest tests for refactored code

---

## 🔴 High Complexity Methods Identified

### 1. ArtisanService::act (Complexity: 22)
**File:** `app/Services/ArtisanService.php`  
**Current Complexity:** 22  
**Target Complexity:** ≤10

**Issues:**
- Large switch statement with 20+ cases
- Multiple responsibilities (migrate, clear cache, routes, errors, modules)
- Violates Single Responsibility Principle

**Refactoring Strategy:**
1. Extract each case into dedicated command handler classes
2. Implement Command Pattern with a registry
3. Create separate services for:
   - `MigrationCommandHandler`
   - `CacheCommandHandler`
   - `RouteCommandHandler`
   - `ErrorCommandHandler`
   - `ModuleCommandHandler`

**Benefits:**
- Each handler has single responsibility
- Easy to test individually
- Easy to extend with new commands
- Reduces complexity from 22 to ~3

---

### 2. SearchTextInDbCommand::handle (Complexity: 18)
**File:** `app/Console/Commands/SearchTextInDbCommand.php`  
**Current Complexity:** 18  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract database search logic to `DatabaseSearchService`
2. Extract result formatting to `SearchResultFormatter`
3. Use early returns to reduce nesting

---

### 3. AssetAction::execute (Complexity: 17)
**File:** `app/Actions/File/AssetAction.php`  
**Current Complexity:** 17  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract asset resolution logic to separate methods
2. Use Strategy Pattern for different asset types
3. Implement guard clauses for early returns

---

### 4. RangeIntersectAction::execute (Complexity: 13)
**File:** `app/Actions/Array/RangeIntersectAction.php`  
**Current Complexity:** 13  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract range comparison logic to helper methods
2. Simplify conditional logic with guard clauses
3. Use collection methods to reduce complexity

---

### 5. GetTransKeyAction::execute (Complexity: 12)
**File:** `app/Actions/GetTransKeyAction.php`  
**Current Complexity:** 12  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract key resolution logic to separate methods
2. Use early returns for edge cases
3. Simplify nested conditionals

---

### 6. GetComponentsAction::execute (Complexity: 12)
**File:** `app/Actions/File/GetComponentsAction.php`  
**Current Complexity:** 12  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract component discovery logic
2. Use collection methods for filtering
3. Reduce nested loops

---

### 7. TransTrait::transFunc (Complexity: 11)
**File:** `app/Filament/Traits/TransTrait.php`  
**Current Complexity:** 11  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract translation resolution to service
2. Use guard clauses
3. Simplify fallback logic

---

### 8. SafeArrayCastAction::execute (Complexity: 11)
**File:** `app/Actions/Cast/SafeArrayCastAction.php`  
**Current Complexity:** 11  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract type checking to separate methods
2. Use polymorphism for different cast types
3. Simplify conditional chains

---

### 9. GetViewNameSpacePathAction::execute (Complexity: 11)
**File:** `app/Actions/File/GetViewNameSpacePathAction.php`  
**Current Complexity:** 11  
**Target Complexity:** ≤10

**Refactoring Strategy:**
1. Extract path resolution logic
2. Use early returns
3. Simplify namespace handling

---

## 📅 Implementation Timeline

### Phase 1: Critical Methods (Week 1)
- [ ] Refactor `ArtisanService::act` (Priority: URGENT)
- [ ] Create comprehensive tests
- [ ] Validate with PHPStan

### Phase 2: High Priority Methods (Week 2)
- [ ] Refactor `SearchTextInDbCommand::handle`
- [ ] Refactor `AssetAction::execute`
- [ ] Create tests for both

### Phase 3: Moderate Priority Methods (Week 3)
- [ ] Refactor remaining methods (complexity 11-13)
- [ ] Create comprehensive test suite
- [ ] Documentation updates

---

## 🧪 Testing Strategy

For each refactored method:

1. **Unit Tests** (Pest)
   - Test each extracted method independently
   - Test edge cases and error conditions
   - Aim for 100% code coverage

2. **Integration Tests**
   - Test the complete flow
   - Test with real data scenarios
   - Test error handling

3. **PHPStan Validation**
   - Run PHPStan level 3+ on each file
   - Ensure no new errors introduced
   - Fix any type-related issues

---

## 📊 Success Metrics

- ✅ All methods have complexity ≤10
- ✅ PHPStan level 3+ passes without errors
- ✅ Test coverage ≥90%
- ✅ No breaking changes to public APIs
- ✅ Documentation updated

---

## 🔗 Related Documents

- [Cyclomatic Complexity Report](../cyclomatic-complexity-report.md)
- [Testing Best Practices](../testing/testing-best-practices.md)
- [PHPStan Workflow](../phpstan-workflow.md)
- [Refactoring Guidelines](../best-practices.md)

---

*Document maintained by: Development Team*  
*Last Updated: 2025-10-01*
