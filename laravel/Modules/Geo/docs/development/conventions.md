# Code Conventions and Standards

## 🎯 Coding Standards

### PSR Compliance
- **PSR-12**: Extended coding style guide (MANDATORY)
- **PSR-4**: Autoloading standard (enforced by Composer)
- **PSR-1**: Basic coding standard

### File Structure
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\SubNamespace;

use Specific\Import\Class;
use Another\Import\Class;

class ClassName
{
    // Class implementation
}
```

## 📝 Naming Conventions

### Classes and Interfaces
```php
// PascalCase for all class types
class UserRepository implements UserRepositoryInterface
interface DataTransformerInterface
abstract class BaseServiceProvider
trait LoggableTrait
enum StatusEnum
```

### Methods and Functions
```php
// camelCase, verb + noun
public function createUser(array $data): User
public function getActiveUsers(): Collection
public function isUserActive(User $user): bool
private function validateUserData(array $data): array
```

### Variables and Properties
```php
// camelCase
private string $userName;
public int $maxRetries = 3;
protected ?User $currentUser = null;

// Constructor property promotion (PHP 8.0+)
public function __construct(
    private readonly UserRepository $userRepository,
    private readonly LoggerInterface $logger,
) {}
```

### Constants
```php
// SCREAMING_SNAKE_CASE
const MAX_LOGIN_ATTEMPTS = 5;
const DEFAULT_CACHE_TTL = 3600;
const API_VERSION = 'v1.0';
```

## 🔧 Language Features

### Strict Types (MANDATORY)
```php
<?php
declare(strict_types=1); // ALWAYS required

function add(int $a, int $b): int
{
    return $a + $b; // Strict type checking
}
```

### Type Declarations
```php
// Return types (always)
public function findUser(int $id): ?User
private function processData(array $data): array

// Parameter types (always)
public function updateUser(User $user, array $data): bool

// Property types (PHP 7.4+)
private string $name;
protected ?Carbon $createdAt;
public array $tags = [];
```

### Union Types (PHP 8.0+)
```php
public function findEntity(int|string $id): Model|null
private function processValue(string|int|float $value): string
```

### Nullable Types
```php
public function findUser(?int $id): ?User
private function getUserName(?User $user): ?string
```

## 🏗️ Architecture Patterns

### Actions (Business Logic)
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Modules\ModuleName\Data\UserData;

class CreateUserAction
{
    use QueueableAction;

    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function execute(UserData $data): User
    {
        // Business logic here
        return $this->repository->create($data->toArray());
    }
}
```

### Data Objects (DTOs)
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Data;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
    ) {}
}
```

### Repository Pattern
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Repositories;

use Modules\ModuleName\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function all(): Collection;
    public function create(array $data): User;
}

class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    // ... other methods
}
```

## 🎨 Code Style

### Indentation and Spacing
```php
// 4 spaces indentation (PSR-12)
class ExampleClass
{
    public function exampleMethod(): void
    {
        if ($condition) {
            $this->doSomething();
        } elseif ($anotherCondition) {
            $this->doSomethingElse();
        } else {
            $this->doDefault();
        }
    }
}
```

### Array Formatting
```php
// Short array syntax
$array = [
    'key' => 'value',
    'another_key' => 'another_value',
];

// Multi-line for readability
$users = [
    ['name' => 'John', 'email' => 'john@example.com'],
    ['name' => 'Jane', 'email' => 'jane@example.com'],
];
```

### String Concatenation
```php
// Use interpolation when possible
$message = "Welcome {$user->name} to {$app->name}!";

// Use concatenation for complex expressions
$query = 'SELECT * FROM users WHERE '
       . 'email = ? AND '
       . 'active = ?';
```

## 📚 Documentation Standards

### Class Documentation
```php
/**
 * User management service.
 *
 * Handles user-related business operations including
 * creation, updates, and authentication workflows.
 *
 * @author Development Team
 * @version 1.0.0
 */
class UserService
{
    // Implementation
}
```

### Method Documentation
```php
/**
 * Create a new user account.
 *
 * Validates input data, creates the user record,
 * and sends welcome email if requested.
 *
 * @param UserData $data Validated user data
 * @param bool $sendWelcomeEmail Whether to send welcome email
 * @return User The created user instance
 * @throws ValidationException When data validation fails
 * @throws DatabaseException When user creation fails
 */
public function createUser(UserData $data, bool $sendWelcomeEmail = true): User
```

## 🧪 Testing Conventions

### Test File Structure
```php
<?php
declare(strict_types=1);

namespace Modules\ModuleName\Tests\Unit\Services;

use Tests\TestCase;
use Modules\ModuleName\Services\UserService;
use Modules\ModuleName\Models\User;

class UserServiceTest extends TestCase
{
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(UserService::class);
    }

    /** @test */
    public function it_creates_user_successfully(): void
    {
        // Arrange, Act, Assert pattern
        $data = ['name' => 'John', 'email' => 'john@example.com'];

        $user = $this->service->createUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->name);
    }
}
```

## 🚫 Anti-Patterns to Avoid

### Service Classes (Use Actions Instead)
```php
// ❌ WRONG
class UserService
{
    public function create(array $data): User
    {
        // Business logic mixed with data access
    }
}

// ✅ CORRECT
class CreateUserAction
{
    use QueueableAction;

    public function execute(UserData $data): User
    {
        // Clean business logic
    }
}
```

### Static Methods for Business Logic
```php
// ❌ WRONG
class UserHelper
{
    public static function formatName(User $user): string
    {
        return $user->first_name . ' ' . $user->last_name;
    }
}

// ✅ CORRECT
class UserData extends Data
{
    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
```

---

**Related**: [Common Pitfalls](../pitfalls.md) | [SOLID Principles](solid.md) | [DRY + KISS Patterns](../dry-kiss.md)
