# Trait Method Signature Rules

## 🚨 Critical Rule: Static vs Non-Static Methods

**NEVER declare methods as static in traits unless they are explicitly designed to be static.**

## 📋 Method Signature Compatibility

### Filament Method Expectations

| Method | Expected Signature | Purpose |
|--------|-------------------|---------|
| `getModelLabel()` | `public function getModelLabel(): string` | Returns singular model label |
| `getPluralModelLabel()` | `public function getPluralModelLabel(): string` | Returns plural model label |
| `getTitle()` | `public function getTitle(): string` | Returns page title |
| `getHeading()` | `public function getHeading(): string` | Returns page heading |
| `getSubHeading()` | `public function getSubHeading(): string` | Returns page subheading |

## ⚠️ Common Error Pattern

**WRONG:** Static method in trait
```php
trait NavigationPageLabelTrait
{
    public static function getModelLabel(): string // ❌ WRONG
    {
        return static::trans('navigation.name');
    }
}
```

**CORRECT:** Non-static method in trait
```php
trait NavigationPageLabelTrait
{
    public function getModelLabel(): string // ✅ CORRECT
    {
        return static::trans('navigation.name');
    }
}
```

## 🔍 Root Cause Analysis

The error "Cannot make static method non static" occurs when:

1. A trait declares a method as `static`
2. A class using the trait inherits from a parent class
3. The parent class already declares the same method as non-static
4. PHP cannot reconcile the conflicting signatures

## 🛡️ Prevention Strategy

### 1. Always Check Parent Class First
Before adding methods to a trait, verify the method signatures in:
- Parent classes
- Interfaces implemented
- Framework base classes

### 2. Use Interface-Driven Development
```php
interface NavigationLabelInterface
{
    public function getModelLabel(): string;
    public function getPluralModelLabel(): string;
}

// Then implement in trait
```

### 3. Documentation First
Document expected method signatures before implementation:
```php
/**
 * @method string getModelLabel() Returns the singular model label
 * @method string getPluralModelLabel() Returns the plural model label
 */
trait NavigationPageLabelTrait
{
    // Implementation
}
```

## 🧪 Validation Checklist

Before committing any trait:

1. [ ] Verify all methods match parent class signatures
2. [ ] No methods are declared as `static` unless absolutely necessary
3. [ ] Method return types match expected signatures
4. [ ] Parameter types and counts match
5. [ ] Access levels (public/protected) match

## 📚 Framework-Specific Rules

### Filament Specifics
- **Resources**: Methods are generally non-static
- **Pages**: Methods are generally non-static  
- **Widgets**: Methods are generally non-static
- **Actions**: Methods are generally non-static

### Laravel Conventions
- **Service Providers**: Static registration methods
- **Models**: Mixed static/non-static methods
- **Controllers**: Primarily non-static methods
- **Commands**: Primarily non-static methods

## 🔧 Automatic Validation

Add PHPStan rules to detect static method issues:

```neon
# phpstan.neon
rules:
  - rule: StaticMethodInTraitRule
    traits:
      - Modules\Xot\Filament\Traits\*
```

## 🚨 Emergency Fix Procedure

If you encounter this error:

1. **Identify the conflicting method** in the trait
2. **Remove the `static` keyword** from the method declaration
3. **Verify the method signature** matches parent expectations
4. **Test thoroughly** to ensure no breaking changes

## 📖 Related Documentation

- [PHP Trait Manual](https://www.php.net/manual/en/language.oop5.traits.php)
- [Filament Method Signatures](https://filamentphp.com/docs)
- [Laravel Code Standards](../laravel_code_standards.md)

---

*Last Updated: 2025-08-27*  
*Trait Standards Version: 2.0*