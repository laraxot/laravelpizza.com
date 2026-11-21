# Componente di Logout

## Problemi Identificati
1. Conflitti Git non risolti nel file
2. Namespace inconsistente
3. Mancanza di gestione degli errori
4. Redirect non gestito correttamente
5. Mancanza di eventi di logout
6. Template view non necessario

## Soluzioni Proposte

### 1. Risoluzione Conflitti
- Rimuovere tutti i marcatori di conflitto Git
- Mantenere il namespace corretto `Modules\User\Http\Livewire\Auth`
- Utilizzare la facade Auth per consistenza

### 2. Gestione Logout
- Aggiungere try/catch per gestire eventuali errori
- Emettere eventi pre e post logout
- Implementare rate limiting per prevenire abusi
- Aggiungere logging per debugging e audit

### 3. Redirect
- Gestire il redirect in modo più robusto
- Permettere la configurazione della rotta di redirect
- Supportare intended URL

### 4. Best Practices
- Utilizzare return type declarations
- Aggiungere PHPDoc completo
- Implementare interfacce appropriate
- Seguire PSR-12

## Implementazione

```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;

class Logout extends Component
{
    public function mount(): void 
    {
        try {
            // Emetti evento pre-logout
            Event::dispatch('auth.logout.attempting', [Auth::user()]);
            
            // Esegui logout
            Auth::logout();
            
            // Invalida e rigenera la sessione
            session()->invalidate();
            session()->regenerateToken();
            
            // Emetti evento post-logout
            Event::dispatch('auth.logout.successful');
            
            // Log per audit
            Log::info('User logged out successfully');
            
            // Redirect alla home
            redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            session()->flash('error', __('Si è verificato un errore durante il logout'));
            redirect()->back();
        }
    }
}
```

## Note Aggiuntive
- Il componente non necessita di una view dedicata
- Può essere utilizzato come action in altri componenti
- Supporta l'estensione tramite eventi
- Segue le best practices di Laravel e Livewire 