# Test Driven Development (TDD) in Laravel - Guida Completa

## Overview

Questa guida raccoglie le best practice per TDD in Laravel, specificamente adattate per il progetto Laraxot/PTVX con Filament v5, Pest v4 e PHPStan Level 10.

## Risorse di Studio

### Serie Laracasts
- [Build a Laravel App with TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd) - Serie completa su TDD
- [Let's Build a Forum with Laravel](https://laracasts.com/series/lets-build-a-forum-with-laravel) - Esempio pratico

### Documentazione Pest PHP
- [Pest Installation](https://pestphp.com/docs/installation) - Framework testing moderno
- Pest v4 è lo standard per questo progetto

### Laravel Modules (nWidart)
- [nWidart/laravel-modules](https://github.com/nWidart/laravel-modules) - Gestione moduli Laravel
- Ogni modulo deve avere i propri test in `Modules/{Module}/tests/`

### Filament TDD
- [Filament TDD Example](https://github.com/leandrocfe/filament-tdd-example) - Repository di esempio
- [Testing Filament Panels](https://filamentphp.com/content/leandrocfe-how-to-write-tests-for-filament-admin-panels) - Guida ufficiale

## Principi Fondamentali TDD

### Ciclo Red-Green-Refactor

1. **Red**: Scrivi un test che fallisce
2. **Green**: Scrivi il codice minimo per far passare il test
3. **Refactor**: Migliora il codice mantenendo i test verdi

### Struttura Test nel Progetto

```
Modules/{ModuleName}/
├── tests/
│   ├── Feature/          # Test di integrazione/feature
│   │   ├── Filament/     # Test risorse Filament
│   │   ├── Http/         # Test controller/routes
│   │   └── Actions/      # Test QueueableActions
│   └── Unit/             # Test unitari
│       ├── Models/       # Test modelli
│       ├── Services/     # Test servizi
│       └── Helpers/      # Test helper
```

## Convenzioni di Naming

### File di Test

- **PascalCase** matching class name: `GenerateDbDocumentationCommandTest.pest.php`
- **Mai** lowercase: ~~`generatedbdocumentationcommandtest.pest.php`~~ ❌
- Suffix `.pest.php` per test Pest

### Metodi di Test

```php
// Pattern: it('description')
it('creates user successfully', function () {
    // Arrange
    $data = UserData::factory()->make();
    
    // Act
    $user = CreateUserAction::execute($data);
    
    // Assert
    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe($data->name);
});

// Pattern: test('description')
test('user can login', function () {
    // ...
});
```

## Best Practice per Test Filament

### Test Risorse

```php
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

it('can render list page', function () {
    Livewire::test(ListUsers::class)
        ->assertSuccessful();
});

it('can create record', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified();
});

it('validates required fields', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => '',
            'email' => '',
        ])
        ->call('create')
        ->assertHasFormErrors(['name', 'email']);
});
```

### Test Tabelle

```php
it('can search records', function () {
    $users = User::factory()->count(5)->create();
    
    Livewire::test(ListUsers::class)
        ->searchTable($users->first()->name)
        ->assertCanSeeTableRecords([$users->first()]);
});

it('can sort records', function () {
    $users = User::factory()->count(3)->create();
    
    Livewire::test(ListUsers::class)
        ->sortTable('name')
        ->assertCanSeeTableRecords($users->sortBy('name'));
});
```

## Test Actions (Spatie QueueableAction)

```php
use Spatie\QueueableAction\QueueableAction;

it('executes action successfully', function () {
    $action = new ProcessDataAction();
    
    $result = $action->execute(
        new ProcessDataInput('test-data')
    );
    
    expect($result)->toBeInstanceOf(ProcessDataOutput::class);
    expect($result->status)->toBe('success');
});

it('handles action failure', function () {
    $action = new ProcessDataAction();
    
    expect(fn () => $action->execute(null))
        ->toThrow(InvalidArgumentException::class);
});
```

## Test Modelli

```php
it('has correct fillable attributes', function () {
    $model = new User();
    
    expect($model->getFillable())->toContain('name', 'email');
});

it('has required relationships', function () {
    $user = User::factory()->create();
    
    expect($user->teams())->toBeInstanceOf(BelongsToMany::class);
});

it('casts attributes correctly', function () {
    $user = User::factory()->create([
        'is_active' => true,
        'created_at' => '2024-01-01',
    ]);
    
    expect($user->is_active)->toBeBool();
    expect($user->created_at)->toBeInstanceOf(Carbon::class);
});
```

## Comandi Testing

```bash
# Esegui tutti i test
./vendor/bin/pest

# Esegui test specifico
./vendor/bin/pest --filter="test_name"

# Esegui test per modulo
./vendor/bin/pest Modules/Xot/tests

# Coverage report
./vendor/bin/pest --coverage

# Parallel testing
./vendor/bin/pest --parallel

# Watch mode
./vendor/bin/pest --watch
```

## Pattern AAA (Arrange-Act-Assert)

```php
it('follows AAA pattern', function () {
    // ARRANGE: Setup
    $user = User::factory()->create();
    $data = ['name' => 'Updated Name'];
    
    // ACT: Execute
    $result = UpdateUserAction::execute($user, $data);
    
    // ASSERT: Verify
    expect($result->name)->toBe('Updated Name');
    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
    ]);
});
```

## Mocking e Fakes

```php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

it('sends notification', function () {
    Notification::fake();
    
    $user = User::factory()->create();
    
    SendWelcomeNotification::execute($user);
    
    Notification::assertSentTo(
        $user,
        WelcomeNotification::class
    );
});

it('queues email', function () {
    Mail::fake();
    
    $user = User::factory()->create();
    
    SendReportEmail::execute($user);
    
    Mail::assertQueued(ReportEmail::class);
});
```

## Testing Database

```php
uses()->group('database');

beforeEach(function () {
    // Refresh database per test
    $this->refreshDatabase();
});

it('creates database record', function () {
    $user = User::factory()->create();
    
    assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => $user->email,
    ]);
});

it('uses transactions', function () {
    // Ogni test usa transazione
    // Rollback automatico dopo il test
});
```

## Collegamenti

- [Pest Documentation](https://pestphp.com/)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Filament Testing](https://filamentphp.com/docs/testing)
- [AGENTS.md](../AGENTS.md) - Code Style Guidelines

---

**Ultimo aggiornamento**: 2026-02-24  
**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan Level 10
