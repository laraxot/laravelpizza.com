# Risoluzione degli Errori PHPStan Relativi ai Tipi Generici nelle Relazioni Eloquent

Questo documento fornisce linee guida per risolvere gli errori PHPStan di livello 9 relativi ai tipi generici nelle relazioni Eloquent nei modelli Laravel.

## Errori Comuni di Tipi Generici

Gli errori più comuni che si verificano con i tipi generici in PHPStan sono:

1. **generics.lessTypes**: Quando non specifichiamo tutti i tipi generici richiesti.
2. **generics.notSubtype**: Quando il tipo specificato non è un sottotipo valido del tipo di template richiesto.
3. **return.type**: Quando il tipo di ritorno dichiarato non corrisponde al tipo effettivo restituito.

## Come Risolvere gli Errori nei Tipi Generici delle Relazioni

### 1. Specifiche Complete per Relazioni BelongsTo

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Profile>
 */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### 2. Specifiche Complete per Relazioni HasMany

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment, \App\Models\Post>
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}
```

### 3. Specifiche Complete per Relazioni BelongsToMany

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Tag, \App\Models\Post>
 */
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class);
}
```

### 4. Specifiche Complete per Relazioni MorphMany e MorphOne

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\App\Models\Comment, \App\Models\Post>
 */
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}

/**
 * @return \Illuminate\Database\Eloquent\Relations\MorphOne<\App\Models\Image, \App\Models\Post>
 */
public function image(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable');
}
```

## Errori con Interfacce e Modelli Concreti

Quando lavori con interfacce (come `UserContract`) e modelli concreti (come `User`), potresti incontrare errori di tipo perché l'interfaccia non è considerata un sottotipo valido per il tipo generico che richiede un modello Eloquent.

### Problema:

```php
Parameter #1 $user of class SomeClass constructor expects UserContract, User given.
```

### Soluzione:

1. **Dichiarare Esplicitamente la Compatibilità**:

```php
/**
 * @param UserContract $user L'utente (User implementa UserContract)
 */
public function __construct(UserContract $user)
{
    $this->user = $user;
}
```

2. **Utilizzare Assertion nei Metodi**:

```php
/**
 * @param mixed $user
 */
public function process($user): void
{
    Assert::isInstanceOf($user, UserContract::class, 'User must implement UserContract');
    // Ora PHPStan sa che $user è un'istanza di UserContract
    $this->user = $user;
}
```

## Configurazione PHPStan per Gestire Meglio i Tipi Generici

Puoi aggiungere al file `phpstan.neon` configurazioni per gestire meglio i tipi generici:

```yaml
parameters:
    treatPhpDocTypesAsCertain: false
    checkGenericClassInNonGenericObjectType: false
    checkMissingIterableValueType: false
```

## Considerazioni sui Metodi di Interfacce e Implementazioni

Se la tua interfaccia dichiara un metodo che ritorna un tipo specifico (come `UserContract`), ma l'implementazione concreta ritorna un tipo più specifico (come `User`), potresti incontrare errori di tipo. In questi casi, le annotazioni PHPDoc appropriate sono fondamentali.

```php
interface UserRepositoryInterface
{
    /**
     * @return UserContract
     */
    public function getCurrentUser(): UserContract;
}

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return User L'implementazione può restituire un tipo più specifico 
     */
    public function getCurrentUser(): UserContract
    {
        // Ma il tipo di ritorno dichiarato deve corrispondere all'interfaccia
        return new User();
    }
}
```

Segui queste linee guida per risolvere la maggior parte degli errori relativi ai tipi generici nei tuoi modelli e relazioni Laravel. 