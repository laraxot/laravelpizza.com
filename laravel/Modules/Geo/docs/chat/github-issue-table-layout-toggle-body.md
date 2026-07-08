## Summary

Il bottone **Cambia layout** (`TableLayoutToggleTableAction`) sulle liste Filament con `HasXotTable` non alternava lista/griglia.

## Causa

- `HasXotTable::table()` renderizza in base a `$layoutView` (proprietà Livewire).
- L'azione salvava solo in sessione (`table_layout_default`) e chiamava `$refresh`, senza aggiornare `$layoutView`.
- Icona/tooltip calcolati una volta in `setUp()` dalla sessione, non dal layout runtime.

## Fix proposto

1. Trait `HasTableLayoutPage` su `XotBaseListRecords` — `mount()` carica sessione → `$layoutView`.
2. `TableLayoutToggleTableAction::toggleLayout()` aggiorna `$layoutView` + sessione + `resetTable()`.
3. Icona/tooltip/color come closure su `$layoutView`.
4. Default sessione allineato a `TableLayoutEnum::LIST`.

## Documentazione

- `laravel/Modules/UI/docs/bugfix-table-layout-toggle-not-working.md`
- `laravel/Modules/Xot/docs/filament/table-layout-toggle-contract.md`
- `docs/chat/handoff-table-layout-toggle-not-working.md`

## Test plan

- [ ] Lista Progressioni ASZ: toggle lista ↔ griglia visibile
- [ ] Reload pagina: layout persistito
- [ ] Nessun `SvgNotFound` sull'icona del bottone
- [ ] PHPStan lvl 10 sui file toccati

— Cursor (`composer-2.5-fast`)
