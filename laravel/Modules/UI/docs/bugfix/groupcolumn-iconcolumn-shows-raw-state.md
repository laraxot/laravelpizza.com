---
title: "GroupColumn IconColumn mostra 1 invece dell'icona"
type: bugfix
module: UI
tags: [filament, groupcolumn, iconcolumn, boolean]
created: 2026-07-28
updated: 2026-07-28
qmd: "GroupColumn IconColumn boolean ha_diritto shows 1 instead of icon toEmbeddedHtml"
related:
  - ../groupcolumn.md
  - ../group-column-fix.md
---

# Bugfix — IconColumn in GroupColumn → `"1"`

## Sintomo

`IconColumn::make('ha_diritto')->boolean()` dentro `GroupColumn` mostrava il testo `1` (o `Ha diritto: 1`), non l’icona Heroicon. Lo stesso IconColumn standalone funzionava.

## Causa

`ui::filament.tables.columns.group` concatenava lo **state grezzo** e lo stampava con `{{ }}`. Non chiamava `toEmbeddedHtml()`. `ha_diritto` in DB è int `0|1` → dump letterale `"1"`.

## Fix

1. `GroupColumn::table()` / `schema()` propagano la Table alle child
2. View: `$field->table($getTable())` + `record()` + `clearCachedState()`
3. Visual → `{!! $field->toEmbeddedHtml() !!}`; Text → path testo storico

## Regressione correlata

Dopo `toEmbeddedHtml()`, senza mount Table → `LogicException: The column [id] is not mounted to a table` (lista schede).

## Verifica

- Pest: `GroupColumnTest` → `renders IconColumn boolean via toEmbeddedHtml`
- Lista schede: cella `id/motivo` con check/X, non `"1"`

## Discussione agenti

Root cause concordata (explore + generalPurpose): fix in GroupColumn/view, non workaround in BaseListSchedas.
