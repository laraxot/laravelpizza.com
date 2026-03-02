# Composer Packages Study - Deep Analysis

Studio completo basato su `composer show` (2026-03-02).

- Pacchetti totali: `312`
- Diretti: `62`
- Transitivi: `250`

## Runtime Critical Set

- `laravel/framework`: `v12.52.0`
- `laravel/folio`: `v1.1.12`
- `livewire/livewire`: `v4.1.4`
- `livewire/volt`: `v1.10.2`
- `filament/filament`: `v5.2.1`
- `nwidart/laravel-modules`: `v12.0.4`
- `calebporzio/sushi`: `v2.5.3`
- `mcamara/laravel-localization`: `v2.3.0`
- `spatie/laravel-data`: `4.19.1`
- `spatie/laravel-queueable-action`: `2.16.2`

## Family Coverage

| Family | Packages | Direct |
|---|---:|---:|
| `application-support` | 181 | 26 |
| `cloud-aws` | 2 | 1 |
| `filament-admin` | 12 | 3 |
| `laravel-core` | 15 | 6 |
| `livewire-frontend` | 3 | 3 |
| `modular-architecture` | 1 | 1 |
| `oauth-social` | 2 | 1 |
| `quality` | 6 | 1 |
| `spatie-ecosystem` | 28 | 16 |
| `symfony-foundation` | 49 | 3 |
| `testing` | 13 | 1 |

## Direct Dependencies (studied one-by-one)

| Package | Version | Family | Operational Note |
|---|---|---|---|
| `aaronfrancis/fast-paginate` | `v2.0.0` | `application-support` | module/theme capability or infrastructure support |
| `aws/aws-sdk-php` | `3.369.37` | `cloud-aws` | module/theme capability or infrastructure support |
| `calebporzio/sushi` | `v2.5.3` | `application-support` | critical runtime |
| `coolsam/panel-modules` | `dev-dev` | `application-support` | module/theme capability or infrastructure support |
| `doctrine/dbal` | `4.4.1` | `application-support` | module/theme capability or infrastructure support |
| `fidum/laravel-eloquent-morph-to-one` | `2.5.0` | `application-support` | module/theme capability or infrastructure support |
| `filament/filament` | `v5.2.1` | `filament-admin` | critical runtime |
| `filament/spatie-laravel-media-library-plugin` | `v5.2.1` | `filament-admin` | module/theme capability or infrastructure support |
| `filament/upgrade` | `v5.2.1` | `filament-admin` | module/theme capability or infrastructure support |
| `flowframe/laravel-trend` | `v0.4.0` | `application-support` | module/theme capability or infrastructure support |
| `guzzlehttp/guzzle` | `7.10.0` | `application-support` | module/theme capability or infrastructure support |
| `intervention/image` | `3.11.6` | `application-support` | module/theme capability or infrastructure support |
| `irazasyed/telegram-bot-sdk` | `v3.15.0` | `application-support` | module/theme capability or infrastructure support |
| `jenssegers/agent` | `v2.6.4` | `application-support` | module/theme capability or infrastructure support |
| `lara-zeus/spatie-translatable` | `2.0.0` | `application-support` | module/theme capability or infrastructure support |
| `laravel-notification-channels/telegram` | `6.0.0` | `application-support` | module/theme capability or infrastructure support |
| `laravel/folio` | `v1.1.12` | `laravel-core` | critical runtime |
| `laravel/framework` | `v12.52.0` | `laravel-core` | critical runtime |
| `laravel/passport` | `v13.4.4` | `laravel-core` | module/theme capability or infrastructure support |
| `laravel/pennant` | `v1.19.0` | `laravel-core` | module/theme capability or infrastructure support |
| `laravel/pulse` | `v1.5.0` | `laravel-core` | module/theme capability or infrastructure support |
| `laravel/tinker` | `v2.11.1` | `laravel-core` | module/theme capability or infrastructure support |
| `livewire/flux` | `v2.12.1` | `livewire-frontend` | module/theme capability or infrastructure support |
| `livewire/livewire` | `v4.1.4` | `livewire-frontend` | critical runtime |
| `livewire/volt` | `v1.10.2` | `livewire-frontend` | critical runtime |
| `maatwebsite/excel` | `3.1.67` | `application-support` | module/theme capability or infrastructure support |
| `mcamara/laravel-localization` | `v2.3.0` | `application-support` | critical runtime |
| `nunomaduro/phpinsights` | `v2.13.3` | `quality` | module/theme capability or infrastructure support |
| `nwidart/laravel-modules` | `v12.0.4` | `modular-architecture` | critical runtime |
| `owenvoke/blade-fontawesome` | `v2.9.1` | `application-support` | module/theme capability or infrastructure support |
| `pbmedia/laravel-ffmpeg` | `8.7.1` | `application-support` | module/theme capability or infrastructure support |
| `pestphp/pest-plugin-laravel` | `v4.0.0` | `testing` | module/theme capability or infrastructure support |
| `phpdocumentor/type-resolver` | `1.12.0` | `application-support` | module/theme capability or infrastructure support |
| `predis/predis` | `v3.4.0` | `application-support` | module/theme capability or infrastructure support |
| `rinvex/countries` | `v9.1.0` | `application-support` | module/theme capability or infrastructure support |
| `saade/filament-fullcalendar` | `v4.0.0-beta3` | `application-support` | module/theme capability or infrastructure support |
| `socialiteproviders/auth0` | `4.2.0` | `oauth-social` | module/theme capability or infrastructure support |
| `spatie/cpu-load-health-check` | `1.0.5` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-activitylog` | `4.11.0` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-data` | `4.19.1` | `spatie-ecosystem` | critical runtime |
| `spatie/laravel-database-mail-templates` | `3.7.1` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-event-sourcing` | `7.13.0` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-health` | `1.37.0` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-model-states` | `2.12.1` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-model-status` | `1.19.0` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-package-tools` | `1.92.7` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-permission` | `7.2.0` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-personal-data-export` | `4.3.1` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-queueable-action` | `2.16.2` | `spatie-ecosystem` | critical runtime |
| `spatie/laravel-responsecache` | `7.7.2` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-schemaless-attributes` | `2.5.2` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-sluggable` | `3.7.5` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spatie/laravel-tags` | `4.10.2` | `spatie-ecosystem` | module/theme capability or infrastructure support |
| `spipu/html2pdf` | `v5.3.3` | `application-support` | module/theme capability or infrastructure support |
| `statikbe/laravel-cookie-consent` | `1.11.4` | `application-support` | module/theme capability or infrastructure support |
| `staudenmeir/eloquent-has-many-deep` | `v1.21.2` | `application-support` | module/theme capability or infrastructure support |
| `staudenmeir/laravel-adjacency-list` | `v1.25.2` | `application-support` | module/theme capability or infrastructure support |
| `symfony/dom-crawler` | `v7.4.4` | `symfony-foundation` | module/theme capability or infrastructure support |
| `symfony/http-client` | `v7.4.5` | `symfony-foundation` | module/theme capability or infrastructure support |
| `symfony/postmark-mailer` | `v7.4.4` | `symfony-foundation` | module/theme capability or infrastructure support |
| `thecodingmachine/safe` | `v3.4.0` | `application-support` | module/theme capability or infrastructure support |
| `tightenco/parental` | `v1.5.0` | `application-support` | module/theme capability or infrastructure support |

## Installed Packages Inventory

Tutti i pacchetti (diretti + transitivi) sono stati analizzati e catalogati nel file inventario:

- [composer-packages-full-inventory.md](composer-packages-full-inventory.md)

## Declared But Not Installed (module risk)

- `Notify`:
  - `kreait/laravel-firebase` (`^7.0`)
  - `laravel-notification-channels/fcm` (`^6.0`)
- `User`:
  - `socialiteproviders/microsoft` (`^4.8`)

## Chaos Monkey Implications

1. Blast radius alto su cluster `laravel/folio + livewire + filament` per regressioni UI/rendering.
2. Per frontoffice CMS il set più sensibile è `folio + sushi + localization + pub_theme namespace`.
3. Mismatch pacchetti dichiarati/non installati deve essere risolto prima di test incidenti su quei moduli.
