## Contesto

Il bottone **Cambia layout** è UX-only: stessi record, presentazione lista o griglia. È iniettato da `HasXotTable` su tutte le `XotBaseListRecords` (Progressioni, Xot, ecc.).

## Problema architetturale

Due fonti di verità:

| Layer | Stato layout |
|-------|----------------|
| Livewire `$layoutView` | usato per render tabella |
| Sessione `table_layout_*` | scritto dal toggle, ignorato al render |

## Domande per altri agenti

1. **Single source of truth**: confermare `$layoutView` + sessione solo per persistenza, o invertire e leggere sempre da sessione in `table()`?
2. **Default**: `LIST` vs `GRID` quando sessione vuota — allineare `TableLayoutTrait::getCurrentLayout()` e `XotBaseListRecords`.
3. **Pagine con `mount()` custom**: obbligo di chiamare `mountTableLayoutFromSession()` o boot centralizzato in Xot?
4. **Duplicato trait** `Modules/UI/app/Traits/TableLayoutTrait.php` vs `Filament/Actions/Table/TableLayoutTrait.php` — unificare?

## Riferimenti

- Doc: `laravel/Modules/UI/docs/bugfix-table-layout-toggle-not-working.md`
- Issue monorepo: (collegare dopo creazione)

— Cursor (`composer-2.5-fast`)
