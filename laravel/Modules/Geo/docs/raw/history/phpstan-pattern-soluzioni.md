# Pattern e Soluzioni per PHPStan Livello 10 - Modulo Xot

Questo documento raccoglie i pattern comuni di errori PHPStan di livello 10 nel modulo Xot e le soluzioni standard implementate.

## Pattern 1: Gestione delle Collection

### Problema
Le collection di Laravel vengono spesso utilizzate con tipi non specificati, causando errori quando PHPStan non riesce a determinare il tipo degli elementi.

### Esempi di Errore
```
Parameter #1 $key of method Illuminate\Support\Arr::only() expects array|string, mixed given.
```

### Soluzione Standard
```php
// Prima
public function execute(Collection $collection): array
{
    $fields = $collection->get('fields');
    return Arr::only($item, $fields);
}

// Dopo
/**
 * @param \Illuminate\Support\Collection<int|string, mixed> $collection
 * @return array<string, mixed>
 */
public function execute(Collection $collection): array
{
    /** @var array<string>|string|null $fields */
    $fields = $collection->get('fields');
    
    if (null === $fields) {
        return [];
    }
    
    if (is_string($fields)) {
        $fields = [$fields];
    }
    
    return Arr::only($item, $fields);
}
```

## Pattern 2: Metodi con $row['field'] non tipizzato

### Problema
Molti metodi accettano array di righe con chiavi non specificate, causando errori quando vengono utilizzati i valori.

### Esempi di Errore
```
Cannot access offset 'id' on mixed.
```

### Soluzione Standard
```php
// Prima
public function processRow($row)
{
    return $row['id'];
}

// Dopo
/**
 * @param array<string, mixed> $row
 * @return int|string|null
 */
public function processRow(array $row)
{
    return $row['id'] ?? null;
}
```

## Pattern 3: Classi/Metodi dinamici con __call e __callStatic

### Problema
L'uso di `__call` e `__callStatic` rende difficile per PHPStan determinare i tipi restituiti.

### Esempi di Errore
```
Call to an undefined method XotBaseClass::dynamicMethod().
```

### Soluzione Standard
```php
/**
 * @method static string dynamicMethod(string $param)
 * @method string anotherMethod(int $param)
 */
class XotBaseClass
{
    public function __call(string $method, array $parameters)
    {
        // Implementazione
    }
    
    public static function __callStatic(string $method, array $parameters)
    {
        // Implementazione
    }
}
```

## Pattern 4: Factory e Builder Pattern

### Problema
I pattern Factory e Builder spesso restituiscono tipi diversi in base ai parametri, causando errori di tipo.

### Esempi di Errore
```
Method Modules\Xot\Actions\GetFactoryAction::execute() should return Illuminate\Database\Eloquent\Factories\Factory but returns mixed.
```

### Soluzione Standard
```php
// Prima
public function execute($modelClass)
{
    return $modelClass::factory();
}

// Dopo
/**
 * @template T of \Illuminate\Database\Eloquent\Model
 * @param class-string<T> $modelClass
 * @return \Illuminate\Database\Eloquent\Factories\Factory<T>
 */
public function execute(string $modelClass)
{
    if (! class_exists($modelClass)) {
        throw new \InvalidArgumentException("Class {$modelClass} does not exist");
    }
    
    if (! method_exists($modelClass, 'factory')) {
        throw new \InvalidArgumentException("Class {$modelClass} does not have a factory method");
    }
    
    return $modelClass::factory();
}
```

## Pattern 5: Gestione delle relazioni nei Model

### Problema
Le relazioni di Eloquent sono difficili da tipizzare, causando errori quando si accede ai risultati.

### Esempi di Errore
```
Method Modules\Xot\Models\BaseModel::relationMethod() should return Illuminate\Database\Eloquent\Relations\HasMany but returns mixed.
```

### Soluzione Standard
```php
// Prima
public function posts()
{
    return $this->hasMany('App\Models\Post');
}

// Dopo
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Post>
 */
public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(\App\Models\Post::class);
}
```

## Pattern 6: Gestione dei File e Path

### Problema
La manipolazione di path e file spesso coinvolge operazioni su stringhe che PHPStan non riesce a seguire.

### Esempi di Errore
```
Parameter #1 $path of function file_get_contents expects string, mixed given.
```

### Soluzione Standard
```php
// Prima
public function getFileContents($path)
{
    return file_get_contents($path);
}

// Dopo
/**
 * @param string $path
 * @return string|false
 */
public function getFileContents(string $path)
{
    if (!file_exists($path)) {
        return false;
    }
    
    return file_get_contents($path);
}
```

## Pattern 7: Metodi con parametri variabili

### Problema
I metodi che accettano un numero variabile di parametri sono difficili da tipizzare correttamente.

### Esempi di Errore
```
Parameter #1 $args of method Modules\Xot\Services\XotService::callMethod() expects array, mixed given.
```

### Soluzione Standard
```php
// Prima
public function callMethod($class, $method, ...$args)
{
    return $class->$method(...$args);
}

// Dopo
/**
 * @template T
 * @param object $class
 * @param string $method
 * @param mixed ...$args
 * @return mixed
 */
public function callMethod(object $class, string $method, ...$args)
{
    if (!method_exists($class, $method)) {
        throw new \BadMethodCallException("Method {$method} does not exist on class " . get_class($class));
    }
    
    return $class->$method(...$args);
}
```

## Pattern 8: Valori da Request e Input

### Problema
I valori ottenuti da Request e Input sono di tipo mixed e causano errori quando utilizzati in operazioni tipizzate.

### Esempi di Errore
```
Cannot access offset 'key' on mixed.
```

### Soluzione Standard
```php
// Prima
public function processInput(Request $request)
{
    $value = $request->input('key');
    return strtoupper($value);
}

// Dopo
/**
 * @param \Illuminate\Http\Request $request
 * @return string
 */
public function processInput(Request $request): string
{
    /** @var string|null $value */
    $value = $request->input('key');
    
    return strtoupper((string) $value);
}
```

## Conclusioni

Questi pattern rappresentano le soluzioni standard da adottare in tutto il modulo Xot per garantire la compatibilità con PHPStan livello 10. Implementando sistematicamente queste soluzioni, si otterrà un codice più robusto e tipizzato correttamente.

## Prossimi Passi

1. Applicare sistematicamente questi pattern a tutto il codice del modulo Xot
2. Estendere questi pattern ad altri moduli del progetto
3. Aggiornare regolarmente questo documento con nuovi pattern identificati 