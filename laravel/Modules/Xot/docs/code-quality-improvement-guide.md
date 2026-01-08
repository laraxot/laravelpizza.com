# Code Quality Improvement Guide

## Overview

This guide provides comprehensive instructions for improving code quality across all modules in the Laraxot PTVX application. Based on analysis using PHPStan, PHPMD, and PHPInsights tools.

## Quick Start

### Immediate Actions

1. **Fix Syntax Errors**
   ```bash
   # Check all PHP files for syntax errors
   find Modules -name "*.php" -exec php -l {} \;
   ```

2. **Remove Merge Conflicts**
   ```bash
   # Find and remove merge conflict markers
   
   ```

3. **Run Code Quality Tools**
   ```bash
   # PHPStan (Level 10)
   ./vendor/bin/phpstan analyse Modules/ --level=10

   # PHPMD
   ./vendor/bin/phpmd Modules/ text cleancode,codesize,controversial,design,naming,unusedcode

   # PHPInsights
   php vendor/bin/phpinsights analyse Modules/
   ```

## Tool-Specific Guidelines

### PHPStan (Level 10 Compliance)

#### Common Issues and Fixes

1. **Type Safety**
   ```php
   // ❌ Wrong
   public function getUser($id) {
       return User::find($id);
   }

   // ✅ Correct
   public function getUser(int $id): ?User {
       return User::find($id);
   }
   ```

2. **Magic Properties**
   ```php
   // ❌ Wrong - property_exists doesn't work with magic properties
   if (property_exists($model, 'email')) { ... }

   // ✅ Correct - Use isset() for magic properties
   if (isset($model->email)) { ... }

   // ✅ Correct - Use getAttribute() for explicit checks
   if ($model->getAttribute('email') !== null) { ... }
   ```

3. **Safe Functions**
   ```php
   // ❌ Wrong - Unsafe function
   $result = json_decode($json);

   // ✅ Correct - Use Safe\ functions
   use function Safe\json_decode;
   $result = json_decode($json);
   ```

### PHPMD Best Practices

#### Complexity Reduction

1. **Method Length**
   - Target: < 50 lines per method
   - Refactor long methods into smaller, focused methods

2. **Cyclomatic Complexity**
   - Target: < 10 per method
   - Extract complex conditions into separate methods

3. **Naming Conventions**
   ```php
   // ❌ Wrong
   $tmp_data = [];
   $value_pos = 0;

   // ✅ Correct
   $temporaryData = [];
   $valuePosition = 0;
   ```

### PHPInsights Standards

#### Architecture
- Follow Laraxot architectural patterns
- Use base classes (`XotBase*`) consistently
- Maintain modular separation

#### Code Style
- Use Laravel Pint for formatting
- Follow PSR-12 standards
- Maintain consistent naming conventions

## Module-Specific Improvements

### Chart Module

#### High Priority
- Refactor complex chart generation methods
- Reduce cyclomatic complexity in `GetGraphAction`
- Improve variable naming in chart actions

#### Example Refactoring
```php
// ❌ Complex method
public function execute(): Graph {
    // 100+ lines of complex logic
}

// ✅ Refactored
public function execute(): Graph {
    $data = $this->prepareChartData();
    $graph = $this->createGraph($data);
    $this->applyStyles($graph);
    return $graph;
}

private function prepareChartData(): array { ... }
private function createGraph(array $data): Graph { ... }
private function applyStyles(Graph $graph): void { ... }
```

### User Module

#### High Priority
- Fix trait method conflicts
- Resolve PSR-4 compliance issues in tests
- Improve test coverage and structure

### Xot Module (Core)

#### High Priority
- Ensure all base classes follow Laraxot patterns
- Maintain backward compatibility
- Document architectural decisions

## Testing Guidelines

### Test Structure
```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Tests\Unit;

use Tests\TestCase;

class YourClassTest extends TestCase
{
    public function test_method_behavior(): void
    {
        // Arrange
        $sut = new YourClass();

        // Act
        $result = $sut->method();

        // Assert
        $this->assertExpected($result);
    }
}
```

### Test Quality
- Follow PSR-4 naming conventions
- Use descriptive test method names
- Maintain test isolation
- Avoid `RefreshDatabase` trait when possible

## Documentation Standards

### Module Documentation Structure
```
Modules/{ModuleName}/docs/
├── README.md              # Module overview
├── models/                # Model documentation
│   └── README.md
├── architecture.md        # Technical architecture
└── code-quality.md        # Quality guidelines
```

### Documentation Content
- Use kebab-case for file names (except README.md)
- Include code examples
- Document architectural patterns
- Update documentation with code changes

## Continuous Improvement Process

### Daily Development
1. Run PHPStan before committing
2. Use Laravel Pint for formatting
3. Review PHPMD warnings
4. Update documentation as needed

### Weekly Review
1. Run comprehensive code quality analysis
2. Review and address technical debt
3. Update improvement guide
4. Share findings with team

### Monthly Assessment
1. Measure progress against quality metrics
2. Review architectural decisions
3. Update long-term improvement strategy
4. Document lessons learned

## Quality Metrics

### Target Scores
- **PHPStan**: Level 10 (100% compliance)
- **PHPMD**: < 50 violations per module
- **PHPInsights**:
  - Quality: > 80%
  - Complexity: > 70%
  - Architecture: > 75%
  - Style: > 85%

### Monitoring
- Track metrics over time
- Set improvement goals
- Celebrate quality improvements
- Share best practices

## Troubleshooting

### Common Issues

1. **PHPStan Errors**
   - Check type hints and return types
   - Verify magic property usage
   - Use Safe\ functions

2. **PHPMD Warnings**
   - Reduce method complexity
   - Improve naming conventions
   - Eliminate static access

3. **PHPInsights Failures**
   - Check syntax errors first
   - Verify PSR-4 compliance
   - Review architectural patterns

### Getting Help
- Review existing documentation
- Check module-specific guidelines
- Consult team members
- Update this guide with new findings

## Conclusion

This guide provides a comprehensive framework for improving and maintaining code quality across the Laraxot PTVX application. By following these guidelines and regularly using the provided tools, we can ensure high-quality, maintainable code that follows best practices and architectural standards.

**Remember**: Code quality is an ongoing process, not a one-time fix. Regular attention and continuous improvement will yield significant benefits in maintainability, reliability, and developer productivity.