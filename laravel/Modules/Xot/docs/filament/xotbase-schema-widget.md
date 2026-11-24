---
title: "XotBaseSchemaWidget"
type: note
status: active
tags: [docs, xot, filament, widgets, schemas]
qmd: "xotbaseschemawidget formclass schemamethod form schema"
---
# XotBaseSchemaWidget

`Modules\Xot\Filament\Widgets\XotBaseSchemaWidget` e' il widget Filament con form (Schemas v5). Il widget orchestra
(mount, submit, redirect); i campi vivono in una classe `*Form`, mai duplicati nel widget. Decisioni di fondo:
`Modules/Xot/docs/bmad/livewire-widget-decision-log.md`.

## `form(Schema $schema)`

- `formClass()` non nullo: `form()` chiama `FormClass::{schemaMethod()}()` (default `getFormSchema`), tramite un
  callable `[$formClass, $method]`; se il metodo non esiste lancia `LogicException`. Uno stesso `*Form` puo' servire
  piu' widget con sotto-schemi diversi (es. `getLoginFormSchema` / `getRegisterFormSchema`).
- `formClass()` nullo: usa `getFormSchema()` del widget (override nelle sottoclassi).
- In entrambi i casi `->statePath('data')`.

Nota di manutenzione: un merge aveva lasciato due assegnazioni di `$components` in fila (`$formClass::$method()` poi
`$resolver()`): la prima era morta (`assign.overwritten`). Tenuta la risoluzione via callable, che PHPStan sa tipizzare
(`@var array<int|string, Component>`).
