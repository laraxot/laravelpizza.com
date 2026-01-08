# Test del Modulo Performance

## Struttura dei Test

```
tests/
├── Feature/
│   ├── Actions/
│   │   ├── CalculatePerformanceScoreActionTest.php
│   │   └── CopyFromLastYearActionTest.php
│   ├── Resources/
│   │   └── IndividualePesiResourceTest.php
│   └── Http/
│       └── Controllers/
├── Unit/
│   ├── Models/
│   │   ├── IndividualePesiTest.php
│   │   └── IndividualePoPesiTest.php
│   └── Data/
│       └── PerformanceScoreDataTest.php
└── TestCase.php
```

## Unit Test

### Test dei Modelli

```php
declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use Modules\Performance\Models\IndividualePesi;
use Modules\Performance\Enums\WorkerType;

class IndividualePesiTest extends TestCase
{
    /** @test */
    public function it_can_create_individuale_pesi(): void
    {
        $pesi = IndividualePesi::factory()->create([
            'type' => WorkerType::DIRIGENTE,
            'anno' => 2024,
        ]);

        $this->assertInstanceOf(IndividualePesi::class, $pesi);
        $this->assertEquals(WorkerType::DIRIGENTE, $pesi->type);
        $this->assertEquals(2024, $pesi->anno);
    }

    /** @test */
    public function it_calculates_total_weight(): void
    {
        $pesi = IndividualePesi::factory()->create([
            'peso_esperienza_acquisita' => 20,
            'peso_risultati_ottenuti' => 30,
            'peso_arricchimento_professionale' => 25,
            'peso_impegno' => 15,
            'peso_qualita_prestazione' => 10,
        ]);

        $this->assertEquals(100, $pesi->total_weight);
    }
}
```

### Test dei Data Objects

```php
declare(strict_types=1);

namespace Tests\Unit\Data;

use Tests\TestCase;
use Modules\Performance\Data\PerformanceScoreData;
use InvalidArgumentException;

class PerformanceScoreDataTest extends TestCase
{
    /** @test */
    public function it_can_create_performance_score_data(): void
    {
        $data = new PerformanceScoreData(
            score: 95.5,
            type: 'DIRIGENTE',
            year: 2024
        );

        $this->assertEquals(95.5, $data->score);
        $this->assertEquals('DIRIGENTE', $data->type);
        $this->assertEquals(2024, $data->year);
    }

    /** @test */
    public function it_validates_score_range(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PerformanceScoreData(
            score: 101, // Invalid score > 100
            type: 'DIRIGENTE',
            year: 2024
        );
    }
}
```

## Feature Test

### Test delle Actions

```php
declare(strict_types=1);

namespace Tests\Feature\Actions;

use Tests\TestCase;
use Modules\Performance\Actions\CalculatePerformanceScoreAction;
use Modules\Performance\Models\IndividualePesi;

class CalculatePerformanceScoreActionTest extends TestCase
{
    /** @test */
    public function it_calculates_performance_score(): void
    {
        $pesi = IndividualePesi::factory()->create([
            'peso_esperienza_acquisita' => 20,
            'peso_risultati_ottenuti' => 30,
        ]);

        $action = app(CalculatePerformanceScoreAction::class);
        $score = $action->execute($pesi);

        $this->assertIsFloat($score);
        $this->assertGreaterThanOrEqual(0, $score);
        $this->assertLessThanOrEqual(100, $score);
    }
}
```

### Test delle Filament Resources

```php
declare(strict_types=1);

namespace Tests\Feature\Resources;

use Tests\TestCase;
use Modules\Performance\Models\IndividualePesi;
use Modules\Performance\Filament\Resources\IndividualePesiResource;
use Livewire\Livewire;

class IndividualePesiResourceTest extends TestCase
{
    /** @test */
    public function it_can_render_list_page(): void
    {
        $this->actingAs($this->createUser());

        Livewire::test(IndividualePesiResource\Pages\ListIndividualePesis::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords(
                IndividualePesi::factory()->count(3)->create()
            );
    }

    /** @test */
    public function it_can_create_record(): void
    {
        $this->actingAs($this->createUser());

        $newData = IndividualePesi::factory()->make()->toArray();

        Livewire::test(IndividualePesiResource\Pages\CreateIndividualePesi::class)
            ->fillForm($newData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('peso_performance_individuale', $newData);
    }
}
```

## Best Practices

### Preparazione dei Test

1. Utilizzare Factory per la creazione dei dati di test
```php
class IndividualePesiFactory extends Factory
{
    protected $model = IndividualePesi::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(WorkerType::cases()),
            'anno' => $this->faker->year(),
            'peso_esperienza_acquisita' => $this->faker->numberBetween(0, 100),
            // ...
        ];
    }
}
```

2. Creare Trait per funzionalità comuni
```php
trait WithPerformanceData
{
    protected function createPerformanceData(): array
    {
        return [
            'type' => WorkerType::DIRIGENTE,
            'anno' => date('Y'),
            // ...
        ];
    }
}
```

### Assertions Personalizzate

```php
trait PerformanceAssertions
{
    public function assertValidPerformanceScore($score): void
    {
        $this->assertIsFloat($score);
        $this->assertGreaterThanOrEqual(0, $score);
        $this->assertLessThanOrEqual(100, $score);
    }
}
```

### Database Transactions

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup comune per tutti i test
        $this->seed(PerformanceSeeder::class);
    }
}
```

## Continuous Integration

### GitHub Actions Workflow

```yaml
name: Performance Module Tests

on:
  push:
    paths:
      - 'Modules/Performance/**'
      - '.github/workflows/performance-tests.yml'
  pull_request:
    paths:
      - 'Modules/Performance/**'

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
        
      - name: Execute tests
        run: vendor/bin/phpunit --testsuite=Performance
```

## Coverage Report

```bash
# Generare report di coverage
php artisan test --coverage --min=80

# Generare report HTML dettagliato
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html coverage
``` 