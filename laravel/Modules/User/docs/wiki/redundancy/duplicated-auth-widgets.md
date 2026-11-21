---
title: "Widget auth duplicati (LoginWidget / LogoutWidget)"
type: redundancy
owner: Modules/User
severity: high
created: 2026-05-22
issues:
related:
  - "./duplicated-profile-form.md"
  - "./duplicated-ratings-relation-manager.md"
  - "./duplicated-users-relation-manager.md"
  - "./oauth-dual-resource-trees.md"
---

# LoginWidget e LogoutWidget duplicati

## Problema

Due path per lo stesso widget nel modulo User:

| Widget | Path A | Path B |
|--------|--------|--------|
| Login | `app/Filament/Widgets/LoginWidget.php` | `app/Filament/Widgets/Auth/LoginWidget.php` |
| Logout | `app/Filament/Widgets/LogoutWidget.php` | `app/Filament/Widgets/Auth/LogoutWidget.php` |

`RegisterWidget` compare anche in **Gdpr** (`Modules/Gdpr/.../Auth/RegisterWidget.php`) — dominio GDPR vs User da chiarire.

## Impatto

- Discovery Filament / autoload può registrare **due widget** con intento uguale.
- Fix auth (Filament v5, traduzioni) va applicato in doppio.

## Fix suggerito

1. Canonico sotto `app/Filament/Widgets/Auth/`.
2. Root `LoginWidget.php` / `LogoutWidget.php` → stub che estende o alias verso Auth, poi rimuovere.
3. Gdpr: estendere widget User o trait condiviso, non copia piena.

## Tracker

Issue [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).
