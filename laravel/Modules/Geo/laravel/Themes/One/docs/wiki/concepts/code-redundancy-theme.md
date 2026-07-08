---
title: "ridondanza e confini — tema One"
module: One
type: concept
tags: [redundancy, theme, blade, auth]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - ../../../../Modules/Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ../../../../Modules/Xot/docs/wiki/redundancy-audit.md
  - ../../../Zero/docs/wiki/concepts/code-redundancy-theme.md
---

# Ridondanza — Theme One

## Scopo del tema

**Vestito** pubblico e admin: Blade, asset, `@livewire` verso widget del modulo **User**. Il tema non possiede business logic HR/PA.

## Politica

| OK nel tema | Vietato nel tema |
|-------------|------------------|
| Layout, CSS, partial Blade | Model, Policy, `Resource` Filament dominio |
| `@livewire(Modules\User\...\Auth\LoginWidget)` | Copia logica login in PHP tema |
| Override view path Filament | Seconda copia di `composer.json` merge root |

## P1 — parità con Zero

File quasi identici:

- `resources/views/pages/auth/login.blade.php`
- `resources/views/filament/widgets/auth/login.blade.php`

**Consiglio:** partial condiviso `Themes/shared/` (se introdotto) o documentare «One = skin A, Zero = skin B» con diff minimo esplicito.

## Perplessità

- ~~Cartella `Themes/Theme_One/` parallela a `One/` — chiarire se legacy o errore struttura.~~ — risolto 2026-05-26: rinominata in `Themes/Three/` (regola: PascalCase singolo, no prefisso `Theme_`).

## Composer

`Themes/One/composer.json` **non** è nel merge `Modules/*/composer.json` del root Laravel — autoload theme è path separato; non duplicare dipendenze già in root.

## Collegamenti

- [Zero — stesso tema concettuale](../../../Zero/docs/wiki/concepts/code-redundancy-theme.md)
- [User auth owner](../../../../Modules/User/docs/wiki/concepts/code-redundancy-user.md)
