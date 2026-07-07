# PHP coding standards (strict)

## Always required

```php
<?php declare(strict_types=1);

public function __construct(
    public readonly UserService $userService,
    public string $mode = 'default'
) {}

public function calculateTotal(array $items): float
{
    // implementation
}

public function processData(string|int $value): string|int
{
    return $value;
}
```

## Forbidden

- `mixed` parameters/returns (unless unavoidable and explicitly justified)
- Missing return types
- Untyped parameters (except variadic)
- Bare `array` without key/value types in PHPDoc when needed (`array<string, int>` etc.)

## Import ordering

```php
<?php declare(strict_types=1);

use Filament\Forms;
use Filament\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Modules\User\Filament\Resources\UserResource;

use function Safe\json_decode;
```
