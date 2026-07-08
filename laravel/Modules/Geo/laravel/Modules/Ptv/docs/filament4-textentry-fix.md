# Filament 4 TextEntry Fix

## Problem
The error "Class 'Filament\Forms\Components\TextEntry' not found" occurred when using TextEntry in a form context.

## Root Cause
In Filament 4.x, `TextEntry` is not a form component but an infolist component. The correct namespace is:
- ❌ `Filament\Forms\Components\TextEntry` (Forms namespace - incorrect)
- ✅ `Filament\Infolists\Components\TextEntry` (Infolists namespace - correct)

## Solution
When using TextEntry in Filament 4.x:

1. **Import the correct namespace:**
   ```php
   use Filament\Infolists\Components\TextEntry;
   ```

2. **Use the correct method:**
   - In forms: Use `Placeholder::make()` with `content()` method
   - In infolists: Use `TextEntry::make()` with `state()` method

## Example Fix
**Before (incorrect):**
```php
use Filament\Forms\Components\TextEntry;

TextEntry::make('records_count')
    ->label('Count')
    ->state(function ($get): string {
        // ...
    })
```

**After (correct):**
```php
use Filament\Infolists\Components\TextEntry;

TextEntry::make('records_count')
    ->label('Count')
    ->state(function ($get): string {
        // ...
    })
```

## Alternative for Forms
If you need a similar component in forms, use `Placeholder`:
```php
use Filament\Forms\Components\Placeholder;

Placeholder::make('records_count')
    ->label('Count')
    ->content(function ($get): string {
        // ...
    })
```

## Files Updated
- `Modules/Ptv/app/Filament/Actions/Header/DeleteCessatiAction.php` - Fixed TextEntry import and usage