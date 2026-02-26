# Troubleshooting: Login Component Not Found

## Regola architetturale
**I form di autenticazione (login, register, reset password) si gestiscono solo con Filament widget** (LoginWidget, RegisterWidget, ecc.). Vietato usare form HTML tradizionali (`<form method="POST" action="{{ route('login') }}">` con @csrf e input raw) nelle pagine tema. Vedere `.cursor/rules/filament-login-widget.mdc`.

**VIETATO ->label(), ->placeholder(), ->helperText():** Le traduzioni sono gestite automaticamente da LangServiceProvider tramite i file in `Modules/User/lang/`. Mai usare questi metodi nei widget auth. Vedere `.cursor/rules/no-filament-labels.mdc`.

## Errore 1: ComponentNotFoundException
Unable to find component: [user::filament.widgets.auth.login-widget] su GET /it/auth/login (Folio, Theme Two).

**Causa root (Livewire v4):** `Finder::resolveClassComponentClassName()` quando il nome contiene `::` cerca SOLO in `$this->classNamespaces` e ignora `$this->classComponents`. Quindi `Livewire::component(‘user::...’, $class)` non funziona: il componente viene registrato in `classComponents` ma non viene trovato. Livewire converte `ClassName::class` → alias `user::filament.widgets.auth.login-widget` → poi fallisce a trovarlo.

**Soluzione:** Usare `Livewire::addComponent($class)` invece di `Livewire::component($alias, $class)`. Il metodo `addComponent` usa hash deterministico (`lw<crc32>`) come nome, compatibile con `@livewire(ClassName::class)`.

```php
// ❌ SBAGLIATO — alias :: non funziona in Livewire v4
Livewire::component(‘user::filament.widgets.auth.login-widget’, LoginWidget::class);

// ✅ CORRETTO
Livewire::addComponent(LoginWidget::class);
```

**Nel Blade:** usare sempre la classe:
```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```
Non usare la stringa alias `@livewire(‘user::filament.widgets.auth.login-widget’)`.

## Errore 2: MethodNotAllowedHttpException
The POST method is not supported for route it/auth/login. Supported methods: GET, HEAD.

**Causa:** Un POST arriva all’URL della pagina login (es. form HTML tradizionale per errore, o submit prima del binding Livewire). Folio espone solo GET.

**Soluzione (Volt + Folio + Laraxot):** Non si aggiungono rotte in `web.php`. Il progetto usa Volt + Folio + Laraxot: niente rotte custom, niente controller per frontend/auth. Il form di login deve essere solo il Filament LoginWidget; il submit avviene via Livewire (wire:submit.prevent). Verificare che in pagina non ci sia un form HTML con `action="{{ route('login') }}"` e usare solo `@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)`.

## Problema Originario
**Errore:** `Livewire\Exceptions\ComponentNotFoundException: Unable to find component: [filament.auth.pages.login]`

**Contesto:**
- Laravel 12.30.1
- PHP 8.3.25
- Filament 3.x
- Livewire 3.x

## Causa Radice
Il componente Livewire della pagina di login di Filament non veniva trovato perché:

1. Cache di Filament non aggiornata dopo modifiche
2. Componenti Filament non ricompilati correttamente
3. Possibili conflitti Git non risolti nei file di traduzione

## Architettura Login

### Panel Provider Principale
Il Panel Admin principale è definito in `/app/Providers/Filament/AdminPanelProvider.php`:

```php
namespace App\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBaseMainPanelProvider;

class AdminPanelProvider extends XotBaseMainPanelProvider
{
}
```

### Registrazione Pagina Login
La pagina di login viene registrata automaticamente in `XotBaseMainPanelProvider`:

```php
if (! Module::has('Cms')) {
    $panel->login(Login::class);
}
```

Dove `Login` è:
```php
use Modules\User\Filament\Pages\Auth\Login;
```

### Pagina Login Custom
La pagina di login personalizzata si trova in:
`Modules/User/app/Filament/Pages/Auth/Login.php`

```php
namespace Modules\User\Filament\Pages\Auth;

use Filament\Pages\Concerns\HasRoutes;

class Login extends \Filament\Auth\Pages\Login
{
    use HasRoutes;

    protected static string $routePath = 'newlogin';
    protected string $view = 'filament-panels::pages.auth.login';
}
```

## Soluzione Implementata

### 1. Pulizia Cache Completa
```bash
php artisan optimize:clear
```

Questo comando pulisce:
- config cache
- cache application
- compiled files
- events
- routes
- views
- blade-icons
- filament
- laravel-event-sourcing

### 2. Rigenerazione Cache Componenti Filament
```bash
php artisan filament:cache-components
```

Questo comando ricompila e registra tutti i componenti Filament, incluse le pagine di autenticazione.

## Componenti di Login Disponibili

Nel modulo User esistono diversi componenti per la gestione del login:

### 1. Pagina Filament
- **Path:** `Modules/User/app/Filament/Pages/Auth/Login.php`
- **Uso:** Pagina di login standard di Filament
- **Route:** `/admin/login` (gestita da Filament)

### 2. Widget Filament
- **Path:** `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`
- **Uso:** Widget riutilizzabile per embedding in pagine Folio/Blade (es. `/it/auth/login`)
- **View:** `user::filament.widgets.auth.login` (definita nel widget; non usare il lookup automatico che cerca `login-widget`)

**Embedding in Blade/Volt:** usare SEMPRE la classe PHP:
```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```
NON usare `<livewire:user::filament.widgets.auth.login-widget />` né `@livewire(‘user::...’)` — in Livewire v4 la risoluzione via namespace `::` non funziona con `addComponent`/`component` standard.

La registrazione in `UserServiceProvider::registerLivewireAuthWidgets()` usa `Livewire::addComponent($class)` (hash-based) che è compatibile con `::class`.

### 3. Componente Livewire Standalone
- **Path:** `Modules/User/app/Http/Livewire/Auth/Login.php`
- **Uso:** Componente Livewire custom per pagine non-Filament
- **View:** `user::livewire.auth.login`

## Configurazione Panel

Il panel User è configurato in `Modules/User/app/Providers/Filament/AdminPanelProvider.php`:

```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'User';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Render hooks per socialite, team selector, etc.
        FilamentView::registerRenderHook('panels::auth.login.form.after', 
            static fn(): string => Blade::render("@livewire('socialite.buttons')"));

        return $panel;
    }
}
```

## Verifiche Post-Risoluzione

Dopo aver applicato la soluzione, verificare:

1. **Accesso alla pagina di login:**
   ```
   http://your-domain.com/admin/login
   ```

2. **Componenti Livewire registrati:**
   ```bash
   php artisan livewire:list | grep -i login
   ```

3. **Route Filament disponibili:**
   ```bash
   php artisan route:list | grep login
   ```

4. **Log degli errori:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Prevenzione Futuri Problemi

### 1. Dopo Merge/Pull
Ogni volta che si fa merge o pull di modifiche che coinvolgono Filament:
```bash
php artisan optimize:clear
php artisan filament:cache-components
```

### 2. Dopo Modifiche ai Panel Provider
Se si modificano i Panel Provider:
```bash
php artisan filament:cache-components
php artisan config:clear
```

### 3. Development Workflow
Durante lo sviluppo, considera di disabilitare la cache:
```bash
php artisan config:cache  # Solo in produzione
```

## File Correlati

### ServiceProvider
- `app/Providers/Filament/AdminPanelProvider.php` - Panel principale
- `Modules/User/Providers/UserServiceProvider.php` - ServiceProvider modulo User; registra i widget auth Livewire (`registerLivewireAuthWidgets()`) per risolvere gli alias `user::filament.widgets.auth.*`
- `Modules/User/Providers/Filament/AdminPanelProvider.php` - Panel User
- `Modules/Xot/Providers/Filament/XotBaseMainPanelProvider.php` - Base panel provider

### Pagine e Widget
- `Modules/User/app/Filament/Pages/Auth/Login.php`
- `Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`
- `Modules/User/app/Http/Livewire/Auth/Login.php`

### Views
- `Modules/User/resources/views/pages/auth/login.blade.php`
- `Modules/User/resources/views/filament/widgets/auth/login.blade.php`

### Traduzioni
- `Modules/Xot/lang/it/set_default_tenant_for_urls.php`
- `Modules/Xot/lang/it/main_dashboard.php`

## Collegamenti

- [Modulo User README](../readme.md)
- [Modulo Xot Service Provider Architecture](../xot/docs/service-provider-architecture.md)
- [Filament Filters and Widgets](./filament-filters-and-widgets.md)
- [Theme Two – Pagina login](../../Themes/Two/docs/auth-login-page.md)

## Risolto Da
Autore: Sistema di documentazione automatica

