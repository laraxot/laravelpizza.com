# Architecture

## 1. System pattern (what this codebase is)
- Modular monolith on Laravel 12 + Livewire/Folio/Filament.
- Domain code is split into NWidart modules under `laravel/Modules/*` (enabled via `laravel/modules_statuses.json`, configured in `laravel/config/modules.php`).
- Shared kernel abstractions live in `laravel/Modules/Xot` and are extended by feature modules.
- Public frontend is theme-driven (`laravel/Themes/*`) and tenant-configurable through `xra` config (`laravel/config/local/*/xra.php`, consumed by `laravel/Modules/Xot/app/Datas/XotData.php`).

## 2. Bootstrapping and entry points

### HTTP entry
- Web server entry is `public_html/index.php` (not `laravel/public/index.php`).
- `public_html/index.php` loads `laravel/vendor/autoload.php` and boots `laravel/bootstrap/app.php`.
- `laravel/app/Application.php` overrides `publicPath()` to point to `../public_html`.

### Console entry
- CLI entry is `laravel/artisan`.
- It also boots from `laravel/bootstrap/app.php`.

### App bootstrap
- `laravel/bootstrap/app.php` configures routing to:
  - `laravel/routes/web.php`
  - `laravel/routes/console.php`
- Middleware aliases for localization are registered in `laravel/bootstrap/app.php`.
- Global providers list is in `laravel/bootstrap/providers.php` (includes `App\Providers\Filament\AdminPanelProvider`).

## 3. Layering model

### 3.1 Platform/core layer (Xot)
- Base provider abstractions:
  - `laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php`
  - `laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php`
  - `laravel/Modules/Xot/app/Providers/XotBaseThemeServiceProvider.php`
- Base admin panel abstractions:
  - `laravel/Modules/Xot/app/Providers/Filament/XotBaseMainPanelProvider.php`
  - `laravel/Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php`
- Cross-module configuration object:
  - `laravel/Modules/Xot/app/Datas/XotData.php`

### 3.2 Module layer (feature domains)
- Each module typically contains:
  - service provider (`app/Providers/*ServiceProvider.php`)
  - route provider (`app/Providers/RouteServiceProvider.php`)
  - routes (`routes/web.php`, `routes/api.php`)
  - domain/application folders (`app/Actions`, `app/Models`, `app/Services`, `app/Filament`, etc.)
- Example service providers extending the base:
  - `laravel/Modules/Cms/app/Providers/CmsServiceProvider.php`
  - `laravel/Modules/User/app/Providers/UserServiceProvider.php`
  - `laravel/Modules/Meetup/app/Providers/MeetupServiceProvider.php`

### 3.3 Theme/presentation layer
- Active theme namespace (`pub_theme`) is registered by `laravel/Modules/Cms/app/Providers/CmsServiceProvider.php`.
- Folio + Volt page mounting is centralized in `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php`.
- Theme package example: `laravel/Themes/Meetup` with provider `laravel/Themes/Meetup/app/Providers/ThemeServiceProvider.php` and views under `laravel/Themes/Meetup/resources/views`.

## 4. Provider and module wiring

### Module activation
- Global module on/off: `laravel/modules_statuses.json`.
- Per-module manifest: `laravel/Modules/<Module>/module.json`.
- Module providers are declared in each `module.json` and loaded through NWidart.

### Base provider behavior (important abstraction)
`XotBaseServiceProvider` in `laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php` standardizes:
- registration of module `RouteServiceProvider` and `EventServiceProvider`
- translation loading
- module config loading from module `config/*.php`
- module views loading
- migration loading
- Livewire/Blade component registration
- command discovery

`XotBaseRouteServiceProvider` in `laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php` standardizes:
- web route mounting from `../../routes/web.php`
- api route mounting from `../../routes/api.php` with `api` prefix

## 5. Data flow (practical)

### 5.1 Frontoffice (theme + Folio/Volt)
1. Request enters via `public_html/index.php`.
2. App bootstraps in `laravel/bootstrap/app.php`.
3. Root route in `laravel/Modules/Cms/routes/web.php` redirects `/` to locale (`/{locale}`).
4. `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php` mounts theme/module page paths with locale prefixes through Folio.
5. Theme views are resolved via `pub_theme` namespace from `laravel/Modules/Cms/app/Providers/CmsServiceProvider.php`.
6. Volt components are mounted from theme/module paths in `FolioVoltServiceProvider`.

### 5.2 API/auth flow example
1. `laravel/Modules/User/routes/api.php` maps `/api/user/login` to `LoginController`.
2. Controller `laravel/Modules/User/app/Http/Controllers/Api/LoginController.php` executes auth attempt.
3. On success, token is issued from user model (`createToken`) and standardized JSON is returned via base controller `laravel/Modules/Xot/app/Http/Controllers/XotBaseController.php`.

### 5.3 Admin panel flow (Filament)
1. App panel provider `laravel/app/Providers/Filament/AdminPanelProvider.php` extends `XotBaseMainPanelProvider`.
2. Main admin panel path is configured as `/admin` in `laravel/Modules/Xot/app/Providers/Filament/XotBaseMainPanelProvider.php`.
3. Module-specific panels extend `XotBasePanelProvider` and are exposed at `/{module}/admin` (see `id()`/`path()` in `laravel/Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php`).
4. Module resources/pages/widgets are auto-discovered from module Filament directories.

## 6. Main abstractions and extension points
- `XotBaseServiceProvider`: module lifecycle standardization.
- `XotBaseRouteServiceProvider`: module route contracts.
- `XotBasePanelProvider` / `XotBaseMainPanelProvider`: Filament panel contracts.
- `XotData`: tenant-aware runtime configuration (`main_module`, `pub_theme`, feature flags).
- `TenantService` (`laravel/Modules/Tenant/app/Services/TenantService.php`): facade that delegates tenant-specific behavior to Actions.
- `GetModulePathByGeneratorAction` (`laravel/Modules/Xot/app/Actions/Module/GetModulePathByGeneratorAction.php`): path abstraction used by base providers.

## 7. Architectural constraints observed in code
- Module naming and provider contracts depend on correct `$name` values in providers (see checks in `XotBaseServiceProvider` and `XotBaseRouteServiceProvider`).
- Theme behavior is runtime-config driven (`xra`/tenant config), not hardcoded to one module/theme (`XotData`, `CmsServiceProvider`).
- Frontend page routing is intentionally Folio/Volt-centric (`FolioVoltServiceProvider`) rather than heavy controller route files.

## 8. Quick mental model for contributors
- Put shared framework behavior in `Modules/Xot`.
- Put domain behavior in a module (`Modules/<Domain>`), registered via `module.json`.
- Put front-office rendering in theme views + Folio/Volt paths (`Themes/<Theme>/resources/views/pages`).
- Put admin UX in Filament resources/pages/widgets under module `app/Filament/*`.
