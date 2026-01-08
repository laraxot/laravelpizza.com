# Standard di Codifica

## Principi Generali

1. **PSR Compliance**
   - PSR-1: Basic Coding Standard
   - PSR-12: Extended Coding Style
   - PSR-4: Autoloading Standard

2. **Tipizzazione**
   - Usare type hints per parametri e return types
   - Preferire tipi strict (`int` invece di `mixed`)
   - Dichiarare proprietà con tipo esplicito

3. **Naming Conventions**
   - PascalCase per classi
   - camelCase per metodi e variabili
   - UPPER_CASE per costanti
   - snake_case per file di configurazione

## Struttura del Codice

### 1. Classi
```php
declare(strict_types=1);

namespace Modules\Example;

use Strict\Type\Declarations;

final class ExampleClass
{
    private Type $property;
    
    public function __construct(Type $dependency)
    {
        $this->property = $dependency;
    }
    
    public function method(): ReturnType
    {
        // Implementation
    }
}
```

### 2. Interfacce
```php
interface ExampleInterface
{
    public function method(): void;
}
```

### 3. Traits
```php
trait ExampleTrait
{
    private function helperMethod(): void
    {
        // Implementation
    }
}
```

## Best Practices

1. **SOLID Principles**
   - Single Responsibility
   - Open/Closed
   - Liskov Substitution
   - Interface Segregation
   - Dependency Inversion

2. **Clean Code**
   - Metodi brevi e focalizzati
   - Nomi descrittivi
   - Evitare nesting eccessivo
   - DRY (Don't Repeat Yourself)

3. **Sicurezza**
   - Validare input
   - Escape output
   - Usare prepared statements
   - Implementare CSRF protection

## PHPStan

### Configurazione Base
```neon
parameters:
    level: 8
    paths:
        - app
        - src
        - tests
    excludePaths:
        - vendor
```

### Regole Custom
```neon
services:
    -
        class: App\PHPStan\Rules\CustomRule
        tags:
            - phpstan.rules.rule
```

## Testing

1. **Unit Tests**
```php
public function test_method_returns_expected_value(): void
{
    $sut = new SystemUnderTest();
    $result = $sut->method();
    $this->assertEquals(expected, $result);
}
```

2. **Feature Tests**
```php
public function test_endpoint_returns_correct_response(): void
{
    $response = $this->get('/api/endpoint');
    $response->assertStatus(200);
}
```

## Documentazione nel Codice

### 1. DocBlocks
```php
/**
 * Breve descrizione del metodo.
 *
 * Descrizione dettagliata se necessaria,
 * può occupare più righe.
 *
 * @param Type $param Descrizione parametro
 * @return ReturnType
 * @throws Exception
 */
public function method(Type $param): ReturnType
{
    // Implementation
}
```

### 2. Commenti
```php
// Commento inline per spiegazione breve
$value = compute(); // Nota sul risultato

/*
 * Blocco di commenti per
 * spiegazioni più lunghe
 */
```

## Gestione Errori

1. **Exceptions**
```php
try {
    $this->riskyOperation();
} catch (SpecificException $e) {
    Log::error('Messaggio dettagliato', [
        'exception' => $e,
        'context' => $this->context,
    ]);
    throw new CustomException($e->getMessage());
}
```

2. **Logging**
```php
Log::info('Operazione completata', ['data' => $result]);
Log::error('Errore durante operazione', ['error' => $e]);
```

## Performance

1. **Query Optimization**
   - Eager loading per relazioni
   - Indici appropriati
   - Query builder invece di collection methods

2. **Caching**
   - Cache query frequenti
   - Cache invalidation strategy
   - Usare cache tags

## Sicurezza

1. **Input Validation**
```php
public function store(Request $request): Response
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);
}
```

2. **Output Escaping**
```php
<div>{{ $safeHtml }}</div>
{!! $unsafeHtml !!} <!-- Usare con cautela -->
```

## Collegamenti

- [PHP-FIG PSRs](https://www.php-fig.org/psr/)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laravel Best Practices](https://laravel.com/docs/master/best-practices)
- [Security Best Practices](../security/README.md) 

## Collegamenti tra versioni di coding-standards.md
* [coding-standards.md](../../../Xot/docs/standards/coding-standards.md)
* [coding-standards.md](../../../Xot/docs/conventions/coding-standards.md)

