---
title: "Filament Blueprint — Gdpr"
type: filament-blueprint
status: active
module: Gdpr
created: 2026-10-16
updated: 2026-10-19
tags: [bmad, filament, blueprint, gdpr]
qmd: "filament blueprint gdpr xotbase resource widget"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
---

# Scopo

Contratto Filament del modulo **Gdpr**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot — mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.

## Resource / widget

- `ConsentResource`
- `TreatmentResource`
- `Filament\Widgets\Auth\RegisterWidget` — form pubblico di registrazione. Lo monta
  il tema (`components/pages/auth-register.blade.php`), non una pagina meetup del modulo User.
  I consensi si vedono solo se la spunta è visibile: il vestito Sixteen usa il checkbox nativo,
  perché Flowbite fuori da Design Comuni la disegnava bianca su bianco.
  Vedi [register-ux-audit.md](../../../../Themes/Sixteen/docs/auth/register-ux-audit.md).

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
