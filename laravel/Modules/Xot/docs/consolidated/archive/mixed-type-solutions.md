# Gestione del tipo `mixed` in PHP e Soluzioni per PHPStan

## Cos'è il tipo `mixed`?

In PHP 8.0 è stato introdotto il tipo `mixed` come tipo esplicito. Rappresenta un valore che può essere di qualsiasi tipo (incluso `null`). PHPStan a livello 9 è molto rigoroso con l'uso di `mixed` e richiede casting espliciti e controlli prima di utilizzare questi valori in operazioni specifiche.

## Problemi comuni con il tipo `mixed`

1. **Accesso a proprietà e metodi**: Non è possibile accedere direttamente a proprietà o chiamare metodi su variabili di tipo `mixed`.
2. **Conversioni implicite**: Non è possibile convertire implicitamente un `mixed` in un altro tipo come `string` o `int`.
3. **Operazioni con altri tipi**: Le operazioni tra `mixed` e altri tipi (es. concatenazione con stringhe) non sono consentite.
4. **Uso in funzioni tipizzate**: Passare un `mixed` a una funzione che si aspetta un tipo specifico genera un errore.

## Soluzioni principali

### 1. Controlli di tipo

Verificare sempre il tipo prima di utilizzare una variabile `mixed`:

```php
if (is_object($value) && method_exists($value, 'getName')) {
    $name = $value->getName();
} else {
    $name = null;
}
```

### 2. Cast espliciti

Convertire esplicitamente al tipo richiesto:

```php
$stringValue = (string) $mixedValue;
$intValue = (int) $mixedValue;
```

### 3. Null coalescing e operatore ternario

Fornire valori predefiniti sicuri:

```php
$safeString = $mixedValue ?? '';
$safeString = is_string($mixedValue) ? $mixedValue : '';
```

### 4. Asserzioni di tipo

Usare asserzioni di tipo per informare PHPStan:

```php
/** @var string $value */
// Ora PHPStan tratterà $value come una stringa
```

### 5. Librerie di assertion

Utilizzare librerie come `webmozart/assert` o `spatie/phpunit-snapshot-assertions`:

```php
use Webmozart\Assert\Assert;

Assert::string($value);
// Ora $value è garantito essere una stringa
```

## Tecniche avanzate

### 1. Gestione degli array

Per gli array di tipo `mixed` che potrebbero contenere diversi tipi di valori:

```php
$array = $mixedValue;
if (!is_array($array)) {
    $array = [];
}

// Trasformare tutti gli elementi in stringhe
$stringArray = array_map(function ($item) {
    return (string) $item;
}, $array);
```

### 2. Gestione degli oggetti

Per oggetti di tipo `mixed` che potrebbero implementare interfacce diverse:

```php
if ($value instanceof \Stringable) {
    $string = (string) $value;
} elseif (is_object($value) && method_exists($value, '__toString')) {
    $string = (string) $value;
} else {
    $string = '';
}
```

### 3. Utilizzare data_get per accesso sicuro alle proprietà

Laravel fornisce `data_get` per accedere in modo sicuro a proprietà annidate:

```php
$value = data_get($mixedObject, 'property.nested_property', 'default_value');
```

## Best practices per il refactoring del codice

1. **Definire tipi precisi**: Evitare `mixed` quando possibile, specificando tipi più precisi.
2. **Aggiungere type hints**: Utilizzare type hints nei parametri e valori di ritorno.
3. **Documentare con PHPDoc**: Utilizzare PHPDoc per documentare i tipi complessi.
4. **Validare input esterni**: Validare e tipizzare gli input il prima possibile.
5. **Utilizzare value objects**: Quando si lavora con dati complessi, considerare l'uso di value objects tipizzati.

## Esempio pratico di refactoring

### Prima:

```php
function processData($data) {
    $result = $data['value'] . ' processed';
    return $result;
}
```

### Dopo:

```php
/**
 * @param array<string, mixed> $data
 * @return string
 */
function processData(array $data): string {
    if (!isset($data['value'])) {
        return 'No value provided';
    }
    
    $value = $data['value'];
    if (!is_string($value) && !is_numeric($value)) {
        return 'Invalid value type';
    }
    
    $result = (string) $value . ' processed';
    return $result;
}
```

Seguendo queste linee guida, sarà possibile risolvere la maggior parte degli errori legati al tipo `mixed` segnalati da PHPStan al livello 9. 