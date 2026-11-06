---
title: "TableLayoutToggleTableAction"
type: note
status: draft
created: 2026-01-20
updated: 2026-10-15
module: UI
tags: [docs, ui, wiki]
qmd: "tablelayouttoggletableaction ui"
---

# TableLayoutToggleTableAction

## Panoramica
Azione Filament per il toggle del layout delle tabelle tra vista griglia e lista.

## Caratteristiche
- Supporto per layout griglia e lista
- Integrazione con Livewire
- Persistenza dello stato del layout
- Supporto per tooltip e icone dinamiche

## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:

1. Tipizzazione stretta dei parametri
2. Utilizzo di tipi unione per i componenti Livewire
3. Implementazione corretta delle interfacce
4. Gestione type-safe degli enum
5. Rimozione di type casting non necessari

## Interfaccia HasTableLayout
```php
interface HasTableLayout
{
    public function getLayoutView(): TableLayoutEnum;
    public function setLayoutView(TableLayoutEnum $layout): void;
    public function resetTable(): void;
}
```

## Utilizzo
```php
use Modules\UI\app\Filament\Actions\Table\TableLayoutToggleTableAction;

class MyListRecords extends ListRecords
{
    protected function getTableActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }
}
```

## Best Practices
1. Implementare l'interfaccia HasTableLayout nei componenti che utilizzano l'azione
2. Utilizzare gli enum per i tipi di layout
3. Gestire correttamente gli eventi di refresh
4. Mantenere la persistenza dello stato

## Collegamenti alla Documentazione
- [Risoluzione Conflitti UI](../../conflitti-merge-risolti.md): Documentazione dei conflitti risolti
- [Test di Risoluzione Conflitti](../../test-conflicts-resolution.md): Test automatici che verificano la corretta risoluzione

[Torna alla documentazione UI](/docs/modules/module_ui.md#actions)
---
title: "TableLayoutToggleTableAction"
type: concept
tags: [table, layout, toggle]
created: 2026-07-14
updated: 2026-07-14
qmd: "table-layout-toggle tablelayouttoggletableaction"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./table-layout-toggle-1.md"
# TableLayoutToggleTableAction
## Scopo
Bottone **Cambia layout** (lista ↔ griglia) sulle `XotBaseListRecords` con `HasXotTable`. Solo UX: stessi record, presentazione diversa.
## Flusso attuale (corretto)
```
click → toggleLayout()
  → getCurrentLayout() + toggle()
  → setTableLayout()        // sessione
  → resetTable()            // invalida tabella Filament
  → js('$wire.$refresh()')  // remount layoutView da sessione
`HasTableLayoutPage::mountTableLayoutFromSession()` (in `bootHasXotTable`) riallinea `$layoutView` dopo il refresh. `HasXotTable::table()` legge `$layoutView`.
## Componenti
| File | Ruolo |
|------|-------|
| `TableLayoutToggleTableAction` | Toggle sessione + refresh UI |
| `TableLayoutTrait` | `getCurrentLayout` / `saveLayout` su sessione |
| `HasTableLayoutPage` | `$layoutView` + mount da sessione |
| `HasXotTable` | Render colonne/griglia da `$layoutView` |
## Cosa non toccare
## Panoramica
Azione Filament per il toggle del layout delle tabelle tra vista griglia e lista.
## Caratteristiche
- Supporto per layout griglia e lista
- Integrazione con Livewire
- Persistenza dello stato del layout
- Supporto per tooltip e icone dinamiche
## Miglioramenti PHPStan Livello 9
Le seguenti modifiche sono state apportate per soddisfare PHPStan livello 9:
1. Tipizzazione stretta dei parametri
2. Utilizzo di tipi unione per i componenti Livewire
3. Implementazione corretta delle interfacce
4. Gestione type-safe degli enum
5. Rimozione di type casting non necessari
## Interfaccia HasTableLayout
```php
interface HasTableLayout
{
    public function getLayoutView(): TableLayoutEnum;
    public function setLayoutView(TableLayoutEnum $layout): void;
    public function resetTable(): void;
}
## Utilizzo
use Modules\UI\app\Filament\Actions\Table\TableLayoutToggleTableAction;
class MyListRecords extends ListRecords
    protected function getTableActions(): array
    {
        return [
            TableLayoutToggleTableAction::make(),
        ];
    }
## Best Practices
1. Implementare l'interfaccia HasTableLayout nei componenti che utilizzano l'azione
2. Utilizzare gli enum per i tipi di layout
3. Gestire correttamente gli eventi di refresh
4. Mantenere la persistenza dello stato
## Collegamenti alla Documentazione
- [Risoluzione Conflitti UI](../../conflitti-merge-risolti.md): Documentazione dei conflitti risolti
- [Test di Risoluzione Conflitti](../../test-conflicts-resolution.md): Test automatici che verificano la corretta risoluzione
- **Non** spostare il toggle in `HasTableLayoutPage`: duplicazione inutile.
- **Non** rimuovere `TableLayoutTrait` dall’Action: è il punto che scrive sessione al click.
- **Non** refactorare icona/tooltip in closure se non c’è bug visivo.
## Fix doppio click
Vedi [bugfix](../bugfix-table-layout-toggle-not-working.md): bastano `resetTable()` + `$wire.$refresh()` dopo `setTableLayout()`.
## Collegamenti
- [Bugfix doppio click](../bugfix-table-layout-toggle-not-working.md)
- [Disciplina agente](../../../../../../docs/wiki/memories/agent-table-layout-toggle-discipline.md)
- [Contratto Xot](../../Xot/docs/filament/table-layout-toggle-contract.md)
- [Tema One: tabelle](../../../Themes/One/docs/filament-resource-schemas-tables.md)
