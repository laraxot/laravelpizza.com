<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> ecd5ec32 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 5e6aa70fe (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> e39b54ba7 (.)
# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.
# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.
# Enum Standards in SaluteOra

This document defines the standards and best practices for working with Enums in the SaluteOra project.
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.
# Enum Standards in <nome progetto>

This document defines the standards and best practices for working with Enums in the <nome progetto> project.
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)

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
<<<<<<< HEAD
<<<<<<< HEAD
namespace Modules\<nome modulo>\Enums;
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
namespace Modules\<nome progetto>\Enums;
=======
>>>>>>> 62cc8443 (.)
namespace Modules\SaluteOra\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\SaluteOra\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\SaluteOra\Enums;
namespace Modules\<nome modulo>\Enums;
<<<<<<< HEAD
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\SaluteOra\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\<nome modulo>\Enums;
namespace Modules\SaluteOra\Enums;
=======
>>>>>>> d86d643a (.)
=======
namespace Modules\<nome modulo>\Enums;
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
namespace Modules\<nome modulo>\Enums;
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
namespace Modules\<nome modulo>\Enums;
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
namespace Modules\<nome modulo>\Enums;
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
namespace Modules\<nome progetto>\Enums;
>>>>>>> 551c768c4 (.)

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 7e4835b8e (.)
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('saluteora::app.consultation'),
            self::CLEANING => __('saluteora::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('saluteora::app.consultation'),
            self::CLEANING => __('saluteora::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('saluteora::app.consultation'),
            self::CLEANING => __('saluteora::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
<<<<<<< HEAD
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('saluteora::app.consultation'),
            self::CLEANING => __('saluteora::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
            self::CONSULTATION => __('saluteora::app.consultation'),
            self::CLEANING => __('saluteora::app.cleaning'),
=======
>>>>>>> d86d643a (.)
=======
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
            self::CONSULTATION => __('<nome progetto>::app.consultation'),
            self::CLEANING => __('<nome progetto>::app.cleaning'),
>>>>>>> 551c768c4 (.)
            // ... other cases
        };
    }
}

// Alias for backward compatibility
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> ab5b3a4f (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
<<<<<<< HEAD
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\Enums\\AppointmentType');
=======
>>>>>>> d86d643a (.)
=======
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
class_alias(AppointmentTypeEnum::class, 'Modules\\<nome progetto>\\Enums\\AppointmentType');
>>>>>>> 551c768c4 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 43d67f21 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 43d67f21 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> b7ea1cd1 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 43d67f21 (.)
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> b7ea1cd1 (.)
<<<<<<< HEAD
>>>>>>> ecd5ec32 (.)
=======
=======
>>>>>>> cc7fb225 (.)
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 53d6a6ba (.)
=======
>>>>>>> 71586de2 (.)
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 76bec91a (.)
<<<<<<< HEAD
>>>>>>> 5e6aa70fe (.)
=======
=======
>>>>>>> e7da37af (.)
<<<<<<< HEAD
>>>>>>> 7e4835b8e (.)
=======
=======
>>>>>>> 55fe1822 (.)
>>>>>>> e39b54ba7 (.)
=======
>>>>>>> 551c768c4 (.)
