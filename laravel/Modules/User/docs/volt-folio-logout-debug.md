# Debug: Perché logout.blade.php non funziona (Volt + Folio)

## Analisi del problema

La pagina `/themes/TwentyOne/resources/views/pages/auth/logout.blade.php` non funziona come logout reale. Ecco i motivi principali:

### 1. **La logica di logout NON viene eseguita automaticamente**
- **Volt** esegue la logica solo tramite azioni (wire:click, wire:submit, ecc.) o lifecycle hooks (`mount`, ecc.), **ma solo se la pagina è una vera Volt Page** (cioè se è dichiarata come componente Volt, non solo come Blade con direttiva @volt e PHP inline).
- Se accedi direttamente alla pagina `/auth/logout`, il codice PHP dentro il file Blade **NON viene eseguito come azione Livewire/Volt**, ma solo renderizzato come Blade.
- Quindi il logout NON avviene: la pagina mostra solo il messaggio, ma l’utente è ancora autenticato!

### 2. **Il redirect e la sessione non vengono gestiti da Livewire/Volt**
- Il codice `$logout = function () { ... }` non viene invocato automaticamente.
- Serve una vera azione Livewire/Volt collegata a un evento (es. `wire:click`, `wire:init`, `mount`, ecc.).

## Come risolvere

### Soluzione 1: Pagina Logout con azione automatica (Volt Page vera)

1. **Crea una vera Volt Page** in `/app/Http/Livewire/Auth/Logout.php`:
```php
<?php
namespace App\Http\Livewire\Auth;

use Livewire\Volt\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
```
2. **Crea la view associata**: `resources/views/livewire/auth/logout.blade.php`
```blade
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Logout effettuato con successo') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('Torna alla Home') }}</a>
        </div>
    </div>
</x-layouts.app>
```
3. **Registra la route Volt/Folio** per `/auth/logout` che punti a questo componente.
   - Se usi Folio, crea un file che richiama il componente Livewire:
   ```blade
   {{-- resources/views/pages/auth/logout.blade.php --}}
   @livewire('auth.logout')
   ```

### Soluzione 2: Logout via azione esplicita (pulsante)

Se vuoi mostrare una conferma, usa un pulsante con `wire:click="logout"` che richiama la funzione.

## Best practice
- **Non scrivere logica di logout direttamente in Blade**: usa sempre un componente Volt/Livewire.
- **Documenta la soluzione**: aggiorna la documentazione interna.

---

**In sintesi:**
- Il logout non funziona perché il codice PHP non viene eseguito come azione Volt.
- Serve una vera Volt Page o un componente Livewire che esegua il logout su mount o su evento.
- Aggiorna la pagina Blade per richiamare il componente Livewire/Volt.
# Debug: Perché logout.blade.php non funziona (Volt + Folio)

## Analisi del problema

La pagina `/themes/TwentyOne/resources/views/pages/auth/logout.blade.php` non funziona come logout reale. Ecco i motivi principali:

### 1. **La logica di logout NON viene eseguita automaticamente**
- **Volt** esegue la logica solo tramite azioni (wire:click, wire:submit, ecc.) o lifecycle hooks (`mount`, ecc.), **ma solo se la pagina è una vera Volt Page** (cioè se è dichiarata come componente Volt, non solo come Blade con direttiva @volt e PHP inline).
- Se accedi direttamente alla pagina `/auth/logout`, il codice PHP dentro il file Blade **NON viene eseguito come azione Livewire/Volt**, ma solo renderizzato come Blade.
- Quindi il logout NON avviene: la pagina mostra solo il messaggio, ma l’utente è ancora autenticato!

### 2. **Il redirect e la sessione non vengono gestiti da Livewire/Volt**
- Il codice `$logout = function () { ... }` non viene invocato automaticamente.
- Serve una vera azione Livewire/Volt collegata a un evento (es. `wire:click`, `wire:init`, `mount`, ecc.).

## Come risolvere

### Soluzione 1: Pagina Logout con azione automatica (Volt Page vera)

1. **Crea una vera Volt Page** in `/app/Http/Livewire/Auth/Logout.php`:
```php
<?php
namespace App\Http\Livewire\Auth;

use Livewire\Volt\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
```
2. **Crea la view associata**: `resources/views/livewire/auth/logout.blade.php`
```blade
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Logout effettuato con successo') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('Torna alla Home') }}</a>
        </div>
    </div>
</x-layouts.app>
```
3. **Registra la route Volt/Folio** per `/auth/logout` che punti a questo componente.
   - Se usi Folio, crea un file che richiama il componente Livewire:
   ```blade
   {{-- resources/views/pages/auth/logout.blade.php --}}
   @livewire('auth.logout')
   ```

### Soluzione 2: Logout via azione esplicita (pulsante)

Se vuoi mostrare una conferma, usa un pulsante con `wire:click="logout"` che richiama la funzione.

## Best practice
- **Non scrivere logica di logout direttamente in Blade**: usa sempre un componente Volt/Livewire.
- **Documenta la soluzione**: aggiorna la documentazione interna.

---

**In sintesi:**
- Il logout non funziona perché il codice PHP non viene eseguito come azione Volt.
- Serve una vera Volt Page o un componente Livewire che esegua il logout su mount o su evento.
- Aggiorna la pagina Blade per richiamare il componente Livewire/Volt.
