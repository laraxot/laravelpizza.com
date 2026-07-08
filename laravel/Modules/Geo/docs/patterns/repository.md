# 🏗️ Repository Pattern - Implementazione PTVX

> **REPOSITORY PATTERN** centralizzato per PTVX - massima astrazione e testabilità.

## 🎯 Scopo

Il Repository Pattern separa la logica di accesso ai dati dalla business logic, fornendo:
- ✅ Interfacce chiare e testabili
- ✅ Implementazioni intercambiabili (DB, API, Cache, etc.)
- ✅ Single Responsibility Principle
- ✅ Dependency Inversion

## 📋 Struttura Base

### Interfaccia Repository

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\NomeModulo\Models\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function findByRole(string $role): Collection;
    public function findActive(): Collection;
}
```

### Implementazione Repository

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {}

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['profile', 'roles'])->paginate($perPage);
    }

    public function findByRole(string $role): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }

    public function findActive(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
```

## 🔗 Binding in Service Provider

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;
use Modules\NomeModulo\Repositories\UserRepository;

class NomeModuloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
```

## 🎮 Utilizzo nei Controller/Action

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Actions;

use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;

class CreateUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(UserData $userData): User
    {
        return $this->userRepository->create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
        ]);
    }
}
```

## 🧪 Testing con Repository

```php
<?php

namespace Tests\Unit\Modules\NomeModulo\Repositories;

use Tests\TestCase;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository(new User());
    }

    /** @test */
    public function it_can_find_user_by_id(): void
    {
        $user = User::factory()->create();

        $found = $this->repository->findById($user->id);

        $this->assertEquals($user->id, $found->id);
    }

    /** @test */
    public function it_can_create_user(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $user = $this->repository->create($data);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
```

## 🔄 Repository con Cache

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Repositories;

use Illuminate\Contracts\Cache\Repository as Cache;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;

class CachedUserRepository implements UserRepositoryInterface
{
    private const CACHE_TTL = 3600; // 1 ora

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly Cache $cache
    ) {}

    public function findById(int $id): ?User
    {
        return $this->cache->remember(
            "user.{$id}",
            self::CACHE_TTL,
            fn () => $this->repository->findById($id)
        );
    }

    // Altri metodi con delega al repository sottostante...
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    public function create(array $data): User
    {
        // Invalida cache se necessario
        $this->cache->flush();
        return $this->repository->create($data);
    }

    // Delega tutti gli altri metodi
    public function __call(string $method, array $arguments)
    {
        return $this->repository->{$method}(...$arguments);
    }
}
```

## 📊 Vantaggi del Pattern

### Separation of Concerns
- **Controller**: Gestione HTTP request/response
- **Action/Service**: Business logic
- **Repository**: Accesso dati

### Testabilità
- Mock delle interfacce per test unitari
- Test di integrazione con database reale
- Implementazioni intercambiabili

### Manutenibilità
- Cambiamenti database isolati
- Codice riutilizzabile
- Facile refactoring

### Performance
- Possibilità di cache
- Lazy loading controllato
- Query ottimizzate

---

**📖 Vedi anche**: [Service Layer Pattern](./service-layer.md), [SOLID Principles](../claude/solid-principles.md)

*Ultimo aggiornamento: Dicembre 2025*
