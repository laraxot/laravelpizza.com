# Code Style Guidelines

Vedi [index](index.md) per navigazione completa.

## PHP Standards (STRICT - PHPStan Level 10 REQUIRED)

### ✅ ALWAYS Required
```php
<?php declare(strict_types=1);

// Use constructor property promotion (PHP 8+)
public function __construct(
    public readonly UserService $userService,
    public string $mode = 'default'
) {}

// Explicit return types ALWAYS
public function calculateTotal(array $items): float
{
    // implementation
}

// Strict typing - NO mixed types allowed
public function processData(string|int $value): string|int  // ✅ OK
public function processValue($data): mixed                   // ❌ FORBIDDEN
```

### ❌ ABSOLUTELY FORBIDDEN
- No `mixed` return types or parameters
- No untyped parameters (except variadic)
- No missing return type declarations
- No `array` without specific shape: use `array<string, int>` or similar

## Naming Conventions
```bash
# Files - kebab-case
user-profile-manager.php
chart-widget-service.php

# Classes - PascalCase
class UserProfileManager
class ChartWidgetService

# Methods/Properties - camelCase
public function getUserData()
private $chartService

# Constants - UPPER_SNAKE_CASE
const MAX_FILE_SIZE = 1024;
const DEFAULT_TIMEOUT = 30;
```

## Import Organization
```php
<?php declare(strict_types=1);

// 1. External libraries (alphabetical)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Filament\Forms;
use Filament\Tables;

// 2. Application imports (alphabetical)
use App\Models\User;
use App\Services\UserService;
use Modules\User\Filament\Resources\UserResource;

// 3. Function imports (if any)
use function Safe\json_decode;
use function Illuminate\Support\str;
```

## Error Handling
```php
// ✅ CORRECT - Use exceptions, not false returns
public function getFileContents(string $path): string
{
    try {
        return Safe\file_get_contents($path);
    } catch (FileNotFoundException $e) {
        throw new UserServiceException("File not found: {$path}", 0, $e);
    }
}

// ❌ WRONG - Manual false checking
public function getFileContents(string $path)
{
    $content = file_get_contents($path);
    if ($content === false) {
        return null;  // Don't do this
    }
    return $content;
}
```

## Documentation Standards
```php
/**
 * Calculate user IVA for Italian invoices.
 *
 * @param float $amount Importo lordo
 * @param float $rate Aliquota IVA (default: 0.22)
 * @return float Importo IVA calcolato
 * @throws InvalidArgumentException When amount is negative
 */
public function calculateIVA(float $amount, float $rate = 0.22): float
{
    if ($amount < 0) {
        throw new InvalidArgumentException('Amount cannot be negative');
    }
    
    return $amount * $rate;
}
```

## Riferimenti

- [index](index.md)
- [critical-rules](critical-rules.md)
