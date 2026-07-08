# Guida alla Localizzazione nel Framework Laraxot PTVX

## Introduzione

La localizzazione (l10n) è un aspetto fondamentale delle applicazioni modern, permettendo di offrire l'interfaccia e i contenuti in diverse lingue. Il framework Laraxot PTVX segue le convenzioni di Laravel per la gestione della localizzazione, con alcune personalizzazioni specifiche.

Questo documento fornisce una guida completa su come implementare e gestire correttamente la localizzazione nei moduli Laraxot.

## Posizione Corretta dei File di Localizzazione

### Regola Fondamentale

I file di localizzazione (file di lingua) **devono rimanere nella directory `lang` alla radice del modulo** e **NON** devono essere spostati nella directory `app`.

```
Modules/
└── NomeModulo/
    ├── lang/               ✓ CORRETTO
    │   ├── it/
    │   │   └── messages.php
    │   └── en/
    │       └── messages.php
    ├── app/                
    │   ├── Models/         ✓ CORRETTO per i Models
    │   └── ...
    └── ...
```

### Struttura Corretta dei File di Lingua

La struttura dei file di lingua deve seguire il formato standard di Laravel:

```php
// File: Modules/User/lang/it/user.php
return [
    'welcome' => 'Benvenuto',
    'profile' => [
        'title' => 'Il tuo profilo',
        'edit' => 'Modifica profilo',
    ],
    // ...
];
```

## Utilizzo della Localizzazione

### Nel Codice PHP

Per utilizzare le traduzioni nel codice PHP, utilizzare le funzioni `__()` o `trans()`:

```php
// Traduzione semplice
echo __('user::user.welcome'); // Output: Benvenuto

// Traduzione con placeholder
echo __('user::user.greeting', ['name' => 'Mario']); // Output: Ciao, Mario

// Traduzioni annidate
echo __('user::user.profile.title'); // Output: Il tuo profilo
```

Il prefisso `user::` indica il modulo da cui caricare il file di traduzione.

### Nelle Viste Blade

Nel file Blade, puoi utilizzare le stesse funzioni:

```blade
<h1>{{ __('user::user.welcome') }}</h1>

<p>{{ __('user::user.greeting', ['name' => $user->name]) }}</p>

@lang('user::user.profile.title')
```

### Pluralizzazione

Laravel offre anche supporto per la pluralizzazione:

```php
// Nel file di lingua
'apples' => '{0} Non ci sono mele|{1} C\'è una mela|[2,*] Ci sono :count mele',

// Nel codice
echo trans_choice('user::user.apples', 0); // Output: Non ci sono mele
echo trans_choice('user::user.apples', 1); // Output: C'è una mela
echo trans_choice('user::user.apples', 10, ['count' => 10]); // Output: Ci sono 10 mele
```

## Localizzazione JSON

Per stringhe più complesse o traduzioni frontend, è possibile utilizzare i file JSON:

```
Modules/
└── NomeModulo/
    ├── lang/
        ├── it.json
        └── en.json
```

Contenuto di `it.json`:
```json
{
    "Welcome to our application": "Benvenuto nella nostra applicazione",
    "Hello, :name": "Ciao, :name"
}
```

## Cambio della Lingua Corrente

Per cambiare la lingua corrente:

```php
// Cambia la lingua per la richiesta corrente
App::setLocale('it');

// Verifica la lingua corrente
$currentLocale = App::getLocale(); // Restituisce 'it'

// Verifica se la lingua corrente è quella specificata
if (App::isLocale('it')) {
    // Codice eseguito solo se la lingua è italiana
}
```

## Implementazione in Laraxot PTVX

### Middleware per il Cambio Automatico della Lingua

È consigliabile utilizzare un middleware per cambiare automaticamente la lingua in base alle preferenze dell'utente:

```php
namespace Modules\User\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Recupera la lingua dalle preferenze dell'utente autenticato
        if (auth()->check() && auth()->user()->preferred_locale) {
            App::setLocale(auth()->user()->preferred_locale);
        } 
        // Altrimenti usa la lingua dalla sessione o quella predefinita
        else if ($request->session()->has('locale')) {
            App::setLocale($request->session()->get('locale'));
        }

        return $next($request);
    }
}
```

Registrare il middleware nel file `app/Http/Kernel.php` sotto `web`:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Modules\User\app\Http\Middleware\LocaleMiddleware::class,
    ],
];
```

### Enum per le Lingue Supportate

È buona pratica utilizzare un Enum per gestire le lingue supportate:

```php
namespace Modules\Xot\app\Enums;

enum SupportedLocale: string
{
    case ITALIAN = 'it';
    case ENGLISH = 'en';
    case FRENCH = 'fr';
    
    public static function getDefault(): self
    {
        return self::ITALIAN;
    }
    
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public function getLabel(): string
    {
        return match($this) {
            self::ITALIAN => 'Italiano',
            self::ENGLISH => 'English',
            self::FRENCH => 'Français',
        };
    }
}
```

### Utilizzare i Nuovi Traduttori di Laravel 10+

Laravel 10 ha introdotto una nuova API per i traduttori. Ecco come usarla:

```php
use Illuminate\Support\Facades\Lang;

// Ottieni un'istanza del traduttore per un file specifico
$translator = Lang::get('user::user');

// Traduci una chiave
$welcome = $translator->get('welcome');

// Traduci con fallback
$greeting = $translator->get('greeting', defaultValue: 'Ciao');

// Traduci con placeholders
$personalized = $translator->get('hello_user', ['name' => 'Mario']);
```

## Utilizzo con Spatie Laravel Data

Quando utilizzi Spatie Laravel Data per DTO, puoi integrare facilmente la localizzazione:

```php
namespace Modules\Rating\app\Datas;

use Spatie\LaravelData\Data;
use Illuminate\Support\Facades\App;

class RatingData extends Data
{
    public function __construct(
        public int $score,
        public string $comment,
        public ?string $localized_label = null,
    ) {
        // Imposta automaticamente l'etichetta localizzata se non fornita
        if ($this->localized_label === null) {
            $this->localized_label = __('rating::rating.score_labels.' . $this->score);
        }
    }
    
    // Factory method con supporto per localizzazione
    public static function fromScoreWithLocale(int $score): self
    {
        return new self(
            score: $score,
            comment: '',
            localized_label: __('rating::rating.score_labels.' . $score),
        );
    }
}
```

## Best Practices

1. **Usa chiavi semantiche**: Preferisci `user.welcome` invece di `user.homepage_text_1`.
2. **Organizza le traduzioni in modo gerarchico**: Usa strutture nidificate per organizzare meglio.
3. **Non concatenare le traduzioni**: Invece di `__('user.hello') . ' ' . $name`, usa `__('user.hello_name', ['name' => $name])`.
4. **Mantieni i file di lingua separati per modulo**: Ogni modulo deve avere i propri file di lingua.
5. **Verifica sempre la presenza di tutte le traduzioni**: Utilizza strumenti come Laravel Lang Publisher per gestire le traduzioni mancanti.

## Strumenti Utili

- **Laravel Lang**: Pacchetto che fornisce traduzioni predefinite per molte lingue ([GitHub](https://github.com/Laravel-Lang/lang))
- **Laravel Translation Manager**: Interfaccia web per gestire le traduzioni ([GitHub](https://github.com/barryvdh/laravel-translation-manager))

## Risoluzione dei Problemi Comuni

### Traduzioni Mancanti

Se una traduzione non viene trovata, Laravel restituirà la chiave stessa. Verifica:

1. Il percorso del file di lingua (deve essere in `Modules/NomeModulo/lang/`)
2. La sintassi della chiave (`modulo::file.chiave`)
3. L'esistenza della chiave nel file di traduzione

### Problemi di Performance

Per migliorare le performance, considera la compilazione delle traduzioni in produzione:

```bash
php artisan lang:cache
```

Per cancellare la cache:

```bash
php artisan lang:clear
```

## Conclusione

Seguendo queste linee guida, potrai implementare un sistema di localizzazione robusto e manutenibile all'interno del framework Laraxot PTVX. Ricorda che i file di localizzazione devono rimanere nella directory `lang` alla radice del modulo, rispettando le convenzioni standard di Laravel. 