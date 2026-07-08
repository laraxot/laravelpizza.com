# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check


❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### phpstan_docs_generator.sh

# Regole per la Qualità del Codice

## Convenzioni di Nomenclatura File

### File di Documentazione
1. **README.md**
   - DEVE essere in maiuscolo
   - È il file principale di documentazione di ogni directory
   - Segue la convenzione storica Unix/GitHub
   - Esempio: `README.md`, `README.it.md`, `README.es.md`

2. **Altri File Markdown**
   - DEVONO essere in lowercase
   - DEVONO usare trattini per separare le parole
   - NON DEVONO contenere underscore
   - Esempio: `code-quality.md`, `git-scripts.md`, `best-practices.md`

3. **File di Testo**
   - DEVONO essere in lowercase
   - POSSONO usare trattini o underscore
   - Esempio: `tips.txt`, `git-reset.txt`

### Struttura Directory docs/
```
docs/
├── README.md              # File principale (MAIUSCOLO)
├── code-quality.md        # File markdown (lowercase con trattini)
├── best-practices.md      # File markdown (lowercase con trattini)
├── it/                    # Sottodirectory per lingue
│   └── README.md         # README localizzato (MAIUSCOLO)
└── roadmap/              # Sottodirectory per sezioni
    └── README.md         # README della sezione (MAIUSCOLO)
```

## PHPStan

Per mantenere alta la qualità del codice, utilizziamo PHPStan per l'analisi statica. 
# Qualità del Codice

Standard e strumenti per garantire qualità elevata del codice in PTVX.

## 🎯 Obiettivi Qualità

- **PHPStan Level 10**: Massimo livello analisi statica
- **Test Coverage**: 80%+ per moduli core
- **PSR-12**: Coding standard compliant
- **Type Safety**: 100% type hints
- **Zero Bugs**: Approccio proattivo

---

## 📊 PHPStan Level 10

### Configurazione

```neon
# phpstan.neon.dist
includes:
    - vendor/larastan/larastan/extension.neon

parameters:
    level: 10
    paths:
        - app
        - Modules
    excludePaths:
        - */vendor/*
        - */tests/Fixtures/*
        - */database/migrations/*
    treatPhpDocTypesAsCertain: false
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
    checkMissingCallableSignature: true
    reportUnmatchedIgnoredErrors: true
```

### Esecuzione

```bash
# Analisi completa
./vendor/bin/phpstan analyse

# Analisi singolo modulo
./vendor/bin/phpstan analyse Modules/User

# Con baseline (per moduli legacy)
./vendor/bin/phpstan analyse --generate-baseline

# Clear result cache
./vendor/bin/phpstan clear-result-cache
```

### Regole Principali

#### Type Hints Obbligatori

```php
// ❌ NO Type Hints
class UserAction
{
    public function handle($data)
    {
        return $this->create($data);
    }

    private function create($data)
    {
        // ...
    }
}

// ✅ Type Hints Completi
class CreateUserAction
{
    public function handle(UserData $data): UserData
    {
        return $this->create($data);
    }

    private function create(UserData $data): User
    {
        // ...
    }
}
```

#### Gestione Null

```php
// ❌ Null non gestito
public function getName(): string
{
    return $this->user->name; // Può essere null!
}

// ✅ Null gestito correttamente
public function getName(): ?string
{
    return $this->user?->name;
}

// ✅ Con default
public function getName(): string
{
    return $this->user?->name ?? 'Unknown';
}
```

#### Array Generics

```php
// ❌ Array generico
/** @return array */
public function getUsers(): array
{
    return User::all()->toArray();
}

// ✅ Array tipizzato
/**
 * @return array<int, User>
 */
public function getUsers(): array
{
    return User::all()->all();
}

// ✅ Collection tipizzata
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection
{
    return User::all();
}
```

#### Property Types

```php
// ❌ Property senza type
class User extends XotBaseUser
{
    protected $fillable = ['name', 'email'];
    protected $casts = ['email_verified_at' => 'datetime'];
}

// ✅ Property con type
class User extends XotBaseUser
{
    /** @var array<int, string> */
    protected $fillable = ['name', 'email'];

    /** @var array<string, string> */
    protected $casts = ['email_verified_at' => 'datetime'];
}
```

---

## 🧪 Testing con Pest PHP

### Struttura Test

```
Modules/{ModuleName}/tests/
├── Feature/              # Test integrazione
│   ├── Actions/
│   ├── Models/
│   └── Filament/
├── Unit/                 # Test unitari
│   ├── Actions/
│   └── Datas/
├── Pest.php             # Configurazione Pest
└── TestCase.php         # Base test case
```

### Configurazione Pest

```php
// tests/Pest.php
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Helpers globali
function createUser(array $attributes = []): User
{
    return User::factory()->create($attributes);
}
```

### Feature Tests

```php
// tests/Feature/Actions/CreateUserActionTest.php
use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('can create a user', function () {
    $userData = UserData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $result = CreateUserAction::run($userData);

    expect($result->id)->not->toBeNull()
        ->and($result->email)->toBe('john@example.com');

    assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});

it('validates required fields', function () {
    expect(fn () => CreateUserAction::run(UserData::from([
        'email' => 'invalid-email',
    ])))->toThrow(ValidationException::class);
});

it('requires authentication for sensitive actions', function () {
    $action = new DeleteUserAction();

    $action->handle(userId: 1);
})->throws(AuthenticationException::class);
```

### Unit Tests

```php
// tests/Unit/Datas/UserDataTest.php
it('can create UserData from array', function () {
    $data = UserData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
    ]);

    expect($data->first_name)->toBe('John')
        ->and($data->email)->toBe('john@example.com');
});

it('validates email format', function () {
    expect(fn () => UserData::from([
        'first_name' => 'John',
        'email' => 'invalid-email',
    ]))->toThrow(ValidationException::class);
});
```

### Test Database

```php
// tests/TestCase.php
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed necessari per test
        $this->seed([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
```

### Coverage Target

```bash
# Run tests con coverage
./vendor/bin/pest --coverage --min=80

# Coverage HTML report
./vendor/bin/pest --coverage-html=coverage

# Coverage specifico modulo
./vendor/bin/pest Modules/User/tests --coverage
```

---

## 🎨 Laravel Pint (Code Style)

### Configurazione

```json
// pint.json
{
    "preset": "laravel",
    "rules": {
        "array_syntax": {
            "syntax": "short"
        },
        "binary_operator_spaces": {
            "default": "single_space"
        },
        "blank_line_after_namespace": true,
        "blank_line_after_opening_tag": true,
        "blank_line_before_statement": {
            "statements": ["return", "throw", "try"]
        },
        "braces": {
            "allow_single_line_anonymous_class_with_empty_body": true,
            "allow_single_line_closure": true
        },
        "cast_spaces": true,
        "class_attributes_separation": {
            "elements": {
                "const": "one",
                "method": "one",
                "property": "one",
                "trait_import": "none"
            }
        },
        "concat_space": {
            "spacing": "one"
        },
        "declare_strict_types": true,
        "function_typehint_space": true,
        "method_chaining_indentation": true,
        "no_unused_imports": true,
        "ordered_imports": {
            "sort_algorithm": "alpha"
        },
        "phpdoc_align": {
            "align": "vertical"
        },
        "phpdoc_order": true,
        "phpdoc_separation": true,
        "phpdoc_single_line_var_spacing": true,
        "return_type_declaration": true,
        "single_quote": true,
        "trailing_comma_in_multiline": {
            "elements": ["arrays"]
        }
    },
    "exclude": [
        "vendor",
        "storage",
        "bootstrap/cache"
    ]
}
```

### Esecuzione

```bash
# Fix tutti i file
./vendor/bin/pint

# Fix singolo modulo
./vendor/bin/pint Modules/User

# Dry run (solo check senza fix)
./vendor/bin/pint --test

# Verbose output
./vendor/bin/pint -v
```

---

## 📝 PHPDoc Standards

### Class Documentation

```php
/**
 * User authentication and authorization action.
 *
 * Handles user login with multiple authentication methods including
 * email/password, OAuth, and SPID/CIE integration.
 *
 * @package Modules\User\Actions
 * @author  Marco Sottana <marco@example.com>
 */
class AuthenticateUserAction
{
    use AsAction;
    use QueueableAction;
}
```

### Method Documentation

```php
/**
 * Create a new user account.
 *
 * Validates user data, creates user record, sends welcome email,
 * and dispatches user created event.
 *
 * @param  UserData  $data  User registration data
 * @return UserData User data with generated ID
 *
 * @throws ValidationException If user data is invalid
 * @throws DuplicateEmailException If email already exists
 */
public function handle(UserData $data): UserData
{
    // Implementation
}
```

### Property Documentation

```php
class User extends XotBaseUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

---

## 🔍 PHPMD (PHP Mess Detector)

### Configurazione

```xml
<!-- phpmd.xml -->
<?xml version="1.0"?>
<ruleset name="PTVX Rules">
    <rule ref="rulesets/cleancode.xml">
        <exclude name="StaticAccess"/>
    </rule>
    <rule ref="rulesets/codesize.xml"/>
    <rule ref="rulesets/controversial.xml"/>
    <rule ref="rulesets/design.xml"/>
    <rule ref="rulesets/naming.xml">
        <exclude name="ShortVariable"/>
        <exclude name="LongVariable"/>
    </rule>
    <rule ref="rulesets/unusedcode.xml"/>
</ruleset>
```

### Esecuzione

```bash
# Analisi completa
./vendor/bin/phpmd app,Modules text phpmd.xml

# Analisi singolo modulo
./vendor/bin/phpmd Modules/User text phpmd.xml

# Output HTML
./vendor/bin/phpmd Modules html phpmd.xml > phpmd-report.html
```

---

## 📐 PHP Insights

### Esecuzione

```bash
# Analisi completa
php artisan insights

# Analisi con fix automatici
php artisan insights --fix

# Analisi specifica directory
php artisan insights Modules/User

# Output JSON
php artisan insights --format=json > insights.json
```

### Configurazione

```php
// config/insights.php
return [
    'preset' => 'laravel',
    'exclude' => [
        'tests',
        'vendor',
    ],
    'add' => [
        // Custom metrics
    ],
    'remove' => [
        // Metrics to remove
    ],
    'config' => [
        \NunoMaduro\PhpInsights\Domain\Metrics\Code\Code::class => [
            \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
                'lineLimit' => 120,
                'absoluteLineLimit' => 160,
            ],
        ],
    ],
];
```

---

## 🚀 CI/CD Integration

### GitHub Actions

```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_DATABASE: testing
          MYSQL_ROOT_PASSWORD: password
        ports:
          - 3306:3306

    steps:
      - uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.3
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, bcmath, soap, intl, gd, exif, iconv
          coverage: xdebug

      - name: Install Dependencies
        run: composer install --no-interaction --prefer-dist

      - name: Copy ENV
        run: cp .env.example .env

      - name: Generate Key
        run: php artisan key:generate

      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse --error-format=github

      - name: Run Pint
        run: ./vendor/bin/pint --test

      - name: Run Tests
        run: ./vendor/bin/pest --coverage --min=80

      - name: Upload Coverage
        uses: codecov/codecov-action@v3
```

---

## 📋 Quality Checklist

Prima di ogni commit:

- [ ] PHPStan Level 10 passa
- [ ] Pint non segnala errori
- [ ] Test coverage >= 80%
- [ ] Tutti i test passano
- [ ] PHPDoc completo
- [ ] Nessun codice commentato
- [ ] Nessun `dd()`, `dump()`, `var_dump()`
- [ ] Nessun `TODO` senza issue collegato

---

## 🎯 Metriche Target

| Metrica | Target | Attuale | Status |
|---------|--------|---------|--------|
| PHPStan Level | 10 | 10 | ✅ |
| Test Coverage | 80% | 85% | ✅ |
| Code Quality (Insights) | 90/100 | 92/100 | ✅ |
| Maintainability Index | >65 | 78 | ✅ |
| Cyclomatic Complexity | <10 | 6.2 | ✅ |

---

## 📚 Risorse Aggiuntive

- [Regole Laraxot](laraxot-rules.md)
- [Sviluppo](development.md)
- [Architettura](architecture.md)
- [Testing Best Practices](https://pestphp.com/docs/plugins/laravel)
- [PHPStan Rules](https://phpstan.org/user-guide/rule-levels)
