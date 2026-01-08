# Sistema di Routing con Laravel Folio

## Introduzione

Questo documento descrive l'implementazione del sistema di routing basato su Laravel Folio nel progetto, con particolare attenzione all'integrazione con il sistema di localizzazione.

## Architettura del Sistema

Laravel Folio è un sistema di routing basato su file che permette di definire le rotte direttamente attraverso la struttura delle cartelle e dei file, senza la necessità di definire esplicitamente le rotte in un file `routes.php`.

### Struttura delle Cartelle

```
Themes/
  ├── ThemeName/
      ├── resources/
          ├── views/
              ├── pages/
                  ├── index.blade.php          # Rotta: /
                  ├── about.blade.php          # Rotta: /about
                  ├── pages/
                      ├── [slug].blade.php     # Rotta: /pages/{slug}
```

### Integrazione con la Localizzazione

Per supportare URL localizzati (es. `/it`, `/en`), è stata implementata un'integrazione tra Laravel Folio e il sistema di localizzazione. Questa integrazione è gestita nel `CmsServiceProvider` attraverso il metodo `registerFolioRoutes()`.

```php
public function registerFolioRoutes(): void
{
    $xot = $this->xot;
    $theme = $xot->pub_theme;
    $path = base_path('Themes/'.$theme.'/resources/views/pages');
    
    // Verifica che la directory delle pagine esista
    if (!File::exists($path)) {
        return;
    }
    
    // Ottieni le lingue supportate
    $supportedLocales = array_keys(config('laravellocalization.supportedLocales', ['it' => [], 'en' => []]));
    $defaultLocale = config('app.locale', 'it');
    
    // Registra le rotte Folio per ogni lingua supportata
    foreach ($supportedLocales as $locale) {
        Folio::path($path)
            ->uri($locale)
            ->middleware([
                '*' => [
                    function ($request, $next) use ($locale) {
                        app()->setLocale($locale);
                        return $next($request);
                    },
                ],
            ]);
    }
    
    // Registra anche le rotte senza prefisso di lingua
    Folio::path($path)
        ->middleware([
            '*' => [
                function ($request, $next) use ($defaultLocale) {
                    app()->setLocale($defaultLocale);
                    return $next($request);
                },
            ],
        ]);
}
```

## Definizione delle Rotte

### Rotte Statiche

Le rotte statiche sono definite semplicemente creando un file Blade nella cartella `pages`:

```php
<?php // pages/about.blade.php
use function Laravel\Folio\{name};

name('about');
?>
<x-layouts.app>
    <h1>About Us</h1>
    <p>This is the about page.</p>
</x-layouts.app>
```

### Rotte Dinamiche

Le rotte dinamiche utilizzano la sintassi `[parametro].blade.php`:

```php
<?php // pages/pages/[slug].blade.php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\{withTrashed, name, render};

withTrashed();
name('page_slug.view');

render(function (View $view, string $slug) {
    $page = Page::firstWhere(['slug' => $slug]);
    return $view->with('page', $page);
});
?>
<x-layouts.app>
    @if($page)
        <h1>{{ $page->title }}</h1>
        <x-page side="content" :slug="$page->slug" />
    @else
        <h1>Pagina non trovata</h1>
    @endif
</x-layouts.app>
```

## Middleware e Funzioni Helper

Laravel Folio fornisce diverse funzioni helper per configurare le rotte:

- `name()`: Assegna un nome alla rotta
- `middleware()`: Applica middleware alla rotta
- `render()`: Definisce una funzione di rendering personalizzata
- `withTrashed()`: Include modelli soft-deleted nelle query

Esempio di utilizzo:

```php
<?php
use function Laravel\Folio\{middleware, name, render};

name('dashboard');
middleware(['auth', 'verified']);

render(function ($view) {
    return $view->with('stats', [
        'users' => 100,
        'posts' => 500,
    ]);
});
?>
```

## Generazione di URL

Per generare URL per le rotte definite con Folio, utilizzare la funzione `route()` con il nome della rotta:

```php
<a href="{{ route('page_slug.view', ['slug' => 'about']) }}">About</a>
```

Per le rotte localizzate, includere il parametro della lingua:

```php
<a href="{{ route('page_slug.view', ['lang' => app()->getLocale(), 'slug' => 'about']) }}">About</a>
```

## Best Practices

1. **Organizzazione delle Rotte**: Organizzare le rotte in cartelle logiche per mantenere una struttura chiara
2. **Nomi delle Rotte**: Assegnare nomi significativi alle rotte per facilitare la generazione degli URL
3. **Middleware**: Utilizzare middleware per proteggere le rotte che richiedono autenticazione
4. **Localizzazione**: Utilizzare il sistema di localizzazione integrato per supportare URL multilingua

## Risoluzione dei Problemi

### Rotte Non Trovate

Se una rotta non viene trovata, verificare:

1. Che il file Blade esista nella posizione corretta
2. Che il nome del file segua la convenzione corretta
3. Che la registrazione delle rotte in `CmsServiceProvider` sia corretta

### Problemi di Localizzazione

Se le rotte localizzate non funzionano correttamente:

1. Verificare che la lingua sia presente in `config/laravellocalization.php`
2. Controllare che il middleware di localizzazione sia applicato correttamente
3. Assicurarsi che la lingua predefinita sia impostata correttamente in `config/app.php`

## Riferimenti

- [Documentazione Laravel Folio](https://laravel.com/docs/folio)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Gestione delle Rotte Localizzate](../localizzazione/gestione-rotte-localizzate.md)