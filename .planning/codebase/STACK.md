# Technology Stack

## 1) Core platform
- **Primary language: PHP** (`^8.2`) from root app Composer requirements in `laravel/composer.json`.
- **Secondary languages: JavaScript (ESM), Blade, CSS** from frontend/tooling config in `laravel/package.json`, `laravel/vite.config.js`, and Blade-heavy module structure under `laravel/Modules/*/resources/views`.
- **Runtime baseline in CI:** PHP `8.3`/`8.4` and Node `20` in `.github/workflows/coverage.yml`, `.github/workflows/pest-coverage.yml`, `.github/workflows/ci.yml`.

## 2) Application framework and architecture
- **Framework:** Laravel `^12.0` in `laravel/composer.json`.
- **Entry/bootstrap:** Laravel 11/12 style bootstrap in `laravel/bootstrap/app.php`.
- **Custom application class:** overridden public path to `../public_html` in `laravel/app/Application.php`.
- **Modular monolith:** `nwidart/laravel-modules` in `laravel/composer.json`, module merge in `laravel/composer.json` (`extra.merge-plugin.include`), module system config in `laravel/config/modules.php`, enabled modules in `laravel/modules_statuses.json`.
- **Active modules:** `Activity`, `Cms`, `Gdpr`, `Geo`, `Job`, `Lang`, `Media`, `Meetup`, `Notify`, `Seo`, `Tenant`, `UI`, `User`, `Xot` from `laravel/modules_statuses.json`.

## 3) UI, frontend, and delivery
- **Admin/UI framework:** `filament/filament` `^5.0` in `laravel/composer.json` and repeated in module composers (for example `laravel/Modules/Xot/composer.json`, `laravel/Modules/Notify/composer.json`).
- **Reactive UI:** `livewire/livewire` `^4.0` and `livewire/volt` in `laravel/composer.json`; `livewire/flux` in `laravel/Modules/Xot/composer.json`.
- **Routing style additions:** `laravel/folio` in `laravel/composer.json` and `laravel/Modules/Xot/composer.json`.
- **Frontend toolchain:** Vite + Tailwind v4 + Axios in `laravel/package.json`.
- **Vite config:** multi-entry build (`resources/*` + `Themes/Meetup/resources/*`) in `laravel/vite.config.js`.
- **Output path:** Vite build output `public/build` in `laravel/vite.config.js`.

## 4) Data, persistence, and state
- **Default DB driver:** configurable, default `mysql` in `laravel/config/database.php`; `.env.example` defaults to `sqlite` (`DB_CONNECTION=sqlite`) in `laravel/.env.example`.
- **Supported DBs:** sqlite, mysql, mariadb, pgsql, sqlsrv in `laravel/config/database.php`.
- **Custom extra DB connection (`user`)** in `laravel/config/database.php`.
- **Tenant-driven DB wiring:** module-level connection cloning/override logic in `laravel/Modules/Tenant/app/Providers/TenantServiceProvider.php`.
- **Redis support:** configured in `laravel/config/database.php`.
- **Cache default:** `database` store in `laravel/config/cache.php`.
- **Queue default:** `database` in `laravel/config/queue.php`.
- **Session default in example env:** `database` in `laravel/.env.example`.

## 5) Dependency profile (practical highlights)

### Root app (`laravel/composer.json`)
- `laravel/framework`, `filament/filament`, `livewire/livewire`, `livewire/volt`, `laravel/folio`, `laravel/passport`, `nwidart/laravel-modules`, `spatie/laravel-data`, `phpoffice/phpspreadsheet`.

### Key module dependencies
- **Activity/Eventing:** `spatie/laravel-activitylog`, `spatie/laravel-event-sourcing` in `laravel/Modules/Activity/composer.json`.
- **Localization:** `mcamara/laravel-localization`, `spatie/laravel-sluggable`, `rinvex/countries` in `laravel/Modules/Lang/composer.json`.
- **Media:** `pbmedia/laravel-ffmpeg`, `intervention/image` in `laravel/Modules/Media/composer.json`.
- **Notifications:** AWS SDK, Telegram SDK/channels, Postmark mailer template stack in `laravel/Modules/Notify/composer.json`.
- **Auth/User:** `laravel/passport`, `socialiteproviders/auth0` in `laravel/Modules/User/composer.json`.
- **Xot foundation:** Spatie ecosystem + Redis + Pulse + Pennant + Excel in `laravel/Modules/Xot/composer.json`.

## 6) Auth and authorization stack
- **Session auth guard (`web`)** in `laravel/config/auth.php`.
- **User model provider:** `Modules\User\Models\User` in `laravel/config/auth.php`.
- **OAuth2 server:** Passport root config in `laravel/config/passport.php` and module-level Passport orchestration in `laravel/Modules/User/app/Providers/PassportServiceProvider.php`.
- **Social login foundation:** Socialite provider registration in `laravel/Modules/User/app/Providers/SocialiteServiceProvider.php` and social routes in `laravel/Modules/User/routes/socialite.php`.

## 7) Testing and quality toolchain
- **Test framework:** Pest setup in `laravel/tests/Pest.php`.
- **Base test case:** `laravel/tests/TestCase.php` extends module base test case.
- **Static analysis:** PHPStan level 10 in `laravel/phpstan.neon`; CI phpstan job in `.github/workflows/ci.yml`.
- **Formatting:** Pint in `.github/workflows/ci.yml` and dev requirements in `laravel/Modules/Xot/composer.json`.
- **Coverage workflows:** dedicated Pest coverage pipelines in `.github/workflows/coverage.yml` and `.github/workflows/pest-coverage.yml`.

## 8) Build/deploy/runtime configuration signals
- **Composer scripts for local bootstrap/dev/test** in `laravel/composer.json` (`setup`, `dev`, `test`).
- **Sail script present** in `laravel/sail`; Docker runtime variants exist under `laravel/docker/8.0` ... `laravel/docker/8.5`.
- **No top-level docker-compose file found** under `laravel/docker` (only Dockerfiles and helper scripts).

## 9) Practical stack summary
- Laravel 12 modular monolith with Filament 5 + Livewire 4/Volt.
- PHP-first backend with strong Spatie package footprint.
- Vite + Tailwind v4 frontend pipeline.
- Multi-database capable with tenant-aware DB reconfiguration.
- OAuth2 + Social login infrastructure integrated in `User` module.
- Notification subsystem is broad (email, telegram, sms, whatsapp, push) but partly environment/config dependent.
