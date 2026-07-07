# Laravel 12 + Qualita Codice — Pacchetti Core

Riferimento per Laravel 12, Pest 4, PHPStan 2, Pint, Rector, Pulse, Pennant, MCP.

## Stack versioni

| Pacchetto | Versione |
|-----------|----------|
| laravel/framework | 12.53.0 |
| pestphp/pest | 4.4.1 |
| pestphp/pest-plugin-arch | 4.0.0 |
| pestphp/pest-plugin-mutate | 4.0.1 |
| pestphp/pest-plugin-type-coverage | 4.0.3 |
| phpstan/phpstan | 2.1.40 |
| larastan/larastan | 3.9.2 |
| laravel/pint | 1.27.1 |
| rector/rector | 2.3.8 |
| driftingly/rector-laravel | 2.1.9 |
| nunomaduro/phpinsights | 2.14.0 |
| laravel/pennant | 1.20.0 |
| laravel/pulse | 1.6.0 |
| laravel/mcp | 0.5.9 |

---

## Laravel 12 — Principali novita

- PHP 8.2+ minimo, pieno supporto PHP 8.4
- `Concurrency` namespace per pattern lottery/feature-flag
- Lazy properties su model Eloquent
- Composite keys nativi
- Enum nativi nei cast Eloquent
- Piena integrazione Pest 4 come framework di test primario

### Pattern model Laravel 12

```php
namespace Modules\Job\Models;

class Task extends BaseModel
{
    // Connection auto-discovered da namespace
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'is_active' => 'boolean',
            'parameters' => 'json',
            'status' => TaskStatus::class, // Enum nativo Laravel 12
        ]);
    }
}
```

---

## Pest 4.4.1 — Testing

### Regola CRITICA: mai RefreshDatabase

```php
// VIETATO
use Illuminate\Foundation\Testing\RefreshDatabase;

// Corretto: .env.testing + DB dedicato
// XDEBUG_MODE=off ./vendor/bin/pest
```

### Sintassi Pest 4

```php
<?php
declare(strict_types=1);

uses(\Modules\MyModule\Tests\TestCase::class);

it('creates a survey with required fields', function (): void {
    $survey = Survey::factory()->create(['title' => 'Test Survey']);

    expect($survey->title)->toBe('Test Survey')
        ->and($survey->id)->not->toBeNull();
});

dataset('locales', ['it', 'en', 'fr']);

it('translates correctly for locale', function (string $locale): void {
    app()->setLocale($locale);
    // ...
})->with('locales');
```

### Expect API

```php
expect($value)->toBe('exact')            // ===
expect($value)->toEqual('loose')         // ==
expect($value)->toBeString()
expect($value)->toBeInt()
expect($value)->toBeNull()
expect($value)->toBeInstanceOf(Model::class)
expect($value)->toBeGreaterThan(5)
expect($array)->toHaveCount(5)
expect($array)->toHaveKey('key')
expect(fn() => throw new Exception)->toThrow(Exception::class)
```

### Arch testing (pest-plugin-arch)

```php
arch('actions sono classi finali')
    ->expect('Modules\*\Actions\*')
    ->toBeFinal();

arch('models estendono BaseModel')
    ->expect('Modules\*\Models\*')
    ->toExtend(\Modules\Xot\Models\BaseModel::class);

arch('no debug in produzione')
    ->expect('Modules\*')
    ->not->toUse(['dd', 'dump', 'var_dump', 'ray']);
```

### Type coverage (pest-plugin-type-coverage)

```bash
XDEBUG_MODE=off ./vendor/bin/pest --type-coverage --min=100
```

### Mutation testing (pest-plugin-mutate)

```bash
XDEBUG_MODE=off ./vendor/bin/pest --mutate
```

### Comandi

```bash
# Dalla cartella laravel/
XDEBUG_MODE=off ./vendor/bin/pest                    # tutti i test
XDEBUG_MODE=off ./vendor/bin/pest --coverage         # con coverage
XDEBUG_MODE=off ./vendor/bin/pest --coverage --min=80

# Modulo specifico
XDEBUG_MODE=off ./vendor/bin/pest Modules/Quaeris/tests

# Via composer
composer coverage
```

### PCOV — driver coverage

`pcov.enabled` e `xdebug.mode` sono `PHP_INI_SYSTEM`: NON modificabili con `ini_set()`.
Usare sempre `XDEBUG_MODE=off` come variabile d'ambiente.

---

## PHPStan 2.1.40 + Larastan 3.9.2

### Regola ASSOLUTA: mai toccare `laravel/phpstan.neon`

Non creare `phpstan.local.neon` o altri file. Usare sempre:
```bash
cd laravel && ./vendor/bin/phpstan analyse
```

### PHPStan 2.x vs 1.x

- Generics completi: `array<string, Column>`
- Flow analysis migliorata
- 2-3x piu veloce (parallelismo)
- Supporto PHP 8.4 completo
- Tipo `mixed` ancora piu restrittivo

### Regole Level 10 (obbligatorie)

```php
// NO: mixed type
public function getData(): mixed { }

// SI: union type
public function getData(): string|int|null { }

// NO: array_values() su Filament returns
return array_values($columns);

// SI: chiavi stringa preservate
return ['id' => TextColumn::make('id'), 'name' => TextColumn::make('name')];

// NO: property_exists() su modelli
if (property_exists($model, 'email')) { }

// SI: isset() per magic properties
if (isset($model->email)) { }
```

---

## Laravel Pint 1.27.1

```bash
cd laravel

# Formatta tutto (from-commit: only dirty files)
./vendor/bin/pint --dirty

# Controlla senza modificare
./vendor/bin/pint --test

# File specifico
./vendor/bin/pint Modules/Job/app/Models/Task.php
```

---

## Rector 2.3.8

```bash
# Dry-run (nessuna modifica)
./vendor/bin/rector --dry-run

# Applica
./vendor/bin/rector

# Modulo specifico
./vendor/bin/rector Modules/Job/ --dry-run
```

**Configurazione in** `laravel/rector.php`:
- `InlineConstructorDefaultToPropertyRector` — constructor promotion
- `TypedPropertyFromStrictConstructorRector` — typed properties
- `LevelSetList::UP_TO_PHP_81` — PHP 8.1 compat
- `SetList::TYPE_DECLARATION` — aggiunge type declarations

---

## Laravel Pennant 1.20.0 — Feature Flags

```php
// Definizione flag
Feature::define('new-survey-builder', fn () => Lottery::odds(1, 10)); // 10%

// Uso
if (Feature::for(Auth::user())->active('new-survey-builder')) {
    return redirect()->route('surveys.build-v2', $survey);
}

// Per tenant
Feature::for($tenant)->activate('premium-features');
Feature::for($tenant)->deactivate('premium-features');
Feature::for($tenant)->toggle('premium-features');

// In Blade
@if(Feature::for($user)->active('premium-features'))
    <x-premium-panel />
@endif
```

**Storage**: tabella `features` (migration da pubblicare).

---

## Laravel Pulse 1.6.0 — Monitoring

Dashboard real-time su `/pulse`. Monitora:
- Slow queries (> 1000ms)
- Slow requests
- Failed jobs
- Memory usage
- Cache hit rate

```php
// Metriche custom
Pulse::record('survey.exported', ['survey_id' => $id, 'duration' => $ms]);

Pulse::measure('survey.pdf.generation', function () {
    return generatePdf($survey);
});
```

**Storage**: SQLite in `storage/pulse.sqlite`, retention 1 settimana.

---

## Laravel MCP 0.5.9 — Model Context Protocol

Espone l'applicazione all'AI (Claude, ecc.) tramite MCP protocol.

```php
use Laravel\Mcp\Server;

$server = new Server('quaeris-surveys');

// Resources (dati che l'AI puo leggere)
$server->resource('surveys', new Resource(
    uri: 'surveys://all',
    name: 'All Surveys',
    text: fn () => Survey::all()->toJson()
));

// Tools (azioni che l'AI puo eseguire)
$server->tool('create-survey', new Tool(
    name: 'Create Survey',
    inputSchema: [
        'type' => 'object',
        'properties' => ['title' => ['type' => 'string']],
        'required' => ['title'],
    ],
    handler: fn (array $input) => Survey::create($input)
));
```

```bash
# Avvio server MCP
php artisan mcp:serve
php artisan mcp:serve --stdio  # per MCP Desktop
```

---

## Checklist pre-commit

```bash
cd laravel
./vendor/bin/pint --dirty                  # stile
./vendor/bin/phpstan analyse               # tipo safety
XDEBUG_MODE=off ./vendor/bin/pest          # test
```
