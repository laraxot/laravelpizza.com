# 🔧 Service Layer Pattern - Business Logic PTVX

> **SERVICE LAYER PATTERN** per separare la business logic dalla presentazione e persistenza.

## 🎯 Scopo

Il Service Layer Pattern centralizza la business logic applicativa, fornendo:
- ✅ Orchestrazione di operazioni complesse
- ✅ Transazioni database
- ✅ Validazione business rules
- ✅ Integrazione tra più repository
- ✅ Single Responsibility per ogni servizio

## 📋 Struttura Base

### Interfaccia Servizio

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services\Contracts;

use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Models\User;

interface UserServiceInterface
{
    public function registerUser(UserData $userData): User;
    public function updateProfile(User $user, UserData $profileData): User;
    public function deactivateUser(User $user): bool;
    public function sendWelcomeEmail(User $user): void;
    public function generateUserReport(): array;
}
```

### Implementazione Servizio

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;
use Modules\NomeModulo\Services\Contracts\UserServiceInterface;
use Modules\NomeModulo\Notifications\WelcomeNotification;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function registerUser(UserData $userData): User
    {
        return DB::transaction(function () use ($userData) {
            // 1. Creazione utente
            $user = $this->userRepository->create([
                'name' => $userData->name,
                'email' => $userData->email,
                'password' => bcrypt($userData->password),
                'is_active' => false, // Deve confermare email
            ]);

            // 2. Invio email benvenuto
            $this->sendWelcomeEmail($user);

            // 3. Log registrazione
            Log::info('User registered', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            return $user;
        });
    }

    public function updateProfile(User $user, UserData $profileData): User
    {
        // Validazione business rules
        $this->validateProfileUpdate($user, $profileData);

        return DB::transaction(function () use ($user, $profileData) {
            // Aggiornamento profilo
            $updatedUser = $this->userRepository->update($user, [
                'name' => $profileData->name,
                'email' => $profileData->email,
            ]);

            // Integrazione con altri servizi
            $this->updateUserCache($updatedUser);
            $this->notifyProfileUpdate($updatedUser);

            return $updatedUser;
        });
    }

    public function deactivateUser(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            // Business rules per disattivazione
            if ($user->hasActiveSubscriptions()) {
                throw new \Exception('Cannot deactivate user with active subscriptions');
            }

            // Disattivazione
            $user->update(['is_active' => false]);

            // Pulizia dati correlati
            $this->cleanupUserData($user);

            Log::info('User deactivated', ['user_id' => $user->id]);

            return true;
        });
    }

    public function sendWelcomeEmail(User $user): void
    {
        $user->notify(new WelcomeNotification());
    }

    public function generateUserReport(): array
    {
        $users = $this->userRepository->findActive();
        $totalUsers = $users->count();
        $newUsersThisMonth = $users->where('created_at', '>=', now()->startOfMonth())->count();

        return [
            'total_users' => $totalUsers,
            'active_users' => $totalUsers,
            'new_users_this_month' => $newUsersThisMonth,
            'generated_at' => now(),
        ];
    }

    private function validateProfileUpdate(User $user, UserData $profileData): void
    {
        // Business rules
        if ($profileData->email !== $user->email) {
            // Verifica email unica
            $existingUser = $this->userRepository->findByEmail($profileData->email);
            if ($existingUser && $existingUser->id !== $user->id) {
                throw new \Exception('Email already in use');
            }
        }
    }

    private function updateUserCache(User $user): void
    {
        // Cache invalidation
        Cache::forget("user.{$user->id}");
        Cache::forget("user.email.{$user->email}");
    }

    private function notifyProfileUpdate(User $user): void
    {
        // Notifiche interne o esterne
        Log::info('Profile updated', ['user_id' => $user->id]);
    }

    private function cleanupUserData(User $user): void
    {
        // Rimozione token, sessioni, etc.
        $user->tokens()->delete();
        // Altri cleanup...
    }
}
```

## 🎮 Utilizzo nei Controller

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Controllers;

use Illuminate\Http\Request;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Services\Contracts\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function register(Request $request)
    {
        $userData = UserData::validateAndCreate($request->all());

        try {
            $user = $this->userService->registerUser($userData);

            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'User registered successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $profileData = UserData::validateAndCreate($request->all());

        $updatedUser = $this->userService->updateProfile($user, $profileData);

        return response()->json([
            'success' => true,
            'user' => $updatedUser
        ]);
    }

    public function report()
    {
        $report = $this->userService->generateUserReport();

        return response()->json($report);
    }
}
```

## 🔗 Binding in Service Provider

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\NomeModulo\Services\Contracts\UserServiceInterface;
use Modules\NomeModulo\Services\UserService;

class NomeModuloServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }
}
```

## 🧪 Testing dei Servizi

```php
<?php

namespace Tests\Unit\Modules\NomeModulo\Services;

use Tests\TestCase;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;
use Modules\NomeModulo\Services\UserService;
use Mockery;

class UserServiceTest extends TestCase
{
    private UserService $service;
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(UserRepositoryInterface::class);
        $this->service = new UserService($this->repository);
    }

    /** @test */
    public function it_can_register_user(): void
    {
        $userData = new UserData(
            name: 'Test User',
            email: 'test@example.com',
            password: 'password123'
        );

        $expectedUser = new User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($expectedUser);

        $result = $this->service->registerUser($userData);

        $this->assertEquals($expectedUser, $result);
    }

    /** @test */
    public function it_validates_profile_update(): void
    {
        $user = User::factory()->create(['email' => 'old@example.com']);
        $profileData = new UserData(
            name: 'New Name',
            email: 'existing@example.com'
        );

        $this->repository
            ->shouldReceive('findByEmail')
            ->with('existing@example.com')
            ->andReturn(User::factory()->create());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email already in use');

        $this->service->updateProfile($user, $profileData);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
```

## 🔄 Service con Multiple Repository

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Modules\NomeModulo\Data\OrderData;
use Modules\NomeModulo\Models\Order;
use Modules\NomeModulo\Repositories\Contracts\UserRepositoryInterface;
use Modules\NomeModulo\Repositories\Contracts\ProductRepositoryInterface;
use Modules\NomeModulo\Repositories\Contracts\OrderRepositoryInterface;

class OrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function createOrder(OrderData $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            // 1. Verifica utente
            $user = $this->userRepository->findById($orderData->userId);
            if (!$user || !$user->is_active) {
                throw new \Exception('Invalid user');
            }

            // 2. Verifica prodotti e disponibilità
            foreach ($orderData->items as $item) {
                $product = $this->productRepository->findById($item['product_id']);
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception("Product {$product->name} out of stock");
                }
            }

            // 3. Crea ordine
            $order = $this->orderRepository->create([
                'user_id' => $orderData->userId,
                'items' => $orderData->items,
                'total' => $this->calculateTotal($orderData->items),
            ]);

            // 4. Aggiorna stock prodotti
            $this->updateProductStock($orderData->items);

            return $order;
        });
    }

    private function calculateTotal(array $items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $product = $this->productRepository->findById($item['product_id']);
            $total += $product->price * $item['quantity'];
        }
        return $total;
    }

    private function updateProductStock(array $items): void
    {
        foreach ($items as $item) {
            $product = $this->productRepository->findById($item['product_id']);
            $this->productRepository->update($product, [
                'stock' => $product->stock - $item['quantity']
            ]);
        }
    }
}
```

## 📊 Vantaggi del Pattern

### Business Logic Centralizzata
- Regole business in un posto solo
- Facile manutenzione e modifiche
- Testabilità isolata

### Transazioni Database
- Operazioni atomiche
- Rollback automatico su errori
- Integrità dati garantita

### Orchestrazione Complessa
- Coordinamento tra più repository
- Chiamate a servizi esterni
- Logging e notifiche integrate

### Dependency Inversion
- Interfacce invece di implementazioni concrete
- Facile mocking per testing
- Implementazioni intercambiabili

---

**📖 Vedi anche**: [Repository Pattern](./repository.md), [SOLID Principles](../claude/solid-principles.md)

*Ultimo aggiornamento: Dicembre 2025*
