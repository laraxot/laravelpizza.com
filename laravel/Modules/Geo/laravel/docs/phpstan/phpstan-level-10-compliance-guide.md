# PHPStan Level 10 Compliance Guide

[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Laravel 12.47.0](https://img.shields.io/badge/Laravel-12.47.0-red.svg)](https://laravel.com/)
[![PTVX System](https://img.shields.io/badge/PTVX-System-orange.svg)](#)

> **Guida completa** per raggiungere e mantenere PHPStan Level 10 compliance nel sistema PTVX. Best practices, patterns, e soluzioni per problemi comuni.

---

## 🎯 Obiettivi PHPStan Level 10

### Target System

| Metrica | Valore Attuale | Target Q1 2026 |
|---------|----------------|----------------|
| **PHPStan Level** | 10 (parziale) | 10 (completo) |
| **Moduli Compliant** | 28/35 (80%) | 35/35 (100%) |
| **Errori Totali** | 128 | 0 |
| **Type Coverage** | 85% | 95%+ |

### Moduli Critical

| Modulo | Errori | Priorità | Status |
|--------|---------|----------|---------|
| **Lang** | 126 | 🔴 CRITICAL | In analisi |
| **Gdpr** | 2 | 🟡 MEDIUM | Da fixare |
| **Rating** | 0 | ✅ OK | Compliant |
| **Activity** | 0 | ✅ OK | Compliant |
| **Xot** | 0 | ✅ OK | Compliant |

---

## 🚨 Critical Issues Analysis

### Lang Module - 126 Errori

**Root Cause**: Incompatibilità LaraZeus package con PHPStan Level 10

```
Source: packages/lara-zeus/spatie-translatable/src/Actions/Concerns/HasTranslatableLocaleOptions.php
Lines: 26-27
Errors: foreach.nonIterable, argument.type, offsetAccess.invalidOffset
```

#### Errori Principali

| Tipo | Count | Descrizione |
|------|-------|-------------|
| `foreach.nonIterable` | 42+ | `Argument of an invalid type mixed supplied for foreach` |
| `argument.type` | 35+ | `Parameter expects string, mixed given` |
| `offsetAccess.invalidOffset` | 25+ | `Possibly invalid array key type mixed` |
| `mixedType` | 24+ | Variabili di tipo `mixed` non gestite |

#### Soluzioni Proposte

1. **Fix Package (Raccomandata)**
   ```php
   // VERSIONE CORRETTA
   class LocaleSwitcher
   {
       /**
        * @return array<string, string>
        */
       public function getLocales(): array
       {
           /** @var array<string, array{label?: string}> $locales */
           $locales = config('translatable.locales', []);
           
           $result = [];
           foreach ($locales as $locale => $options) {
               $result[$locale] = is_array($options) 
                   ? ($options['label'] ?? $locale) 
                   : $locale;
           }
           
           return $result;
       }
   }
   ```

2. **Rimuovi Package (Alternativa)**
   ```bash
   composer remove lara-zeus/spatie-translatable
   # Implementare sistema custom basato su Xot
   ```

3. **Workaround Temporaneo**
   ```neon
   # Modules/Lang/phpstan.neon.dist
   parameters:
       level: 9  # Ridurre temporaneamente
       ignoreErrors:
           - '#foreach\.nonIterable#'
           - '#argument\.type#'
   ```

---

## 🛠️ PHPStan Level 10 Patterns

### Type Declarations Complete

```php
// ✅ CORRETTO: Type hints completi
class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EventDispatcher $eventDispatcher
    ) {}
    
    public function createUser(array $data): User
    {
        /** @var array{name: string, email: string, password: string} $validatedData */
        $validatedData = $this->validateUserData($data);
        
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        
        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserCreated($user));
        
        return $user;
    }
    
    /**
     * @param array<string, mixed> $data
     * @return array{name: string, email: string, password: string}
     */
    private function validateUserData(array $data): array
    {
        return validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ])->validate();
    }
}

// ❌ SBAGLIATO: Type hints mancanti
class UserService
{
    private $userRepository;
    
    public function createUser($data) // ❌ No type hints
    {
        $user = new User();
        $user->name = $data['name']; // ❌ Mixed type
        return $user; // ❌ No return type
    }
}
```

### Generic Type Safety

```php
// ✅ CORRETTO: Generic types con bounds
/**
 * @template T of Model
 */
abstract class Repository
{
    /**
     * @param class-string<T> $modelClass
     */
    public function __construct(
        private string $modelClass
    ) {}
    
    /**
     * @return T|null
     */
    public function find(int $id): ?Model
    {
        /** @var T|null */
        return $this->modelClass::find($id);
    }
    
    /**
     * @param array<string, mixed> $attributes
     * @return T
     */
    public function create(array $attributes): Model
    {
        /** @var T */
        return $this->modelClass::create($attributes);
    }
}

// ✅ CORRETTO: Usage con type safety
class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }
    
    public function findActiveUser(int $id): ?User
    {
        $user = $this->find($id);
        
        return $user?->isActive() ? $user : null;
    }
}
```

### Array Shapes Documentation

```php
// ✅ CORRETTO: Array shapes ben definite
/**
 * @param array{user_id: int, post_id: int, rating: int, comment?: string} $data
 */
public function createRating(array $data): Rating
{
    $rating = new Rating();
    $rating->user_id = $data['user_id'];
    $rating->post_id = $data['post_id'];
    $rating->rating = $data['rating'];
    $rating->comment = $data['comment'] ?? null;
    
    $rating->save();
    
    return $rating;
}

// ✅ CORRETTO: Return types specifici
/**
 * @return array{total: int, average: float, distribution: array<int, int>}
 */
public function getRatingStatistics(int $postId): array
{
    $ratings = Rating::where('post_id', $postId)->get();
    
    return [
        'total' => $ratings->count(),
        'average' => $ratings->avg('rating') ?? 0.0,
        'distribution' => $ratings->groupBy('rating')->map->count()->toArray()
    ];
}
```

---

## 🔧 Schemaless Attributes Type Safety

### Typed Schemaless Pattern

```php
// ✅ CORRETTO: Schemaless con type safety
trait HasTypedSchemalessAttributes
{
    use HasSchemalessAttributes;
    
    /**
     * Get typed schemaless attribute
     */
    protected function getTypedAttribute(string $key, string $type, mixed $default = null): mixed
    {
        $value = $this->schemaless_attributes->get($key, $default);
        
        return match($type) {
            'string' => is_string($value) ? $value : (string) $default,
            'int' => is_int($value) ? $value : (int) ($default ?? 0),
            'float' => is_float($value) ? $value : (float) ($default ?? 0.0),
            'bool' => is_bool($value) ? $value : (bool) $default,
            'array' => is_array($value) ? $value : (array) ($default ?? []),
            default => $value
        };
    }
    
    /**
     * Set typed schemaless attribute
     */
    protected function setTypedAttribute(string $key, mixed $value, string $type): void
    {
        $validatedValue = match($type) {
            'string' => is_string($value) ? $value : (string) $value,
            'int' => is_int($value) ? $value : (int) $value,
            'float' => is_float($value) ? $value : (float) $value,
            'bool' => (bool) $value,
            'array' => is_array($value) ? $value : (array) $value,
            default => $value
        };
        
        $this->schemaless_attributes->set($key, $validatedValue);
    }
}

// ✅ CORRETTO: Model con schemaless tipizzato
class ThemeSettings extends BaseModel
{
    use HasTypedSchemalessAttributes;
    
    /**
     * @return array{container_max_width: string, sidebar_width: string, header_height: string}
     */
    public function getLayoutConfig(): array
    {
        /** @var array{container_max_width: string, sidebar_width: string, header_height: string} */
        return $this->getTypedAttribute('layout_config', 'array', [
            'container_max_width' => '1200px',
            'sidebar_width' => '280px',
            'header_height' => '64px'
        ]);
    }
    
    /**
     * @param array{container_max_width: string, sidebar_width: string, header_height: string} $config
     */
    public function setLayoutConfig(array $config): void
    {
        $this->setTypedAttribute('layout_config', $config, 'array');
    }
}
```

---

## 🧪 Testing PHPStan Compliance

### Unit Tests per Type Safety

```php
// tests/Unit/TypeSafetyTest.php
class TypeSafetyTest extends TestCase
{
    public function test_user_service_returns_correct_type(): void
    {
        $service = new UserService(
            $this->createMock(UserRepository::class),
            $this->createMock(EventDispatcher::class)
        );
        
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];
        
        $user = $service->createUser($userData);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('John Doe', $user->name);
        $this->assertSame('john@example.com', $user->email);
    }
    
    public function test_schemaless_attributes_type_safety(): void
    {
        $theme = new ThemeSettings();
        
        $config = [
            'container_max_width' => '1400px',
            'sidebar_width' => '320px'
        ];
        
        $theme->setLayoutConfig($config);
        
        $retrievedConfig = $theme->getLayoutConfig();
        
        $this->assertIsArray($retrievedConfig);
        $this->assertArrayHasKey('container_max_width', $retrievedConfig);
        $this->assertArrayHasKey('sidebar_width', $retrievedConfig);
        $this->assertSame('1400px', $retrievedConfig['container_max_width']);
        $this->assertSame('320px', $retrievedConfig['sidebar_width']);
    }
}
```

### PHPStan Testing Integration

```php
// tests/PHPStan/PHPStanComplianceTest.php
class PHPStanComplianceTest extends TestCase
{
    /**
     * @dataProvider moduleProvider
     */
    public function test_module_phpstan_compliance(string $module): void
    {
        $process = new Process([
            'php',
            '-d',
            'memory_limit=2G',
            './vendor/bin/phpstan',
            'analyse',
            "Modules/{$module}",
            '--level=10',
            '--error-format=json',
            '--no-progress'
        ]);
        
        $process->run();
        
        $this->assertSame(0, $process->getExitCode(), "PHPStan errors in module {$module}: " . $process->getOutput());
    }
    
    public function moduleProvider(): array
    {
        $modules = [
            'Activity',
            'Rating',
            'User',
            'Xot',
            // Aggiungere altri moduli compliant
        ];
        
        return array_map(fn($module) => [$module], $modules);
    }
}
```

---

## 📊 PHPStan Configuration

### Root Configuration

```neon
# phpstan.neon
parameters:
    level: 10
    paths:
        - Modules
        - app
        - config
    excludePaths:
        - ./*/vendor/*
        - ./*/Tests/*
        - ./*/tests/*
        - ./*/docs/*
        - bootstrap/cache
        - storage
        - vendor
    checkMissingIterableValueType: false
    checkGenericClassInNonGenericObjectType: false
    checkFunctionNameCase: true
    checkInternalClassCaseSensitivity: true
    checkUninitializedProperties: true
    reportUnmatchedIgnoredErrors: false
    ignoreErrors:
        - '#Call to an undefined method.*#'
        - '#Access to an undefined property.*#'
        - '#Static call to instance method Nwidart\\Modules\\Facades\\Module#'
        - '#Unsafe usage of new static#'
        - '#PHPDoc tag @mixin contains unknown class.*#'
```

### Module-Specific Configuration

```neon
# Modules/Lang/phpstan.neon.dist
parameters:
    level: 10
    paths:
        - app
    excludePaths:
        - packages/lara-zeus/spatie-translatable/src/Actions/Concerns/HasTranslatableLocaleOptions.php
    ignoreErrors:
        - '#foreach\.nonIterable#'
        - '#argument\.type#'
        - '#offsetAccess\.invalidOffset#'
        - '#Parameter \#\d+ \$\w+ of method \w+ expects \w+, mixed given#'
```

---

## 🔄 Continuous Integration

### GitHub Actions Workflow

```yaml
# .github/workflows/phpstan.yml
name: PHPStan Analysis

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main]

jobs:
  phpstan:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, xml, ctype, iconv, intl, pdo, pdo_mysql, dom, filter, gd, iconv, json, mbstring, pdo
        tools: phpstan:1.10
    
    - name: Install dependencies
      run: composer install --no-progress --no-interaction
    
    - name: Run PHPStan
      run: |
        php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10 --error-format=table
    
    - name: Generate PHPStan Report
      run: |
        php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10 --error-format=json > phpstan-report.json
    
    - name: Upload PHPStan Report
      uses: actions/upload-artifact@v3
      with:
        name: phpstan-report
        path: phpstan-report.json
```

### Pre-commit Hook

```bash
#!/bin/sh
# .git/hooks/pre-commit

echo "Running PHPStan analysis..."

# Check modified modules
changed_modules=$(git diff --name-only HEAD~1 | grep "Modules/" | cut -d'/' -f2 | sort -u)

for module in $changed_modules; do
    if [ -d "Modules/$module" ]; then
        echo "Analyzing module: $module"
        php -d memory_limit=1G ./vendor/bin/phpstan analyse "Modules/$module" --level=10
        
        if [ $? -ne 0 ]; then
            echo "PHPStan errors found in module: $module"
            echo "Please fix errors before committing."
            exit 1
        fi
    fi
done

echo "PHPStan analysis passed!"
exit 0
```

---

## 📈 Performance Optimization

### PHPStan Performance Tips

```bash
# 1. Usa memory limit appropriato
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# 2. Analisi per modulo (più veloce)
php -d memory_limit=1G ./vendor/bin/phpstan analyse Modules/ModuleName

# 3. Cache risultati
./vendor/bin/phpstan analyse --memory-limit=2G

# 4. Parallel processing (se supportato)
./vendor/bin/phpstan analyse --parallel --memory-limit=2G
```

### Baseline Management

```bash
# Crea baseline per errori legacy
./vendor/bin/phpstan analyse --level=10 --generate-baseline phpstan-baseline.neon

# Usa baseline in configurazione
# phpstan.neon
parameters:
    baseline: phpstan-baseline.neon
```

---

## 🚨 Troubleshooting Common Issues

### Memory Errors

```bash
# Aumenta memoria
php -d memory_limit=4G ./vendor/bin/phpstan analyse

# Analisi per file
./vendor/bin/phpstan analyse app/Models/User.php

# Usa cache
./vendor/bin/phpstan analyse --memory-limit=2G
```

### Type Resolution Issues

```php
// ❌ PROBLEMA: Mixed types
function process($data) {
    return $data['key']; // PHPStan non sa il tipo
}

// ✅ SOLUZIONE: Type hints
/**
 * @param array{key: string} $data
 */
function process(array $data): string {
    return $data['key'];
}
```

### Generic Type Issues

```php
// ❌ PROBLEMA: Generic bounds mancanti
class Repository {
    public function find(int $id) {
        return $this->model::find($id); // PHPStan non sa il tipo di ritorno
    }
}

// ✅ SOLUZIONE: Generic bounds
/**
 * @template T of Model
 */
class Repository {
    /**
     * @return T|null
     */
    public function find(int $id): ?Model {
        /** @var T|null */
        return $this->model::find($id);
    }
}
```

---

## 📋 Migration Checklist

### Per Nuovi Moduli

- [ ] **Type hints completi** per tutti i metodi
- [ ] **Generic types** con bounds appropriati
- [ ] **Array shapes** documentati
- [ ] **PHPStan config** specifico del modulo
- [ ] **Unit tests** per type safety
- [ ] **CI integration** per PHPStan

### Per Moduli Esistenti

- [ ] **Analisi PHPStan** corrente
- [ ] **Fix prioritized** per errori critici
- [ ] **Type hints aggiunti** dove mancanti
- [ ] **Tests aggiornati** per compliance
- [ ] **Documentation aggiornata** con patterns

---

## 🔗 Resources

### Documentation

- [PHPStan Documentation](https://phpstan.org/)
- [PHPStan Level 10 Guide](https://phpstan.org/user-guide/getting-started)
- [Larastan Documentation](https://github.com/nunomaduro/larastan)

### Tools

- [PHPStan Playground](https://phpstan.org/playground)
- [PHPStan Config Builder](https://phpstan.org/config-reference)

### Community

- [PHPStan GitHub](https://github.com/phpstan/phpstan)
- [Larastan Issues](https://github.com/nunomaduro/larastan/issues)

---

**Guide Version**: 1.0  
**Last Updated**: 2026-02-10  
**Target Compliance**: PHPStan Level 10 ✅  
**System Coverage**: 100% target

*Guida completa per PHPStan Level 10 compliance nel sistema PTVX con patterns, best practices, e soluzioni per problemi comuni.*
