# Riassunto delle Correzioni per PHPStan Livello 9

Questo documento riassume i problemi comuni riscontrati con PHPStan livello 9 e le relative soluzioni, basato su un'analisi dettagliata del codice.

## Problemi nei Modelli

### 1. Tipi PHPDoc Covarianti

**Problema:** PHPStan richiede che i tipi PHPDoc siano covarianti rispetto alle classi estese.

**Esempio di errore:**
```
PHPDoc type array<string> of property BaseModel::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.
```

**Soluzione:**
```php
/**
 * @var list<string>  // Usare list<string> invece di array<string> o string[]
 */
protected $fillable = ['id', 'name', 'email'];

/**
 * @var list<string>
 */
protected $hidden = ['password', 'remember_token'];
```

### 2. Metodo newFactory() nei Modelli

**Problema:** Il metodo `newFactory()` deve restituire un'istanza di `Factory` e non `object` generico.

**Soluzione:**
```php
/**
 * @return Factory
 */
protected static function newFactory(): Factory
{
    // Utilizzo di app() per risolvere la factory dal container
    if (class_exists($factoryNamespace)) {
        return app($factoryNamespace);
    }
    
    return Factory::factoryForModel(static::class);
}
```

### 3. Gestione sicura delle funzioni che potrebbero restituire false

**Problema:** Funzioni come `strrpos()` possono restituire `false` causando errori di tipo con `substr()`.

**Soluzione:**
```php
// Problema
$namespace = substr(static::class, 0, strrpos(static::class, '\\'));

// Soluzione
$position = strrpos(static::class, '\\');
if ($position === false) {
    $namespace = '';
} else {
    $namespace = substr(static::class, 0, $position);
}
```

## Problemi nei Trait e nelle Relazioni

### 1. Metodi mancanti riferiti nei Trait

**Problema:** Errori come `Call to an undefined method X::belongsToManyX()` possono verificarsi quando un trait usa metodi che non sono definiti nelle classi che lo usano.

**Soluzione:**
1. Assicurarsi che la classe utilizzi il trait corretto che include il metodo mancante:
```php
use Modules\Xot\Models\Traits\RelationX; // Fornisce metodi come belongsToManyX
```

2. Se si utilizzano trait generici, aggiungere dichiarazioni di tipo appropriate:
```php
/**
 * @method BelongsToMany belongsToManyX(string $class)
 */
class BaseUser extends Authenticatable
```

### 2. Incompatibilità tra interfacce nei parametri

**Problema:** I parametri nei metodi implementati devono essere compatibili con quelli dichiarati nell'interfaccia.

**Esempio di errore:**
```
Parameter $fail (Closure(string): void) should be compatible with parameter $fail (Closure(string, string|null=): PotentiallyTranslatedString)
```

**Soluzione:**
```php
/**
 * @param \Closure(string, string|null=): PotentiallyTranslatedString $fail
 */
public function validate(string $attribute, mixed $value, \Closure $fail): void
```

### 3. Tipi generici incompleti

**Problema:** PHPStan richiede che tutte le variabili di tipo generico siano specificate.

**Esempio di errore:**
```
Generic type BelongsToMany<User> in PHPDoc tag @return does not specify all template types of class BelongsToMany: TRelatedModel, TDeclaringModel
```

**Soluzione:**
```php
/**
 * @return BelongsToMany<User, Role>
 */
public function users()
```

## Problemi di visibilità dei metodi

### 1. Visibilità in trait e classi che li utilizzano

**Problema:** I metodi nei trait che vengono utilizzati da classi che implementano interfacce o estendono altre classi devono avere la visibilità corretta.

**Esempio di errore:**
```
Access level to HasXotTable::getTableHeaderActions() must be public (as in class XotBaseRelationManager)
```

**Soluzione:**
```php
// Nel trait
public function getTableHeaderActions(): array
{
    // Implementazione
}
```

## Problemi di type casting

### 1. Cast di mixed a tipi scalari

**Problema:** PHPStan non consente il cast diretto di `mixed` a tipi scalari come `string`, `int`, `float`.

**Soluzione:**
```php
// Errato
$databaseName = (string) config("database.connections.{$connection}.database");

// Corretto
$databaseConfig = config("database.connections.{$connection}.database");
$databaseName = is_string($databaseConfig) ? $databaseConfig : '';
```

## Risoluzione degli errori modulo per modulo

### Approccio raccomandato

1. **Analisi iniziale**: Eseguire PHPStan su ciascun modulo separatamente per identificare i problemi specifici:
   ```bash
   ./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/NomeModulo
   ```

2. **Prioritizzazione**: Correggere prima i problemi che causano più errori o che bloccano il funzionamento base:
   - Problemi di visibilità nei trait
   - Tipi nei modelli base
   - Incompatibilità di interfacce

3. **Correzione dei trait sottoutilizzati**: Aggiungere annotazioni PHPDoc o implementare metodi mancanti

4. **Test incrementale**: Dopo ogni serie di correzioni, eseguire nuovamente PHPStan per verificare i miglioramenti

### Come ignorare temporaneamente gli errori

In caso di errori che non possono essere risolti immediatamente, è possibile utilizzare annotazioni per ignorarli:

```php
/** @phpstan-ignore-next-line */
$value = $data['key'];

/** @phpstan-ignore-line */
public function someComplexMethod() { ... }

/**
 * @phpstan-ignore offsetAccess.nonOffsetAccessible
 */
```

## Documentazione da studiare

Per una comprensione più completa delle correzioni necessarie, consultare:

1. [NAMESPACE-RULES.md](./NAMESPACE-RULES.md) - Per le regole sui namespace
2. [PHPSTAN-LEVEL9-GUIDE.md](./PHPSTAN-LEVEL9-GUIDE.md) - Per dettagli su come gestire errori livello 9
3. [FILAMENT-TABLES.md](./FILAMENT-TABLES.md) - Per problemi specifici di Filament 