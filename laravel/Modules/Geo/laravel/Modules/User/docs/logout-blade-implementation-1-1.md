# Implementazione Corretta di logout.blade.php

## Collegamenti correlati
- [Documentazione centrale](../../../docs/README.md)
- [Collegamenti documentazione](../../../docs/collegamenti-documentazione.md)
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Volt Errors](./VOLT_ERRORS.md)
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md)
- [Volt Logout Action](./VOLT_LOGOUT_ACTION.md)
- [Auth Pages Implementation](./AUTH_PAGES_IMPLEMENTATION.md)

## Posizione Corretta
Il file `logout.blade.php` deve essere posizionato in:
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

## Approcci di Implementazione

, ci sono tre approcci principali per implementare il logout:

### 1. Folio con PHP puro (Raccomandato)

Questo approccio è il più semplice e diretto per il logout, poiché non richiede gestione dello stato o interazione con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

if(Auth::check()) {
    // Esegui il logout
    Auth::logout();

    // Invalida e rigenera la sessione per prevenire session fixation
    request()->session()->invalidate();
    request()->session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

**Vantaggi:**
- Semplice e diretto
- Non richiede componenti aggiuntivi
- Esegue immediatamente il logout e reindirizza

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta `logout`.

**Step 1:** Creare il file `Modules/User/app/Http/Volt/LogoutAction.php`:

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

        // Reindirizza alla home page localizzata
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }
}
```

**Step 2:** Utilizzare un form con metodo POST nel template:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

**Vantaggi:**
- Supporta il metodo POST (più sicuro per il logout)
- Definisce una rotta dedicata
- Può essere riutilizzato in più punti dell'applicazione

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio per gestire il logout.

```blade
@volt('auth.logout')
    use Illuminate\Support\Facades\Auth;
    use function Livewire\Volt\{mount};

    mount(function() {
        if(Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }
        
        // Reindirizza alla home page localizzata
        $this->redirect('/' . app()->getLocale());
    });
@endvolt

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout in corso...') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page.') }}
                </p>
            </div>
        </div>
    </div>
</x-layout>
```

**Vantaggi:**
- Coerente con l'approccio Volt utilizzato in altre pagine auth
- Permette di mostrare un messaggio di conferma durante il reindirizzamento
- Utilizza il pattern mount per eseguire azioni all'inizializzazione del componente

## Implementazione Raccomandata per SaluteOra

Per SaluteOra, **l'approccio 1 (Folio con PHP puro)** è raccomandato per il logout per i seguenti motivi:

1. Il logout è un'operazione semplice che non richiede gestione dello stato
2. Non è necessaria interazione con l'utente durante il processo
3. Il reindirizzamento immediato è preferibile per una migliore esperienza utente
4. Riduce la complessità e il carico del browser

## Best Practices

### Sicurezza
- Utilizzare sempre `Auth::logout()` per terminare la sessione autenticata
- Invalidare sempre la sessione con `session()->invalidate()`
- Rigenerare sempre il token CSRF con `session()->regenerateToken()`
- Verificare che l'utente sia autenticato con `Auth::check()` prima del logout

### Localizzazione
- Utilizzare sempre `app()->getLocale()` per ottenere la lingua corrente
- Includere sempre il prefisso della lingua nei link e nei reindirizzamenti
- Utilizzare la funzione `__()` per tutte le stringhe visualizzate all'utente

### UI/UX
- Se si utilizza un approccio con visualizzazione (Approccio 3), utilizzare i componenti Filament
- Fornire un feedback chiaro all'utente sul processo di logout
- Implementare un reindirizzamento automatico dopo un breve ritardo

## Errori Comuni da Evitare

1. **Mancata invalidazione della sessione**: Può portare a vulnerabilità di sicurezza
2. **URL non localizzati**: Genera errori di navigazione e problemi di UX
3. **Componenti UI personalizzati**: Utilizzare sempre i componenti Filament nativi
4. **Mancanza di feedback all'utente**: Lasciare l'utente senza informazioni sul processo
5. **Rotte in `routes/web.php`**: Utilizzare Folio o attributi PHP 8 per le rotte

## Implementazione Finale Raccomandata

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

if(Auth::check()) {
    // Esegui il logout
    Auth::logout();

    // Invalida e rigenera la sessione per prevenire session fixation
    request()->session()->invalidate();
    request()->session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

Questa implementazione è semplice, sicura e segue tutte le best practices del progetto SaluteOra.
