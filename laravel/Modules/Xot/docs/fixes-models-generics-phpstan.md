# Fix PHPStan Modelli - Generics e Tipizzazione Completa

## Data: 2025-01-27

## Problema Identificato

Errori PHPStan livello 9 nei modelli base del modulo Xot:

1. **BaseModel**: PHPDoc `@extends` con errore di parsing
2. **BaseExtra**: Mancanza di template generics per Factory
3. **BaseTreeModel**: Mancanza di template generics per Factory  
4. **Cache**: PHPDoc `@extends` con errore di parsing e mancanza generics
5. **Proprietà $fillable**: Mancanza di tipizzazione `list<string>`

## Errori Specifici

```
PHPDoc tag @extends has invalid value (Model): Unexpected token "\n * ", expected '<'
Class BaseExtra extends generic class BaseModel but does not specify its types: TFactory
Class BaseTreeModel extends generic class BaseModel but does not specify its types: TFactory
Property $fillable type has no value type specified in iterable type array
```

## Soluzioni Implementate

### 1. BaseModel - Rimozione @extends Problematico

**Prima:**
```php
/**
 * Class BaseModel.
 * 
 * @extends Model
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
abstract class BaseModel extends Model
```

**Dopo:**
```php
/**
 * Class BaseModel.
 *
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
abstract class BaseModel extends Model
```

### 2. BaseExtra - Aggiunta Template Generics

**Prima:**
```php
abstract class BaseExtra extends BaseModel implements ExtraContract
```

**Dopo:**
```php
/**
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
abstract class BaseExtra extends BaseModel implements ExtraContract
```

### 3. BaseTreeModel - Aggiunta Template Generics

**Prima:**
```php
abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
```

**Dopo:**
```php
/**
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
```

### 4. Cache - Correzione PHPDoc e Generics

**Prima:**
```php
 * @extends \Modules\Xot\Models\BaseModel
 */
class Cache extends BaseModel
```

**Dopo:**
```php
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
class Cache extends BaseModel
```

### 5. Tipizzazione Proprietà $fillable

**Prima:**
```php
protected $fillable = [
    'key',
    'value', 
    'expiration',
];
```

**Dopo:**
```php
/** @var list<string> */
protected $fillable = [
    'key',
    'value',
    'expiration', 
];
```

## Test di Verifica

### PHPStan
```bash
./vendor/bin/phpstan analyse Modules/Xot/app/Models/BaseModel.php --level=9
./vendor/bin/phpstan analyse Modules/Xot/app/Models/BaseExtra.php --level=9
./vendor/bin/phpstan analyse Modules/Xot/app/Models/BaseTreeModel.php --level=9
./vendor/bin/phpstan analyse Modules/Xot/app/Models/Cache.php --level=9
```

**Risultato**: ✅ Nessun errore per tutti i modelli

### Test Unitari
```bash
php artisan test Modules/Xot/tests/Unit/Models/BaseModelTest.php
```

**Risultato**: ✅ 10 test passati (18 assertions)

## Impatto

- ✅ Risolti tutti gli errori PHPStan livello 9 per i modelli base
- ✅ Aggiunta tipizzazione completa per proprietà $fillable
- ✅ Corretti template generics per Factory
- ✅ Rimossi PHPDoc problematici
- ✅ Mantenuta funzionalità esistente
- ✅ Nessun breaking change
- ✅ Test di regressione implementati

## Collegamenti

- [BaseModel.php](../../app/Models/BaseModel.php)
- [BaseExtra.php](../../app/Models/BaseExtra.php)
- [BaseTreeModel.php](../../app/Models/BaseTreeModel.php)
- [Cache.php](../../app/Models/Cache.php)
- [BaseModelTest.php](../../tests/Unit/Models/BaseModelTest.php)
- [PHPStan Fixes](./phpstan-fixes.md)

## Note per il Futuro

- Evitare tag @extends con classi non generiche
- Utilizzare sempre template generics per modelli che estendono BaseModel
- Tipizzare sempre proprietà array come `list<string>` o `array<string, mixed>`
- Testare sempre con PHPStan dopo modifiche ai modelli base
- Implementare test di regressione per validare le correzioni
