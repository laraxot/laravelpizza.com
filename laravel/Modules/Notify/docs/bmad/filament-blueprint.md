---
title: "Filament Blueprint: Notify"
type: filament-blueprint
status: active
module: Notify
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, filament, blueprint, notify]
qmd: "filament blueprint notify xotbase resource widget"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./decision-log.md
---

# Scopo

Contratto Filament del modulo **Notify**: BO per template, log e prove di invio
multi-canale; la consegna resta nelle Queueable Actions/canali, non nei form hooks.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot: mai classi Filament dirette (`MailTemplateResource` → `LangBaseResource` dove serve i18n).
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: nessun chrome Notify di default; i moduli owner invocano Actions, non Resource del tema.

## Resource / widget

- `NotificationResource`
- `MailTemplateResource`
- `NotificationLogResource`

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## PHPStan

Gate unico `laravel/phpstan.neon`: `cd laravel && ./vendor/bin/phpstan analyse Modules` a zero senza conferma. Fix alla sorgente; mai ignore/baseline.

Track: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md) · `graphify-out/`: [graphify-out-gitignore](../../../Xot/docs/bmad/graphify-out-gitignore.md)

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
- Decision log: [decision-log.md](./decision-log.md)
