# PHP Syntax Errors Block PHPStan Analysis

## Problem
PHPStan bootstrap fails with cryptic errors when any PHP file in the analyzed path has a syntax error:

```
PHP Fatal error: syntax error, unexpected token "<", expecting ";" or "{"
```

## Root Cause
PHPStan bootstraps the Laravel application before analysis. If any discovered file (e.g., Filament widgets discovered via `discoverWidgets()`) has a syntax error, the bootstrap fails and PHPStan exits without analyzing anything.

## Common Syntax Errors Found
1. **Space before colon in function signature** (invalid PHP syntax):
   ```php
   // WRONG - syntax error
   public function getFormSchema(): array<int, TextInput|Grid>
   
   // CORRECT
   public function getFormSchema(): array
   ```

2. **Void method returning value** (fatal error in PHP 8):
   ```php
   // WRONG - void method returns value
   public function someVoidMethod(): void
   {
       return $media->toInlineResponse($request); // FATAL
   }
   
   // CORRECT
   public function someVoidMethod(): void
   {
       $media->toInlineResponse($request); // Just call, don't return
   }
   ```

3. **Missing `<?php` tag** - file starts with `<` character

## Detection Command
```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
find Modules -name "*.php" -exec php -l {} \; 2>&1 | grep -v "No syntax errors"
```

## Files Fixed This Session
- `Modules/UI/app/Filament/Widgets/UserCalendarWidget.php` - fixed `function ():` to `function():`
- `Modules/Media/app/Filament/Tables/Columns/IconMediaColumn.php` - removed return from void method
- `Modules/AI/app/Providers/EventServiceProvider.php` - removed typed `$listen` property
- `Modules/Xot/app/Models/XotBaseModel.php` - removed typed `$appends` property

## Bad Practice
- Assuming PHPStan errors are type issues - always check for syntax errors first
- Using `function (): void` with space before colon (invalid PHP 8 syntax)

## Good Practice
- Run `php -l filename.php` before running PHPStan
- Use `sed -i 's/function ()/function()/g'` to fix space-before-colon syntax errors globally
- Check PHPStan bootstrap errors carefully - they often indicate syntax errors, not type errors

## False Friends
- **`function (): void` looks right** - IDE might not flag it, but it's invalid PHP syntax
- **Void methods can't return** - even returning `null` or calling another method that returns is fatal

## Prevention
```bash
# Find all files with space before colon in function signature
grep -r "function ()" Modules/*/app/Filament/ --include="*.php" | grep -v "function()"
```

## Related
- Story 8-121: PHPStan Modules Full Quality Gate
- Commit: "Fix syntax errors blocking PHPStan analysis"
