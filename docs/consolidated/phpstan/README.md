# PHPStan Documentation Hub

## Overview
This directory contains comprehensive documentation for PHPStan analysis, error patterns, and best practices across all modules. The documentation is organized to help developers understand, prevent, and fix PHPStan errors effectively.

## Documentation Structure

### Core Documents

1. **`phpstan_analysis_summary.md`**
   - Comprehensive analysis of current PHPStan errors
   - Error statistics by module and category
   - Recommended solutions and patterns

2. **`phpstan_error_patterns.md`**
   - Detailed patterns of common PHPStan errors
   - Specific solutions for each error type
   - Code examples and best practices

3. **`phpstan_guidelines.md`**
   - Coding standards and best practices
   - Configuration guidelines
   - Dependency management strategies

### Module-Specific Documentation

Each module should maintain its own PHPStan documentation in `Modules/[ModuleName]/docs/phpstan/` directory:

- `blog_phpstan_issues.md` - Blog module specific issues
- `user_phpstan_analysis.md` - User module analysis
- `[module]_phpstan_report.md` - Module-specific reports

## Current Status

### PHPStan Configuration
- **Level**: 9 (Strict type checking)
- **Total Errors**: 255 file errors across all modules
- **Ignored Patterns**: 12 specific error patterns

### Error Distribution
- **Class Not Found**: 15%
- **Property Not Found**: 20%
- **Type Declaration Issues**: 25%
- **Method Not Found**: 15%
- **Casting Issues**: 10%
- **Array/Collection Issues**: 15%

## Quick Start

### Running PHPStan
```bash
# Full analysis
vendor/bin/phpstan analyse --level=9 --memory-limit=2G

# Specific module
vendor/bin/phpstan analyse Modules/Blog --level=9

# Generate JSON report
vendor/bin/phpstan analyse --error-format=json
```

### Common Fixes

1. **Missing Classes**: Use `class_exists()` checks
2. **Property Access**: Use null-safe operators (`?->`)
3. **Type Issues**: Add explicit type declarations
4. **Method Calls**: Check `method_exists()` before calling

## Best Practices

### 1. Type Safety
```php
declare(strict_types=1);

// Always declare types
public function process(string $input, int $count): array
{
    return [];
}
```

### 2. Defensive Programming
```php
// Use null-safe operators
$value = $object?->property;

// Check method existence
if (method_exists($object, 'method')) {
    $result = $object->method();
}
```

### 3. Proper PHPDoc
```php
/**
 * @param array{id: int, name: string} $data
 * @return array<string, string>
 */
public function process(array $data): array
{
    return ['status' => 'processed'];
}
```

## Module Maintenance

### Adding New Module Documentation
1. Create `Modules/[ModuleName]/docs/phpstan/` directory
2. Add module-specific analysis document
3. Update links in main documentation
4. Run module-specific PHPStan analysis

### Updating Documentation
1. Run PHPStan analysis to get current errors
2. Update relevant documentation files
3. Verify fixes with follow-up analysis
4. Commit changes with descriptive messages

## CI/CD Integration

### GitHub Actions Example
```yaml
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
        run: composer install
      - name: Run PHPStan
        run: vendor/bin/phpstan analyse --level=9 --error-format=github
```

## Troubleshooting

### Common Issues
1. **Memory Limits**: Use `--memory-limit=2G`
2. **False Positives**: Add specific ignore rules
3. **Missing Dependencies**: Check class existence
4. **Configuration Issues**: Verify phpstan.neon

### Getting Help
1. Check existing documentation first
2. Review similar error patterns
3. Consult module-specific documentation
4. Create issue if problem persists

## Related Documents

- [PHPStan Official Documentation](https://phpstan.org/)
- [Larastan Documentation](https://github.com/larastan/larastan)
- [Module Development Guidelines](../module_development.md)
- [Coding Standards](../coding_standards.md)

## Contributing

When contributing to PHPStan documentation:

1. **Run Analysis**: Always run current PHPStan analysis
2. **Document Patterns**: Add new error patterns and solutions
3. **Update Examples**: Keep code examples current
4. **Verify Fixes**: Test suggested solutions work
5. **Cross-reference**: Link related documents

## Version History

- **2025-01-22**: Initial comprehensive documentation
- **2025-01-15**: Module-specific analysis began
- **2025-01-10**: PHPStan level 9 configuration implemented

## Support

For questions about PHPStan configuration or error resolution:

1. Check this documentation first
2. Review module-specific documentation
3. Consult the PHPStan error messages
4. Create an issue if needed

---

*This documentation is maintained as part of our commitment to code quality and type safety across all modules.*