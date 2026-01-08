# Service Provider in il progetto

Il service provider è responsabile della registrazione e configurazione del tema. Ogni tema deve avere il proprio service provider.

## Struttura del Service Provider

Il service provider è organizzato in:

```
app/Providers/
└── ThemeServiceProvider.php
```

## Service Provider del Tema

### ThemeServiceProvider.php
```php
<?php

namespace Themes\One\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registra i servizi del tema
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registra il tema con Filament
        FilamentAsset::register([
            'name' => 'one',
            'path' => 'themes/one',
        ]);

        // Carica gli assets del tema
        $this->loadAssets();

        // Registra le viste del tema
        $this->loadViews();

        // Registra le configurazioni del tema
        $this->loadConfigurations();
    }

    /**
     * Carica gli assets del tema.
     */
    protected function loadAssets(): void
    {
        // Carica CSS
        $this->publishes([
            __DIR__.'/../../assets/css' => public_path('themes/one/css'),
            __DIR__.'/../../assets/js' => public_path('themes/one/js'),
            __DIR__.'/../../assets/images' => public_path('themes/one/images'),
            __DIR__.'/../../assets/fonts' => public_path('themes/one/fonts'),
        ], 'one-assets');

        // Carica Vite
        $this->publishes([
            __DIR__.'/../../vite.config.js' => base_path('vite.config.js'),
        ], 'one-vite');
    }

    /**
     * Carica le viste del tema.
     */
    protected function loadViews(): void
    {
        // Carica le viste
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'one');

        // Pubblica le viste
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/one'),
        ], 'one-views');
    }

    /**
     * Carica le configurazioni del tema.
     */
    protected function loadConfigurations(): void
    {
        // Carica le configurazioni
        $this->mergeConfigFrom(
            __DIR__.'/../../config/theme.php', 'theme'
        );

        // Pubblica le configurazioni
        $this->publishes([
            __DIR__.'/../../config/theme.php' => config_path('theme.php'),
            __DIR__.'/../../config/components/blocks.php' => config_path('components/blocks.php'),
            __DIR__.'/../../config/components/forms.php' => config_path('components/forms.php'),
            __DIR__.'/../../config/components/ui.php' => config_path('components/ui.php'),
        ], 'one-config');
    }
}
```

## Registrazione del Service Provider

Il service provider deve essere registrato in:

1. `config/app.php`:
```php
'providers' => [
    // ...
    Themes\One\Providers\ThemeServiceProvider::class,
],
```

2. `composer.json`:
```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Themes\\One\\Providers\\ThemeServiceProvider"
            ]
        }
    }
}
```

## Best Practices

1. **Organizzazione**: Mantieni una struttura pulita e organizzata
2. **Documentazione**: Documenta tutte le funzionalità
3. **Validazione**: Valida i dati di configurazione
4. **Manutenibilità**: Mantieni il codice pulito e documentato
5. **Consistenza**: Mantieni uno stile coerente
6. **Sicurezza**: Proteggi le informazioni sensibili
7. **Performance**: Ottimizza il caricamento delle risorse
8. **Versioning**: Gestisci correttamente le versioni 