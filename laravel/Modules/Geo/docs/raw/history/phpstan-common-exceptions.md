# Eccezioni Comuni in PHPStan Livello 10 e Come Risolverle

## Introduzione

Questo documento descrive i problemi più comuni riscontrati durante l'analisi del codice con PHPStan a livello 10 nei moduli Laraxot PTVX e fornisce soluzioni concrete per risolverli.

## 1. Accesso a Proprietà di un Oggetto Potenzialmente `mixed`

### Problema
```
Cannot access property $name on mixed.
```

### Causa
Questo errore si verifica quando si cerca di accedere a una proprietà di un oggetto che PHPStan considera di tipo `mixed` (non tipizzato). Questo è particolarmente comune quando si usano funzioni come `app()` che restituiscono un risultato di tipo `mixed`.

### Soluzione
1. Aggiungere un cast esplicito o un controllo di tipo:

```php
// Prima (errore)
$result = app(MyClass::class);
$value = $result->property;

// Dopo (corretto)
/** @var MyClass $result */
$result = app(MyClass::class);
$value = $result->property;
```

2. Utilizzare il null-coalescing operator per gestire i valori mancanti:

```php
$value = $result->property ?? '';
```

## 2. Chiamata a Metodi su un Oggetto Potenzialmente `mixed`

### Problema
```
Cannot call method execute() on mixed.
```

### Causa
Questo errore si verifica quando si chiama un metodo su un oggetto che PHPStan considera di tipo `mixed`. Questo succede spesso con il pattern di service container resolution.

### Soluzione
1. Memorizzare il risultato in una variabile con un'annotazione di tipo:

```php
// Prima (errore)
app(MyAction::class)->execute();

// Dopo (corretto)
/** @var MyAction $action */
$action = app(MyAction::class);
$action->execute();
```

2. Per le chiamate di metodo potenzialmente non esistenti, usare un approccio difensivo:

```php
if (method_exists($object, 'methodName')) {
    /** @var callable $method */
    $method = [$object, 'methodName'];
    $result = $method();
}
```

## 3. Cast non Sicuri da `mixed` a tipi Scalari

### Problema
```
Cannot cast mixed to string.
```

### Causa
PHPStan a livello 10 non consente di effettuare cast diretti da `mixed` a tipi scalari come `string`, `int`, ecc.

### Soluzione
1. Utilizzare controlli di tipo espliciti:

```php
// Prima (errore)
$value = (string) $mixedValue;

// Dopo (corretto)
$value = is_scalar($mixedValue) ? (string) $mixedValue : '';
// Oppure
$value = is_string($mixedValue) || is_numeric($mixedValue) ? (string) $mixedValue : '';
```

## 4. Metodo `belongsToManyX` non Trovato

### Problema
```
Call to an undefined method SomeModel::belongsToManyX().
```

### Causa
Questo errore si verifica quando si cerca di utilizzare il metodo `belongsToManyX` che è definito nel trait `RelationX`, ma la classe o un suo genitore non include questo trait.

### Soluzione
1. Aggiungere il trait RelationX alla classe o alla sua classe base:

```php
// Prima (errore)
class MyModel extends BaseModel
{
    use SomeTrait;
    
    public function relatedModels()
    {
        return $this->belongsToManyX(RelatedModel::class);
    }
}

// Dopo (corretto)
use Modules\Xot\Models\Traits\RelationX;

class MyModel extends BaseModel
{
    use SomeTrait;
    use RelationX;
    
    public function relatedModels()
    {
        return $this->belongsToManyX(RelatedModel::class);
    }
}
```

## 5. Problemi con Metodi su Collections

### Problema
```
Cannot call method isEmpty() on mixed.
```

### Causa
Questo errore si verifica quando si chiamano metodi sulle collezioni che PHPStan considera di tipo `mixed`.

### Soluzione
1. Aggiungere controlli di tipo:

```php
// Prima (errore)
$collection->isEmpty();

// Dopo (corretto)
if ($collection instanceof \Illuminate\Support\Collection) {
    $collection->isEmpty();
} else {
    // Gestione alternativa
}
```

2. Oppure aggiungere annotazioni di tipo nelle docblock per le proprietà e i metodi:

```php
/**
 * @var \Illuminate\Support\Collection
 */
protected $items;

/**
 * @return \Illuminate\Support\Collection
 */
public function getItems()
{
    return $this->items;
}
```

## 6. Problemi con Tipi Generici nei Metodi di Relazione

### Problema
```
Generic type Illuminate\Database\Eloquent\Relations\BelongsToMany<Model> in PHPDoc tag @return does not specify all template types of class Illuminate\Database\Eloquent\Relations\BelongsToMany: TRelatedModel, TDeclaringModel.
```

### Causa
PHPStan richiede che tutti i parametri di tipo generici siano esplicitamente dichiarati.

### Soluzione
Aggiungere tutti i parametri di tipo generici nelle annotazioni:

```php
// Prima (errore)
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Model>
 */

// Dopo (corretto)
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Model, $this>
 */
```

## 7. Problemi di Covarianza nei Tipi di Ritorno

### Problema
```
Return type Model|null of method getModel() is not covariant with return type User|null of method getUserModel().
```

### Causa
PHPStan controlla che i tipi di ritorno nelle sottoclassi siano covarianti (più specifici o uguali) rispetto ai tipi di ritorno nella classe o interfaccia padre.

### Soluzione
Assicurarsi che i tipi di ritorno nelle sottoclassi siano covarianti:

```php
// Nella classe padre o interfaccia
public function getModel(): ?Model
{
    // ...
}

// Nella sottoclasse (errore)
public function getModel(): ?User
{
    // ...
}

// Nella sottoclasse (corretto, con cast esplicito)
public function getModel(): ?Model
{
    /** @var ?Model */
    return $this->user;
}
```

## Conclusione

L'analisi statica del codice con PHPStan a livello 10 è uno strumento potente per migliorare la qualità del codice e prevenire errori durante l'esecuzione. Seguendo queste best practices, è possibile risolvere la maggior parte degli errori comuni e scrivere codice più robusto e manutenibile. 