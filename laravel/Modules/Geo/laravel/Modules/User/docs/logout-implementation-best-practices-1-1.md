# Best Practices per l'Implementazione del Logout 

## Collegamenti correlati
- [README modulo User](./README.md)
- [Best Practices Componenti di Autenticazione](./AUTH_COMPONENTS_BEST_PRACTICES.md)
- [Utilizzo di Laravel Localization](/laravel/Modules/Lang/docs/LARAVEL_LOCALIZATION_USAGE.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive le best practices per implementare il processo di logout , con particolare attenzione all'utilizzo di Livewire Volt e alla gestione corretta degli eventi di autenticazione.

## Problematiche del Logout Diretto

L'implementazione del logout direttamente nel codice PHP di una pagina Folio causa diversi problemi:

1. **Logout Automatico**: Il logout viene eseguito automaticamente al caricamento della pagina, senza conferma dell'utente
2. **Reindirizzamento Immediato**: L'utente viene reindirizzato immediatamente, senza feedback
3. **Gestione Errori Limitata**: Non c'è una gestione adeguata degli errori che potrebbero verificarsi durante il processo di logout
4. **Problemi di UX**: L'utente non ha la possibilità di annullare l'operazione

## Implementazione Corretta con Livewire Volt

La soluzione migliore è utilizzare un componente Livewire Volt che gestisce il logout in modo controllato:

```php
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

new class extends Component
{
    public bool $logoutCompleted = false;
    public bool $hasError = false;
    public string $errorMessage = '';
    
    public function mount(): void
    {
        // Non eseguiamo il logout automaticamente al mount
        // Il logout verrà eseguito solo quando l'utente clicca sul pulsante
    }
    
    public function logout(): void
    {
        try {
            // Dispatch dell'evento prima del logout
            Event::dispatch('auth.logout.attempting', [Auth::user()]);

            // Esegui il logout
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            // Dispatch dell'evento dopo il logout
            Event::dispatch('auth.logout.successful');
            
            $this->logoutCompleted = true;
            $this->hasError = false;
        } catch (\Exception $e) {
            // Gestione dell'errore
            $this->logoutCompleted = false;
            $this->hasError = true;
            $this->errorMessage = $e->getMessage();
        }
    }
    
    public function redirectHome(): void
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $this->redirect(LaravelLocalization::getLocalizedURL($locale, route('home')));
    }
};
```

## Vantaggi dell'Approccio Volt

1. **Controllo Utente**: L'utente deve confermare esplicitamente il logout
2. **Feedback Visivo**: L'utente riceve un feedback chiaro sullo stato del processo
3. **Gestione Errori Robusta**: Gli errori vengono catturati e visualizzati all'utente
4. **Flessibilità**: L'utente può annullare l'operazione se lo desidera
5. **Esperienza Utente Migliorata**: L'interfaccia è più intuitiva e reattiva

## Template Blade Corretto

Il template Blade associato al componente Volt dovrebbe gestire i diversi stati del processo di logout:

```php
<x-layouts.main>
    <div class="flex flex-col items-center justify-center min-h-screen py-12 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @volt('auth.logout')
                <div class="text-center">
                    <x-ui.logo class="w-auto h-12 mx-auto text-gray-700 fill-current dark:text-gray-200" />
                    
                    @if($logoutCompleted)
                        <!-- Stato di successo -->
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                            {{ __('auth.logout.success_title') }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('auth.logout.success_message') }}
                        </p>
                        
                        <div class="mt-8">
                            <x-ui.button 
                                type="primary" 
                                rounded="md" 
                                tag="a" 
                                href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')) }}"
                                class="w-full"
                            >
                                {{ __('auth.logout.back_to_home') }}
                            </x-ui.button>
                        </div>
                    @elseif($hasError)
                        <!-- Stato di errore -->
                        <h2 class="mt-6 text-3xl font-extrabold text-red-600 dark:text-red-500">
                            {{ __('auth.logout.error_title') }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('auth.logout.error_message') }}
                        </p>
                        
                        <div class="mt-8 space-y-4">
                            <x-ui.button 
                                type="danger" 
                                rounded="md" 
                                wire:click="logout"
                                class="w-full"
                            >
                                {{ __('auth.logout.try_again') }}
                            </x-ui.button>
                            
                            <x-ui.button 
                                type="secondary" 
                                rounded="md" 
                                tag="a" 
                                href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')) }}"
                                class="w-full"
                            >
                                {{ __('auth.logout.back_to_home') }}
                            </x-ui.button>
                        </div>
                    @else
                        <!-- Stato iniziale (conferma) -->
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                            {{ __('auth.logout.title') }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('auth.logout.confirm_message') }}
                        </p>
                        
                        <div class="mt-8 space-y-4">
                            <x-ui.button 
                                type="primary" 
                                rounded="md" 
                                wire:click="logout"
                                class="w-full"
                            >
                                {{ __('auth.logout.confirm_button') }}
                            </x-ui.button>
                            
                            <x-ui.button 
                                type="secondary" 
                                rounded="md" 
                                tag="a" 
                                href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')) }}"
                                class="w-full"
                            >
                                {{ __('auth.logout.cancel_button') }}
                            </x-ui.button>
                        </div>
                    @endif
                </div>
            @endvolt
        </div>
    </div>
</x-layouts.main>
```

## Chiavi di Traduzione

Le chiavi di traduzione per il processo di logout devono seguire la struttura gerarchica definita nelle best practices di SaluteOra:

```php
'logout' => [
    'submit' => 'Logout',
    'title' => 'Logout',
    'success_title' => 'Logout effettuato',
    'success_message' => 'Sei stato disconnesso con successo.',
    'error_title' => 'Errore durante il logout',
    'error_message' => 'Si è verificato un errore durante il logout. Riprova.',
    'confirm_message' => 'Sei sicuro di voler effettuare il logout?',
    'confirm_button' => 'Conferma logout',
    'cancel_button' => 'Annulla',
    'back_to_home' => 'Torna alla home',
    'try_again' => 'Riprova',
],
```

## Eventi di Autenticazione

È importante gestire correttamente gli eventi di autenticazione durante il processo di logout:

1. **auth.logout.attempting**: Inviato prima di eseguire il logout, con l'utente corrente come parametro
2. **auth.logout.successful**: Inviato dopo che il logout è stato completato con successo

Questi eventi possono essere utilizzati per eseguire azioni aggiuntive, come la registrazione del logout nei log o l'aggiornamento dello stato dell'utente.

## Sicurezza

Per garantire la sicurezza durante il processo di logout, è fondamentale:

1. **Invalidare la Sessione**: `request()->session()->invalidate()`
2. **Rigenerare il Token CSRF**: `request()->session()->regenerateToken()`
3. **Utilizzare il Middleware auth**: `middleware(['auth'])`

Queste misure prevengono attacchi di tipo session fixation e garantiscono che solo gli utenti autenticati possano accedere alla pagina di logout.

## Integrazione con Laravel Localization

Tutti i link e i reindirizzamenti devono utilizzare `LaravelLocalization::getLocalizedURL()` per mantenere il prefisso della lingua corrente:

```php
$locale = LaravelLocalization::getCurrentLocale();
$this->redirect(LaravelLocalization::getLocalizedURL($locale, route('home')));
```

## Riferimenti

- [Documentazione Laravel Authentication](https://laravel.com/docs/10.x/authentication)
- [Documentazione Livewire Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Laravel Folio](https://laravel.com/docs/10.x/folio)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
