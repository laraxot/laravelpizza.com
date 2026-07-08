# Naming Conventions

## PHP Naming Standards

### Classes and Interfaces

```php
<?php

declare(strict_types=1);

// ✅ CORRECT - PascalCase for classes
namespace Modules\User\Models;

class User extends BaseModel
{
    // Implementation
}

interface UserRepositoryInterface
{
    // Contract definition
}

// ✅ CORRECT - Abstract classes
abstract class BaseRepository implements RepositoryInterface
{
    // Common functionality
}

// ✅ CORRECT - Traits
trait HasTimestamps
{
    // Reusable functionality
}
```

### Methods and Functions

```php
<?php

declare(strict_types=1);

class UserService
{
    // ✅ CORRECT - camelCase for methods
    public function createUser(array $data): User
    {
        // Implementation
    }

    public function updateUser(User $user, array $data): User
    {
        // Implementation
    }

    public function deleteUser(User $user): bool
    {
        // Implementation
    }

    // ✅ CORRECT - Private methods with underscore prefix if needed
    private function validateUserData(array $data): array
    {
        // Implementation
    }
}
```

### Properties and Variables

```php
<?php

declare(strict_types=1);

class User extends BaseModel
{
    // ✅ CORRECT - camelCase for properties
    public string $firstName;
    protected string $lastName;
    private array $preferences;

    // ✅ CORRECT - Constants in UPPER_SNAKE_CASE
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    private const CACHE_TTL = 3600;

    public function __construct()
    {
        // ✅ CORRECT - camelCase for variables
        $defaultPreferences = [
            'theme' => 'light',
            'language' => 'it',
        ];

        $this->preferences = $defaultPreferences;
    }
}
```

## Database Naming

### Tables

```sql
-- ✅ CORRECT - snake_case, plural
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ✅ CORRECT - Pivot tables
CREATE TABLE user_roles (
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, role_id)
);
```

### Columns

```sql
-- ✅ CORRECT - snake_case
ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL;

-- ✅ CORRECT - Foreign keys
ALTER TABLE posts ADD COLUMN user_id BIGINT UNSIGNED NOT NULL;
ALTER TABLE posts ADD CONSTRAINT fk_posts_user_id
    FOREIGN KEY (user_id) REFERENCES users(id);
```

## File and Directory Naming

### Module Structure

```
Modules/
└── User/                          # PascalCase module name
    ├── app/
    │   ├── Actions/              # PascalCase directories
    │   ├── Data/
    │   ├── Exceptions/
    │   ├── Filament/
    │   │   ├── Resources/        # PascalCase
    │   │   └── Pages/
    │   ├── Http/
    │   │   ├── Controllers/      # PascalCase
    │   │   ├── Middleware/
    │   │   ├── Requests/
    │   │   └── Resources/
    │   ├── Models/               # PascalCase
    │   └── Providers/
    ├── config/
    ├── database/
    │   ├── factories/           # Plural, lowercase
    │   ├── migrations/
    │   └── seeders/
    ├── docs/                     # Lowercase
    ├── lang/                     # Lowercase
    ├── resources/
    │   ├── js/                  # Lowercase
    │   ├── sass/                # Lowercase
    │   ├── views/               # Lowercase
    │   └── assets/
    ├── routes/                   # Lowercase
    └── tests/                    # Lowercase
```

### File Naming

```php
// ✅ CORRECT - File names match class names
// File: app/Models/User.php
class User extends Model { }

// File: app/Http/Controllers/UserController.php
class UserController extends Controller { }

// File: app/Actions/CreateUserAction.php
class CreateUserAction implements ShouldQueue { }

// File: database/factories/UserFactory.php
class UserFactory extends Factory { }
```

## URL and Route Naming

### Route Names

```php
<?php

declare(strict_types=1);

// ✅ CORRECT - Consistent naming
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->name('users.destroy');
```

### API Routes

```php
<?php

declare(strict_types=1);

// ✅ CORRECT - API versioning
Route::prefix('api/v1')
    ->middleware(['auth:sanctum'])
    ->name('api.v1.')
    ->group(function (): void {
        Route::apiResource('users', UserController::class);
        Route::apiResource('posts', PostController::class);
    });
```

## Translation Keys

### Translation Files Structure

```php
// ✅ CORRECT - lang/en/messages.php
return [
    'welcome' => 'Welcome to our application',
    'error_occurred' => 'An error occurred',
];

// ✅ CORRECT - lang/en/validation.php
return [
    'required' => 'This field is required',
    'email' => 'Please enter a valid email address',
];

// ✅ CORRECT - lang/en/auth.php
return [
    'login' => 'Login',
    'logout' => 'Logout',
    'register' => 'Register',
];
```

### Usage in Code

```php
<?php

declare(strict_types=1);

class UserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // ✅ CORRECT - Translation keys
        return redirect()->back()
            ->with('success', __('user::messages.created'))
            ->withErrors(__('user::validation.errors'));
    }
}
```

## Package and Library Naming

### Composer Packages

```json
{
    "name": "organization/package-name",
    "description": "Package description",
    "autoload": {
        "psr-4": {
            "Organization\\PackageName\\": "src/"
        }
    }
}
```

### Configuration Files

```php
// ✅ CORRECT - config files in kebab-case
// config/user-settings.php
return [
    'default-role' => 'user',
    'session-timeout' => 7200,
];

// config/api-settings.php
return [
    'rate-limiting' => true,
    'throttle-attempts' => 60,
];
```

---

**Version**: 4.0
**Last Updated**: December 2025
**Standard**: PSR-12 + Laraxot conventions
