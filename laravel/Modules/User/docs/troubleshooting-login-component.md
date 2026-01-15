# Troubleshooting: Login Component Not Found

## Problema
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
- **Uso:** Widget riutilizzabile per embedding
- **View:** `pub_theme::filament.widgets.auth.login`

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
- `Modules/User/Providers/UserServiceProvider.php` - ServiceProvider modulo User
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

- [Modulo User README](../README.md)
- [Modulo Xot Service Provider Architecture](../xot/docs/service-provider-architecture.md)
- [Filament Filters and Widgets](./filament-filters-and-widgets.md)

## Risolto Da
Autore: Sistema di documentazione automatica

*Ultimo aggiornamento: Sistema di documentazione automatica*
