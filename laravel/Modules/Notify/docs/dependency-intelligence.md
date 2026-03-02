# Dependency Intelligence - Module Notify

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| `aws/aws-sdk-php` | `*` | `3.369.37` | `cloud-aws` |
| `filament/filament` | `^5.0` | `v5.2.1` | `admin-ui` |
| `illuminate/contracts` | `*` | `provided-by-laravel/framework-v12.52.0` | `laravel-core` |
| `illuminate/support` | `*` | `provided-by-laravel/framework-v12.52.0` | `laravel-core` |
| `irazasyed/telegram-bot-sdk` | `*` | `v3.15.0` | `application-support` |
| `kreait/laravel-firebase` | `^7.0` | `not-installed` | `application-support` |
| `laravel-notification-channels/fcm` | `^6.0` | `not-installed` | `application-support` |
| `laravel-notification-channels/telegram` | `*` | `6.0.0` | `application-support` |
| `phpdocumentor/type-resolver` | `*` | `1.12.0` | `application-support` |
| `spatie/laravel-database-mail-templates` | `*` | `3.7.1` | `spatie-ecosystem` |
| `symfony/http-client` | `*` | `v7.4.5` | `symfony-foundation` |
| `symfony/postmark-mailer` | `*` | `v7.4.4` | `symfony-foundation` |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- `kreait/laravel-firebase`
- `laravel-notification-channels/fcm`

## Workspace critical runtime versions

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

## Chaos monkey focus points

- Verificare breaking changes su dipendenze `admin-ui` (Filament/Livewire) prima di toccare pagine o widget.
- Verificare coerenza tra package lock e vincoli modulo dopo merge di `Modules/*/composer.json`.
- Se un modulo ha `require` vuoto, i rischi runtime arrivano soprattutto da dipendenze transitivamente fornite da Xot/app root.

## Deep Study References

- [Composer packages study](../../../../../../docs/architecture/composer-packages-study.md)
- [Composer packages full inventory](../../../../../../docs/architecture/composer-packages-full-inventory.md)
