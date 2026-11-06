---
title: "IDColumn: la colonna ID che porta l'ancora della riga (puntatore alla story di Xot)"
type: story
status: review
module: UI
epic: filament-tables
updated: 2026-10-30
tags: [filament, idcolumn, recordanchor, tables, pointer]
related:
  - ../../../Xot/docs/stories/idcolumn-row-anchor-return-to.story.md
  - ../bmad/filament-blueprint.md
---

# IDColumn e ancora di riga (lato UI)

**Story ID:** filament-tables.idcolumn-row-anchor
**Status:** review

> La story completa (criteri, decisioni, aperti, verifiche) e' nel modulo Xot: [idcolumn-row-anchor-return-to.story.md](../../../Xot/docs/stories/idcolumn-row-anchor-return-to.story.md). Questo file e' il puntatore dell'owner di `IDColumn`: non duplicare li' dentro il contenuto.

## Cosa appartiene a UI

- `Modules/UI/app/Filament/Tables/Columns/IDColumn.php`: emette `<span id="record-N" class="scroll-mt-24">` accanto al valore dell'ID. Non forza `searchable()` ne' `label()`; con `copyable()` copia il valore grezzo.
- Regola d'uso: dopo `IDColumn::make('id')` non si mettono `->numeric()` ne' `->formatStateUsing()`, perche' sostituiscono il formato e l'ancora sparisce.
- Documentazione d'uso della colonna: [filament-blueprint.md](../bmad/filament-blueprint.md).

## Owned File/Module Scope

- `laravel/Modules/UI/app/Filament/Tables/Columns/IDColumn.php`
- `laravel/Modules/UI/docs/bmad/filament-blueprint.md`
- Una sola tabella di UI usa `IDColumn::make('id')` (migrata nella stessa passata).

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|------|------|---|-----|
| Issue (coordinamento) | laraxot/base_techplanner_fila5 | 18 | https://github.com/laraxot/base_techplanner_fila5/issues/18 |
| **Discussion** (canon) | laraxot/base_techplanner_fila5 | 54 | https://github.com/laraxot/base_techplanner_fila5/discussions/54 |

## Dev Agent Record

Sessione 97f16a39, 2026-10-30: vedi la sezione omonima nella story di Xot. Nessuna modifica di codice a `IDColumn` in questa passata oltre a quanto gia' presente.
