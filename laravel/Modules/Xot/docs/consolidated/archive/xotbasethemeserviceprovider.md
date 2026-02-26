# XotBaseThemeServiceProvider

## Descrizione

`XotBaseThemeServiceProvider` è la classe base per tutti i ServiceProvider dei temi. Fornisce funzionalità comuni per la registrazione di viste, traduzioni e componenti Blade.

## Proprietà

```php
public string $name = '';         // Nome del tema (es. 'One', 'Two')
public string $nameLower = '';    // Nome del tema in minuscolo (es. 'one', 'two')
protected string $module_dir = __DIR__;  // Directory del provider
protected string $module_ns = __NAMESPACE__; // Namespace del provider
```

## Metodi

### boot()

```php
public function boot(): void
{
    $this->loadViewsFrom($this->module_dir.'/../resources/views', $this->nameLower);
    $this->loadTranslationsFrom($this->module_dir.'/../resources/lang', $this->nameLower);
    $this->loadJsonTranslationsFrom($this->module_dir.'/../resources/lang');
    $this->registerBladeComponents();
}
```

Questo metodo:
1. Carica le viste del tema
2. Carica le traduzioni del tema
3. Carica le traduzioni JSON
4. Registra i componenti Blade

### register()

```php
public function register(): void
{
    $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
    $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
}
```

Questo metodo:
1. Registra il RouteServiceProvider del tema
2. Registra l'EventServiceProvider del tema

### registerBladeComponents()

```php
protected function registerBladeComponents(): void
{
    $componentNamespace = $this->module_ns.'\View\Components';
    \Illuminate\Support\Facades\Blade::componentNamespace($componentNamespace, $this->nameLower);

    app(\Modules\Xot\Actions\Blade\RegisterBladeComponentsAction::class)
        ->execute(
            $this->module_dir.'/../View/Components',
            $this->module_ns
        );
}
```

Questo metodo:
1. Registra il namespace dei componenti Blade
2. Registra automaticamente tutti i componenti nella directory `View/Components`

## Struttura Directory

```
ThemeName/
├── app/
│   └── Providers/
│       ├── ThemeServiceProvider.php
│       ├── RouteServiceProvider.php
│       └── EventServiceProvider.php
├── resources/
│   ├── views/
│   │   └── components/
│   │       └── button.blade.php
│   └── lang/
│       ├── en/
│       │   └── theme.php
│       └── it/
│           └── theme.php
└── View/
    └── Components/
        └── Button.php
```

## Esempio di Utilizzo

```php
<?php

declare(strict_types=1);

namespace Themes\MyTheme\Providers;

use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'MyTheme';
    public string $nameLower = 'mytheme';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Aggiungi qui solo logica specifica del tema
    }
}
```

## Best Practices

1. **Estensione**
   - Estendere sempre `XotBaseThemeServiceProvider`
   - Non estendere direttamente `ServiceProvider`

2. **Proprietà**
   - Definire sempre tutte le proprietà richieste
   - Usare nomi coerenti per il tema

3. **Boot**
   - Chiamare sempre `parent::boot()`
   - Aggiungere solo logica specifica del tema

4. **Componenti**
   - Seguire la struttura directory standard
   - Usare nomi descrittivi per i componenti
   - Mantenere i componenti piccoli e riutilizzabili

## Troubleshooting

### Viste Non Trovate
- Verificare che le viste siano nella directory corretta (`resources/views/`)
- Verificare che il nome del tema sia corretto in `$nameLower`

### Traduzioni Non Funzionanti
- Verificare che i file di traduzione siano nella directory corretta (`resources/lang/`)
- Verificare che le chiavi di traduzione siano corrette

### Componenti Non Registrati
- Verificare che i componenti siano nella directory corretta (`View/Components/`)
- Verificare che i nomi dei file seguano le convenzioni
- Verificare che i namespace siano corretti

## Link Utili
- [service-provider-best-practices.md](service-provider-best-practices.md)
- [blade-component-registration.md](blade-component-registration.md)
- [theme-development.md](theme-development.md) 