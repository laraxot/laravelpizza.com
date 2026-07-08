# 📝 Conventions - Stile e Convenzioni Codice

> **FONDAMENTALE**: Convenzioni consistenti garantiscono codice leggibile, manutenibile e collaborativo in PTVX.

## 🎯 Principi Guida

### DRY (Don't Repeat Yourself)
- Ogni concetto implementato una sola volta
- Single Source of Truth per ogni logica
- Riutilizzo attraverso composizione, non duplicazione

### KISS (Keep It Simple, Stupid)
- Codice semplice è meglio di codice complesso
- Evitare over-engineering
- Chiarezza sopra eleganza

### SOLID
- **S**ingle Responsibility - Una classe, una responsabilità
- **O**pen/Closed - Aperto a estensioni, chiuso a modifiche
- **L**iskov Substitution - Sostituibilità senza effetti collaterali
- **I**nterface Segregation - Interfacce focalizzate
- **D**ependency Inversion - Dipende da astrazioni

---

## 📏 Code Style Standards

### PHP Standards

#### Strict Typing OBBLIGATORIO
```php
<?php

declare(strict_types=1); // OBBLIGATORIO in ogni file

namespace Modules\MyModule\Services;

// ✅ CORRETTO
class MyService
{
    public function __construct(
        private readonly MyRepository $repository
    ) {}
    
    public function processData(array $data): array // Return type OBBLIGATORIO
    {
        return array_map(fn ($item) => $this->processItem($item), $data);
    }
    
    private function processItem(array $item): array // Parametri tipizzati
    {
        return $item;
    }
}

// ❌ SBAGLIATO
class MyService
{
    public function __construct($repository) // No typing
    {
        $this->repository = $repository;
    }
    
    public function processData($data) // No return type
    {
        // ...
    }
}
```

#### Naming Conventions
```php
// ✅ Class names: PascalCase
class UserService
class CreatePdfAction
class MyModelRepository

// ✅ Method names: camelCase
public function createUser()
public function generatePdf()
public function calculateTotal()

// ✅ Variable names: camelCase, descriptive
$userRepository
$pdfContent
$totalAmount

// ✅ Constants: UPPER_SNAKE_CASE
const MAX_RETRY_ATTEMPTS = 3;
const DEFAULT_TIMEOUT = 30;

// ❌ SBAGLIATO
class userservice // lowercase
function createuser() // not camelCase
$userrepo // not descriptive
```

#### Method Organization
```php
class MyService
{
    // 1. Constructor and dependencies
    public function __construct(
        private readonly MyRepository $repository,
        private readonly EventDispatcher $dispatcher
    ) {}
    
    // 2. Public methods - main API
    public function create(array $data): MyModel
    {
        return $this->validateAndSave($data);
    }
    
    public function update(int $id, array $data): MyModel
    {
        return $this->validateAndSave($data, $id);
    }
    
    // 3. Protected methods - extension points
    protected function validateAndSave(array $data, ?int $id = null): MyModel
    {
        $this->validateData($data);
        
        return $id 
            ? $this->repository->update($id, $data)
            : $this->repository->create($data);
    }
    
    // 4. Private methods - implementation details
    private function validateData(array $data): void
    {
        // Validation logic
    }
}
```

### Documentation Standards

#### PHPDoc Blocks
```php
/**
 * Service for managing user operations.
 *
 * @package Modules\MyModule\Services
 */
class UserService
{
    /**
     * Create a new user with validation and events.
     *
     * @param array<string, mixed> $data User data
     * @return \Modules\MyModule\Models\User Created user model
     * @throws \Illuminate\Validation\ValidationException On validation failure
     */
    public function create(array $data): User
    {
        // Implementation
    }
    
    /**
     * Calculate user statistics for reporting.
     *
     * @param \Illuminate\Support\Collection<int, User> $users User collection
     * @return array{total: int, active: int, inactive: int} Statistics array
     */
    public function calculateStats(Collection $users): array
    {
        return [
            'total' => $users->count(),
            'active' => $users->where('active', true)->count(),
            'inactive' => $users->where('active', false)->count(),
        ];
    }
}
```

---

## 🏗️ Architecture Conventions

### Class Structure Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Actions;

// 1. Use statements - alphabetical by namespace
use Illuminate\Support\Facades\Log;
use Modules\MyModule\Data\UserData;
use Modules\MyModule\Exceptions\UserNotFoundException;
use Modules\MyModule\Models\User;
use Spatie\QueueableAction\QueueableAction;

// 2. Class declaration
class CreateUserAction
{
    // 3. Traits
    use QueueableAction;
    
    // 4. Constants
    private const DEFAULT_ROLE = 'user';
    private const MAX_ATTEMPTS = 3;
    
    // 5. Properties
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventDispatcher $dispatcher
    ) {}
    
    // 6. Public methods
    public function execute(UserData $data): User
    {
        $this->validateData($data);
        
        $user = $this->repository->create($data->toArray());
        
        $this->dispatcher->dispatch(new UserCreated($user));
        
        return $user;
    }
    
    // 7. Protected methods
    protected function validateData(UserData $data): void
    {
        // Validation logic
    }
    
    // 8. Private methods
    private function assignDefaultRole(User $user): void
    {
        // Role assignment logic
    }
}
```

### Interface Segregation
```php
// ✅ Small, focused interfaces
interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(int $id, array $data): User;
    public function delete(int $id): bool;
}

interface UserSearchInterface
{
    public function findByEmail(string $email): ?User;
    public function searchByName(string $name): Collection;
    public function getActiveUsers(): Collection;
}

// ❌ Large, unfocused interface (anti-pattern)
interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(int $id, array $data): User;
    public function delete(int $id): bool;
    public function findByEmail(string $email): ?User;
    public function sendWelcomeEmail(User $user): void;
    public function generateReport(): array;
    public function exportToCsv(): string;
}
```

---

## 🗄️ Database Conventions

### Migration Standards
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Basic info
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Status and timestamps
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['email', 'active']);
            $table->index('created_at');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### Model Conventions
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\MyModule\Database\Factories\UserFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $active
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\MyModule\Models\Post> $posts
 */
class User extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
```

---

## 🎨 Frontend Conventions

### Blade Template Standards
```blade
{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('title', __('Users'))

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header section --}}
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            {{ __('Users Management') }}
        </h1>
        <p class="mt-2 text-gray-600">
            {{ __('Manage system users and permissions') }}
        </p>
    </header>

    {{-- Main content --}}
    <main>
        @if($users->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">{{ __('No users found') }}</p>
            </div>
        @else
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="relative px-6 py-3">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $user->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->active ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        {{ __('Edit') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

    {{-- Pagination --}}
    @if($users->hasPages())
        <footer class="mt-8">
            {{ $users->links() }}
        </footer>
    @endif
</div>
@endsection
```

### CSS Conventions
```css
/* assets/css/components.css */

/* Component-based CSS with BEM methodology */
.card {
  @apply bg-white rounded-lg shadow-md overflow-hidden;
}

.card__header {
  @apply px-6 py-4 border-b border-gray-200;
}

.card__title {
  @apply text-lg font-semibold text-gray-900;
}

.card__content {
  @apply px-6 py-4;
}

.card__footer {
  @apply px-6 py-4 bg-gray-50 border-t border-gray-200;
}

/* Utility classes for common patterns */
.btn {
  @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
}

.btn--primary {
  @apply bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500;
}

.btn--secondary {
  @apply bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500;
}

.btn--danger {
  @apply bg-red-600 text-white hover:bg-red-700 focus:ring-red-500;
}
```

---

## 🧪 Testing Conventions

### Test Structure
```php
<?php

declare(strict_types=1);

use Modules\MyModule\Models\User;
use Modules\MyModule\Actions\CreateUserAction;
use Modules\MyModule\Data\UserData;

// Organization: describe blocks for features
describe('User Management', function () {
    // Setup common data
    beforeEach(function () {
        $this->userData = UserData::from([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
    });
    
    // Individual test cases
    it('can create a user with valid data', function () {
        $user = app(CreateUserAction::class)->execute($this->userData);
        
        expect($user)
            ->toBeInstanceOf(User::class)
            ->name->toBe('Test User')
            ->email->toBe('test@example.com')
            ->active->toBeTrue();
    });
    
    it('throws validation exception with invalid email', function () {
        $invalidData = UserData::from([
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password',
        ]);
        
        expect(fn() => app(CreateUserAction::class)->execute($invalidData))
            ->toThrow(ValidationException::class);
    });
    
    it('dispatches user created event', function () {
        Event::fake();
        
        $user = app(CreateUserAction::class)->execute($this->userData);
        
        Event::assertDispatched(UserCreated::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    });
});
```

### Test Naming Conventions
```php
// ✅ Descriptive test names
it('validates email format');
it('calculates total with tax included');
it('returns active users only');

// ❌ Vague test names
it('test_validation');
it('test_calculation');
it('test_users');

// ✅ Test data setup
describe('User Service', function () {
    beforeEach(function () {
        $this->service = app(UserService::class);
        $this->user = User::factory()->create();
    });
    
    // Test cases...
});

// ✅ Custom helpers
function createTestUser(array $attributes = []): User
{
    return User::factory()->create($attributes);
}
```

---

## 📝 Documentation Conventions

### README Structure
```markdown
# Module Name

## Overview
Brief description of the module purpose and functionality.

## Installation
Step-by-step installation instructions.

## Usage
Basic usage examples and common scenarios.

## API Reference
Detailed API documentation.

## Configuration
Configuration options and environment variables.

## Testing
How to run tests and write new tests.

## Contributing
Guidelines for contributing to the module.

## Changelog
Version history and changes.
```

### Code Comments Policy
```php
// ✅ Comments for WHY, not WHAT
public function calculateTotal(array $items): float
{
    // Apply tax only for digital products (legal requirement)
    $subtotal = array_sum(array_column($items, 'price'));
    
    if ($this->hasDigitalProducts($items)) {
        return $subtotal * 1.22; // 22% VAT for digital products
    }
    
    return $subtotal;
}

// ❌ Obvious comments (don't do this)
public function calculateTotal(array $items): float
{
    // Calculate subtotal
    $subtotal = array_sum(array_column($items, 'price'));
    
    // Return subtotal
    return $subtotal;
}

// ✅ Complex logic explanation
public function generateReport(): array
{
    // Group by month first to avoid memory issues with large datasets
    $monthlyData = $this->groupByMonth($this->rawData);
    
    // Calculate running averages for trend analysis
    $averages = $this->calculateRunningAverages($monthlyData);
    
    return [
        'monthly' => $monthlyData,
        'averages' => $averages,
        'trends' => $this->calculateTrends($averages),
    ];
}
```

---

## 📋 Quality Checklist

### Code Review Checklist
- [ ] Strict typing everywhere
- [ ] Return types on all methods
- [ ] Descriptive variable and method names
- [ ] Single responsibility principle followed
- [ ] No hardcoded values
- [ ] Proper error handling
- [ ] Documentation for complex logic
- [ ] Tests cover edge cases

### Architecture Review Checklist
- [ ] Dependencies injected
- [ ] Interfaces used where appropriate
- [ ] No tight coupling
- [ ] SOLID principles followed
- [ ] Database queries optimized
- [ ] Caching considered
- [ ] Security implemented

### Documentation Review Checklist
- [ ] README complete and up-to-date
- [ ] API documentation accurate
- [ ] Examples provided
- [ ] Installation steps clear
- [ ] Contributing guidelines present

---

## 📚 Riferimenti Correlati

- [Code Quality](code-quality.md) - Tools e standard qualità
- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Core Rules](core.md) - Regole fondamentali
- [Module Structure](module-structure.md) - Struttura moduli

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 📡 MEDIA - Consistenza codice  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Code is read more often than it is written. Make it readable."