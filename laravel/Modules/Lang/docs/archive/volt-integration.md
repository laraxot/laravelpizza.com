# Integrazione di mcamara/laravel-localization con Laravel Volt

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Volt](#installazione-di-volt)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Middleware per Volt](#middleware-per-volt)
4. [Componenti Volt Localizzati](#componenti-volt-localizzati)
5. [Gestione dei Form](#gestione-dei-form)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione di `mcamara/laravel-localization` con Laravel Volt richiede un approccio specifico per garantire che i componenti reattivi rispettino l'impostazione della lingua corrente. Questa guida ti mostrerà come implementare correttamente la localizzazione nei tuoi componenti Volt.

## Configurazione Iniziale

### Installazione di Volt

```bash
composer require livewire/volt
```

### Configurazione di Laravel-Localization

Assicurati di avere `mcamara/laravel-localization` installato e configurato:

```bash
composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

## Middleware per Volt

Crea un middleware dedicato per gestire le richieste dei componenti Volt:

```php
// app/Http/Middleware/VoltLocalization.php

namespace App\Http\Middleware;

use Closure;
use Mcamara\LaravelLocalization\LaravelLocalization;

class VoltLocalization
{
    protected $localization;

    public function __construct(LaravelLocalization $localization)
    {
        $this->localization = $localization;
    }

    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('X-Livewire') && $request->hasHeader('Referer')) {
            $referer = $request->header('Referer');
            
            // Estrai la lingua dall'URL di riferimento
            $path = parse_url($referer, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            
            if (count($segments) > 0 && in_array($segments[0], array_keys($this->localization->getSupportedLocales()))) {
                $locale = $segments[0];
                app()->setLocale($locale);
                session(['locale' => $locale]);
            }
        }

        return $next($request);
    }
}
```

Registra il middleware nel kernel HTTP:

```php
// app/Http/Kernel.php

protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\VoltLocalization::class,
    ],
];
```

## Componenti Volt Localizzati

### Creazione di un Componente Base

Crea un trait riutilizzabile per i componenti Volt che necessitano di supporto multilingua:

```php
// app/Http/Traits/WithLocalization.php

namespace App\Http\Traits;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait WithLocalization
{
    /**
     * Restituisce la traduzione per la chiave specificata
     */
    public function t(string $key, array $replace = [], ?string $locale = null): string|array|null
    {
        return __($key, $replace, $locale);
    }

    /**
     * Cambia la lingua corrente
     */
    public function switchLanguage(string $locale): void
    {
        if (array_key_exists($locale, $this->getSupportedLocales())) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
            $this->dispatch('language-changed', locale: $locale);
        }
    }

    /**
     * Restituisce le lingue supportate
     */
    public function getSupportedLocales(): array
    {
        return LaravelLocalization::getSupportedLocales();
    }
}
```

### Esempio di Componente Volt Localizzato

```php
<?php

use function Livewire\Volt\state;
use function Livewire\Volt\computed;
use function Livewire\Volt\on;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

state([
    'name' => '',
    'currentLocale' => fn() => app()->getLocale(),
]);

$supportedLocales = computed(fn() => LaravelLocalization::getSupportedLocales());

$changeLanguage = function ($locale) {
    if (array_key_exists($locale, $this->supportedLocales)) {
        $this->currentLocale = $locale;
        session(['locale' => $locale]);
        app()->setLocale($locale);
        
        // Reindirizza alla stessa pagina nella nuova lingua
        $currentUrl = url()->current();
        $newUrl = LaravelLocalization::getLocalizedURL($locale, null, [], true);
        
        // Se l'URL corrente non è localizzato, mantieni il percorso
        $path = parse_url($currentUrl, PHP_URL_PATH);
        $path = ltrim($path, '/');
        $segments = explode('/', $path);
        
        if (count($segments) > 0 && array_key_exists($segments[0], $this->supportedLocales)) {
            array_shift($segments);
        }
        
        if (!empty($segments)) {
            $newUrl = rtrim($newUrl, '/') . '/' . implode('/', $segments);
        }
        
        return redirect($newUrl);
    }
};

$save = function () {
    $this->validate([
        'name' => 'required|min:3',
    ]);
    
    // Logica di salvataggio...
    
    session()->flash('message', __('messages.saved_successfully'));
};
?>

<div>
    <form wire:submit="save">
        <div>
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" wire:model="name" class="form-control">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </form>
    
    <div class="mt-8">
        <h3 class="text-lg font-medium">{{ __('Change Language') }}</h3>
        <div class="mt-2">
            @foreach($this->supportedLocales as $localeCode => $properties)
                <button 
                    type="button" 
                    wire:click="changeLanguage('{{ $localeCode }}')"
                    class="px-4 py-2 mr-2 text-sm font-medium {{ $currentLocale === $localeCode ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} rounded-md"
                >
                    {{ $properties['native'] }}
                </button>
            @endforeach
        </div>
    </div>
    
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
```

## Testing

### Test per il Middleware

```php
// tests/Feature/VoltLocalizationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoltLocalizationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_sets_locale_from_referer()
    {
        $response = $this->withHeaders([
            'X-Livewire' => true,
            'Referer' => 'http://example.com/it/dashboard',
        ])->get('/livewire/update');
        
        $response->assertStatus(200);
        $this->assertEquals('it', app()->getLocale());
    }
    
    /** @test */
    public function it_handles_invalid_locale()
    {
        $response = $this->withHeaders([
            'X-Livewire' => true,
            'Referer' => 'http://example.com/xx/dashboard',
        ])->get('/livewire/update');
        
        $response->assertStatus(200);
        $this->assertEquals(config('app.locale'), app()->getLocale());
    }
}
```

## Best Practice

1. **Middleware Dedicato**
   Utilizza un middleware dedicato per gestire la localizzazione nelle richieste dei componenti Volt.

2. **Trait Riutilizzabile**
   Crea un trait per la gestione della localizzazione che può essere utilizzato da più componenti.

3. **Traduzioni**
   Mantieni tutte le stringhe testuali nei file di traduzione.

4. **Test**
   Scrivi test per verificare il corretto funzionamento della localizzazione.

5. **Prestazioni**
   Utilizza la cache delle traduzioni in produzione per migliorare le prestazioni.

## Risoluzione Problemi

### Le traduzioni non si aggiornano
- Esegui `php artisan view:clear` e `php artisan cache:clear`
- Verifica che i file di traduzione siano nella cartella corretta
- Controlla i permessi delle cartelle di cache

### Problemi con le richieste Volt
- Assicurati che il middleware sia registrato correttamente
- Verifica che l'header `X-Livewire` sia presente nelle richieste
- Controlla i log di errore per eventuali eccezioni

### Problemi con i form
- Verifica che i nomi dei campi nei form corrispondano alle chiavi di traduzione
- Assicurati che i file di traduzione contengano le chiavi necessarie
- Controlla che la validazione venga eseguita correttamente

### Problemi con il cambio lingua
- Verifica che la lingua venga salvata correttamente nella sessione
- Controlla che l'URL di reindirizzamento sia corretto
- Assicurati che il middleware di localizzazione sia configurato correttamente
