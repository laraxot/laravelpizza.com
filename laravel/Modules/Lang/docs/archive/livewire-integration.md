# Integrazione di mcamara/laravel-localization con Livewire

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Livewire](#installazione-di-livewire)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Middleware per Livewire](#middleware-per-livewire)
4. [Componenti Livewire Localizzati](#componenti-livewire-localizzati)
5. [Gestione dei Form](#gestione-dei-form)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione tra `mcamara/laravel-localization` e Livewire richiede un'attenzione particolare alla gestione dello stato dell'applicazione e al ciclo di vita dei componenti. Questa guida ti mostrerà come implementare correttamente la localizzazione nei tuoi componenti Livewire.

## Configurazione Iniziale

### Installazione di Livewire

```bash
composer require livewire/livewire
```

### Configurazione di Laravel-Localization

Assicurati di avere `mcamara/laravel-localization` installato e configurato:

```bash
composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

## Middleware per Livewire

Crea un middleware dedicato per gestire le richieste Livewire:

```php
// app/Http/Middleware/LivewireLocalization.php

namespace App\Http\Middleware;

use Closure;
use Mcamara\LaravelLocalization\LaravelLocalization;

class LivewireLocalization
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
            $locale = $this->localization->getCurrentLocale();
            
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
        \App\Http\Middleware\LivewireLocalization::class,
    ],
];
```

## Componenti Livewire Localizzati

### Creazione di un Componente Base

Crea un componente Livewire di base che gestisca la localizzazione:

```php
// app/Http/Livewire/LocalizedComponent.php

namespace App\Http\Livewire;

use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocalizedComponent extends Component
{
    protected $listeners = ['languageChanged' => '$refresh'];
    
    public function mount()
    {
        $this->setLocale();
    }
    
    protected function setLocale()
    {
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);
    }
    
    public function changeLanguage($locale)
    {
        if (array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
            $this->emit('languageChanged');
        }
    }
}
```

### Esempio di Componente Localizzato

```php
// app/Http/Livewire/ExampleComponent.php

namespace App\Http\Livewire;

class ExampleComponent extends LocalizedComponent
{
    public $name = '';
    
    protected $rules = [
        'name' => 'required|min:3',
    ];
    
    public function save()
    {
        $this->validate();
        
        // Logica di salvataggio...
        
        session()->flash('message', __('messages.saved_successfully'));
    }
    
    public function render()
    {
        return view('livewire.example-component');
    }
}
```

## Gestione dei Form

### Validazione Localizzata

Per i messaggi di validazione localizzati, crea un file di traduzione per le regole di validazione:

```php
// resources/lang/it/validation.php

return [
    'required' => 'Il campo :attribute è obbligatorio.',
    'min' => [
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    // Altre traduzioni...
];

// resources/lang/it/attributes.php

return [
    'name' => 'nome',
    'email' => 'indirizzo email',
    // Altri attributi...
];
```

### Selezione della Lingua

Crea un componente per il cambio lingua:

```php
// app/Http/Livewire/LanguageSwitcher.php

namespace App\Http\Livewire;

use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $availableLocales = [];
    
    public function mount()
    {
        $this->currentLocale = app()->getLocale();
        $this->availableLocales = LaravelLocalization::getSupportedLocales();
    }
    
    public function changeLanguage($locale)
    {
        if (array_key_exists($locale, $this->availableLocales)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
            
            // Reindirizza alla stessa pagina nella nuova lingua
            $currentUrl = url()->current();
            $newUrl = LaravelLocalization::getLocalizedURL($locale, null, [], true);
            
            // Se l'URL corrente non è localizzato, mantieni il percorso
            $path = parse_url($currentUrl, PHP_URL_PATH);
            $path = ltrim($path, '/');
            $segments = explode('/', $path);
            
            if (count($segments) > 0 && array_key_exists($segments[0], $this->availableLocales)) {
                array_shift($segments);
            }
            
            if (!empty($segments)) {
                $newUrl = rtrim($newUrl, '/') . '/' . implode('/', $segments);
            }
            
            return redirect($newUrl);
        }
    }
    
    public function render()
    {
        return view('livewire.language-switcher');
    }
}
```

## Testing

### Test per il Middleware

```php
// tests/Feature/LivewireLocalizationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LivewireLocalizationTest extends TestCase
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
   Utilizza un middleware dedicato per gestire la localizzazione nelle richieste Livewire.

2. **Componente Base**
   Crea un componente base che gestisca la logica di localizzazione comune.

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

### Problemi con le richieste Livewire
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
