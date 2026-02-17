# Bugfix: DeviceUser e HasXotFactory

## Contesto

Durante il login utente, si verificava un Fatal Error causato dalla mancanza del trait `HasXotFactory` utilizzato dal modello `DeviceUser`.

## Problema

Il modello `DeviceUser` estende `BasePivot`, che a sua volta estende `Illuminate\Database\Eloquent\Relations\Pivot`. 

```php
class DeviceUser extends BasePivot
{
    use \Modules\Xot\Models\Traits\HasXotFactory;  // ❌ Trait mancante
}
```

## Causa

Il trait `HasXotFactory` era stato cancellato per errore dal modulo Xot durante un refactoring.

## Soluzione

### 1. Ripristinato HasXotFactory Trait

Il trait è stato ripristinato in `Modules/Xot/app/Models/Traits/HasXotFactory.php`

### 2. Aggiunto newFactory() a BasePivot

Per evitare che modelli Pivot debbano sempre usare il trait esplicitamente, il metodo `newFactory()` è stato aggiunto direttamente a `BasePivot`:

```php
// Modules/User/app/Models/BasePivot.php

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Actions\Factory\GetFactoryAction;

abstract class BasePivot extends Pivot
{
    use Updater;

    protected static function newFactory(): Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }
}
```

### 3. DeviceUser Funzionante

Ora `DeviceUser` può:
- Usare il trait esplicitamente: `use \Modules\Xot\Models\Traits\HasXotFactory;`
- Oppure ereditare il comportamento da `BasePivot`

Entrambi i modi funzionano correttamente.

## Test

```bash
# Test 1: Trait disponibile
php artisan tinker
>>> trait_exists('Modules\Xot\Models\Traits\HasXotFactory');
=> true

# Test 2: Login funziona
# Accedere a http://127.0.0.1:8000/admin/login
# ✅ Login completo senza errori

# Test 3: Factory generation
php artisan tinker
>>> \Modules\User\Models\DeviceUser::factory()->create();
=> Modules\User\Models\DeviceUser {#...}
```

## Impatto

✅ **DeviceUser** - Login utente funziona correttamente  
✅ **LoginListener** - Creazione/aggiornamento record device completata  
✅ **Testing** - Factory disponibile per tutti i modelli Pivot

## Link Correlati

- [HasXotFactory Documentation](../../Xot/docs/traits/hasxotfactory.md)
- [HasXotFactory Restoration](../../Xot/docs/bugfix/hasxotfactory-restoration.md)
- [BasePivot Documentation](../models/basepivot.md)

---

**Data**: 22 Ottobre 2025  
**Stato**: ✅ RISOLTO  
**Modulo**: User  
**File Modificati**: `Modules/User/app/Models/BasePivot.php`





