# HasXotFactory Trait

## Panoramica

Il trait `HasXotFactory` estende il comportamento standard di Laravel `HasFactory` per supportare la generazione automatica di factory per i modelli nell'architettura modulare Laraxot.

## Namespace

```php
Modules\Xot\Models\Traits\HasXotFactory
```

## Business Logic

### Problema Risolto

In un'architettura modulare con molti modelli, creare manualmente tutte le factory può essere:
- Laborioso e ripetitivo
- Fonte di errori se dimenticato
- Difficile da mantenere sincronizzato con i modelli

### Soluzione

`HasXotFactory` intercetta la creazione della factory e:
1. **Controlla se esiste** - Se la factory esiste, la utilizza normalmente
2. **Genera automaticamente** - Se non esiste, la crea al volo usando `GetFactoryAction`
3. **Supporta moduli** - Riconosce la struttura modulare di Laraxot

## Utilizzo

### Modelli Standard

```php
<?php

namespace Modules\User\Models;

use Modules\Xot\Models\Traits\HasXotFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasXotFactory;
}
```

### Modelli che estendono BaseModel

```php
<?php

namespace Modules\User\Models;

use Modules\User\Models\BaseModel;

class Profile extends BaseModel
{
    // BaseModel già include HasXotFactory tramite il metodo newFactory()
    // Non serve aggiungerlo esplicitamente
}
```

### Modelli Pivot

Per i modelli pivot che estendono `BasePivot`, il trait è già incluso tramite il metodo `newFactory()` nella classe base.

```php
<?php

namespace Modules\User\Models;

use Modules\User\Models\BasePivot;

class DeviceUser extends BasePivot
{
    // BasePivot ha già newFactory() implementato
    // che usa GetFactoryAction
}
```

## Architettura Tecnica

### Implementazione

```php
trait HasXotFactory
{
    use EloquentHasFactory {
        newFactory as parentNewFactory;
    }

    /**
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }
}
```

### Componenti Chiave

1. **Alias del metodo originale**: `newFactory as parentNewFactory`
   - Preserva l'implementazione originale di Laravel
   - Permette di chiamarla se necessario

2. **Override del metodo**: `newFactory()`
   - Utilizza `GetFactoryAction` per logica avanzata
   - Restituisce `Factory<static>` per type safety

3. **Dependency Injection**: `app(GetFactoryAction::class)`
   - Utilizza il service container di Laravel
   - Permette testing e mocking facilmente

## GetFactoryAction

Il trait delega la logica a `GetFactoryAction`:

```php
<?php

namespace Modules\Xot\Actions\Factory;

class GetFactoryAction
{
    public function execute(string $model_class): Factory
    {
        $factory_class = $this->getFactoryClass($model_class);

        // Se esiste, la usa
        if (class_exists($factory_class)) {
            return $factory_class::new();
        }

        // Altrimenti la crea
        $this->createFactory($model_class);

        // Richiede refresh per caricarla
        throw new Exception('Factory created, press F5 to refresh');
    }
}
```

### Convenzioni Naming

La factory viene cercata/creata seguendo le convenzioni Laravel:
- Modello: `Modules\User\Models\User`
- Factory: `Modules\User\Database\Factories\UserFactory`

## Vantaggi

### 1. Developer Experience

✅ **Non serve creare factory manualmente**
```bash
# Prima (manuale)
php artisan module:make-factory User User

# Dopo (automatico)
User::factory()->create();  # Factory creata automaticamente
```

### 2. Testing Veloce

✅ **Scrivi test immediatamente**
```php
it('creates a user', function () {
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});
```

### 3. Consistency

✅ **Convenzioni uniformi** - Tutte le factory seguono lo stesso pattern

✅ **Errori ridotti** - Non si dimentica di creare la factory

✅ **Manutenzione facile** - Un solo punto di modifica

## Testing

### Test del Trait

```php
it('generates factory automatically', function () {
    $model = new class extends Model {
        use HasXotFactory;
    };

    $factory = $model::factory();
    expect($factory)->toBeInstanceOf(Factory::class);
});
```

### Mock di GetFactoryAction

```php
it('uses GetFactoryAction', function () {
    $mockAction = Mockery::mock(GetFactoryAction::class);
    $mockAction->shouldReceive('execute')
        ->once()
        ->andReturn(UserFactory::new());

    app()->instance(GetFactoryAction::class, $mockAction);

    User::factory();
});
```

## Troubleshooting

### Errore: "Factory not found"

**Problema**: La factory non esiste e la generazione automatica fallisce

**Causa**:
- Struttura modulo non standard
- Permessi di scrittura mancanti
- Namespace non risolto correttamente

**Soluzione**:
```bash
# Crea manualmente la factory
php artisan module:make-factory User User

# Verifica namespace
php artisan route:list --compact
```

### Errore: "Press F5 to refresh"

**Problema**: Factory appena creata, non ancora autoloaded

**Causa**: Composer autoload non aggiornato

**Soluzione**:
```bash
# Refresh autoload
composer dump-autoload

# Riprova
php artisan test
```

### Conflitto con HasFactory standard

**Problema**: Entrambi i trait definiscono `newFactory()`

**Causa**: Uso simultaneo di `HasFactory` e `HasXotFactory`

**Soluzione**:
```php
// ❌ ERRATO
use HasFactory;
use HasXotFactory;

// ✅ CORRETTO - Usa solo uno
use HasXotFactory;
```

## Best Practices

### 1. Usa HasXotFactory in moduli custom

```php
// Moduli Laraxot → HasXotFactory
namespace Modules\MyModule\Models;

use HasXotFactory;

class MyModel extends Model
{
    use HasXotFactory;
}
```

### 2. BaseModel ha già la logica

```php
// Se estendi BaseModel, non servono trait aggiuntivi
namespace Modules\MyModule\Models;

class MyModel extends BaseModel
{
    // BaseModel.newFactory() usa già GetFactoryAction
}
```

### 3. Crea factory manualmente se complessa

```php
// Se la factory ha logica complessa, creala manualmente
php artisan module:make-factory ComplexModel MyModule

// Poi personalizzala
class ComplexModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'computed_field' => $this->computeComplexValue(),
            // ... logica custom
        ];
    }
}
```

## Compatibilità PHPStan

### Type Safety

Il trait è completamente compatibile con PHPStan Level 9+:

```php
/**
 * @return Factory<static>
 */
protected static function newFactory(): Factory
```

- `Factory<static>` indica che la factory ritorna istanze del modello corrente
- PHPStan può inferire correttamente i tipi
- Nessun warning su mixed types

## Storia

### Creazione Originale
- **Data**: Implementato nelle prime versioni di Laraxot
- **Motivo**: Semplificare testing con architettura modulare

### Cancellazione Accidentale
- **Data**: 21 Ottobre 2025 (commit `b8f17d9e`)
- **Causa**: Refactoring che ha spostato la logica in BaseModel
- **Impatto**: Errori fatali su modelli Pivot che non estendono BaseModel

### Ripristino
- **Data**: 22 Ottobre 2025
- **Motivo**: Modelli Pivot (es. DeviceUser) richiedono il trait
- **Soluzione**: Ripristinato trait + aggiunto newFactory() a BasePivot

## Link Correlati

- [GetFactoryAction](../actions/get-factory-action.md)
- [BaseModel](../models/basemodel.md)
- [BasePivot](../../User/docs/models/basepivot.md)
- [Testing Guide](../testing/factory-testing.md)
- [Laravel Factories Documentation](https://laravel.com/docs/eloquent-factories)

## Changelog

### v3.0.0 - 22 Ottobre 2025
- ✅ **Ripristinato** trait dopo cancellazione accidentale
- ✅ **Documentato** business logic e architettura
- ✅ **Aggiunto** supporto esplicito in BasePivot
- ✅ **PHPStan Level 9** compliant con type hints corretti

---

**Autore**: Laraxot Core Team
**Ultima modifica**: 22 Ottobre 2025
**Stato**: ✅ Produzione
**PHPStan**: Level 9 compliant
