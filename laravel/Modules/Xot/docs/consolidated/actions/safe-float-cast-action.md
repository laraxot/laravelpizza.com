# SafeFloatCastAction

## Descrizione

La `SafeFloatCastAction` è un'action centralizzata per convertire in modo sicuro valori di tipo `mixed` in `float`, risolvendo gli errori PHPStan "Cannot cast mixed to float" che si verificano frequentemente nel codebase.

## Principi di Design

### DRY (Don't Repeat Yourself)
- Centralizza tutta la logica di cast float in un'unica classe
- Evita duplicazione di codice di conversione in tutto il progetto
- Fornisce un'interfaccia consistente per tutti i cast float

### KISS (Keep It Simple, Stupid)
- Logica semplice e diretta
- API intuitiva con metodi statici di convenienza
- Gestione degli errori trasparente

### Sicurezza
- Gestisce tutti i casi edge (null, array, oggetti, stringhe malformate)
- Previene errori di cast non sicuri
- Valida che i float risultanti siano finiti (non infiniti o NaN)

## Utilizzo

### Uso Base

```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

// Conversione semplice
$value = SafeFloatCastAction::cast($mixedValue);

// Con valore di default personalizzato
$value = SafeFloatCastAction::cast($mixedValue, 10.5);
```

### Con Validazione di Range

```php
// Percentuale (0.0 - 100.0)
$percentage = SafeFloatCastAction::castWithRange($mixedValue, 0.0, 100.0);

// Temperatura (-273.15 - 1000.0)
$temperature = SafeFloatCastAction::castWithRange($mixedValue, -273.15, 1000.0, 20.0);
```

### Uso con Istanza

```php
$castAction = app(SafeFloatCastAction::class);

$value = $castAction->execute($mixedValue);
$rangedValue = $castAction->executeWithRange($mixedValue, 0.0, 100.0);
```

## Casi d'Uso Tipici

### 1. Risoluzione Errori PHPStan

**Prima (errore PHPStan):**
```php
// ❌ Cannot cast mixed to float
$elevation = (float) $apiResponse['elevation'];
```

**Dopo (sicuro):**
```php
// ✅ Sicuro e validato
$elevation = SafeFloatCastAction::cast($apiResponse['elevation']);
```

### 2. Parsing Dati CSV/JSON

```php
// Dati da file CSV con possibili valori malformati
foreach ($csvData as $row) {
    $price = SafeFloatCastAction::cast($row['price'], 0.0);
    $discount = SafeFloatCastAction::castWithRange($row['discount'], 0.0, 100.0, 0.0);
}
```

### 3. Input Utente

```php
// Form input che può contenere virgole europee o caratteri extra
$amount = SafeFloatCastAction::cast($request->input('amount'));
```

### 4. API Esterne

```php
// Risposta API con dati non garantiti
$coordinates = [
    'lat' => SafeFloatCastAction::castWithRange($response['lat'], -90.0, 90.0),
    'lng' => SafeFloatCastAction::castWithRange($response['lng'], -180.0, 180.0),
];
```

## Comportamento per Tipo di Input

| Tipo Input | Comportamento | Esempio |
|------------|---------------|---------|
| `float` | Verifica finito, restituisce valore o default | `3.14` → `3.14` |
| `int` | Conversione diretta | `42` → `42.0` |
| `string` | Parsing intelligente con pulizia | `"3,14"` → `3.14` |
| `bool` | `true` → `1.0`, `false` → `0.0` | `true` → `1.0` |
| `null` | Restituisce default | `null` → `0.0` |
| `array` | Se un elemento, ricorsione | `[3.14]` → `3.14` |
| `object` | Se ha `__toString`, parsing | `$obj` → parsing |
| Altri | Restituisce default | `resource` → `0.0` |

## Gestione Stringhe Avanzata

La classe gestisce automaticamente:

- **Separatori decimali**: Virgola europea (`3,14` → `3.14`)
- **Caratteri extra**: Rimozione automatica (`"€ 3.14"` → `3.14`)
- **Spazi**: Trim automatico (`" 3.14 "` → `3.14`)
- **Segni**: Supporto per `+` e `-` (`"-3.14"` → `-3.14`)

## Esempi di Risoluzione Errori PHPStan

### Geo Module - Coordinate

**Prima:**
```php
// ❌ Cannot cast mixed to float
$lat = (float) $data['lat'];
$lng = (float) $data['lng'];
```

**Dopo:**
```php
// ✅ Sicuro
$lat = SafeFloatCastAction::castWithRange($data['lat'], -90.0, 90.0);
$lng = SafeFloatCastAction::castWithRange($data['lng'], -180.0, 180.0);
```

### Chart Module - Valori Numerici

**Prima:**
```php
// ❌ Cannot cast mixed to float
$value = (float) $chartData['value'];
```

**Dopo:**
```php
// ✅ Sicuro
$value = SafeFloatCastAction::cast($chartData['value']);
```

### Notify Module - ID Numerici

**Prima:**
```php
// ❌ Cannot cast mixed to int
$chatId = (int) $config['chat_id'];
```

**Dopo:**
```php
// ✅ Sicuro (usando SafeIntCastAction o cast a float poi int)
$chatId = (int) SafeFloatCastAction::cast($config['chat_id']);
```

## Performance

- **Overhead minimo**: Controlli di tipo nativi PHP
- **Cache-friendly**: Nessun stato interno, completamente stateless
- **Memory-efficient**: Nessuna allocazione di memoria aggiuntiva

## Testing

```php
// Test cases coperti
$action = new SafeFloatCastAction();

// Casi base
assert($action->execute(3.14) === 3.14);
assert($action->execute(42) === 42.0);
assert($action->execute("3.14") === 3.14);
assert($action->execute("3,14") === 3.14);
assert($action->execute(true) === 1.0);
assert($action->execute(false) === 0.0);
assert($action->execute(null) === 0.0);

// Casi edge
assert($action->execute("") === 0.0);
assert($action->execute("abc") === 0.0);
assert($action->execute([3.14]) === 3.14);
assert($action->execute([]) === 0.0);

// Range validation
assert($action->executeWithRange(150.0, 0.0, 100.0) === 100.0);
assert($action->executeWithRange(-10.0, 0.0, 100.0) === 0.0);
```

## Collegamenti

- [SafeStringCastAction](./safe-string-cast-action.md)
- [PHPStan Error Resolution Guide](../phpstan-error-resolution.md)
- [Cast Actions Overview](../cast-actions-overview.md)

## Changelog

- **2025-07-31**: Creazione iniziale con supporto completo per cast sicuri
- **2025-07-31**: Aggiunta validazione range e gestione stringhe avanzata
- **2025-07-31**: Miglioramento documentazione ed esempi d'uso

---

*Ultimo aggiornamento: 31 luglio 2025*
