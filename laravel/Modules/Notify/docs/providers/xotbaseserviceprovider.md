# XotBaseServiceProvider

## Panoramica
Classe astratta base per tutti i Service Provider dei moduli. Fornisce l'implementazione standard delle funzionalità comuni.

## Proprietà

```php
public string $name = '';              // Nome del modulo (DEVE essere public)
public string $nameLower = '';         // Nome del modulo in minuscolo
protected string $module_dir = __DIR__; // Directory del modulo
protected string $module_ns = __NAMESPACE__; // Namespace del modulo
```

## Ciclo di Vita

### register()
```php
public function register(): void
{
    // Converte il nome in minuscolo
    $this->nameLower = Str::lower($this->name);
    
    // Estrae il namespace del modulo
    $this->module_ns = collect(explode('\\', $this->module_ns))
        ->slice(0, -1)
        ->implode('\\');
    
    // Registra i provider standard
    $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
    $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
    
    // Registra le icone Blade
    $this->registerBladeIcons();
}
```

### boot()
```php
public function boot(): void
{
    // Registra traduzioni, config, views
    $this->registerTranslations();
    $this->registerConfig();
    $this->registerViews();
    
    // Carica migrazioni
    $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
    
    // Registra componenti
    $this->registerLivewireComponents();
    $this->registerBladeComponents();
    $this->registerCommands();
}
```

## Funzionalità Standard

### 1. Views
- Registrate automaticamente da `resources/views`
- Namespace basato sul nome del modulo
- Supporto per override tramite publish

### 2. Traduzioni
- Caricate da `lang`
- Supporto JSON e array
- Fallback configurabile

### 3. Configurazioni
- File config pubblicati automaticamente
- Merge con config esistenti
- Supporto per override

### 4. Componenti
- Blade components registrati automaticamente
- Livewire components registrati automaticamente
- Supporto per namespace personalizzati

## Best Practices

1. **Estensione**
   ```php
   class MyServiceProvider extends XotBaseServiceProvider
   {
       public string $name = 'MyModule';
       protected string $module_dir = __DIR__;
       protected string $module_ns = __NAMESPACE__;
   }
   ```

2. **Override Selettivo**
   - Estendere solo i metodi necessari
   - Chiamare sempre parent::method()
   - Mantenere la struttura standard

3. **Configurazione**
   - Usare i path standard
   - Rispettare le convenzioni di naming
   - Documentare le personalizzazioni

## Troubleshooting

### Problemi Comuni

1. **Componenti non registrati**
   - Verifica namespace
   - Controlla struttura directory
   - Debug registrazione

2. **Traduzioni mancanti**
   - Verifica path
   - Controlla formato file
   - Debug caricamento

3. **Config non pubblicati**
   - Verifica tag
   - Controlla permessi
   - Debug publish

## Collegamenti
- [Service Provider](../service-provider.md)
- [Module Structure](../module-structure.md)
- [Configuration](../configuration.md)

## Vedi Anche
- [Laravel Service Providers](https://laravel.com/docs/providers)
- [Laravel Package Development](https://laravel.com/docs/packages)
### Versione HEAD

- [Laravel Module Development](https://nwidart.com/laravel-modules/v6/introduction) 

### Versione Incoming

- [Laravel Module Development](https://nwidart.com/laravel-modules/v6/introduction) 
## Collegamenti tra versioni di xotbaseserviceprovider.md
* [xotbaseserviceprovider.md](../../../Xot/docs/providers/xotbaseserviceprovider.md)


---

