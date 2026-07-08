---
module: UI
topic: table-layout-toggle
status: open
related_issue: provtv/base_ptv_fila5_mono
related_module_repo: laraxot/module_ui_fila5
---

# Bug: «Cambia layout» non alterna lista/griglia

## Scopo del bottone (business)

Il bottone **Cambia layout** (`TableLayoutToggleTableAction`) è un controllo **solo UX** sulle liste Filament: consente all’operatore di passare tra due presentazioni degli **stessi record**, senza modificare query, filtri o dati.

| Layout | Esperienza utente | Caso d’uso |
|--------|-------------------|------------|
| **Lista** | Tabella classica righe/colonne | Confronto denso di molti campi (es. ASZ in Progressioni) |
| **Griglia** | Card responsive | Scansione visiva con meno colonne per card |

È registrato automaticamente da `HasXotTable::getTableHeaderActions()` su tutte le `XotBaseListRecords`.

## Sintomo

- Il bottone è visibile in header tabella (es. `/progressioni/admin/asz00fs`).
- Dopo il click la tabella **resta in layout lista** (o non cambia in modo affidabile).
- In alcuni casi precedenti: crash `SvgNotFound` perché l’icona non risolveva la traduzione (fix separato su `transClass` + `table_layout_enum.php`).

## Causa radice

Due fonti di verità **non sincronizzate**:

| Componente | Cosa legge/scrive | Chiave / proprietà |
|------------|-------------------|--------------------|
| `HasXotTable::table()` | **render** colonne e griglia | `$this->layoutView` (Livewire) |
| `TableLayoutToggleTableAction` | **toggle** al click | sessione `table_layout_default` via `TableLayoutTrait` |

Il toggle salvava in sessione e faceva `$refresh`, ma **non aggiornava** `$livewire->layoutView`. La tabella continuava a usare il valore iniziale (`TableLayoutEnum::LIST`).

Inoltre:

- `setUp()` dell’azione leggeva layout da sessione **una sola volta** (icona/tooltip statici).
- Default incoerente: `getCurrentLayout()` tornava `GRID` senza sessione, mentre `XotBaseListRecords` inizializza `LIST`.

## Contratto corretto (single source of truth)

1. **Runtime**: `$layoutView` sulla pagina Livewire guida `HasXotTable::table()`.
2. **Persistenza**: sessione tramite `TableLayoutTrait` (stesso identifier).
3. **Mount**: caricare sessione → `$layoutView`.
4. **Toggle**: aggiornare `$layoutView` + sessione + `resetTable()` / refresh.
5. **Icona/tooltip**: closure dinamiche su `$layoutView` corrente.

## File coinvolti

- `Modules/UI/app/Filament/Actions/Table/TableLayoutToggleTableAction.php`
- `Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`
- `Modules/UI/app/Filament/Traits/HasTableLayoutPage.php` (sync mount)
- `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `Modules/Xot/app/Filament/Traits/HasXotTable.php`

## Fix applicato

Vedi commit associato all’issue GitHub. In sintesi: trait `HasTableLayoutPage`, toggle che scrive su `layoutView`, default allineato a `LIST`, closure dinamiche per icona.

## Verifica manuale

1. Aprire una lista con `HasXotTable` (es. ASZ Progressioni).
2. Click **Cambia layout** → passaggio visivo lista ↔ griglia.
3. Ricaricare pagina → layout persistito in sessione.
4. Icona e tooltip coerenti col layout attivo.

## Collegamenti

- [TableLayoutToggleTableAction](./actions/table-layout-toggle.md)
- [HasXotTable — layout tabella](../../Xot/docs/filament/traits/has-xot-table.md)
- [TableLayoutEnum](./table-layout-enum-complete-guide.md)
- [Handoff agenti](../../../docs/chat/handoff-table-layout-toggle-not-working.md)
