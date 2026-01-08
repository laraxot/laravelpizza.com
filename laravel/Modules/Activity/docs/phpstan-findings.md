# PHPStan Findings - Activity Module

**Data**: 2025-10-10  
**Livello**: MAX (9)  
**Status**: ✅ MODELS CORRETTI

## Errori Risolti

### Models (7 errori → 0 errori)

#### 1. BaseModel.php
- **Errore**: `missingType.generics` - HasFactory senza type parameter
- **Correzione**: Aggiunto template type
```php
/**
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
abstract class BaseModel extends Model
{
    /** @use HasFactory<TFactory> */
    use \Modules\Xot\Models\Traits\HasXotFactory;
}
```

#### 2. Activity.php
- **Errore**: `class.notFound` - IdeHelperActivity non esiste
- **Correzione**: Rimosso @mixin IdeHelperActivity, aggiunto HasFactory type
```php
class Activity extends SpatieActivity
{
    /** @use HasFactory<\Modules\Activity\Database\Factories\ActivityFactory> */
    use \Modules\Xot\Models\Traits\HasXotFactory;
}
```

#### 3. Snapshot.php
- **Errore 1**: `missingType.iterableValue` - Property $state senza value type
- **Errore 2**: `class.notFound` - IdeHelperSnapshot
- **Errore 3**: `missingType.generics` - HasFactory
- **Correzione**:
```php
/**
 * @property array<string, mixed> $state
 */
class Snapshot extends SpatieSnapshot
{
    /** @use HasFactory<\Modules\Activity\Database\Factories\SnapshotFactory> */
    use \Modules\Xot\Models\Traits\HasXotFactory;
}
```

#### 4. StoredEvent.php
- **Errore 1**: `class.notFound` - IdeHelperStoredEvent
- **Errore 2**: `missingType.generics` - HasFactory
- **Correzione**:
```php
class StoredEvent extends SpatieStoredEvent
{
    /** @use HasFactory<\Modules\Activity\Database\Factories\StoredEventFactory> */
    use \Modules\Xot\Models\Traits\HasXotFactory;
}
```

## Pattern Identificati

### 1. HasFactory Generic Type
Sempre specificare il tipo di Factory:
```php
/** @use HasFactory<\Modules\ModuleName\Database\Factories\ModelFactory> */
use \Modules\Xot\Models\Traits\HasXotFactory;
```

### 2. Array Properties
Specificare sempre il tipo degli elementi:
```php
/** @property array<string, mixed> $propertyName */
```

### 3. IDE Helper Classes
Rimuovere @mixin per classi IdeHelper* generate da ide-helper package (non esistono a runtime).

## Risultato

✅ **0 errori** in tutti i Models del modulo Activity!

---

**Aggiornato**: 2025-10-10T10:54:56+02:00
