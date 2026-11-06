---
title: "Dependency Intelligence - Module User"
type: concept
tags: [dependency, intelligence]
created: 2026-07-14
updated: 2026-07-14
qmd: "dependency-intelligence dependency intelligence - module user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Dependency Intelligence - Module User

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| `flowframe/laravel-trend` | `*` | `v0.4.0` | `application-support` |
| `jenssegers/agent` | `*` | `v2.6.4` | `application-support` |
| `laravel/passport` | `*` | `v13.4.4` | `laravel-core` |
| `socialiteproviders/auth0` | `*` | `4.2.0` | `oauth-social` |
| `socialiteproviders/microsoft` | `^4.8` | `not-installed` | `oauth-social` |
| `spatie/laravel-personal-data-export` | `*` | `4.3.1` | `spatie-ecosystem` |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- `socialiteproviders/microsoft`

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
