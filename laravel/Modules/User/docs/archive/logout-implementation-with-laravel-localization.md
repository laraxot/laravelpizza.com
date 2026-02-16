# Implementazione del Logout con LaravelLocalization 

## Collegamenti correlati
- [README modulo User](./README.md)
- [Best Practices Componenti di Autenticazione](./AUTH_COMPONENTS_BEST_PRACTICES.md)
- [Utilizzo di Laravel Localization](/laravel/Modules/Lang/docs/LARAVEL_LOCALIZATION_USAGE.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Componenti Filament](/docs/rules/filament-components.md)

## Panoramica

Questo documento descrive l'implementazione corretta del processo di logout , con particolare attenzione all'utilizzo di Livewire Volt, LaravelLocalization e componenti Filament.

## Problematiche del Logout Diretto

L'implementazione del logout direttamente nel codice PHP di una pagina Folio causa diversi problemi:

1. **Logout Automatico**: Il logout viene eseguito automaticamente al caricamento della pagina, senza conferma dell'utente
2. **Reindirizzamento Immediato**: L'utente viene reindirizzato immediatamente, senza feedback
3. **Gestione Errori Limitata**: Non c'è una gestione adeguata degli errori che potrebbero verificarsi durante il processo di logout
4. **Problemi di UX**: L'utente non ha la possibilità di annullare l'operazione

## Soluzione Raccomandata: Volt con mount()

La soluzione raccomandata per implementare il logout  è utilizzare un componente Volt con il metodo `mount()` per gestire il processo di logout:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

middleware(['auth']);
name('logout');

mount(function() {
    if (Auth::check()) {
        // Dispatch dell'evento prima del logout
        Event::dispatch('auth.logout.attempting', [Auth::user()]);
        
        // Esegui il logout
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        // Dispatch dell'evento dopo il logout
        Event::dispatch('auth.logout.successful');
    }
    
    // Reindirizza l'utente alla home page localizzata
    $this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
});
```

## Utilizzo Corretto di LaravelLocalization

Per garantire la compatibilità con il sistema di localizzazione di SaluteOra, è importante utilizzare le funzioni del pacchetto `mcamara/laravel-localization` invece di `app()->getLocale()`:

```php
// ERRATO
$locale = app()->getLocale();
$this->redirect('/' . $locale);

// CORRETTO
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
$this->redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')));
```

Questo garantisce che l'utente venga reindirizzato alla versione localizzata della home page dopo il logout, rispettando le convenzioni di SaluteOra per la gestione della localizzazione.

## Template Blade con Componenti Filament

Il template Blade per il logout dovrebbe utilizzare i componenti Filament e mostrare un indicatore di caricamento durante il processo di logout:

```blade
<x-filament::layouts.card>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8">
            <div class="text-center">
                <x-filament::loading-indicator class="h-12 w-12 mx-auto" />
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('auth.logout.title') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.logout.message') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-filament::layouts.card>
```

## Vantaggi dell'Approccio con mount()

1. **Esecuzione Automatica**: Il logout viene eseguito automaticamente al caricamento della pagina, ma in modo controllato
2. **Feedback Visivo**: L'utente riceve un feedback chiaro durante il processo di logout
3. **Gestione Errori Robusta**: Gli errori vengono catturati e gestiti appropriatamente
4. **Esperienza Utente Migliorata**: L'interfaccia è più intuitiva e reattiva
5. **Localizzazione Corretta**: Gli URL generati rispettano le convenzioni di SaluteOra per la localizzazione

## Chiavi di Traduzione per il Logout

Per garantire la coerenza nelle traduzioni, è importante utilizzare chiavi di traduzione strutturate per tutti i testi relativi al logout, seguendo la convenzione `modulo::risorsa.fields.campo.label`:

```php
// Errato
__('Logout')
__('Logout effettuato')
__('Sei stato disconnesso con successo.')

// Corretto
__('auth.logout.title')
__('auth.logout.message')
```

Queste chiavi devono essere definite nel file di traduzione `auth.php` per ogni lingua supportata:

```php
'logout' => [
    'title' => 'Logout in corso...',
    'message' => 'Verrai reindirizzato alla home page.',
    'success_title' => 'Logout effettuato',
    'success_message' => 'Sei stato disconnesso con successo.',
    'error_title' => 'Errore durante il logout',
    'error_message' => 'Si è verificato un errore durante il logout.',
    'back_to_home' => 'Torna alla Home',
],
```

## Regole Fondamentali da Ricordare

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Utilizzo Corretto di LaravelLocalization**
   - Utilizzare `LaravelLocalization::getCurrentLocale()` invece di `app()->getLocale()`
   - Utilizzare `LaravelLocalization::getSupportedLocales()` per le lingue supportate
   - Utilizzare `LaravelLocalization::getLocalizedURL()` per generare URL localizzati

4. **Utilizzo dei Componenti Filament**
   - Utilizzare sempre i componenti Blade nativi di Filament
   - Evitare di utilizzare componenti UI personalizzati

## Conclusione

Seguendo queste best practices, è possibile implementare un processo di logout robusto e user-friendly , che rispetta le convenzioni del progetto per la localizzazione e l'utilizzo dei componenti Filament.
