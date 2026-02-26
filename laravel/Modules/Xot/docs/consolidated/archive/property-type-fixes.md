# Property Type Fixes for Xot Module

## Missing Property Types

### 1. ArtisanCommandsManager::$listeners Property

**Error Message:**
```
Property Modules\Xot\Filament\Pages\ArtisanCommandsManager::$listeners has no type specified.
```

**File Location:**
`Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

**Problem Analysis:**
The `$listeners` property in the ArtisanCommandsManager class is missing a type declaration, which is required for PHPStan level 7 compliance and is a best practice for type safety.

**Implementation Strategy:**
- Add the appropriate array type declaration for the $listeners property
- Follow Laraxot framework type safety standards
- Ensure backward compatibility with existing code

### 2. XotBaseWidget::$view Property Type Mismatch

**Error Message:**
```
Static property Modules\Xot\Filament\Widgets\XotBaseWidget::$view (view-string) does not accept string.
```

**File Location:**
`Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

**Problem Analysis:**
The static property `$view` in XotBaseWidget is declared with a type of `view-string`, but it's being assigned a value that PHPStan recognizes as a regular string. The property needs to properly accept and handle view string values according to Laravel's view resolution system.

**Implementation Strategy:**
- Update the property type annotation to match the expected value type
- Use PHPDoc or type casting to ensure type compatibility
- Follow Laravel view-string conventions
