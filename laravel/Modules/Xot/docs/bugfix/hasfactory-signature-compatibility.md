# Bugfix: HasFactory newFactory() Signature Compatibility

**Data Fix**: 11 Novembre 2025  
**Status**: ✅ RISOLTO

## Problema

**Errore Fatal**:
```
Declaration of Illuminate\Database\Eloquent\Factories\HasFactory::newFactory() 
must be compatible with Modules\Xot\Models\BaseModel::newFactory(): 
Illuminate\Database\Eloquent\Factories\Factory
```

**Stack Trace**:
```
vendor/laravel/framework/src/Illuminate/Database/Eloquent/Factories/HasFactory.php:33
```

## Causa Radice

**Incompatibilità di Signature tra Laravel 12 e BaseModel**:

1. **Laravel 12 `HasFactory` trait**: Il metodo `newFactory()` restituisce `Factory|null` (nullable)
   ```php
   protected static function newFactory(): ?Factory
   ```

2. **BaseModel di Xot**: Il metodo `newFactory()` restituiva `Factory` (non nullable)
   ```php
   protected static function newFactory(): Factory  // ❌ INCOMPATIBILE
   ```

3. **Conflitto**: PHP 8.3+ richiede che i metodi sovrascritti abbiano signature compatibili con i metodi del trait/classe base.

## Pattern Corretto

### Laravel 12 HasFactory Trait Signature

```php
trait HasFactory
{
    /**
     * Create a new factory instance for the model.
     *
     * @return TFactory|null
     */
    protected static function newFactory()
    {
        // Può restituire null se non trova factory
        return static::getUseFactoryAttribute() ?? null;
    }
}
```

### BaseModel Corretto

```php
abstract class BaseModel extends Model
{
    use HasFactory {
        HasFactory::newFactory as parentNewFactory;  // Alias opzionale
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>|null
     */
    protected static function newFactory(): ?Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }
}
```

## Soluzione Applicata

### File Corretto
`Modules/Xot/app/Models/BaseModel.php`

### Modifiche

1. **Aggiunto alias per il metodo del trait** (opzionale, per compatibilità futura):
   ```php
   use HasFactory {
       HasFactory::newFactory as parentNewFactory;
   }
   ```

2. **Cambiato return type da `Factory` a `?Factory`**:
   ```php
   // ❌ PRIMA
   protected static function newFactory(): Factory
   
   // ✅ DOPO
   protected static function newFactory(): ?Factory
   ```

3. **Aggiornato PHPDoc**:
   ```php
   /**
    * Create a new factory instance for the model.
    *
    * @return Factory<static>|null
    */
   ```

## Note Tecniche

### Perché `GetFactoryAction` restituisce sempre `Factory`?

`GetFactoryAction::execute()` restituisce sempre `Factory` (non nullable) perché:
- Se la factory esiste, la restituisce
- Se la factory non esiste, la crea e lancia un'eccezione

Tuttavia, per essere compatibili con la signature del trait `HasFactory` di Laravel 12, dobbiamo accettare `?Factory` come return type.

### Compatibilità PHP 8.3+

PHP 8.3+ applica regole più rigorose per la compatibilità delle signature:
- I metodi sovrascritti devono avere signature compatibili
- `Factory` non è compatibile con `Factory|null`
- `Factory|null` è compatibile con `Factory` (ma non viceversa)

## Verifica

- ✅ Classe caricata correttamente
- ✅ Signature compatibile con Laravel 12
- ✅ PHP 8.3+ compatibility check passato
- ✅ Pattern architetturale rispettato

## Pattern da Seguire

Quando si sovrascrive `newFactory()` in classi che usano `HasFactory`:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MyModel extends BaseModel
{
    use HasFactory;

    /**
     * @return Factory<static>|null
     */
    protected static function newFactory(): ?Factory
    {
        // Implementazione personalizzata
        return MyModelFactory::new();
    }
}
```

## Riferimenti

- [Laravel 12 HasFactory Trait](https://github.com/laravel/framework/blob/12.x/src/Illuminate/Database/Eloquent/Factories/HasFactory.php)
- [PHP 8.3 Method Signature Compatibility](https://www.php.net/manual/en/language.oop5.basic.php)
- [Xot BaseModel Pattern](../../docs/traits/hasxotfactory.md)

