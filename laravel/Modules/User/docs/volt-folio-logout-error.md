# Errore nel Logout con Volt e Folio

## Il Problema
Il file `logout.blade.php` non funziona correttamente perché:

1. **Layout Errato**: 
   - Si usa `<x-layouts.app>` invece di `<x-layout>`
   - Il layout corretto è definito nel tema TwentyOne

2. **Direttiva Volt Non Necessaria**:
   - La pagina è una pagina Folio, non un componente Volt
   - Il logout può essere gestito con un form standard

3. **Gestione Sessione Non Ottimale**:
   - Il reindirizzamento JavaScript non è la soluzione migliore
   - Meglio gestire il reindirizzamento lato server

## Soluzione Corretta

### 1. Pagina di Logout (logout.blade.php)
```blade
<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Sei sicuro di voler uscire?') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Potrai sempre accedere nuovamente con le tue credenziali.') }}
                </p>
            </div>

            <div class="mt-8 space-y-6">
                <div class="flex items-center justify-between space-x-4">
                    <a href="{{ route('home') }}" 
                       class="flex-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Annulla') }}
                    </a>

                    <form action="{{ route('logout') }}" method="post" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
```

### 2. LogoutAction.php
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

        return redirect()->route('home');
    }
}
```

## Perché Questa Soluzione Funziona

1. **Separazione delle Responsabilità**:
   - Folio gestisce il routing e la visualizzazione
   - Volt gestisce l'azione di logout
   - Il form standard gestisce l'invio della richiesta

2. **Sicurezza**:
   - CSRF token incluso
   - Sessione gestita correttamente
   - Middleware auth applicato

3. **UX Migliorata**:
   - Conferma prima del logout
   - Possibilità di annullare
   - Feedback visivo chiaro

## Best Practices

1. **Layout**:
   - Usare sempre il layout corretto del tema
   - Non mischiare diversi sistemi di layout

2. **Routing**:
   - Lasciare che Folio gestisca il routing delle pagine
   - Usare Volt solo per le azioni

3. **Sessione**:
   - Gestire il reindirizzamento lato server
   - Evitare JavaScript per operazioni critiche

## Collegamenti
- [Best Practices Folio](./ROUTING_BEST_PRACTICES.md)
- [Best Practices Volt](./VOLT_BEST_PRACTICES.md)
- [Gestione Sessione](./SESSION_MANAGEMENT.md) 
