# Xot Module - PHPStan Fix Plan

## Current Status

**Errors**: 3 errors
- CountAction.php: 2 errors
- UpdateCountAction.php: 1 error
- XotBaseEditRecord.php: 1 error (shared with Filament)

## Issues Analysis

### 1. InformationSchemaTable Missing Methods (2 errors)

**Files Affected**:
- `app/Actions/ModelClass/CountAction.php`
- `app/Actions/ModelClass/UpdateCountAction.php`

**Missing Methods**:
```php
public static function getModelCount(): int
public static function updateModelCount(): void
```

**Root Cause**: InformationSchemaTable model doesn't implement these static methods required by Actions.

**Fix Plan**:
1. Add `getModelCount()` method to InformationSchemaTable
   - Count records in the information_schema
   - Return integer count
   - Handle empty table case

2. Add `updateModelCount()` method to InformationSchemaTable
   - Update cached count in metadata
   - Use Sushi's JSON storage
   - Implement proper error handling

**Implementation**:
```php
// app/Models/InformationSchemaTable.php

public static function getModelCount(): int
{
    return static::count();
}

public static function updateModelCount(): void
{
    // Update count in JSON file if using Sushi
    // Or refresh model cache
    static::all()->count();
}
```

### 2. XotBaseEditRecord Argument Type (1 error)

**File**: `app/Filament/Resources/Pages/XotBaseEditRecord.php`

**Error**: Parameter type mismatch in `components()` method
- Expects: `array<Illuminate\Contracts\Support\Htmlable|string>|Closure|...`
- Receives: `array<int|string, Filament\Support\Components\Component>`

**Root Cause**: Filament 5 updated type expectations for schema components.

**Fix Plan**:
1. Review Filament 5 documentation for correct type
2. Adjust array structure if needed
3. Consider using proper type casting

**Implementation**:
```php
// Option 1: Adjust return type
/** @return array<int|string, mixed> */
protected function getFormSchema(): array
{
    return $this->resource->getFormSchema();
}

// Option 2: Type cast in components call
public function components(): array
{
    $schema = $this->getFormSchema();
    // Ensure proper type for Filament 5
    return array_values($schema);
}
```

## Dependencies

- Filament v5 documentation
- Sushi trait documentation
- PHPStan level 10 requirements

## Testing Requirements

1. Test CountAction execution
2. Test UpdateCountAction execution
3. Test XotBaseEditRecord with various resource types
4. Verify PHPStan passes after fixes

## Timeline

- Priority: MEDIUM
- Estimated effort: 2-3 hours
- Dependencies: None

## Success Criteria

- All 3 errors resolved
- Actions execute correctly
- Form schemas render properly
- PHPStan level 10 passes