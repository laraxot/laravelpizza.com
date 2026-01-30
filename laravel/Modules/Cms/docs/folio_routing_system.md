# Sistema di Routing e Localizzazione con Laravel Folio

## Collegamenti correlati
- [Indice documentazione CMS](/laravel/Modules/Cms/project_docs/index.md)
- [Gestione Route Folio](/laravel/Modules/Cms/project_docs/gestione-route-folio.md)
- [Frontoffice Flow](/laravel/Modules/Cms/project_docs/frontoffice-flow.md)
- [Volt Folio Structure](/laravel/Modules/Cms/project_docs/volt_folio_structure.md)
- [Documentazione generale progetto](/project_docs/README.md)

## Panoramica

Il modulo CMS utilizza **Laravel Folio** per gestire le rotte del frontoffice, incluse le rotte localizzate come `/it`, `/en`, ecc. Questo sistema permette di creare pagine dinamiche basate su file di view senza dover definire esplicitamente le rotte.

## Architettura

### Laravel Folio
- **Folio** gestisce automaticamente le rotte basandosi sulla struttura dei file nelle directory `pages`
- Le rotte sono registrate automaticamente nel `CmsServiceProvider`
- Supporta la localizzazione attraverso parametri URI dinamici

### Localizzazione
- Utilizza **Laravel Localization** per gestire le lingue supportate
- Le rotte sono prefissate con il codice lingua (es. `/it`, `/en`)
- La lingua corrente viene determinata automaticamente da `LaravelLocalization::setLocale()`

## Configurazione nel CmsServiceProvider

```php
public function registerFolio(): void
{
    // Ottiene i middleware di base dal TenantService
    $middleware = TenantService::config('middleware');
    $base_middleware = Arr::get($middleware, 'base', []);
    
    // Aggiunge middleware per la localizzazione
    $base_middleware[] = \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class;
    $base_middleware[] = \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class;

    // Ottiene il percorso del tema corrente
    $theme_path = XotData::make()->getPubThemeViewPath('pages');
    
    // Ottiene la lingua corrente
    $currentLocale = LaravelLocalization::setLocale() ?? app()->getLocale();

    // Registra le pagine del tema con prefisso lingua
    Folio::path($theme_path)
        ->uri($currentLocale)
        ->middleware(['*' => $base_middleware]);

    // Registra le pagine dei moduli
    $modules = Module::collections();
    foreach ($modules as $module) {
        $path = $module->getPath().'/resources/views/pages';
        if (File::exists($path)) {
            Folio::path($path)
                ->uri($currentLocale)
                ->middleware(['*' => $base_middleware]);
        }
    }

    // Monta i percorsi per Volt
    Volt::mount($paths);
}
```

## Struttura delle Directory

### Tema Principale
```
Themes/{theme_name}/resources/views/pages/
├── index.blade.php          # Homepage (/)
├── about.blade.php          # Pagina about (/about)
├── contact/
│   └── index.blade.php      # Pagina contatti (/contact)
└── ...
```

### Moduli
```
Modules/{ModuleName}/resources/views/pages/
├── index.blade.php          # Pagina principale del modulo
├── {feature}/
│   └── index.blade.php      # Pagina specifica della feature
└── ...
```

## Middleware di Localizzazione

### Middleware Attivi
- `LocaleSessionRedirect`: Reindirizza basandosi sulla lingua salvata in sessione
- `LaravelLocalizationRedirectFilter`: Filtra e gestisce i redirect per la localizzazione

### Middleware Commentati (non utilizzati)
- `LaravelLocalizationRoutes`: Gestione avanzata delle rotte localizzate
- `LocaleCookieRedirect`: Redirect basato sui cookie
- `LaravelLocalizationViewPath`: Percorsi delle view localizzate

## Configurazione delle Lingue

### File di Configurazione
Le lingue supportate sono definite in `config/laravellocalization.php`:

```php
'supportedLocales' => [
    'it' => [
        'name' => 'Italiano',
        'script' => 'Latn',
        'native' => 'Italiano',
        'regional' => 'it_IT',
    ],
    'en' => [
        'name' => 'English',
        'script' => 'Latn', 
        'native' => 'English',
        'regional' => 'en_GB',
    ],
],
```

### Verifica della Configurazione
Il `CmsServiceProvider` verifica che:
1. La configurazione di localizzazione sia caricata
2. La lingua predefinita sia supportata
3. La lingua sia impostata correttamente

## Esempi di Rotte Generate

### Rotte del Tema
- `/it` → `Themes/{theme}/resources/views/pages/index.blade.php`
- `/it/about` → `Themes/{theme}/resources/views/pages/about.blade.php`
- `/it/contact` → `Themes/{theme}/resources/views/pages/contact/index.blade.php`

### Rotte dei Moduli
- `/it/blog` → `Modules/Blog/resources/views/pages/index.blade.php`
- `/it/predict` → `Modules/Predict/resources/views/pages/index.blade.php`

## Debugging e Troubleshooting

### Comandi Utili
```bash
# Verificare le rotte registrate
php artisan route:list

# Verificare i moduli attivi
php artisan module:list

# Pulire le cache
php artisan config:clear
php artisan view:clear
```

### Log e Monitoraggio
- I middleware di localizzazione loggano le operazioni di redirect
- Verificare i log in `storage/logs/laravel.log` per problemi di routing
- Utilizzare `php artisan telescope` per monitorare le richieste (se installato)

## Best Practices

### Organizzazione dei File
1. Mantenere una struttura coerente nelle directory `pages`
2. Utilizzare sottodirectory per raggruppare pagine correlate
3. Nominare i file in modo descrittivo e coerente

### Performance
1. Utilizzare il caching delle view quando possibile
2. Ottimizzare i middleware per ridurre l'overhead
3. Monitorare le performance delle rotte più utilizzate

### Sicurezza
1. Validare sempre i parametri di localizzazione
2. Utilizzare middleware di sicurezza appropriati
3. Proteggere le pagine sensibili con autenticazione

## Integrazione con Altri Sistemi

### XotComposer
Il sistema di routing Folio si integra con il `XotComposer` per:
- Fornire dati di contesto alle view
- Gestire i metodi dinamici per i temi
- Integrare con il sistema di traduzione

### Sistema di Traduzione
- Le chiavi di traduzione seguono la struttura gerarchica
- I file di traduzione sono organizzati per modulo
- Il sistema supporta il fallback automatico alle lingue predefinite

## Migrazione e Aggiornamenti

### Aggiornamento di Laravel Folio
1. Verificare la compatibilità con la versione di Laravel
2. Testare le rotte esistenti dopo l'aggiornamento
3. Aggiornare la documentazione se necessario

### Aggiunta di Nuove Lingue
1. Aggiungere la configurazione in `laravellocalization.php`
2. Creare i file di traduzione corrispondenti
3. Testare le rotte con la nuova lingua 
