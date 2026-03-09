# Testing Standards - PSR-4 and Autoloading

## PSR-4 Compliance for Test Helpers

All helper classes (Dummies, Proxies, TestModels) defined within the `tests/` directory MUST comply with PSR-4 autoloading standards to avoid PHPStan errors and ensure consistent discovery.

### 1. Mandatory Namespacing

Every class defined in a test file must have a namespace that matches its directory structure relative to the `tests/` folder.

- **Rule**: `Modules\<ModuleName>\Tests\` maps to `./Modules/<ModuleName>/tests`
- **Example**: A class in `Modules/Notify/tests/Unit/Traits/MyTest.php` should have the namespace `Modules\Notify\Tests\Unit\Traits;`.

### 2. Handling Dummy/Helper Classes

#### Option A: Inline Helpers (Specific to one test)
If a Dummy class is used ONLY in one test file, it can stay in that file but **MUST** have the correct namespace.

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;

class NotifyRateLimitDummy extends Model 
{
    // ...
}
```

#### Option B: Shared Helpers (Reusable)
If a Dummy class is used across multiple tests, it MUST be moved to its own file in a `Support` or `Helpers` directory.

- **Path**: `Modules/Notify/tests/Support/NotifyRateLimitDummy.php`
- **Namespace**: `Modules\Notify\Tests\Support;`

### 3. PHPStan Compliance

PHPStan Level 10 is strict about class discovery. Missing or incorrect namespaces in tests will trigger "does not comply with psr-4 autoloading standard" warnings.

- **Avoid**: Defining classes in the global namespace within test files.
- **Avoid**: Defining classes whose name doesn't match the filename (unless they are internal helpers and namespaced correctly).

### 4. Verification

After making changes to test namespaces or structures:

```bash
# Refresh autoloading
composer dump-autoload

# Run PHPStan on the specific module
./vendor/bin/phpstan analyse Modules/<ModuleName> --level=10
```

---
*Standards: PSR-4, PHP 8.3, Laraxot Methodology*
