# Service Provider nel Framework PTVX

## Panoramica

I Service Provider sono il cuore del sistema di registrazione e configurazione dei moduli nel framework PTVX. Ogni modulo ha un Service Provider principale che estende `XotBaseServiceProvider` per ereditare funzionalità comuni e garantire coerenza nell'intero sistema.

## Struttura Gerarchica

### XotBaseServiceProvider (Classe Astratta)
Classe base che fornisce funzionalità comuni a tutti i service provider:

```php
abstract class XotBaseServiceProvider extends ServiceProvider
{
    public string $name = '';
    public string $nameLower = '';
    
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
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
        $this->registerBladeIcons();
    }
}
```

Funzionalità principali:
- Registrazione automatica di views, traduzioni e configurazioni
- Caricamento delle migrations
- Registrazione dei componenti Livewire e Blade
- Configurazione delle icone Blade

### Service Provider del Modulo
Ogni modulo ha un service provider specifico che estende `XotBaseServiceProvider`:

```php
class UserServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'User';
    
    public function boot(): void
    {
        parent::boot();
        $this->registerAuthenticationProviders();
        $this->registerEventListener();
        $this->registerPasswordRules();
        $this->registerPulse();
        $this->registerMailsNotification();
    }
    
    public function register(): void
    {
        parent::register();
        $this->registerTeamModelBindings();
    }
}
```

## Panel Provider

### XotBasePanelProvider (Classe Astratta)
Gestisce la configurazione dei pannelli Filament:

```php
abstract class XotBasePanelProvider extends PanelProvider
{
    protected string $module;
    protected bool $topNavigation = false;
    protected bool $globalSearch = false;
    protected bool $navigation = true;
    
    public function panel(Panel $panel): Panel
    {
        $moduleNamespace = $this->getModuleNamespace();
        $moduleLow = Str::lower($this->module);
        
        $panel = $panel
            ->default($default)
            ->passwordReset()
            ->sidebarFullyCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->topNavigation($this->topNavigation)
            ->globalSearch($this->globalSearch)
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->navigation($this->navigation)
            ->id($moduleLow.'::admin')
            ->path($moduleLow.'/admin')
            ->discoverResources(
                in: base_path('Modules/'.$this->module.'/app/Filament/Resources'),
                for: sprintf('%s\\Filament\\Resources', $moduleNamespace),
            )
            ->discoverPages(
                in: base_path('Modules/'.$this->module.'/app/Filament/Pages'),
                for: sprintf('%s\\Filament\\Pages', $moduleNamespace),
            )
            ->discoverWidgets(
                in: base_path('Modules/'.$this->module.'/app/Filament/Widgets'),
                for: sprintf('%s\\Filament\\Widgets', $moduleNamespace),
            )
            ->discoverClusters(
                in: base_path('Modules/'.$this->module.'/app/Filament/Clusters'),
                for: sprintf('%s\\Filament\\Clusters', $moduleNamespace),
            );
            
        return $panel;
    }
}
```

### AdminPanelProvider del Modulo
Configurazione specifica per il pannello admin di ogni modulo:

```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'User';
    
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        // Registrazione di hook di rendering personalizzati
        FilamentView::registerRenderHook('panels::auth.login.form.after', static fn (): string => Blade::render(
            "@livewire('socialite.buttons')",
        ));
        
        return $panel;
    }
}
```

## Convenzioni e Best Practices

### Naming Convention
- Service Provider principale: `{ModuleName}ServiceProvider`
- Panel Provider: `AdminPanelProvider`
- Posizionamento: `Modules/{ModuleName}/app/Providers/`

### Registrazione Automatica
- I service provider vengono automaticamente registrati dal framework
- Nessuna registrazione manuale richiesta nei file di configurazione
- Sistema di auto-discovery per componenti Filament

### Estensibilità
- Tutti i service provider estendono classi astratte per garantire coerenza
- Metodi hook per estensioni personalizzate
- Possibilità di override selettivo delle funzionalità

## Funzionalità Chiave

### Registrazione Componenti
1. **Views**: Caricamento automatico delle views del modulo
2. **Traduzioni**: Sistema multilingua integrato
3. **Configurazioni**: Caricamento delle configurazioni specifiche del modulo
4. **Migrations**: Caricamento automatico delle migrations
5. **Componenti Livewire**: Registrazione automatica dei componenti
6. **Componenti Blade**: Registrazione di componenti anonimi e con namespace

### Integrazione Filament
1. **Discovery automatico**: Resources, Pages, Widgets e Clusters
2. **Configurazione pannello**: Impostazioni comuni per tutti i moduli
3. **Hook di rendering**: Personalizzazione dell'interfaccia utente
4. **Middleware**: Configurazione dei middleware di sicurezza

### Sicurezza e Autenticazione
1. **Provider di autenticazione**: Integrazione con Laravel Passport
2. **Regole password**: Configurazione centralizzata delle regole di sicurezza
3. **Notifiche email**: Sistema personalizzato per reset password e verifica email
4. **Pulse**: Monitoraggio e autorizzazioni per il pannello di amministrazione

## Esempio Completo: Modulo User

### UserServiceProvider
```php
class UserServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'User';
    
    public function boot(): void
    {
        parent::boot();
        $this->registerAuthenticationProviders();
        $this->registerEventListener();
        $this->registerPasswordRules();
        $this->registerPulse();
        $this->registerMailsNotification();
    }
    
    protected function registerAuthenticationProviders(): void
    {
        $this->registerPassport();
        $this->registerSocialite();
    }
    
    private function registerPassport(): void
    {
        if (method_exists(Passport::class, 'routes')) {
            Passport::routes();
        }
        
        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
```

### AdminPanelProvider
```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'User';
    
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        // Integrazione Socialite
        FilamentView::registerRenderHook('panels::auth.login.form.after', static fn (): string => Blade::render(
            "@livewire('socialite.buttons')",
        ));
        
        // Cambio team
        FilamentView::registerRenderHook('panels::user-menu.before', static fn (): string => Blade::render(
            "@livewire('team.change')",
        ));
        
        return $panel;
    }
}
```

## Conclusione

Il sistema dei Service Provider nel framework PTVX rappresenta un approccio sofisticato e modulare alla configurazione dell'applicazione. Attraverso l'ereditarietà, l'auto-discovery e le convenzioni intelligenti, il framework garantisce coerenza, manutenibilità ed estensibilità mentre riduce al minimo la configurazione manuale richiesta dagli sviluppatori.