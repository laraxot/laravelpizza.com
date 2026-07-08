# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.
# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.

## Naming Conventions

1. **File Naming**:
   - All enum files MUST end with `Enum.php` (e.g., `AppointmentTypeEnum.php`)
   - The class name MUST match the filename (without `.php`)
   - **CRITICAL**: Il nome della classe DEVE includere il suffisso `Enum` (e.g., `enum AppointmentTypeEnum: string`)
   - **ERRATO**: `enum AppointmentType: string` in un file chiamato `AppointmentTypeEnum.php`
   - **CORRETTO**: `enum AppointmentTypeEnum: string` in un file chiamato `AppointmentTypeEnum.php`

2. **Class Naming**:
   - Use PascalCase for enum class names
   - Always suffix with `Enum` (e.g., `AppointmentTypeEnum`)

## Implementation Guidelines

1. **Basic Structure**:
   ```php
   <?php
   
   declare(strict_types=1);
   
   namespace Modules\YourModule\Enums;
   
   use Filament\Support\Contracts\HasLabel;
   
   enum YourEnumNameEnum: string implements HasLabel
   {
       case EXAMPLE = 'example';
       
       public function getLabel(): ?string
       {
           return match ($this) {
               self::EXAMPLE => __('your_module::app.example_label'),
           };
       }
   }
   ```

2. **Backward Compatibility**:
   - Always include a class alias for backward compatibility:
   ```php
   // Alias for backward compatibility
   class_alias(YourEnumNameEnum::class, 'Modules\\YourModule\\Enums\\YourEnumName');
   ```

3. **Using Enums in Filament**:
   ```php
   use Modules\YourModule\Enums\YourEnumNameEnum;
   
   // In your form/table
   Select::make('field_name')
       ->options(YourEnumNameEnum::class)
   ```

## Best Practices

1. **Always implement `HasLabel`** for Filament compatibility
2. **Use translation keys** for all labels
3. **Keep enum values in lowercase** for consistency
4. **Document each case** with PHPDoc if the purpose isn't immediately clear
5. **Group related enums** in the same file when appropriate

## Example: Complete Enum Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\<nome progetto>\Enums;
namespace Modules\<nome progetto>\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Represents different types of appointments in the system.
 */
enum AppointmentTypeEnum: string implements HasLabel
{
    case CONSULTATION = 'consultation';
    case CLEANING = 'cleaning';
    // ... other cases
    
    /**
     * Get the human-readable label for the enum case.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            // ... other cases
        };
    }
}

// Alias for backward compatibility
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
```

## Updating Existing Enums

1. Rename the file to include the `Enum` suffix
2. Update the class name to match
3. Add the backward compatibility alias
4. Update all references in the codebase
5. Run `composer dump-autoload`

## Common Issues

1. **Class not found**: Ensure the class name matches the filename exactly
2. **Translation not working**: Verify the translation key exists in the language files
3. **Backward compatibility issues**: Check that the alias is correctly defined
