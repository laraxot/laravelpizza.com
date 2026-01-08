# Testing - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTE le regole di testing del progetto
> 
> **🔗 Riferimenti**: [coding-standards.md](coding-standards.md) | [best-practices.md](best-practices.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file di testing, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **25+ file di testing duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `testing.md` in qualsiasi modulo
- `testing-guide.md` duplicati
- `testing-best-practices.md` sparsi
- Qualsiasi documentazione testing specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/testing-consolidated.md`
- **Implementazione**: Test nei singoli moduli (solo test, non docs)

## Principi Fondamentali

### Struttura Standard dei Test
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature;

use Tests\TestCase;
use Modules\ModuleName\Models\ExampleModel;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_can_create_example(): void
    {
        // Arrange
        $data = ['name' => 'Test Example'];

        // Act
        $response = $this->postJson('/api/examples', $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('examples', $data);
    }
}
```

### Naming Conventions
```php
// ✅ CORRETTO
public function it_can_create_user(): void
public function it_validates_required_fields(): void
public function it_returns_404_for_invalid_id(): void

// ❌ ERRATO
public function testCreateUser(): void
public function createUser(): void
```

### Tipizzazione Rigorosa
```php
// ✅ CORRETTO
public function it_can_process_data(array $data): void
public function it_returns_user_data(): UserData
public function it_handles_empty_input(): void

// ❌ ERRATO
public function it_can_process_data($data)
public function it_returns_user_data()
```

## Struttura dei Test

### Unit Tests
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Unit;

use Tests\TestCase;
use Modules\ModuleName\Actions\ProcessDataAction;
use Modules\ModuleName\Data\UserData;

class ProcessDataActionTest extends TestCase
{
    /** @test */
    public function it_can_process_valid_data(): void
    {
        // Arrange
        $action = app(ProcessDataAction::class);
        $data = UserData::from([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Act
        $result = $action->execute($data);

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals('Test User', $result->name);
    }

    /** @test */
    public function it_throws_exception_for_invalid_data(): void
    {
        // Arrange
        $action = app(ProcessDataAction::class);
        $invalidData = UserData::from([
            'name' => '', // Invalid empty name
            'email' => 'invalid-email',
        ]);

        // Act & Assert
        $this->expectException(\InvalidArgumentException::class);
        $action->execute($invalidData);
    }
}
```

### Feature Tests
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature;

use Tests\TestCase;
use Modules\ModuleName\Models\ExampleModel;
use Modules\User\Models\User;

class ExampleApiTest extends TestCase
{
    /** @test */
    public function it_can_list_resources(): void
    {
        // Arrange
        $user = User::factory()->create();
        ExampleModel::factory()->count(3)->create();

        // Act
        $response = $this->actingAs($user)
            ->getJson('/api/examples');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_create_resource(): void
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Example',
            'description' => 'Test Description',
        ];

        // Act
        $response = $this->actingAs($user)
            ->postJson('/api/examples', $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('examples', $data);
    }

    /** @test */
    public function it_validates_required_fields(): void
    {
        // Arrange
        $user = User::factory()->create();
        $invalidData = [
            'description' => 'Missing required name',
        ];

        // Act
        $response = $this->actingAs($user)
            ->postJson('/api/examples', $invalidData);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_returns_404_for_invalid_id(): void
    {
        // Arrange
        $user = User::factory()->create();
        $invalidId = 99999;

        // Act
        $response = $this->actingAs($user)
            ->getJson("/api/examples/{$invalidId}");

        // Assert
        $response->assertStatus(404);
    }
}
```

### Filament Tests
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Tests\Feature\Filament;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\ModuleName\Models\ExampleModel;
use Livewire\Livewire;

class ExampleResourceTest extends TestCase
{
    /** @test */
    public function it_can_create_resource_via_filament(): void
    {
        // Arrange
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Example',
            'description' => 'Test Description',
        ];

        // Act
        Livewire::actingAs($user)
            ->test(\Modules\ModuleName\Filament\Resources\ExampleResource\Pages\CreateExample::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        // Assert
        $this->assertDatabaseHas('examples', $data);
    }

    /** @test */
    public function it_validates_form_fields(): void
    {
        // Arrange
        $user = User::factory()->create();
        $invalidData = [
            'description' => 'Missing required name',
        ];

        // Act & Assert
        Livewire::actingAs($user)
            ->test(\Modules\ModuleName\Filament\Resources\ExampleResource\Pages\CreateExample::class)
            ->fillForm($invalidData)
            ->call('create')
            ->assertHasFormErrors(['name']);
    }
}
```

## Testing Patterns

### Database Testing
```php
/** @test */
public function it_can_create_and_retrieve_model(): void
{
    // Arrange
    $data = [
        'name' => 'Test Model',
        'description' => 'Test Description',
    ];

    // Act
    $model = ExampleModel::create($data);

    // Assert
    $this->assertDatabaseHas('examples', $data);
    $this->assertEquals('Test Model', $model->name);
    $this->assertNotNull($model->id);
}

/** @test */
public function it_can_update_model(): void
{
    // Arrange
    $model = ExampleModel::factory()->create();
    $newData = ['name' => 'Updated Name'];

    // Act
    $model->update($newData);

    // Assert
    $this->assertDatabaseHas('examples', $newData);
    $this->assertEquals('Updated Name', $model->fresh()->name);
}

/** @test */
public function it_can_delete_model(): void
{
    // Arrange
    $model = ExampleModel::factory()->create();

    // Act
    $model->delete();

    // Assert
    $this->assertDatabaseMissing('examples', ['id' => $model->id]);
    $this->assertSoftDeleted($model); // Se usa soft delete
}
```

### API Testing
```php
/** @test */
public function it_returns_correct_json_structure(): void
{
    // Arrange
    $user = User::factory()->create();
    $example = ExampleModel::factory()->create();

    // Act
    $response = $this->actingAs($user)
        ->getJson("/api/examples/{$example->id}");

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
            ],
        ]);
}

/** @test */
public function it_handles_pagination(): void
{
    // Arrange
    $user = User::factory()->create();
    ExampleModel::factory()->count(25)->create();

    // Act
    $response = $this->actingAs($user)
        ->getJson('/api/examples?page=2&per_page=10');

    // Assert
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'meta' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
            ],
        ]);
}
```

### Authentication Testing
```php
/** @test */
public function it_requires_authentication(): void
{
    // Act
    $response = $this->getJson('/api/examples');

    // Assert
    $response->assertStatus(401);
}

/** @test */
public function it_requires_authorization(): void
{
    // Arrange
    $user = User::factory()->create();
    $example = ExampleModel::factory()->create();

    // Act
    $response = $this->actingAs($user)
        ->deleteJson("/api/examples/{$example->id}");

    // Assert
    $response->assertStatus(403);
}
```

## Testing Best Practices

### 1. Test Isolation
```php
// ✅ CORRETTO - Ogni test è indipendente
class ExampleTest extends TestCase
{
    use RefreshDatabase; // Garantisce database pulito

    /** @test */
    public function test_a(): void
    {
        // Test isolato
    }

    /** @test */
    public function test_b(): void
    {
        // Test isolato, non dipende da test_a
    }
}
```

### 2. Meaningful Assertions
```php
// ✅ CORRETTO - Assertioni specifiche
$this->assertEquals('Expected Value', $result->name);
$this->assertCount(3, $collection);
$this->assertDatabaseHas('table', ['column' => 'value']);

// ❌ ERRATO - Assertioni generiche
$this->assertNotNull($result);
$this->assertTrue($result);
```

### 3. Descriptive Test Names
```php
// ✅ CORRETTO - Nomi descrittivi
public function it_can_create_user_with_valid_data(): void
public function it_throws_exception_when_email_is_invalid(): void
public function it_returns_404_when_user_not_found(): void

// ❌ ERRATO - Nomi generici
public function testCreate(): void
public function testValidation(): void
public function testNotFound(): void
```

### 4. Arrange-Act-Assert Pattern
```php
/** @test */
public function it_can_process_user_data(): void
{
    // Arrange - Preparazione dati
    $user = User::factory()->create();
    $data = ['name' => 'John Doe'];

    // Act - Esecuzione azione
    $result = $this->service->process($user, $data);

    // Assert - Verifica risultati
    $this->assertEquals('John Doe', $result->name);
    $this->assertDatabaseHas('users', ['name' => 'John Doe']);
}
```

## Testing Tools

### PHPUnit Configuration
```xml
<!-- phpunit.xml -->
<testsuites>
    <testsuite name="Unit">
        <directory suffix="Test.php">./laravel/Modules/*/tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./laravel/Modules/*/tests/Feature</directory>
    </testsuite>
</testsuites>
```

### Factory Definitions
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ModuleName\Models\ExampleModel;

class ExampleModelFactory extends Factory
{
    protected $model = ExampleModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
```

### Seeder Testing
```php
/** @test */
public function it_can_seed_database(): void
{
    // Act
    $this->artisan('db:seed', ['--class' => 'ExampleSeeder']);

    // Assert
    $this->assertDatabaseCount('examples', 10);
    $this->assertDatabaseHas('examples', [
        'name' => 'Default Example',
    ]);
}
```

## Performance Testing

### Database Query Testing
```php
/** @test */
public function it_uses_eager_loading(): void
{
    // Arrange
    $users = User::factory()->count(5)->create();
    $users->each(fn ($user) => $user->examples()->createMany(
        ExampleModel::factory()->count(3)->make()->toArray()
    ));

    // Act & Assert
    DB::enableQueryLog();
    
    $usersWithExamples = User::with('examples')->get();
    
    $this->assertCount(5, $usersWithExamples);
    $this->assertLessThan(10, count(DB::getQueryLog())); // N+1 query prevention
}
```

### Memory Testing
```php
/** @test */
public function it_does_not_memory_leak(): void
{
    // Arrange
    $initialMemory = memory_get_usage();

    // Act
    for ($i = 0; $i < 1000; $i++) {
        $model = ExampleModel::factory()->create();
        $model->process();
    }

    // Assert
    $finalMemory = memory_get_usage();
    $memoryIncrease = $finalMemory - $initialMemory;
    
    $this->assertLessThan(10 * 1024 * 1024, $memoryIncrease); // Max 10MB increase
}
```

## Errori Comuni e Soluzioni

### Problema: Test che Falliscono Intermittentemente
**Causa**: Test non isolati o dipendenze condivise

**Soluzione**:
```php
class ExampleTest extends TestCase
{
    use RefreshDatabase; // Garantisce database pulito
    
    protected function setUp(): void
    {
        parent::setUp();
        // Setup specifico per ogni test
    }
}
```

### Problema: Test Lenti
**Causa**: Troppi database queries o operazioni costose

**Soluzione**:
```php
// ✅ CORRETTO - Eager loading
$users = User::with(['roles', 'permissions'])->get();

// ❌ ERRATO - N+1 queries
$users = User::all();
foreach ($users as $user) {
    $user->roles; // Query aggiuntiva per ogni utente
}
```

### Problema: Test che Dipendono da Ordine
**Causa**: Test che modificano stato condiviso

**Soluzione**:
```php
// ✅ CORRETTO - Test indipendenti
/** @test */
public function test_a(): void
{
    $this->assertDatabaseCount('users', 0);
    User::factory()->create();
    $this->assertDatabaseCount('users', 1);
}

/** @test */
public function test_b(): void
{
    $this->assertDatabaseCount('users', 0); // Non dipende da test_a
    User::factory()->create();
    $this->assertDatabaseCount('users', 1);
}
```

## Comandi Utili

### Esecuzione Test
```bash
# Tutti i test
php artisan test

# Test specifici per modulo
php artisan test --testsuite=ModuleName

# Test con coverage
php artisan test --coverage

# Test paralleli
php artisan test --parallel
```

### Debugging Test
```bash
# Test con output dettagliato
php artisan test --verbose

# Test specifico
php artisan test --filter=test_name

# Test con stop on failure
php artisan test --stop-on-failure
```

## Collegamenti

- [Coding Standards](coding-standards.md)
- [Best Practices](best-practices.md)
- [PHPStan Guide](phpstan-consolidated.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Testing*
