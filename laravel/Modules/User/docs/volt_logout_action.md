# Logout via Volt Action

## Contesto
Durante il logout in frontoffice, il form chiama:
```blade
<form action="{{ route('logout') }}" method="post"> @csrf
    <button>Logout</button>
</form>
```
e genera l’errore:
```
Route [logout] not defined.
```
In Volt + Folio + Filament **non** si usano rotte in `routes/web.php` per il frontoffice.

## Soluzione: Volt Action dedicata
Creiamo una Volt Action che definisce la rotta `logout` con attributo PHP8.

### 1. Creazione della Volt Action
File: `Modules/User/app/Http/Volt/LogoutAction.php`
```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla rotta "home" del frontoffice
        return redirect()->route('home');
    }
}
```

### 2. Utilizzo nel Blade
Non serve cambiare il form:
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button>Logout</button>
</form>
```
Volt scoprirà automaticamente la rotta `logout` grazie all’Attribute.

## Verifica
1. Svuota cache delle rotte: `php artisan route:clear && php artisan route:cache`
2. Accedi al frontoffice e clicca "Logout": non otterrai più l’Internal Server Error.

## Note
- Il middleware `web` gestisce session e CSRF.
- Il middleware `auth` impedisce accessi non autenticati.
- Non toccare `routes/web.php` per il frontoffice.
