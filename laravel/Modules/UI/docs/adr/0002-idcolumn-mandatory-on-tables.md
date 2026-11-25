---
title: "ADR — IDColumn obbligatoria su ogni tabella Filament"
type: decision
status: accepted
created: 2026-11-25
updated: 2026-11-25
module: UI
decision-makers:
  - product
  - architecture
qmd: "ADR UI 0002 IDColumn mandatory tables RecordAnchor self-link copyable"
---

# ADR — IDColumn obbligatoria su ogni tabella Filament

## Contesto

Senza colonna `id` tipizzata l'operatore non puo' citare la riga. Override di
`getTableColumns()` dimenticano spesso `id` (tab Servizi scheda 11254).
Filament non emette `id` stabile sul `<tr>`: serve target HTML nella cella.

## Decisione

**Related**: story [idcolumn-mandatory-filament-tables](../bmad/stories/0012-idcolumn-mandatory-filament-tables.story.md). Promotes the rule already described in `id-column-record-anchor.md`. Former unnumbered kebab-only path removed; canonico = questo file `0002-…`.

## Decision Drivers

- Operability: cite and share a row via `#record-{id}`.
- DRY: one column type (`Modules\UI\Filament\Tables\Columns\IDColumn`), not ad-hoc `TextColumn::make('id')`.
- Return-from-edit: `RecordAnchor::appendTo()` must target the column anchor.
- Avoid gaps from full overrides of `getTableColumns()`.

## Considered Options

- Only `TextColumn::make('id')` — no anchor, no coherent copyable behaviour.
- Inject `id` only in Progressioni leaf pages — repeats the gap on every new tab.
- Put the anchor on the `<tr>` via JS — fragile against Livewire `wire:key`.
- Mandatory `IDColumn` as first column; Sigma leaves call `withIdColumn()` inside `getTableColumns()` — chosen.

## Decision Outcome

Scelta: **mandatory `IDColumn` as first column on every Filament table**, perché operability + DRY + RecordAnchor alignment, with a single owner in UI; Sigma leaves prepend via `withIdColumn()` inside `getTableColumns()`.

1. **Mandate**: every `getTableColumns()` / Table class exposes `'id' => IDColumn::make()` (or `IDColumn::make('id')`) as the first column.
2. **Owner**: module **UI** owns `IDColumn`; **Xot** owns `RecordAnchor`.
3. **Rendering**: the cell is a self-link
   `<a id="record-{id}" href="#record-{id}" class="scroll-mt-24">…</a>`
   (browser copy-link, row bookmark) plus `copyable()` on the raw id state.
4. **Sigma history (Ptv)**: leaves override **`getTableColumns()`** (never `getSigmaTableColumns` / `get{Domain}TableColumns`) and call `withIdColumn([...])` from `BaseSigmaHistoryScheda` (ADR Ptv [0005](../../../Ptv/docs/adr/0005-gettablecolumns-not-domain-prefix.md)).
5. **Forbidden**: hardcoded `->label('ID')` (LangServiceProvider / `Column::configureUsing`); domain-prefixed column hooks (`getSigmaTableColumns`, `getListTableColumns`, …). Fleet guard: Pest `NoDomainPrefixedTableColumnsTest` + rule `.cursor/rules/gettablecolumns-no-domain-prefix.mdc`.

### Consequences

- Buono, perché deep-link `#record-*`, copy id, parity across Servizi/Qualifiche/… tabs.
- Cattivo, perché leaves that overrode `getTableColumns` without id need a refactor.
- Neutro, perché `ColumnBuilder::id()` remains a facade to `IDColumn`.

### Confirmation

- Story: [idcolumn-mandatory-filament-tables](../bmad/stories/0012-idcolumn-mandatory-filament-tables.story.md)
- Pest: `Modules/UI/tests/Feature/IDColumnTest.php` (self-link + escape)
- Source guard: Sigma history tabs include key `id` typed as `IDColumn`
- PHPStan on `IDColumn` + `Base*Scheda`
- Host `10.100.200.15`: Pest skip (data-sacred)
