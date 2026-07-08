# Guida Pratica all'Implementazione delle Soluzioni PHPStan

Questo documento fornisce una guida pratica su come implementare le soluzioni ai problemi più comuni rilevati da PHPStan a livello 9 nel framework Laraxot PTVX.

## Approccio Metodico alla Correzione

### 1. Esecuzione Iniziale di PHPStan

Prima di iniziare qualsiasi correzione, eseguire PHPStan sul modulo specifico:

```bash
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/NomeModulo
```

### 2. Categorizzazione degli Errori

Organizzare gli errori in categorie per affrontarli in modo sistematico:

- **Errori di namespace**: Namespace errati che includono `app` o altri problemi di struttura
- **Errori di tipo nei modelli**: Problemi con `$fillable`, `$hidden`, `$casts`, ecc.
- **Errori di relazione**: Tipi generici incompleti nelle relazioni Eloquent
- **Errori di metodo**: Tipi di ritorno mancanti o errati, parametri incompatibili
- **Errori di accesso a proprietà**: Proprietà non definite o tipi incompatibili

### 3. Correggere gli Errori per Categoria

#### Errori di Namespace

1. Identificare i file con namespace errati
2. Correggere rimuovendo il segmento `app` dal namespace

```php
// Da
namespace Modules\Rating\App\Models;

// A
namespace Modules\Rating\Models;
```

#### Errori di Tipo nei Modelli

1. Correggere le annotazioni PHPDoc per le proprietà del modello

```php
/**
 * @var list<string>  // Correzione per $fillable
 */
protected $fillable = ['name', 'email'];

/**
 * @var array<string, string>  // Correzione per $casts
 */
protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime',
];
```

2. Correggere il metodo `newFactory()`

```php
/**
 * @return \Illuminate\Database\Eloquent\Factories\Factory
 */
protected static function newFactory(): Factory
{
    // Implementazione...
}
```

#### Errori di Relazione

1. Aggiungere i tipi generici completi alle relazioni

```php
/**
 * @return HasMany<Comment, Post>
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}
```

2. Correggere i metodi che usano `morphMany` e `morphOne`

```php
/**
 * @return MorphMany<Notification, static>
 */
public function notifications(): MorphMany
{
    return $this->morphMany(Notification::class, 'notifiable');
}
```

#### Errori di Metodo

1. Specificare i tipi di ritorno corretti

```php
public function getFormSchema(): array
{
    // Implementazione...
}
```

2. Correggere i parametri per compatibilità con interfacce

```php
public function validate(string $attribute, mixed $value, \Closure $fail): void
{
    // Implementazione...
}
```

#### Errori di Accesso a Proprietà

1. Aggiungere controlli per proprietà dinamiche o non definite

```php
if (property_exists($this, 'someProperty')) {
    // Usa $this->someProperty
}
```

2. Utilizzare getter e setter quando appropriato

```php
// Invece di accedere direttamente
$this->someProperty;

// Utilizzare un getter
$this->getSomeProperty();
```

### 4. Test Incrementale

Dopo ogni serie di correzioni, eseguire nuovamente PHPStan per verificare i miglioramenti:

```bash
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/NomeModulo
```

## Gestione di Situazioni Specifiche

### 1. Funzioni che Possono Restituire `false`

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

### 2. Incompatibilità tra Interfacce e Implementazioni Concrete

```php
// Problema
// Parameter #1 $user of class SomeClass constructor expects UserContract, User given.

// Soluzione con annotazione PHPDoc
/**
 * @param User|UserContract $user L'utente (User implementa UserContract)
 */
public function __construct(UserContract $user)
{
    $this->user = $user;
}
```

### 3. Cast di Valori Mixed

```php
// Problema
$databaseName = (string) config('database.name');

// Soluzione
$databaseConfig = config('database.name');
$databaseName = is_string($databaseConfig) ? $databaseConfig : '';
```

### 4. Metodi Mancanti in Trait

```php
// Problema
// Call to undefined method Class::methodName()

// Verifica che il trait sia incluso
use Modules\Xot\Models\Traits\RequiredTrait;

// Oppure aggiungi un'annotazione PHPDoc
/**
 * @method void methodName()
 */
class MyClass
{
    // Implementazione...
}
```

### 5. Proprietà Dinamiche nei Modelli

```php
// Problema
// Access to an undefined property $model->dynamicProperty

// Soluzione con @property
/**
 * @property string $dynamicProperty
 */
class MyModel extends Model
{
    // Implementazione...
}

// Oppure con accessori
public function getDynamicPropertyAttribute()
{
    // Implementazione...
}
```

## Ottimizzazione del Workflow

### 1. Automazione con Script

Creare script di shell per automatizzare l'analisi e la verifica:

```bash
#!/bin/bash
# analyze_module.sh
MODULE=$1
echo "Analizzando il modulo $MODULE..."
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/$MODULE
```

### 2. Ignorare Temporaneamente gli Errori

Quando la correzione immediata non è pratica, usare:

```php
/** @phpstan-ignore-next-line */
$problematicLine = doSomething();

// O per categorie specifiche di errori
/**
 * @phpstan-ignore method.notFound
 */
$result = $this->undefinedMethod();
```

### 3. Creazione di Baseline

Per progetti con molti errori, creare una baseline per tracciare i miglioramenti:

```bash
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G --generate-baseline=phpstan-baseline.neon Modules/NomeModulo
```

## Documentazione delle Soluzioni

Ogni modulo dovrebbe documentare le soluzioni ai problemi PHPStan specifici in `Modules/NomeModulo/docs/PHPSTAN-SOLUTIONS.md`:

```markdown
# Soluzioni PHPStan per il Modulo NomeModulo

## Problema: Namespace Errati
- **File**: `app/Models/Example.php`
- **Errore**: `Class Modules\NomeModulo\App\Models\Example not found`
- **Soluzione**: Rimosso `app` dal namespace

## Problema: Tipo Mancante per Relazione
- **File**: `app/Models/User.php`
- **Errore**: `Generic type BelongsToMany<Team> does not specify all template types`
- **Soluzione**: Aggiunto secondo tipo generico `BelongsToMany<Team, User>`
```

## Risorse Utili

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Blog PHPStan sui Generics](https://phpstan.org/blog/generics-in-php-using-phpdocs)
- [Solving Undefined Properties](https://phpstan.org/blog/solving-phpstan-access-to-undefined-property)
- [Modules/Xot/docs/PHPSTAN-GENERIC-TYPES.md](../Xot/docs/PHPSTAN-GENERIC-TYPES.md) - Guida specifica per tipi generici
- [Modules/Xot/docs/NAMESPACE-CONVENTIONS.md](../Xot/docs/NAMESPACE-CONVENTIONS.md) - Convenzioni per i namespace

---

Seguendo questa guida pratica, potrai affrontare e risolvere in modo metodico i problemi rilevati da PHPStan nel tuo codebase Laraxot PTVX, migliorando la qualità complessiva del codice e riducendo gli errori a runtime. 