# Structure

## 1. Repository layout (top-level)
- `laravel/`: main Laravel application (runtime code).
- `public_html/`: actual web root with HTTP entrypoint (`public_html/index.php`).
- `docs/`: project-level documentation and operational notes.
- `.planning/codebase/`: generated codebase mapping docs (this file, architecture, conventions).
- `bashscripts/`: automation/utilities.

## 2. Laravel app layout (`laravel/`)
- `laravel/bootstrap/`: app bootstrap (`app.php`, `providers.php`).
- `laravel/config/`: framework and environment/tenant-aware config overlays.
- `laravel/routes/`: root app routes (`web.php`, `console.php`, `ai.php`).
- `laravel/app/`: base app layer (minimal in this repo; most business logic is modular).
- `laravel/Modules/`: domain modules (core organization unit).
- `laravel/Themes/`: frontend themes (public presentation layer).
- `laravel/database/`: root migrations/factories/seeders.
- `laravel/resources/`: root assets/views.
- `laravel/tests/`: root test suite.

## 3. Module layout pattern (`laravel/Modules/<Module>/`)
Observed across modules like `Cms`, `User`, `Xot`, `Geo`, `Tenant`.

### Core module files
- `module.json`: module metadata/providers/dependencies (example: `laravel/Modules/User/module.json`).
- `composer.json`: module package/autoload metadata (example: `laravel/Modules/Cms/composer.json`).
- `routes/web.php`, `routes/api.php`: module routing contract.

### Common code locations
- `app/Providers/`: module service/event/route providers.
- `app/Actions/`: application/domain actions.
- `app/Models/`: Eloquent models.
- `app/Services/`: service-layer orchestrators (when present).
- `app/Filament/`: Filament resources/pages/widgets/clusters/fields.
- `app/Http/`: controllers, middleware, Livewire/Volt adapters.
- `app/Datas/`: typed data objects.
- `app/Enums/`, `app/Contracts/`, `app/Traits/`: typed domain abstractions.

### Module resources
- `config/`: module config.
- `database/migrations`, `database/factories`, `database/seeders`.
- `lang/`: module translations.
- `resources/views`, `resources/svg`, `resources/assets`.
- `tests/Feature`, `tests/Unit` (and module-specific extra suites in some modules).
- `docs/`: module-local architecture/decisions/runbooks.

## 4. Theme layout pattern (`laravel/Themes/<Theme>/`)
Example: `laravel/Themes/Meetup`.

- `app/Providers/ThemeServiceProvider.php`: theme provider.
- `resources/views/pages/`: Folio page files (example: `laravel/Themes/Meetup/resources/views/pages/index.blade.php`).
- `resources/views/components/`: Blade components/layouts.
- `resources/css`, `resources/js`: theme assets.
- `public/assets`: built/copied assets.
- `lang/`: theme translations.
- `docs/`: theme-specific docs.

## 5. Key locations by concern

### Boot and runtime
- HTTP bootstrap: `public_html/index.php`.
- Console bootstrap: `laravel/artisan`.
- App bootstrap: `laravel/bootstrap/app.php`.
- Base provider list: `laravel/bootstrap/providers.php`.

### Module system
- Module config: `laravel/config/modules.php`.
- Enabled modules: `laravel/modules_statuses.json`.
- Module manifests: `laravel/Modules/*/module.json`.

### Shared architecture kernel
- Shared base providers: `laravel/Modules/Xot/app/Providers/*`.
- Shared panel providers: `laravel/Modules/Xot/app/Providers/Filament/*`.
- Shared runtime data/config object: `laravel/Modules/Xot/app/Datas/XotData.php`.

### Tenant/theme switching
- Tenant service facade: `laravel/Modules/Tenant/app/Services/TenantService.php`.
- Theme namespace wiring: `laravel/Modules/Cms/app/Providers/CmsServiceProvider.php`.
- Folio/Volt mounting: `laravel/Modules/Cms/app/Providers/FolioVoltServiceProvider.php`.

## 6. Naming conventions (observed)

### Namespaces and class naming
- Modules use PSR-4 style `Modules\<Module>\...` (example: `Modules\User\Providers\UserServiceProvider` in `laravel/Modules/User/app/Providers/UserServiceProvider.php`).
- Themes use `Themes\<Theme>\...` (example: `Themes\Meetup\Providers\ThemeServiceProvider` in `laravel/Themes/Meetup/app/Providers/ThemeServiceProvider.php`).
- Providers typically end in `ServiceProvider`, `RouteServiceProvider`, `EventServiceProvider`.

### Folder naming
- Major code folders are PascalCase after `app/` (`Actions`, `Datas`, `Filament`, `Models`, `Providers`).
- Route/config/resource directories are lowercase (`routes`, `config`, `resources`, `database`, `tests`).

### Feature naming patterns
- Action classes usually follow `<Verb><Subject>Action` and expose `execute(...)` (example: `laravel/Modules/Xot/app/Actions/Module/GetModulePathByGeneratorAction.php`).
- Data classes usually end with `Data` (examples: `laravel/Modules/Xot/app/Datas/XotData.php`, `laravel/Modules/Cms/app/Datas/BlockData.php`).
- Filament panel providers are consistently named `AdminPanelProvider` under `app/Providers/Filament`.

## 7. Practical placement rules (where new code should go)
- New shared cross-module abstractions: `laravel/Modules/Xot/app/...`.
- New domain feature: create/extend `laravel/Modules/<Domain>/...` and register provider(s) in `module.json`.
- New admin UI: `laravel/Modules/<Domain>/app/Filament/Resources|Pages|Widgets`.
- New public page/theme UI: `laravel/Themes/<Theme>/resources/views/pages` (+ components under `resources/views/components`).
- Tenant-aware configuration behavior: implement in `laravel/Modules/Tenant/app/Actions/...` and expose through `TenantService`.

## 8. Structure risks to keep in mind
- Some modules include legacy/noise files (`*.old`, `.up`, mixed-case duplicate folders like `database/Migrations` vs `database/migrations` in some modules); keep new additions aligned with the dominant modern pattern:
  - lowercase infra dirs (`database/migrations`, `tests/Feature`, `tests/Unit`)
  - PascalCase class files under `app/*`.
