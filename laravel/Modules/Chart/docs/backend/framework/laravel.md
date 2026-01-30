# Laravel 12.x

## Prerequisiti
- PHP 8.2+
- Composer 2.x
- Node.js 18+
- NPM 9+

## Caratteristiche Principali

### 1. Route Groups
```php
Route::prefix('api/v1')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
});
```

### 2. Folio Routing
```php
// pages/users/[id].blade.php
<?php
use function Livewire\Volt\{state, mount};

state(['user' => null]);

mount(function ($id) {
    $this->user = User::findOrFail($id);
});
?>
```

### 3. Volt Components
```php
// components/user-card.blade.php
<?php
use function Livewire\Volt\{state, computed};

state(['user' => null]);

computed(function () {
    return $this->user?->full_name;
})->name;
?>
```

### 4. Model Attributes
```php
class User extends Model
{
    protected $attributes = [
        'is_active' => true,
        'role' => 'user'
    ];
    
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }
}
```

### 5. Dependency Injection
```php
class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected RoleService $roleService
    ) {}
    
    public function index(Request $request)
    {
        return $this->userService->getAll($request->all());
    }
}
```

## Best Practices

### 1. Struttura Progetto
```
app/
├── Actions/       # Single responsibility classes
├── Contracts/     # Interfaces
├── Enums/        # PHP 8.1+ enums
├── Events/       # Event classes
├── Exceptions/   # Custom exceptions
├── Facades/      # Facade classes
├── Http/         # Controllers, Middleware, etc.
├── Models/       # Eloquent models
├── Policies/     # Authorization policies
├── Providers/    # Service providers
├── Rules/        # Custom validation rules
└── Services/     # Business logic
```

### 2. Service Container
```php
// Service Provider
public function register()
{
    $this->app->singleton(UserService::class, function ($app) {
        return new UserService(
            $app->make(UserRepository::class)
        );
    });
}

// Controller
public function __construct(
    protected UserService $userService
) {}
```

### 3. Repository Pattern
```php
interface UserRepository
{
    public function getAll(array $filters = []): Collection;
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
}

class EloquentUserRepository implements UserRepository
{
    public function getAll(array $filters = []): Collection
    {
        return User::query()
            ->when($filters['active'] ?? null, fn($q) => $q->active())
            ->get();
    }
    
    // ...
}
```

### 4. Form Requests
```php
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->user);
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
            'role' => ['required', 'string', Rule::in(Role::cases())]
        ];
    }
}
```

### 5. Events & Listeners
```php
// Event
class UserCreated
{
    public function __construct(
        public readonly User $user
    ) {}
}

// Listener
class SendWelcomeEmail
{
    public function handle(UserCreated $event): void
    {
        Mail::to($event->user)->send(new WelcomeMail($event->user));
    }
}
```

## Testing

### 1. Unit Tests
```php
class UserTest extends TestCase
{
    public function test_it_can_get_full_name(): void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
        
        $this->assertEquals('John Doe', $user->full_name);
    }
}
```

### 2. Feature Tests
```php
class UserControllerTest extends TestCase
{
    public function test_it_can_create_user(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }
}
```

## Performance

### 1. Query Optimization
```php
// ❌ N+1 Problem
$users = User::all();
foreach ($users as $user) {
    echo $user->profile->name;
}

// ✅ Eager Loading
$users = User::with('profile')->get();
foreach ($users as $user) {
    echo $user->profile->name;
}
```

### 2. Caching
```php
// Cache query results
$users = Cache::remember('users', 3600, function () {
    return User::with('profile')->get();
});

// Cache view fragments
@cache('user-list', 3600)
    @foreach ($users as $user)
        <x-user-card :user="$user" />
    @endforeach
@endcache
```

## Collegamenti
- [Struttura Base](../laravel/Modules/Xot/docs/STRUCTURE.md)
- [Convenzioni di Routing](../laravel/Modules/Xot/docs/routing-conventions.md)
- [Convenzioni di Namespace](../laravel/Modules/Xot/docs/namespace-conventions.md)
- [Documentazione Folio & Volt](FOLIO_VOLT.md) 