# 3. Code Style Guidelines

### PHP Strict Types
```php
<?php

declare(strict_types=1);

namespace Modules\User\Models;
```

### Import Conventions
- Use FQCN (Fully Qualified Class Names)
- Group imports: internal Laravel → external packages → custom modules
- Sort alphabetically within groups
```php
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Profile;
use Spatie\QueueableAction\QueueableAction;
```

### Naming Conventions
| Element | Convention | Example |
|---------|------------|---------|
| Models | PascalCase | `User`, `EventRegistration` |
| Controllers | PascalCase + Controller suffix | `UserController` |
| Actions | Verb + Action suffix | `CreateEventAction` |
| Migrations | `create_{table}_table.php` | `2024_01_01_000000_create_users_table.php` |
| Blade Components | kebab-case | `language-switcher.blade.php` |
| Routes | kebab-case | `user-profile` |
| Tests | `{Class}Test.php` | `UserTest.php` |
| Variables | camelCase | `$userProfile` |
| Constants | UPPER_SNAKE_CASE | `MAX_RETRY_COUNT` |

### Type Declarations
- Always use return types
- Use union types where appropriate (PHP 8+)
- Nullable types with `?Type`
```php
public function execute(UserData $data): ?User
public function getName(): string|null
public function setConfig(array $config): void
```

### Model Conventions
- Use `casts()` method (NOT `$casts` property)
- Use `HasUuids`, `SoftDeletes`, `HasFactory` traits
- Define `$fillable` as typed array
- **ALWAYS use short array syntax `[]` instead of `array()`**
```php
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

### Error Handling
- Use exceptions with meaningful messages
- Throw in constructors only if critical
- Catch specific exceptions
- Never suppress errors with `@`

---

