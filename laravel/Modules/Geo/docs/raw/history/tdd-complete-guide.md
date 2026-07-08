# TDD - Test-Driven Development Complete Guide

## Cos'è TDD?

Test-Driven Development (TDD) è una metodologia di sviluppo software che enfatizza la scrittura dei test prima del codice di implementazione.

### Ciclo Red-Green-Refactor

```
🔴 RED    → Scrivi un test che fallisce
🟢 GREEN  → Scrivi il minimo codice per far passare il test
🔵 REFACTOR → Migliora il codice mantenendo i test verdi
```

---

## Perché TDD?

### Vantaggi

1. **Qualità del codice superiore** - Il design emerge dai test
2. **Bug catturati in anticipo** - Errori trovati subito
3. **Feedback immediato** - Sai subito se qualcosa è rotto
4. **Documentazione eseguibile** - I test documentano il comportamento
5. **Refactoring sicuro** - Cambiamenti senza paura
6. **Meno regressioni** - Bug non si ripresentano

### Quando Usare TDD

- Nuove feature e funzionalità
- Bug fix (test che riproduce il bug prima del fix)
- Refactoring (test come rete di sicurezza)
- API e integrazioni
- Business logic critica

---

## TDD in Laravel 12 con Pest

### Setup

```bash
# Installazione Pest
composer remove phpunit/phpunit
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### Configurazione Testing

```env
# .env.testing
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=array
```

---

## Esempio Pratico: Task Management

### Step 1: RED - Scrivi il test che fallisce

```php
// tests/Feature/TaskTest.php
use App\Models\Task;
use App\Models\User;

it('can create a new task', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->postJson('/api/tasks', [
            'title' => 'Complete Laravel TDD article',
            'description' => 'Write a comprehensive guide',
            'due_date' => '2024-12-31',
            'priority' => 'high',
        ]);
    
    $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => ['id', 'title', 'description', 'due_date', 'priority', 'status']
        ]);
    
    $this->assertDatabaseHas('tasks', [
        'title' => 'Complete Laravel TDD article',
    ]);
});
```

Esegui il test:
```bash
php artisan test --filter="can create a new task"
# Risultato: FALLISCE (nessuna route, controller, model)
```

### Step 2: GREEN - Codice minimo per passare

Crea la migration:
```bash
php artisan make:migration create_tasks_table
```

```php
// database/migrations/xxxx_create_tasks_table.php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('due_date')->nullable();
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
```

Crea il model:
```bash
php artisan make:model Task
```

```php
// app/Models/Task.php
class Task extends Model
{
    protected $fillable = ['title', 'description', 'due_date', 'priority', 'status', 'user_id'];
    
    protected $casts = ['due_date' => 'date'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

Crea il controller:
```bash
php artisan make:controller Api/TaskController --api
```

```php
// app/Http/Controllers/Api/TaskController.php
class TaskController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'priority' => $request->priority ?? 'medium',
            'user_id' => $request->user()->id,
        ]);
        
        return response()->json(['data' => $task], 201);
    }
}
```

Aggiungi la route:
```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
```

Esegui il test:
```bash
php artisan test --filter="can create a new task"
# Risultato: PASSA ✅
```

### Step 3: REFACTOR - Migliora il codice

Aggiungi validazione con Form Request:
```bash
php artisan make:request StoreTaskRequest
```

```php
// app/Http/Requests/StoreTaskRequest.php
class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after:today',
            'priority' => 'in:low,medium,high',
        ];
    }
}
```

Refactorizza il controller:
```php
public function store(StoreTaskRequest $request): JsonResponse
{
    $task = Task::create([
        ...$request->validated(),
        'user_id' => $request->user()->id,
    ]);
    
    return response()->json(['data' => $task], 201);
}
```

Esegui i test per verificare:
```bash
php artisan test
# Tutti i test passano ✅
```

---

## Test Struttura nei Moduli

```
Modules/{ModuleName}/
├── tests/
│   ├── Pest.php              # Configurazione
│   ├── Unit/
│   │   ├── Models/
│   │   │   └── {Model}Test.php
│   │   ├── Actions/
│   │   │   └── {Action}Test.php
│   │   └── Services/
│   │       └── {Service}Test.php
│   ├── Feature/
│   │   ├── {Feature}Test.php
│   │   └── Filament/
│   │       └── {Resource}Test.php
│   └── TestCase.php
```

---

## AAA Pattern

```php
it('creates a task and assigns to user', function () {
    // Arrange - prepara i dati
    $user = User::factory()->create();
    $taskData = [
        'title' => 'Complete Laravel TDD',
        'description' => 'Write a comprehensive guide',
    ];
    
    // Act - esegui l'azione
    $response = $this->actingAs($user)
        ->postJson('/api/tasks', $taskData);
    
    // Assert - verifica il risultato
    $response->assertStatus(201);
    expect($response->json('data.title'))->toBe('Complete Laravel TDD');
});
```

---

## Best Practices

### Naming dei Test

```php
// ✅ CORRETTO - nome descrittivo
it('creates a task with valid data and assigns it to the authenticated user', function () {});
it('validates required title when creating a task', function () {});
it('cannot create task without authentication', function () {});

// ❌ SBAGLIATO - troppo generico
it('test_create', function () {});
it('works', function () {});
```

### Edge Cases

```php
describe('Task Validation', function () {
    it('rejects tasks with past due dates', function () {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => 'Test',
                'due_date' => '2020-01-01',
            ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['due_date']);
    });
    
    it('handles extremely long task titles gracefully', function () {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => str_repeat('a', 300),
            ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    });
});
```

### Factory States

```php
// database/factories/TaskFactory.php
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'status' => 'pending',
            'priority' => 'medium',
            'user_id' => User::factory(),
        ];
    }
    
    public function completed(): static
    {
        return $this->state(fn () => ['status' => 'completed']);
    }
    
    public function highPriority(): static
    {
        return $this->state(fn () => ['priority' => 'high']);
    }
}

// Usage
$completedTask = Task::factory()->completed()->create();
```

---

## Comandi Utili

```bash
# Esegui tutti i test
php artisan test

# Test singolo
php artisan test --filter="test_name"

# Test con coverage
php artisan test --coverage

# Coverage minima
php artisan test --coverage --min=80

# Test parallelo
php artisan test --parallel

# Stop al primo fallimento
php artisan test --stop-on-failure

# Test modulo specifico
./vendor/bin/pest Modules/{Module}/tests
```

---

## Risorse

- [Laravel Testing](https://laravel.com/docs/testing)
- [Pest Documentation](https://pestphp.com/docs)
- [Laracasts - Build a Laravel App with TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd)
- [PEST Driven Laravel Course](https://pestdrivenlaravel.com/)
