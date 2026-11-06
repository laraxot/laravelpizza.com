---
title: "UX: SuperAdmin user menu"
type: ux-design
module: User
status: approved
related:
  - ./prd.md
  - ./architecture.md
  - ./tech-spec.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "ux design: emblema hero nel user menu user"
---

# UX design: emblema hero nel user menu

## Scopo

Un controllo **silenzioso** accanto al menu account Filament. Non un form, non una pagina, non un banner.

## Posizione

Hook `USER_MENU_BEFORE`. A sinistra del menu utente, distinto dal team switcher.

## Stati visivi

| Stato profilo | Metafora | File SVG | Icona Blade Icons | Colore Filament | Tooltip (lang) |
|---------------|----------|----------|-------------------|-----------------|----------------|
| `super-admin` | identità svelata | `superman.svg` | `user-superman` | `warning` | attivo |
| `negate-super-admin` | identità nascosta | `clark-kent.svg` | `user-clark-kent` | `danger` | negato |
| nessuno dei due |: |: | nessun bottone |: |: |

Ruolo elevato visibile = eroe (cappa + ciuffo). Ruolo negato = travestimento da reporter (occhiali + cravatta). Non è lo scudo registrato: outline originale, `stroke="currentColor"` sul root.

`XotBaseServiceProvider::registerBladeIcons()` registra `resources/svg/` con prefisso `user`. Filament 5: `x-filament::icon-button icon="user-superman"`. I file `superadmin.svg`, `negate-superadmin.svg`, `user-super-admin.svg` restano in cartella come archivio: non si cancellano, non si usano nel bottone.

Vista widget: `user::filament.widgets.profile.super-admin` (convenzione `GetViewByClassAction`, nessun pin `$view`).

Marcatore di test: `data-super-admin-state="active"|"negated"`. `label` e `tooltip` dalla lang.

## Interazione

1. Click sull’icona.
2. Ruolo invertito lato server.
3. Redirect 303 sulla stessa URL.
4. Nessun modal.

## Accessibilità

`x-filament::icon-button` con `label` + `tooltip` dalla lang. Due glifi distinti + colore.

## Fuori UX di questo slice

Layout login, team switcher, avatar dropdown.
