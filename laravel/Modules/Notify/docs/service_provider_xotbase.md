# XotBaseServiceProvider: Analisi, Regole e Best Practice

## 1. Cos'è XotBaseServiceProvider
`XotBaseServiceProvider` è la classe base **obbligatoria** per tutti i Service Provider principali dei moduli Laraxot. Estende `Illuminate\Support\ServiceProvider` e implementa:
- Registrazione automatica di views, traduzioni, config, Livewire, Blade components, comandi
- Caricamento delle migrazioni
- Naming e namespace standardizzati

## 2. Proprietà e Metodi Fondamentali

```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    public string $name = '';
    public string $nameLower = '';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    // ...

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
        $this->registerLivewireComponents();
        $this->registerBladeComponents();
        $this->registerCommands();
    }

    public function register(): void
    {
        $this->nameLower = Str::lower($this->name);
        $this->module_ns = collect(explode('\\', $this->module_ns))->slice(0, -1)->implode('\\');
        $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
        $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
        $this->registerConfig();
        $this->registerBladeIcons();
    }
    // ...
}
```

## 3. Come si Estende Correttamente

- **Visibilità proprietà**: le proprietà pubbliche della base vanno sempre dichiarate `public` anche nell'estensione.
- **Naming**: imposta sempre `$name` e `$nameLower`.
- **Mai duplicare logica di boot**: NON ridefinire `boot()` per caricare views, config, migrazioni ecc. (già gestito dalla base!).
- **Aggiungi solo override specifici**: Se servono binding custom, aggiungili solo in `register()` dopo il `parent::register()`.

## 4. Errori Comuni da NON Fare Mai Più

- ❌ **Ridefinire la logica di boot** (es: caricare views/config/migrations manualmente): già gestito dalla base!
- ❌ **Dimenticare di chiamare `parent::register()`**: rischi di non registrare provider essenziali.
- ❌ **Dichiarare proprietà con visibilità diversa dalla base**: causa errori di access level.
- ❌ **Duplicare codice di registrazione di risorse**.

## 5. Esempio Corretto

```php
class NotifyServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Notify';

    public function register(): void
    {
        parent::register();
        $this->app->singleton('notify.manager', function ($app) {
            return new \Modules\Notify\Services\NotificationManager();
        });
    }

    public function provides(): array
    {
        return [
            'notify.manager',
        ];
    }
}
```

## 6. Checklist per PR e Revisione
- [x] La proprietà `$name` è `public`
- [x] Il metodo `register()` chiama sempre `parent::register()`
- [x] Non ci sono override inutili di `boot()`
- [x] Nessuna duplicazione di logica di registrazione risorse
- [x] Solo binding custom in `register()`

## 7. Riferimenti
- [XotBaseServiceProvider](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php)
- [Best Practices](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/project_docs/service-provider-best-practices.md)

---

> **Questa documentazione è stata aggiornata dopo un errore di override errato del metodo boot. Seguire SEMPRE queste regole per evitare errori futuri.**
