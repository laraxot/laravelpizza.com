# PHPStan Guidelines and Best Practices

## Overview
This document provides comprehensive guidelines for maintaining code quality using PHPStan across all modules. It covers configuration, error prevention, and best practices for type-safe development.

## PHPStan Configuration Standards

### Base Configuration
```neon
# phpstan.neon
parameters:
    level: 9
    paths:
        - ./Modules/

    # Ignore specific error patterns
    ignoreErrors:
        - '#PHPDoc tag @mixin contains unknown class#'
        - '#Static call to instance method Nwidart#'
        - '#is used zero times and is not analysed#'

    # Exclude paths
    excludePaths:
        - ./*/vendor/*
        - ./*/tests/*
        - ./*/docs/*
```

### Module-Specific Configuration
Each module can have its own `phpstan.neon.dist` file for specific rules:

```neon
# Modules/Example/phpstan.neon.dist
includes:
    - ../../phpstan.neon

parameters:
    paths:
        - ./app/
        - ./database/

    # Module-specific ignore rules
    ignoreErrors:
        - '#Module-specific exception#'
```

## Type Declaration Standards

### Strict Typing
```php
declare(strict_types=1);

class Example
{
    // Always use type declarations
    public function process(string $input, int $count): array
    {
        return [];
    }
}
```

### PHPDoc Annotations
```php
/**
 * Process user data with validation
 *
 * @param array{id: int, name: string, email: string} $userData
 * @param non-empty-string $domain
 * @return array<string, string>
 *
 * @throws \InvalidArgumentException
 */
public function processUser(array $userData, string $domain): array
{
    // implementation
}
```

## Error Prevention Patterns

### 1. Null Safety
```php
// Use null-safe operator
$value = $object?->property?->subProperty;

// Provide defaults
$result = $nullableValue ?? 'default';

// Explicit null checks
if ($object !== null) {
    $value = $object->property;
}
```

### 2. Type Validation
```php
// Validate input types
public function calculateTotal($items): float
{
    if (!is_array($items) && !$items instanceof \Traversable) {
        throw new \InvalidArgumentException('Expected array or traversable');
    }

    $total = 0.0;
    foreach ($items as $item) {
        if (!is_numeric($item)) {
            throw new \InvalidArgumentException('All items must be numeric');
        }
        $total += (float)$item;
    }

    return $total;
}
```

### 3. Array and Collection Safety
```php
// Safe array access
public function getArrayValue(array $array, string $key, $default = null)
{
    return $array[$key] ?? $default;
}

// Collection type annotations
/** @var \Illuminate\\Support\\Collection<int, \stdClass> $results */
$filtered = $results->filter(fn($item) => $item->active);
```

## Dependency Management Guidelines

### 1. Cross-Module Dependencies
```php
// Use service contracts instead of concrete classes
interface UserServiceInterface
{
    public function findUser(int $id): ?User;
}

// In consuming module
public function __construct(private UserServiceInterface $userService) {}
```

### 2. Optional Dependencies
```php
// Check for class existence
if (class_exists('Modules\\Optional\\Service')) {
    $service = new \Modules\\Optional\\Service();
    $result = $service->process();
} else {
    // Fallback implementation
    $result = $this->fallbackProcess();
}
```

### 3. Service Location
```php
// Use Laravel's service container
public function process(): void
{
    if (app()->bound(ServiceInterface::class)) {
        $service = app()->make(ServiceInterface::class);
        $service->execute();
    }
}
```

## Testing and Quality Assurance

### 1. PHPStan Integration
```bash
# Run PHPStan analysis
vendor/bin/phpstan analyse --level=9 --memory-limit=2G

# Generate baseline
vendor/bin/phpstan analyse --generate-baseline

# Check specific module
vendor/bin/phpstan analyse Modules/User --level=9
```

### 2. CI/CD Integration
```yaml
# GitHub Actions example
name: PHPStan Analysis

on: [push, pull_request]

jobs:
  phpstan:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'

    - name: Install dependencies
      run: composer install --no-progress --prefer-dist

    - name: Run PHPStan
      run: vendor/bin/phpstan analyse --level=9 --error-format=github
```

### 3. Quality Gates
- **Level 7**: Basic type checking (minimum standard)
- **Level 8**: Strict type checking (recommended)
- **level 10**: Maximum strictness (ideal for new code)

## Common Issues and Solutions

### Issue: Missing Classes
**Solution**: Implement feature detection and fallbacks
```php
if (class_exists('Required\\Class')) {
    // Use the class
} else {
    // Log warning and use alternative
    logger()->warning('Required class not available');
    // Fallback implementation
}
```

### Issue: Type Mismatches
**Solution**: Add explicit type validation
```php
public function processUser($user): void
{
    if (!$user instanceof User) {
        throw new \InvalidArgumentException('Expected User instance');
    }

    // Safe to use $user-> methods
}
```

### Issue: Array Shape Problems
**Solution**: Use array shape annotations
```php
/**
 * @param array{id: int, name: string, email: string} $userData
 */
public function validateUser(array $userData): bool
{
    return isset($userData['id'], $userData['name'], $userData['email']);
}
```

## Code Organization Standards

### 1. Module Structure
```
Modules/
  Example/
    app/
      Models/
      Actions/
      DataObjects/
    database/
      factories/
      migrations/
    docs/
      phpstan/          # PHPStan documentation
    phpstan.neon.dist   # Module-specific config
```

### 2. Documentation Structure
```
docs/
  phpstan/
    phpstan_analysis_summary.md    # Overall analysis
    phpstan_error_patterns.md      # Common errors and solutions
    phpstan_guidelines.md          # This document
    module_specific/
      blog_phpstan_issues.md       # Module-specific issues
```

## Performance Optimization

### 1. Memory Management
```bash
# Increase memory limit for large codebases
vendor/bin/phpstan analyse --memory-limit=2G

# Use parallel processing
vendor/bin/phpstan analyse --parallel
```

### 2. Cache Configuration
```neon
# phpstan.neon
parameters:
    tmpDir: /tmp/phpstan
    # Enable result cache (PHPStan 1.0+)
    resultCache: true
```

## Maintenance and Updates

### 1. Regular Analysis
- Run PHPStan weekly to catch new issues
- Update baseline after major changes
- Monitor error trends over time

### 2. Dependency Updates
- Keep PHPStan and Larastan updated
- Review ignored errors regularly
- Remove obsolete ignore rules

### 3. Team Training
- Educate developers on PHPStan patterns
- Share common error solutions
- Encourage type-safe coding practices

## Emergency Procedures

### 1. Critical Errors
If PHPStan reports critical errors that block development:

1. **Temporary Ignore**: Add specific ignore rules
2. **Fix Immediately**: Address the root cause
3. **Remove Ignore**: Remove temporary rules once fixed

### 2. False Positives
For legitimate false positives:

```neon
# Add specific ignore with explanation
ignoreErrors:
    -
        message: '#Specific error pattern#'
        path: specific/file.php
        reason: 'False positive due to dynamic nature'
```

## Conclusion
Following these guidelines will help maintain high code quality across all modules. Regular PHPStan analysis, combined with these best practices, ensures type safety, reduces bugs, and improves maintainability.

**Key Principles**:
1. Always declare types explicitly
2. Use defensive programming techniques
3. Validate inputs and handle errors gracefully
4. Maintain clear documentation
5. Regular analysis and continuous improvement