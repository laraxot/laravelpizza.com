---
title: "UX: campagna widget-only"
type: ux-design
module: User
status: approved
related:
  - ./ux-design.md
  - ./livewire-widget-prd.md
  - ./livewire-inventory.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "ux: stesso chrome, contenitore giusto user"
---

# UX: stesso chrome, contenitore giusto

Lo slice SuperAdmin (icona corona) resta in [ux-design.md](./ux-design.md). Qui gli altri pezzi visibili.

## Principio

L’operatore **non deve notare** la conversione. Stesso posto, stesso click, testi da lang. Cambia solo che un 500 Jet non può più nascondere il menu.

## Superfici

| Superficie | Oggi | Target visivo |
|------------|------|----------------|
| User menu | SuperAdmin HTTP + team HTTP | due widget, stesso ordine: team poi re (o invariato rispetto a oggi) |
| Login panel after form | `socialite.buttons` | stessi bottoni via `SocialLoginWidget` |
| Login/register/password FO | widget + HTTP morti | solo widget / tema; HTTP invisibile |
| Delete account | form password + toast IT | stesso flusso, stringhe lang, componente Filament |
| Privacy / terms | Livewire User | pagine Gdpr, non User |

## Non fare in UX

- Modal di conferma sul toggle SuperAdmin (oggi non c’è).
- Dashboard card per team/super-admin/social.
- Banner “migrazione widget”.
- Riattivare terms sull’hook login User.

## Accessibilità

Controlli chrome: componenti Filament (`icon-button`, menu). Tooltip/lang, non `title` nudo se il componente ha tooltip.
