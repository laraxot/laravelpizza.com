# Correzioni PHPStan Livello 7 - Modulo UI

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo UI e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in TableLayoutToggleTableAction.php

```
Metodo toggleLayout() ha il parametro $livewire senza type hint specificato.
Cannot call method dispatch() on class-string|object.
Cannot call method resetTable() on class-string|object.
# Correzioni PHPStan Livello 7 - Modulo User

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in Profile.php

```
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::permission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::role() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withExtraAttributes() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutPermission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutRole() return type contains unknown class Modules\User\Models\Builder.
# Correzioni PHPStan Livello 7 - Modulo Media

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo Media e le relative soluzioni implementate.

## Errori Identificati

### 1. Errore in VideoStream.php

```
Line 141: Parameter #2 $length of function Safe\fread expects int<1, max>, int given.
```

## Soluzioni Implementate

### 1. Correzione in TableLayoutToggleTableAction.php

Per risolvere i problemi di type safety nella classe `TableLayoutToggleTableAction`, sono stati apportati i seguenti cambiamenti:

1. Aggiunto il type hint `mixed` al parametro `$livewire` del metodo `toggleLayout()` invece di forzare un tipo specifico, poiché il parametro potrebbe essere di vari tipi:

```php
protected function toggleLayout(mixed $livewire = null): void
```

2. Aggiunti controlli `method_exists` e `property_exists` prima di chiamare metodi o accedere a proprietà sull'oggetto `$livewire`:

```php
if ($livewire) {
    // Use property_exists to safely check if the property exists
    if (property_exists($livewire, 'layoutView')) {
        $livewire->layoutView = $newLayout;
    }
    
    // These methods should be available on Filament components
    if (method_exists($livewire, 'dispatch')) {
        $livewire->dispatch('$refresh');
        $livewire->dispatch('refreshTable');
    }
    
    if (method_exists($livewire, 'resetTable')) {
        $livewire->resetTable();
    }
}
```

Questo approccio è più robusto e previene errori a runtime quando l'oggetto `$livewire` non ha i metodi o le proprietà previste.
### 1. Correzione in Profile.php

Il problema è che i tag PHPDoc facevano riferimento a una classe `Builder` nel namespace `Modules\User\Models` che non esiste. Abbiamo corretto i riferimenti utilizzando il namespace completo per la classe Builder:

```php
/**
 * ...
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * ...
 */
```

Questo controllo garantisce che `fread()` venga chiamato solo con un valore positivo per il parametro `$length`, evitando anche potenziali loop infiniti nel caso in cui `$bytesToRead` fosse zero o negativo. 
