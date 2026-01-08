# Enums Naming Convention

## Naming Rules
1. All enum classes must end with `Enum` suffix
2. Use `PascalCase` for enum names
3. Use `UPPER_SNAKE_CASE` for enum cases
4. Place enums in the `App\Enums` namespace of each module

## Examples

### ✅ CORRECT
```php
// File: Modules/ModuleName/app/Enums/UserTypeEnum.php
namespace Modules\ModuleName\Enums;

enum UserTypeEnum: string
{
    case ADMIN = 'admin';
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
}
```

### ❌ INCORRECT
```php
// Missing Enum suffix
class UserType {}

// Wrong case naming
enum user_type_enum {}

// Wrong case values
enum UserTypeEnum {
    case Admin;
    case PatientUser;
}
```

## Best Practices
1. Always type-hint enums in method parameters and return types
2. Use `::cases()` to get all possible values
3. Implement `fromValue()` and `tryFromValue()` methods when needed
4. Add proper PHPDoc blocks for better IDE support

## Migration Guide
When renaming enums to follow this convention:
1. Rename the file to include `Enum` suffix
2. Update the class name to include `Enum` suffix
3. Update all references to the enum in your codebase
4. Run tests to ensure everything works as expected
