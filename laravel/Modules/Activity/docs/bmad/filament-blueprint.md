---
title: "Filament Blueprint: Activity"
type: filament-blueprint
status: active
module: Activity
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, filament, blueprint, activity]
qmd: "filament blueprint activity xotbase resource widget"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
---

# Scopo

Contratto Filament del modulo **Activity**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot: mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.

## Resource / widget

- `ActivityResource`
- `SnapshotResource`
- `StoredEventResource`

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## PHPStan

Filament e test del modulo passano da `laravel/phpstan.neon` solo; ogni turn non banale riallinea verso `analyse Modules` a zero senza conferma. Memoria: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
