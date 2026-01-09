# Regole Architetturali

## Principi Fondamentali

1. **No Controller Manuali**
   - Non creare controller manualmente
   - Utilizzare Filament per la gestione del backend
   - Utilizzare Folio per la gestione delle pagine

2. **No Route Manuali**
   - Non modificare `web.php`
   - Non aggiungere route manualmente
   - Lasciare che Filament e Folio gestiscano le rotte

3. **No Middleware Personalizzati**
   - Utilizzare i middleware forniti da Filament e Folio
   - Non creare middleware personalizzati per la gestione delle rotte
   - Utilizzare i middleware di localizzazione forniti da Laravel Localization

4. **Risorse Statiche**
   - Le immagini pubbliche devono essere in `/public_html/images`
   - I file SVG dei componenti devono essere in `Modules/UI/resources/svg`
   - Non utilizzare percorsi hardcoded per le risorse statiche
   - Utilizzare sempre gli helper di Laravel per i percorsi delle risorse

5. **Service Provider**
   - I service provider devono essere in `Modules/[ModuleName]/app/Providers`
   - Ereditare da `XotBaseServiceProvider` per i moduli
   - Non duplicare la registrazione dei componenti già registrati
   - Utilizzare i trait e le interfacce fornite dai service provider base

6. **Componenti UI**
   - Utilizzare sempre i componenti Blade di Filament quando disponibili
   - Non creare componenti personalizzati se esiste già un equivalente Filament
   - Seguire le convenzioni di naming e stile di Filament
   - Utilizzare i componenti Filament per:
     - Avatar
     - Badge
     - Breadcrumbs
     - Button
     - Checkbox
     - Dropdown
     - Fieldset
     - Icon button
     - Input
     - Input wrapper
     - Link
     - Loading indicator
     - Modal
     - Pagination
     - Section
     - Select
     - Tabs

## Struttura del Progetto

### Filament
- Tutte le risorse devono essere in `app/Filament/Resources`
- Utilizzare i trait e le interfacce fornite da Filament
- Seguire le convenzioni di naming di Filament
- Utilizzare i componenti Blade di Filament per l'interfaccia utente

### Folio
- Tutte le pagine devono essere in `resources/views/pages`
- Utilizzare i middleware di Folio
- Seguire le convenzioni di routing di Folio

### Localizzazione
- Utilizzare Laravel Localization per la gestione delle traduzioni
- Non implementare soluzioni personalizzate per la localizzazione
- Seguire le best practices di Laravel Localization

### Risorse Statiche
- `/public_html/images` - Immagini pubbliche
- `Modules/UI/resources/svg` - SVG dei componenti
- `Modules/UI/resources/css` - Stili dei componenti
- `Modules/UI/resources/js` - Script dei componenti

### Service Provider
- `Modules/UI/app/Providers` - Service provider del modulo UI
- `Modules/Xot/app/Providers` - Service provider base
- `app/Providers` - Service provider dell'applicazione

## Best Practices

1. **Filament**
   - Utilizzare i form builder di Filament
   - Utilizzare i table builder di Filament
   - Utilizzare i widget di Filament
   - Localizzare le risorse usando Laravel Localization
   - Utilizzare i componenti Blade di Filament per l'interfaccia utente

2. **Folio**
   - Organizzare le pagine per lingua
   - Utilizzare i componenti Blade
   - Localizzare le pagine usando Laravel Localization

3. **Localizzazione**
   - Utilizzare i file di traduzione in `resources/lang`
   - Utilizzare le funzioni helper di Laravel (`__()`, `trans()`)
   - Non hardcodare testi nelle view

4. **Risorse Statiche**
   - Utilizzare `asset()` per le risorse pubbliche
   - Utilizzare `Vite::asset()` per le risorse compilate
   - Utilizzare i componenti SVG registrati per le icone
   - Non hardcodare percorsi delle risorse

5. **Service Provider**
   - Verificare sempre i service provider esistenti prima di crearne di nuovi
   - Utilizzare l'ereditarietà per estendere le funzionalità
   - Non duplicare la registrazione dei componenti
   - Seguire le convenzioni di naming dei moduli

6. **Componenti UI**
   - Preferire i componenti Filament ai componenti personalizzati
   - Seguire le convenzioni di stile di Filament
   - Utilizzare i componenti Filament per la consistenza dell'interfaccia
   - Documentare eventuali personalizzazioni dei componenti Filament

## Esempi

### ❌ Non Fare

```php
// Non creare controller manualmente
class ExampleController extends Controller
{
    public function index()
    {
        return view('example');
    }
}

// Non aggiungere route manualmente
Route::get('/example', [ExampleController::class, 'index']);

// Non creare middleware personalizzati
class CustomMiddleware
{
    public function handle($request, Closure $next)
    {
        // ...
    }
}

// Non hardcodare percorsi delle risorse
<img src="/var/www/html/_bases/base_techplanner_fila3_mono/laravel/public/images/avatar.png">
<img src="/var/www/html/saluteora/laravel/public/images/avatar.png">

// Non duplicare la registrazione dei componenti
Blade::component('ui::components.icon', 'ui.icon');

// Non creare componenti personalizzati se esiste un equivalente Filament
<x-ui.button>Click me</x-ui.button>
```

### ✅ Fare

```php
// Utilizzare Filament per le risorse
class ExampleResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return __('example.title');
    }
}

// Utilizzare Folio per le pagine
// resources/views/pages/example.blade.php
<x-layout>
    <h1>{{ __('example.title') }}</h1>
</x-layout>

// Utilizzare i middleware di Laravel Localization
Route::middleware(['localize'])->group(function () {
    // Le route verranno gestite da Filament e Folio
});

// Utilizzare gli helper per le risorse
<img src="{{ asset('images/avatar.png') }}">
<x-filament::avatar />

// Ereditare dal service provider base
class UIServiceProvider extends XotBaseServiceProvider
{
    public function boot()
    {
        parent::boot();
        // Aggiungere solo le funzionalità specifiche
    }
}

// Utilizzare i componenti Filament
<x-filament::button>Click me</x-filament::button>
<x-filament::input />
<x-filament::dropdown />
```

## Collegamenti Correlati
- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md)
- [Componenti Blade Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)

## Gestione delle Rotte

### Frontoffice (Folio)
- Utilizzare Folio per tutte le rotte del frontoffice
- Le pagine devono essere posizionate in `Themes/One/resources/views/pages/`
- Non creare manualmente rotte in `web.php` o altri file di routing
- Utilizzare la struttura delle cartelle per definire le rotte
- Esempio:
  ```
  /pages/
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── profile/
    │   └── show.blade.php
    └── index.blade.php
  ```

### Backoffice (Filament)
- Utilizzare Filament per tutte le rotte di amministrazione
- Non creare manualmente rotte per le funzionalità di amministrazione
- Utilizzare i Resource e le Page di Filament
- Le rotte vengono generate automaticamente da Filament

### Cosa NON Fare
❌ Non creare manualmente rotte in `web.php`
❌ Non definire rotte personalizzate per funzionalità già gestite da Filament
❌ Non utilizzare controller tradizionali per il frontoffice
❌ Non mescolare approcci diversi per la stessa funzionalità

### Cosa Fare
✅ Utilizzare Folio per il frontoffice
✅ Utilizzare Filament per il backoffice
✅ Seguire la struttura delle cartelle per definire le rotte
✅ Mantenere la separazione tra frontoffice e backoffice

## Layout e Struttura

### Layout Frontoffice
- Utilizzare `x-layouts.main` per le pagine del frontoffice
- Non utilizzare i layout di Filament (`filament::layouts.*`) nel frontoffice
- I layout devono essere in `Themes/One/resources/views/components/layouts/`
- Struttura standard:
  ```
  /layouts/
    ├── main.blade.php      # Layout principale
    ├── app.blade.php       # Layout applicazione
    └── guest.blade.php     # Layout per utenti non autenticati
  ```

### Layout Backoffice
- Utilizzare i layout di Filament per il backoffice
- Non mescolare layout frontoffice e backoffice
- Seguire le convenzioni di Filament per i layout

### Cosa NON Fare
❌ Non utilizzare `filament::layouts.*` nel frontoffice
❌ Non creare layout personalizzati se non necessario
❌ Non mescolare approcci diversi per lo stesso scopo

### Cosa Fare
✅ Utilizzare `x-layouts.main` per il frontoffice
✅ Utilizzare i layout Filament per il backoffice
✅ Mantenere la separazione tra frontoffice e backoffice

## Volt e Folio

### Volt
- Utilizzare la direttiva `@volt` per i componenti Volt in Folio
- Struttura standard per i componenti Volt:
  ```blade
  @volt('component.name')
  <?php
  use function Livewire\Volt\{state, mount};

  state([
      'property' => null,
  ]);

  $action = function () {
      // Logica dell'azione
  };
  ?>

  <div>
      <!-- Template del componente -->
  </div>
  @endvolt
  ```

### Folio
- Utilizzare Folio per le pagine del frontoffice
- Struttura standard per le pagine Folio:
  ```blade
  <?php
  use function Laravel\Folio\{middleware, name};
  use function Livewire\Volt\{state, mount};

  middleware(['auth']);
  name('page.name');

  state([
      'property' => null,
  ]);
  ?>

  <x-layouts.main>
      <!-- Contenuto della pagina -->
  </x-layouts.main>
  ```

### Best Practices
- Mantenere la separazione tra logica e presentazione
- Utilizzare state per la gestione dello stato
- Documentare le azioni e gli stati
- Testare i componenti in isolamento

### Cosa NON fare
- ❌ Omettere la direttiva `@volt` nei componenti Volt
- ❌ Mischiare logica di business con la presentazione
- ❌ Duplicare stati tra componenti
- ❌ Ignorare la gestione degli errori

### Cosa fare
- ✅ Utilizzare la direttiva `@volt` per i componenti Volt
- ✅ Seguire la struttura standard per i componenti
- ✅ Gestire correttamente gli stati e le azioni
- ✅ Implementare la gestione degli errori
- ✅ Testare i componenti

## Traduzioni

### Struttura
- Utilizzare il namespace `auth.` per le traduzioni relative all'autenticazione
- Organizzare le traduzioni per contesto:
  ```
  auth/
    ├── login/
    │   ├── title
    │   ├── email
    │   ├── password
    │   ├── remember_me
    │   ├── forgot_password
    │   ├── submit
    │   └── link
    ├── register/
    │   ├── title
    │   ├── email
    │   ├── password
    │   ├── confirm_password
    │   ├── submit
    │   └── link
    ├── logout/
    │   ├── title
    │   ├── confirm_message
    │   ├── success_title
    │   ├── success_message
    │   ├── error_title
    │   ├── error_message
    │   ├── confirm_button
    │   ├── cancel_button
    │   ├── back_to_home
    │   └── try_again
    └── user_dropdown/
        ├── manage_account
        ├── profile
        ├── settings
        └── logout
  ```

### Best Practices
- Utilizzare chiavi di traduzione semantiche
- Mantenere la coerenza nella struttura
- Documentare le traduzioni
- Testare in tutte le lingue supportate

### Cosa NON fare
- ❌ Hardcodare testi nelle view
- ❌ Duplicare chiavi di traduzione
- ❌ Utilizzare chiavi non semantiche
- ❌ Ignorare il supporto multilingua

### Cosa fare
- ✅ Utilizzare il namespace appropriato
- ✅ Seguire la struttura standard
- ✅ Documentare le traduzioni
- ✅ Testare in tutte le lingue

## Gestione dell'Autenticazione

### Componenti
- Utilizzare `x-blocks.navigation.user-dropdown` per utenti autenticati
- Utilizzare `x-blocks.navigation.login-buttons` per utenti non autenticati
- Struttura standard:
  ```blade
  @auth
      <x-blocks.navigation.user-dropdown :user="auth()->user()" />
  @else
      <x-blocks.navigation.login-buttons />
  @endauth
  ```

### Best Practices
- Mantenere la separazione tra stati autenticati e non
- Utilizzare i componenti appropriati
- Gestire correttamente le traduzioni
- Supportare il tema scuro

### Cosa NON fare
- ❌ Mischiare stati autenticati e non
- ❌ Duplicare logica di autenticazione
- ❌ Ignorare le traduzioni
- ❌ Ignorare il supporto per il tema scuro

### Cosa fare
- ✅ Utilizzare i componenti appropriati
- ✅ Seguire la struttura standard
- ✅ Gestire correttamente le traduzioni
- ✅ Testare in entrambi gli stati

## Regole di Navigazione

### Gestione degli Stati di Autenticazione

1. **Componenti di Navigazione**:
   - Utilizzare `@auth` e `@else` per gestire gli stati di autenticazione
   - Passare l'utente autenticato ai componenti che lo richiedono
   - Utilizzare le traduzioni per tutti i testi

2. **Struttura**:
   - Desktop: Menu principale e dropdown utente
   - Mobile: Menu responsive con opzioni di autenticazione
   - Mantenere la coerenza tra desktop e mobile

3. **Traduzioni**:
   - Utilizzare le chiavi di traduzione standard:
     - `auth.user_dropdown.*` per il dropdown utente
     - `auth.login.*` per il login
     - `auth.register.*` per la registrazione

4. **Cosa NON Fare**:
   - Non mescolare componenti Filament con componenti front office
   - Non hardcodare testi
   - Non duplicare la logica di autenticazione

5. **Cosa Fare**:
   - Utilizzare i componenti responsive appropriati
   - Mantenere la coerenza con il tema dark/light
   - Gestire correttamente il logout con CSRF
# Regole Architetturali

## Principi Fondamentali

1. **No Controller Manuali**
   - Non creare controller manualmente
   - Utilizzare Filament per la gestione del backend
   - Utilizzare Folio per la gestione delle pagine

2. **No Route Manuali**
   - Non modificare `web.php`
   - Non aggiungere route manualmente
   - Lasciare che Filament e Folio gestiscano le rotte

3. **No Middleware Personalizzati**
   - Utilizzare i middleware forniti da Filament e Folio
   - Non creare middleware personalizzati per la gestione delle rotte
   - Utilizzare i middleware di localizzazione forniti da Laravel Localization

4. **Risorse Statiche**
   - Le immagini pubbliche devono essere in `/public_html/images`
   - I file SVG dei componenti devono essere in `Modules/UI/resources/svg`
   - Non utilizzare percorsi hardcoded per le risorse statiche
   - Utilizzare sempre gli helper di Laravel per i percorsi delle risorse

5. **Service Provider**
   - I service provider devono essere in `Modules/[ModuleName]/app/Providers`
   - Ereditare da `XotBaseServiceProvider` per i moduli
   - Non duplicare la registrazione dei componenti già registrati
   - Utilizzare i trait e le interfacce fornite dai service provider base

6. **Componenti UI**
   - Utilizzare sempre i componenti Blade di Filament quando disponibili
   - Non creare componenti personalizzati se esiste già un equivalente Filament
   - Seguire le convenzioni di naming e stile di Filament
   - Utilizzare i componenti Filament per:
     - Avatar
     - Badge
     - Breadcrumbs
     - Button
     - Checkbox
     - Dropdown
     - Fieldset
     - Icon button
     - Input
     - Input wrapper
     - Link
     - Loading indicator
     - Modal
     - Pagination
     - Section
     - Select
     - Tabs

## Struttura del Progetto

### Filament
- Tutte le risorse devono essere in `app/Filament/Resources`
- Utilizzare i trait e le interfacce fornite da Filament
- Seguire le convenzioni di naming di Filament
- Utilizzare i componenti Blade di Filament per l'interfaccia utente

### Folio
- Tutte le pagine devono essere in `resources/views/pages`
- Utilizzare i middleware di Folio
- Seguire le convenzioni di routing di Folio

### Localizzazione
- Utilizzare Laravel Localization per la gestione delle traduzioni
- Non implementare soluzioni personalizzate per la localizzazione
- Seguire le best practices di Laravel Localization

### Risorse Statiche
- `/public_html/images` - Immagini pubbliche
- `Modules/UI/resources/svg` - SVG dei componenti
- `Modules/UI/resources/css` - Stili dei componenti
- `Modules/UI/resources/js` - Script dei componenti

### Service Provider
- `Modules/UI/app/Providers` - Service provider del modulo UI
- `Modules/Xot/app/Providers` - Service provider base
- `app/Providers` - Service provider dell'applicazione

## Best Practices

1. **Filament**
   - Utilizzare i form builder di Filament
   - Utilizzare i table builder di Filament
   - Utilizzare i widget di Filament
   - Localizzare le risorse usando Laravel Localization
   - Utilizzare i componenti Blade di Filament per l'interfaccia utente

2. **Folio**
   - Organizzare le pagine per lingua
   - Utilizzare i componenti Blade
   - Localizzare le pagine usando Laravel Localization

3. **Localizzazione**
   - Utilizzare i file di traduzione in `resources/lang`
   - Utilizzare le funzioni helper di Laravel (`__()`, `trans()`)
   - Non hardcodare testi nelle view

4. **Risorse Statiche**
   - Utilizzare `asset()` per le risorse pubbliche
   - Utilizzare `Vite::asset()` per le risorse compilate
   - Utilizzare i componenti SVG registrati per le icone
   - Non hardcodare percorsi delle risorse

5. **Service Provider**
   - Verificare sempre i service provider esistenti prima di crearne di nuovi
   - Utilizzare l'ereditarietà per estendere le funzionalità
   - Non duplicare la registrazione dei componenti
   - Seguire le convenzioni di naming dei moduli

6. **Componenti UI**
   - Preferire i componenti Filament ai componenti personalizzati
   - Seguire le convenzioni di stile di Filament
   - Utilizzare i componenti Filament per la consistenza dell'interfaccia
   - Documentare eventuali personalizzazioni dei componenti Filament

## Esempi

### ❌ Non Fare

```php
// Non creare controller manualmente
class ExampleController extends Controller
{
    public function index()
    {
        return view('example');
    }
}

// Non aggiungere route manualmente
Route::get('/example', [ExampleController::class, 'index']);

// Non creare middleware personalizzati
class CustomMiddleware
{
    public function handle($request, Closure $next)
    {
        // ...
    }
}

// Non hardcodare percorsi delle risorse
<img src="/var/www/html/<nome progetto>/laravel/public/images/avatar.png">

// Non duplicare la registrazione dei componenti
Blade::component('ui::components.icon', 'ui.icon');

// Non creare componenti personalizzati se esiste un equivalente Filament
<x-ui.button>Click me</x-ui.button>
```

### ✅ Fare

```php
// Utilizzare Filament per le risorse
class ExampleResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return __('example.title');
    }
}

// Utilizzare Folio per le pagine
// resources/views/pages/example.blade.php
<x-layout>
    <h1>{{ __('example.title') }}</h1>
</x-layout>

// Utilizzare i middleware di Laravel Localization
Route::middleware(['localize'])->group(function () {
    // Le route verranno gestite da Filament e Folio
});

// Utilizzare gli helper per le risorse
<img src="{{ asset('images/avatar.png') }}">
<x-filament::avatar />

// Ereditare dal service provider base
class UIServiceProvider extends XotBaseServiceProvider
{
    public function boot()
    {
        parent::boot();
        // Aggiungere solo le funzionalità specifiche
    }
}

// Utilizzare i componenti Filament
<x-filament::button>Click me</x-filament::button>
<x-filament::input />
<x-filament::dropdown />
```

## Collegamenti Correlati
- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md)
- [Componenti Blade Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)

## Gestione delle Rotte

### Frontoffice (Folio)
- Utilizzare Folio per tutte le rotte del frontoffice
- Le pagine devono essere posizionate in `Themes/One/resources/views/pages/`
- Non creare manualmente rotte in `web.php` o altri file di routing
- Utilizzare la struttura delle cartelle per definire le rotte
- Esempio:
  ```
  /pages/
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── profile/
    │   └── show.blade.php
    └── index.blade.php
  ```

### Backoffice (Filament)
- Utilizzare Filament per tutte le rotte di amministrazione
- Non creare manualmente rotte per le funzionalità di amministrazione
- Utilizzare i Resource e le Page di Filament
- Le rotte vengono generate automaticamente da Filament

### Cosa NON Fare
❌ Non creare manualmente rotte in `web.php`
❌ Non definire rotte personalizzate per funzionalità già gestite da Filament
❌ Non utilizzare controller tradizionali per il frontoffice
❌ Non mescolare approcci diversi per la stessa funzionalità

### Cosa Fare
✅ Utilizzare Folio per il frontoffice
✅ Utilizzare Filament per il backoffice
✅ Seguire la struttura delle cartelle per definire le rotte
✅ Mantenere la separazione tra frontoffice e backoffice

## Layout e Struttura

### Layout Frontoffice
- Utilizzare `x-layouts.main` per le pagine del frontoffice
- Non utilizzare i layout di Filament (`filament::layouts.*`) nel frontoffice
- I layout devono essere in `Themes/One/resources/views/components/layouts/`
- Struttura standard:
  ```
  /layouts/
    ├── main.blade.php      # Layout principale
    ├── app.blade.php       # Layout applicazione
    └── guest.blade.php     # Layout per utenti non autenticati
  ```

### Layout Backoffice
- Utilizzare i layout di Filament per il backoffice
- Non mescolare layout frontoffice e backoffice
- Seguire le convenzioni di Filament per i layout

### Cosa NON Fare
❌ Non utilizzare `filament::layouts.*` nel frontoffice
❌ Non creare layout personalizzati se non necessario
❌ Non mescolare approcci diversi per lo stesso scopo

### Cosa Fare
✅ Utilizzare `x-layouts.main` per il frontoffice
✅ Utilizzare i layout Filament per il backoffice
✅ Mantenere la separazione tra frontoffice e backoffice

## Volt e Folio

### Volt
- Utilizzare la direttiva `@volt` per i componenti Volt in Folio
- Struttura standard per i componenti Volt:
  ```blade
  @volt('component.name')
  <?php
  use function Livewire\Volt\{state, mount};

  state([
      'property' => null,
  ]);

  $action = function () {
      // Logica dell'azione
  };
  ?>

  <div>
      <!-- Template del componente -->
  </div>
  @endvolt
  ```

### Folio
- Utilizzare Folio per le pagine del frontoffice
- Struttura standard per le pagine Folio:
  ```blade
  <?php
  use function Laravel\Folio\{middleware, name};
  use function Livewire\Volt\{state, mount};

  middleware(['auth']);
  name('page.name');

  state([
      'property' => null,
  ]);
  ?>

  <x-layouts.main>
      <!-- Contenuto della pagina -->
  </x-layouts.main>
  ```

### Best Practices
- Mantenere la separazione tra logica e presentazione
- Utilizzare state per la gestione dello stato
- Documentare le azioni e gli stati
- Testare i componenti in isolamento

### Cosa NON fare
- ❌ Omettere la direttiva `@volt` nei componenti Volt
- ❌ Mischiare logica di business con la presentazione
- ❌ Duplicare stati tra componenti
- ❌ Ignorare la gestione degli errori

### Cosa fare
- ✅ Utilizzare la direttiva `@volt` per i componenti Volt
- ✅ Seguire la struttura standard per i componenti
- ✅ Gestire correttamente gli stati e le azioni
- ✅ Implementare la gestione degli errori
- ✅ Testare i componenti

## Traduzioni

### Struttura
- Utilizzare il namespace `auth.` per le traduzioni relative all'autenticazione
- Organizzare le traduzioni per contesto:
  ```
  auth/
    ├── login/
    │   ├── title
    │   ├── email
    │   ├── password
    │   ├── remember_me
    │   ├── forgot_password
    │   ├── submit
    │   └── link
    ├── register/
    │   ├── title
    │   ├── email
    │   ├── password
    │   ├── confirm_password
    │   ├── submit
    │   └── link
    ├── logout/
    │   ├── title
    │   ├── confirm_message
    │   ├── success_title
    │   ├── success_message
    │   ├── error_title
    │   ├── error_message
    │   ├── confirm_button
    │   ├── cancel_button
    │   ├── back_to_home
    │   └── try_again
    └── user_dropdown/
        ├── manage_account
        ├── profile
        ├── settings
        └── logout
  ```

### Best Practices
- Utilizzare chiavi di traduzione semantiche
- Mantenere la coerenza nella struttura
- Documentare le traduzioni
- Testare in tutte le lingue supportate

### Cosa NON fare
- ❌ Hardcodare testi nelle view
- ❌ Duplicare chiavi di traduzione
- ❌ Utilizzare chiavi non semantiche
- ❌ Ignorare il supporto multilingua

### Cosa fare
- ✅ Utilizzare il namespace appropriato
- ✅ Seguire la struttura standard
- ✅ Documentare le traduzioni
- ✅ Testare in tutte le lingue

## Gestione dell'Autenticazione

### Componenti
- Utilizzare `x-blocks.navigation.user-dropdown` per utenti autenticati
- Utilizzare `x-blocks.navigation.login-buttons` per utenti non autenticati
- Struttura standard:
  ```blade
  @auth
      <x-blocks.navigation.user-dropdown :user="auth()->user()" />
  @else
      <x-blocks.navigation.login-buttons />
  @endauth
  ```

### Best Practices
- Mantenere la separazione tra stati autenticati e non
- Utilizzare i componenti appropriati
- Gestire correttamente le traduzioni
- Supportare il tema scuro

### Cosa NON fare
- ❌ Mischiare stati autenticati e non
- ❌ Duplicare logica di autenticazione
- ❌ Ignorare le traduzioni
- ❌ Ignorare il supporto per il tema scuro

### Cosa fare
- ✅ Utilizzare i componenti appropriati
- ✅ Seguire la struttura standard
- ✅ Gestire correttamente le traduzioni
- ✅ Testare in entrambi gli stati

## Regole di Navigazione

### Gestione degli Stati di Autenticazione

1. **Componenti di Navigazione**:
   - Utilizzare `@auth` e `@else` per gestire gli stati di autenticazione
   - Passare l'utente autenticato ai componenti che lo richiedono
   - Utilizzare le traduzioni per tutti i testi

2. **Struttura**:
   - Desktop: Menu principale e dropdown utente
   - Mobile: Menu responsive con opzioni di autenticazione
   - Mantenere la coerenza tra desktop e mobile

3. **Traduzioni**:
   - Utilizzare le chiavi di traduzione standard:
     - `auth.user_dropdown.*` per il dropdown utente
     - `auth.login.*` per il login
     - `auth.register.*` per la registrazione

4. **Cosa NON Fare**:
   - Non mescolare componenti Filament con componenti front office
   - Non hardcodare testi
   - Non duplicare la logica di autenticazione

5. **Cosa Fare**:
   - Utilizzare i componenti responsive appropriati
   - Mantenere la coerenza con il tema dark/light
   - Gestire correttamente il logout con CSRF
