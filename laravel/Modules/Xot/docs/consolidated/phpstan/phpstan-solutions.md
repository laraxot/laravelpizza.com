# Soluzioni per Errori PHPStan di Livello 9

Questo documento contiene soluzioni comuni per risolvere i vari tipi di errori rilevati da PHPStan a livello 9, con esempi pratici e best practices.

## 1. Cannot cast mixed to string/int

**Problema:**
```php
// Errore: Cannot cast mixed to string
$value = $data;
$result = "Prefix: " . $value;
```

**Soluzione:**
```php
// Soluzione 1: Cast esplicito con controllo
$value = $data;
if (is_string($value) || is_numeric($value)) {
    $result = "Prefix: " . (string)$value;
} else {
    $result = "Prefix: ";
}

// Soluzione 2: Cast diretto con fallback
$value = $data;
$result = "Prefix: " . (is_null($value) ? '' : (string)$value);
```

## 2. Parameter expects type X, mixed given

**Problema:**
```php
// Errore: Parameter #1 $string of function strlen expects string, mixed given
$length = strlen($data);
```

**Soluzione:**
```php
// Soluzione 1: Check del tipo
if (is_string($data)) {
    $length = strlen($data);
} else {
    $length = 0; // o gestire diversamente l'errore
}

// Soluzione 2: Cast con controllo di fallback
$length = is_string($data) ? strlen($data) : strlen((string)$data);
```

## 3. Cannot access property on mixed

**Problema:**
```php
// Errore: Cannot access property $name on mixed
$name = $object->name;
```

**Soluzione:**
```php
// Soluzione 1: Controllo del tipo
if (is_object($object) && property_exists($object, 'name')) {
    $name = $object->name;
} else {
    $name = null; // o un valore predefinito appropriato
}

// Soluzione 2: Assert
/** @var object $object */
$name = $object->name;

// Soluzione 3: Utilizzare data_get
$name = data_get($object, 'name');
```

## 4. Cannot call method on mixed

**Problema:**
```php
// Errore: Cannot call method getName() on mixed
$name = $object->getName();
```

**Soluzione:**
```php
// Soluzione 1: Controllo del tipo
if (is_object($object) && method_exists($object, 'getName')) {
    $name = $object->getName();
} else {
    $name = null; // o un valore predefinito appropriato
}

// Soluzione 2: PHPDoc con asserto
/** @var \App\Models\User $object */
$name = $object->getName();

// Soluzione 3: Controllo instanceof
if ($object instanceof \App\Models\User) {
    $name = $object->getName();
}
```

## 5. Binary operation between incompatible types

**Problema:**
```php
// Errore: Binary operation "." between mixed and "suffix" results in an error
$result = $value . "suffix";
```

**Soluzione:**
```php
// Soluzione 1: Cast esplicito
$result = (string)$value . "suffix";

// Soluzione 2: Controllo condizionale
if (is_string($value) || is_numeric($value)) {
    $result = $value . "suffix";
} else {
    $result = "suffix";
}
```

## 6. Part $variable of encapsed string cannot be cast to string

**Problema:**
```php
// Errore: Part $variable of encapsed string cannot be cast to string
$message = "Hello, {$variable}!";
```

**Soluzione:**
```php
// Soluzione 1: Conversione esplicita
$message = "Hello, " . (is_string($variable) ? $variable : (string)$variable) . "!";

// Soluzione 2: Controllo preventivo
if (is_string($variable) || is_numeric($variable)) {
    $message = "Hello, {$variable}!";
} else {
    $message = "Hello, Guest!"; // Fallback
}
```

## 7. Argument of invalid type mixed supplied for foreach

**Problema:**
```php
// Errore: Argument of an invalid type mixed supplied for foreach, only iterables are supported
foreach ($items as $item) {
    // ...
}
```

**Soluzione:**
```php
// Soluzione 1: Controllo del tipo
if (is_array($items) || $items instanceof \Traversable) {
    foreach ($items as $item) {
        // ...
    }
}

// Soluzione 2: Cast a array con controllo
$itemsArray = is_array($items) ? $items : [];
foreach ($itemsArray as $item) {
    // ...
}

// Soluzione 3: Utilizzare collection
$itemsCollection = collect($items);
$itemsCollection->each(function ($item) {
    // ...
});
```

## 8. Function X is unsafe to use

**Problema:**
```php
// Errore: Function file_get_contents is unsafe to use
$content = file_get_contents($path);
```

**Soluzione:**
```php
// Soluzione: Usare Safe
use function Safe\file_get_contents;

$content = file_get_contents($path);
```

## 9. Return type mismatch

**Problema:**
```php
// Errore: Method X::execute() should return string but returns mixed
public function execute(): string
{
    return $this->processValue();
}
```

**Soluzione:**
```php
// Soluzione 1: Cast esplicito con controllo
public function execute(): string
{
    $result = $this->processValue();
    return is_string($result) ? $result : '';
}

// Soluzione 2: Controllo dettagliato con eccezione
public function execute(): string
{
    $result = $this->processValue();
    if (!is_string($result)) {
        throw new \InvalidArgumentException('Expected string result');
    }
    return $result;
}
```

## 10. Template type issues in Eloquent Relations

**Problema:**
```php
// Errore: Method returns BelongsTo<Model, Profile> but returns BelongsTo<Model, $this(Profile)>
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

**Soluzione:**
```php
// Soluzione 1: Usare phpdoc senza type-hint nel return
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
 */
public function user()
{
    return $this->belongsTo(User::class);
}

// Soluzione 2: Ignorare questo specifico errore in phpstan.neon
// parameters:
//     ignoreErrors:
//         - '#Template type TDeclaringModel on class Illuminate\\Database\\Eloquent\\Relations\\BelongsTo is not covariant#'
```

## Best Practices Generali

1. **Utilizzare sempre typehint nei parametri e nei return type**
2. **Aggiungere PHPDoc con @param e @return dove necessario**
3. **Per variabili complesse, usare PHPDoc anche all'interno dei metodi**
4. **Usare assert in modo strategico per aiutare l'analisi statica**
5. **Validare input esterni il prima possibile**
6. **Utilizzare nullsafe operator (->) quando appropriato**
7. **Utilizzare collections invece di array quando possibile**
8. **Configurare .phpstan.neon per ignorare errori non risolvibili**

Implementando queste soluzioni sistematicamente, sarà possibile risolvere la maggior parte degli errori PHPStan di livello 9. 