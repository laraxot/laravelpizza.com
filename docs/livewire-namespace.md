# Regole per i componenti Livewire in Windsurf/Xot

## Namespace corretto

I namespace dei componenti Livewire **NON DEVONO MAI** includere il segmento `app` anche se i file sono fisicamente posizionati nella directory app:

### ✅ CORRETTO
```php
namespace Modules\User\Http\Livewire\Auth;
```

### ❌ ERRATO
```php
namespace Modules\User\App\Http\Livewire\Auth;
```

## Sintesi della regola
La directory `app` è un contenitore fisico, NON un elemento logico del namespace. Questa regola è fondamentale per l'autoloading PSR-4 e la compatibilità con PHPStan.

## Implementazione corretta dei componenti di autenticazione

I componenti Livewire per l'autenticazione devono:

1. Usare il namespace corretto
2. Iniettare le dipendenze tramite constructor injection quando possibile
3. Utilizzare la facade `Auth` piuttosto che l'helper `auth()`
4. Implementare trattamento degli errori con messaggi chiari
5. Documentare il componente e le sue responsabilità

### Esempio: Componente Logout

```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class Logout extends Component
{
    /**
     * Gestisce il processo di logout.
     *
     * Questo metodo:
     * 1. Esegue il logout dell'utente
     * 2. Invalida la sessione corrente
     * 3. Rigenera il token CSRF
     * 4. Reindirizza alla pagina di login
     */
    public function mount(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        redirect()->route('login');
    }

    /**
     * Renderizza il componente.
     */
    public function render(): View
    {
        return view('user::livewire.auth.logout');
    }
}
```

## Risoluzione dei conflitti Git

Durante i merge, prestare particolare attenzione ai file dei componenti Livewire, specialmente se ci sono modifiche nel namespace. I problemi tipici includono:

1. Conflitti tra namespace con/senza `app`
2. Differenze nella logica di autenticazione
3. Differenze nei percorsi di reindirizzamento

La risoluzione manuale è sempre da preferire per questi file, assicurandosi di mantenere la coerenza con le regole del progetto.

## Note sulla compatibilità e sicurezza

- Assicurarsi che la rigenerazione del token CSRF avvenga sempre dopo il logout
- Verificare che i percorsi di reindirizzamento siano coerenti con l'architettura dell'applicazione
- Preferire le facade come `Auth` agli helper come `auth()` per maggiore testabilità
