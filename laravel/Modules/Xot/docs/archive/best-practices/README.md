# Best Practices

## Laraxot Framework Standards

### Models
- ALWAYS extend module's BaseModel
- NEVER extend Eloquent\Model directly
- Use `declare(strict_types=1);` in all files
- Implement `casts()` method, not `$casts` property

### Filament Resources
- ALWAYS extend XotBaseResource
- NEVER use `->label()` method
- Return associative arrays from `getFormSchema()`
- Use enum classes instead of hardcoded options

### Migrations
- Use anonymous classes extending XotBaseMigration
- NEVER implement `down()` method
- Always check existence with `hasTable()` and `hasColumn()`
- Copy original migration with new timestamp for column additions

### Translations
- Use expanded structure ALWAYS
- NEVER remove existing keys
- Maintain consistency across all languages (IT/EN/DE)
- Use snake_case for all keys

## Code Quality
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- PHPStan level 9+ for all new code
- Complete PHPDoc annotations
- Use Safe library for unsafe functions
- Follow PSR-12 coding standards

## Documentation
- All files in docs/ must be lowercase (except README.md)
- Create bidirectional links between related documents
- Update both module and root documentation
- Include practical examples in all guides
