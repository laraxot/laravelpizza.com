# SafeFloatCastAction

## Descrizione

L'azione `SafeFloatCastAction` fornisce un modo sicuro e consistente per convertire valori di tipo `mixed` in `float`. Questa azione centralizza la logica di cast per evitare duplicazioni di codice (principio DRY) e garantire un comportamento prevedibile in tutto il codebase.

## Principi Applicati

- **DRY (Don't Repeat Yourself)**: Centralizza la logica di cast float evitando duplicazioni
- **KISS (Keep It Simple, Stupid)**: Logica semplice e diretta, facile da comprendere e mantenere
- **Type Safety**: Gestione sicura dei tipi con validazioni appropriate
- **Consistency**: Comportamento consistente in tutto il progetto

## Utilizzo

### Metodo di Istanza

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

$action = app(SafeFloatCastAction::class);

// Conversione base
$float = $action->execute('123.45'); // 123.45
$float = $action->execute(null); // 0.0
$float = $action->execute('invalid', 10.0); // 10.0

// Conversione con range
$float = $action->executeWithRange('150.0', 0.0, 100.0); // 100.0 (clamped)
```

### Metodo Statico

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

// Conversione base
$float = SafeFloatCastAction::cast('123.45'); // 123.45
$float = SafeFloatCastAction::cast(null, 5.0); // 5.0

// Conversione con range
$float = SafeFloatCastAction::castWithRange('150.0', 0.0, 100.0); // 100.0
```

## Comportamento per Tipo

| Tipo Input | Comportamento | Esempio |
|------------|---------------|---------|
| `float` | Restituito direttamente | `123.45` → `123.45` |
| `int` | Convertito in float | `123` → `123.0` |
| `null` | Restituisce default | `null` → `0.0` |
| `string` (numerica) | Convertita in float | `"123.45"` → `123.45` |
| `string` (vuota) | Restituisce default | `""` → `0.0` |
| `string` (non numerica) | Restituisce default | `"abc"` → `0.0` |
| `bool` | Convertito (true=1.0, false=0.0) | `true` → `1.0` |
| Altri tipi | Restituisce default | `[]` → `0.0` |

## Validazioni

### Numeri Infiniti e NaN

L'azione verifica che i numeri convertiti siano finiti:

```php
$action = app(SafeFloatCastAction::class);

// Numeri infiniti vengono gestiti come default
$float = $action->execute('INF'); // 0.0
$float = $action->execute('NAN'); // 0.0
```

### Range Validation

Il metodo `executeWithRange` garantisce che il valore sia entro i limiti specificati:

```php
$action = app(SafeFloatCastAction::class);

// Clamp automatico
$float = $action->executeWithRange('150.0', 0.0, 100.0); // 100.0
$float = $action->executeWithRange('-10.0', 0.0, 100.0); // 0.0
```

## Esempi Pratici

### Nel Modello Eloquent

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

class Product extends BaseModel
{
    public function getPriceAttribute($value): float
    {
        return SafeFloatCastAction::cast($value, 0.0);
    }
    
    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = SafeFloatCastAction::cast($value, 0.0);
    }
}
```

### Nel Controller

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $total = SafeFloatCastAction::cast($request->input('total'), 0.0);
        $tax = SafeFloatCastAction::cast($request->input('tax'), 0.0);
        
        // Calcolo sicuro
        $finalTotal = $total + $tax;
        
        // ...
    }
}
```

### Nel Service

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

class CalculationService
{
    public function calculatePercentage(float $value, float $total): float
    {
        $safeValue = SafeFloatCastAction::cast($value);
        $safeTotal = SafeFloatCastAction::cast($total);
        
        if ($safeTotal === 0.0) {
            return 0.0;
        }
        
        return ($safeValue / $safeTotal) * 100;
    }
}
```

## Best Practices

1. **Sempre specificare un default**: Evita valori inaspettati
2. **Usa il range validation**: Per valori che devono essere entro limiti specifici
3. **Documenta il comportamento**: Soprattutto per valori che potrebbero essere null
4. **Testa i casi edge**: Stringhe vuote, null, valori non numerici

## Testing

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

class SafeFloatCastActionTest extends TestCase
{
    public function test_cast_string_to_float()
    {
        $result = SafeFloatCastAction::cast('123.45');
        $this->assertEquals(123.45, $result);
    }
    
    public function test_cast_null_with_default()
    {
        $result = SafeFloatCastAction::cast(null, 10.0);
        $this->assertEquals(10.0, $result);
    }
    
    public function test_cast_with_range()
    {
        $result = SafeFloatCastAction::castWithRange('150.0', 0.0, 100.0);
        $this->assertEquals(100.0, $result);
    }
}
```

## Collegamenti

- [SafeStringCastAction](../actions/cast/safe-string-cast-action.md)
- [Xot Actions Documentation](../actions/README.md)
- [DRY Principle](../../project_docs/dry-principle.md)
- [KISS Principle](../../project_docs/kiss-principle.md)

---

*Ultimo aggiornamento: 2025-01-06* 