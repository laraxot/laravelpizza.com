# DRY + KISS Refactoring Checklist

## DRY (Don't Repeat Yourself) Violations

### Code Duplication
- [ ] **Same code pattern** repeated 3+ times → Extract to helper method
- [ ] **Database queries** duplicated → Create repository/query scope
- [ ] **Validation rules** repeated → Extract to form request class
- [ ] **Business logic** scattered → Create service/action class
- [ ] **API responses** formatted multiple ways → Use API resource class

### Data Transformation
- [ ] **Date formatting** repeated → Create date helper
- [ ] **Type casting** repeated → Create casting helper
- [ ] **Array manipulation** repeated → Create collection helper
- [ ] **String formatting** repeated → Create formatting helper

### Configuration
- [ ] **Hardcoded values** in multiple places → Move to config file
- [ ] **Magic numbers** scattered → Create named constants
- [ ] **Email templates** inline → Extract to blade templates
- [ ] **SQL snippets** repeated → Create query builder methods

## KISS (Keep It Simple, Stupid) Violations

### Method Complexity
- [ ] **Methods > 30 lines** → Split into smaller methods
- [ ] **Cyclomatic complexity > 10** → Simplify conditional logic
- [ ] **Nested if/else > 3 levels** → Use early returns or polymorphism
- [ ] **Multiple responsibilities** in one method → Extract to separate methods
- [ ] **Complex algorithms** → Delegate to dedicated classes

### Class Complexity
- [ ] **Classes > 300 lines** → Split into smaller classes
- [ ] **Too many dependencies** → Apply dependency injection principles
- [ ] **God classes** with everything → Separate concerns
- [ ] **Mixed responsibilities** → Apply single responsibility principle

### Code Clarity
- [ ] **Unclear variable names** → Use descriptive names
- [ ] **Complex expressions** → Break into intermediate variables
- [ ] **Magic numbers** → Replace with named constants
- [ ] **Long parameter lists** → Use data objects or parameter objects
- [ ] **Confusing logic** → Add explanatory comments or extract methods

## Clean Code Violations

### Dead Code
- [ ] **Commented-out code** → Delete (use Git for history)
- [ ] **Unused imports** → Remove
- [ ] **Unused variables** → Remove
- [ ] **Unused private methods** → Remove
- [ ] **Empty catch blocks** → Add proper error handling

### Debug Code
- [ ] **dd()/var_dump()** statements → Remove
- [ ] **console.log()** in production → Remove
- [ ] **Temporary logging** → Remove or make conditional
- [ ] **Development-only code** → Remove or make environment-specific

### Code Formatting
- [ ] **Inconsistent indentation** → Use PSR-12
- [ ] **Missing spaces** around operators → Fix formatting
- [ ] **Long lines** (>120 chars) → Break into multiple lines
- [ ] **Inconsistent brace placement** → Follow PSR-12

## SOLID Principles Check

### Single Responsibility
- [ ] **Classes doing too many things** → Split responsibilities
- [ ] **Methods with multiple purposes** → Extract focused methods
- [ ] **Mixed concerns** → Separate into different classes

### Open/Closed
- [ ] **Modifying existing code for new features** → Use inheritance/extension
- [ ] **Hardcoded conditionals** → Use polymorphism
- [ ] **Switch statements for types** → Use strategy pattern

### Liskov Substitution
- [ ] **Subclasses breaking parent contracts** → Fix method signatures
- [ ] **Inconsistent behavior** in inheritance hierarchies → Align behavior
- [ ] **Type violations** in subtypes → Ensure compatibility

### Interface Segregation
- [ ] **Fat interfaces** → Split into smaller interfaces
- [ ] **Unused interface methods** → Create specific interfaces
- [ ] **Forced implementations** → Use role interfaces

### Dependency Inversion
- [ ] **Direct class instantiations** → Use dependency injection
- [ ] **Tight coupling** → Depend on abstractions
- [ ] **Concrete dependencies** → Use interfaces/contracts

## Performance Issues

### N+1 Queries
- [ ] **Missing eager loading** → Add `with()` clauses
- [ ] **Looping queries** → Use eager loading or batch operations
- [ ] **Individual record updates** → Use batch updates

### Memory Usage
- [ ] **Large collections in memory** → Use chunking/pagination
- [ ] **Unnecessary data loading** → Select only needed columns
- [ ] **Memory leaks** → Properly dispose resources

### Caching Opportunities
- [ ] **Expensive operations** not cached → Add caching layer
- [ ] **Repeated computations** → Cache results
- [ ] **Database calls** → Cache query results

## Security Issues

### Input Validation
- [ ] **Missing validation** → Add comprehensive validation
- [ ] **Weak validation rules** → Strengthen rules
- [ ] **Mass assignment** vulnerabilities → Use fillable/guarded

### Authentication & Authorization
- [ ] **Missing authorization checks** → Add proper gates/policies
- [ ] **Insecure direct object references** → Use authorization
- [ ] **Session fixation** → Implement proper session handling

### Data Exposure
- [ ] **Sensitive data in logs** → Sanitize log data
- [ ] **API responses** with sensitive data → Use API resources
- [ ] **Debug information** in production → Disable debug mode

## Testing Gaps

### Unit Tests
- [ ] **Untested business logic** → Add unit tests
- [ ] **Untested helper methods** → Test utilities
- [ ] **Untested validation rules** → Test custom rules

### Feature Tests
- [ ] **Untested user flows** → Add feature tests
- [ ] **Untested API endpoints** → Test API responses
- [ ] **Untested form submissions** → Test form handling

### Integration Tests
- [ ] **Untested module interactions** → Add integration tests
- [ ] **Untested database operations** → Test data persistence
- [ ] **Untested external service calls** → Mock and test

## Documentation Needs

### Code Documentation
- [ ] **Missing PHPDoc** → Add comprehensive documentation
- [ ] **Outdated comments** → Update to reflect current code
- [ ] **Missing parameter descriptions** → Document all parameters

### API Documentation
- [ ] **Undocumented endpoints** → Add OpenAPI/Swagger docs
- [ ] **Missing response schemas** → Document response formats
- [ ] **Unclear error responses** → Document error codes

### User Documentation
- [ ] **Missing user guides** → Create usage documentation
- [ ] **Outdated screenshots** → Update visual documentation
- [ ] **Incomplete feature docs** → Document all features

---

## Implementation Priority

### 🚨 Critical (Fix Immediately)
- Security vulnerabilities
- Data corruption bugs
- Performance bottlenecks affecting production
- Breaking API changes

### ⚠️ High Priority (Fix This Sprint)
- Code duplication affecting maintenance
- Missing critical tests
- Complex methods blocking development
- Database performance issues

### 📋 Medium Priority (Fix When Possible)
- Code style inconsistencies
- Missing non-critical documentation
- Minor performance optimizations
- Test coverage gaps

### 📝 Low Priority (Technical Debt)
- Old TODO comments
- Minor code style issues
- Optimization opportunities
- Additional documentation

---

**Purpose**: Comprehensive checklist for code quality improvement
**Usage**: Run through this checklist during code reviews and refactoring sessions
