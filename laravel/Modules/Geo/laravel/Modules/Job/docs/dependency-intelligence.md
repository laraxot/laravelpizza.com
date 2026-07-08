# Dependency Intelligence - Module Job

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- Nessun pacchetto mancante nel lock corrente.

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

- [Composer packages study](../../../../docs/architecture/composer-packages-study.md)
- [Composer packages full inventory](../../../../docs/architecture/composer-packages-full-inventory.md)
