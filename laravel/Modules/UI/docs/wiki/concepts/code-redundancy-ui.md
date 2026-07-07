---
title: "ridondanza codice — modulo UI"
module: UI
type: concept
tags: [redundancy, ui, filament, traits]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - ../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ../../../redundancy-audit-2026-05-21.md
  - ../../../redundancy-report.md
---

# Ridondanza — UI

## Scopo

Componenti Filament estesi (`XotBaseField`, layout tabella, icone), enum layout, asset SVG condivisi. UI **non** deve reimplementare `HasXotTable` — solo estendere.

## P1 — trait layout tabella

| Path | Namespace |
|------|-----------|
| `app/Traits/TableLayoutTrait.php` | `Modules\UI\Traits` |
| `app/Filament/Actions/Table/TableLayoutTrait.php` | `Modules\UI\Filament\Actions\Table` |
| `HasTableLayout.php` | trait aggiuntivo |

**Azione:** unificare in un trait canonico; l’altro delega o `@deprecated`.

## P2 — viste blade duplicate

- `stat-with-icon.blade.php` vs `statwithicon.blade.php`

**Azione:** tenere kebab-case; delete alias.

## Cosa non è ridondanza

- Componenti form in `Filament/Forms/` che estendono Xot — **corretto**; non copiare in altri moduli.

## Collegamenti

- [Filosofia](../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md)
- [Audit trasversale](../../../../Xot/docs/wiki/redundancy-audit-2026-05-26.md)
