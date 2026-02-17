# Implementazione Corretta del Logout con Volt e Folio

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Analisi Logout Blade](./LOGOUT_BLADE_ANALYSIS.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)

## Panoramica
Questo documento descrive l'implementazione corretta del logout utilizzando Laravel Folio e Volt, seguendo le convenzioni di <nome progetto>.

## Percorso Corretto
Il file di logout deve essere posizionato in:
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

## Approcci Raccomandati

In base all'analisi dettagliata del file logout.blade.php e alle convenzioni del progetto <nome progetto>, si raccomandano i seguenti approcci per l'implementazione del logout.

### 1. Approccio Folio con PHP puro (Raccomandato)

Questo approccio è raccomandato per il logout in quanto è un'operazione semplice che non richiede gestione dello stato o interazione complessa con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta `logout`:

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

Quindi nel form:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio per gestire il logout:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};

middleware(['auth']);
name('logout');

mount(function() {
    if(Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    // Reindirizza alla home page localizzata
    $this->redirect('/' . app()->getLocale());
});
?>

<x-layouts.main>
    @volt('auth.logout')
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
    @endvolt
</x-layouts.main>
```

## Punti Importanti

1. **Localizzazione degli URL**: Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:
   ```
   /{locale}/{sezione}/{risorsa}
   ```

2. **Recuperare la Locale Corrente**: Usare sempre `app()->getLocale()` per ottenere la lingua corrente:
   ```php
   $locale = app()->getLocale();
   ```

3. **Generare Link Localizzati**: Quando si generano link, includere sempre la locale:
   ```php
   // CORRETTO
   <a href="{{ url('/' . app()->getLocale()) }}">{{ __('Home') }}</a>

   // ERRATO
   <a href="{{ route('home') }}">{{ __('Home') }}</a>
   ```

4. **Sicurezza**: Assicurarsi di invalidare e rigenerare la sessione per prevenire attacchi di session fixation.

## Problemi Comuni

1. **Mancata Localizzazione**: Non includere il prefisso della lingua negli URL.
2. **Utilizzo di route() senza Locale**: Utilizzare `route('home')` senza considerare la localizzazione.
3. **Mancata Rigenerazione Token**: Non rigenerare il token CSRF dopo il logout.

## Implementazione con Componenti Filament

Per seguire le best practices di <nome progetto>, utilizzare sempre i componenti Blade nativi di Filament:

```php
<x-filament::button tag="a" href="{{ url('/' . $locale) }}" color="primary" class="w-full">
    {{ __('Torna alla Home') }}
</x-filament::button>
```

invece di:

```php
<a href="{{ url('/' . $locale) }}" class="btn btn-primary w-full">
    {{ __('Torna alla Home') }}
</a>
```

## Conclusione

Seguire l'approccio Folio con Volt è raccomandato per la gestione del logout . Assicurarsi di includere sempre la localizzazione negli URL e di utilizzare i componenti Filament per la UI.
