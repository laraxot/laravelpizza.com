---
title: "Layout tabella lista/griglia"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui table layout toggle list grid TableLayoutEnum TableLayoutToggleTableAction HasTableLayoutPage layoutView sessione"
---

# Layout tabella: lista / griglia

Il bottone **Cambia layout** e' un controllo solo UX: alterna due presentazioni degli stessi record (lista = confronto
denso di molti campi, griglia = card responsive) senza toccare query o filtri.

## Pezzi (codice)

| File | Ruolo |
|---|---|
| `app/Enums/TableLayoutEnum.php` | `LIST` / `GRID` (`HasColor`, `HasIcon`, `HasLabel`); `init()` = `LIST`; `toggle()`, `isGridLayout()`, `getTableContentGrid()` (griglia `sm=1 md=2 lg=3 xl=4 2xl=5`, `null` per la lista), `getTableColumns($list, $grid)`, `getContainerClasses()`; tooltip e helper tradotti via `transClass` |
| `app/Filament/Actions/Table/TableLayoutToggleTableAction.php` | azione (`XotBaseAction`, nome `table_layout_toggle`): bottone grigio senza etichetta, icona e tooltip dinamici sul layout *di destinazione* |
| `app/Filament/Actions/Table/TableLayoutTrait.php` + `HasTableLayout.php` | persistenza in sessione per `$identifier` (`getCurrentLayout`, `saveLayout`, `resetLayout`, `getTableLayout`); default `LIST` |
| `app/Filament/Traits/HasTableLayoutPage.php` | per componenti Livewire (pagine, widget, relation manager): proprieta' `$layoutView` inizializzata dalla sessione (`mountTableLayoutFromSession()`), `applyLayoutView()` |
| `app/Filament/Actions/Header/TableLayoutToggleHeaderAction.php` | variante da header (`list`/`grid` come stringhe su `$livewire->layoutView`) |
| `app/Contracts/HasTableLayout.php`, `app/Traits/TableLayoutTrait.php` | coppia **legacy** (`getTableLayout()/setTableLayout()`, sessione `table_layout`, default `GRID`): nessun consumer noto, non usarla |
| `app/Enums/TableLayout.php` | enum legacy gemello di `TableLayoutEnum`, senza metodi di presentazione |

Consumatore cross-modulo: `Modules\Xot\Filament\Traits\HasXotTable` (registra l'azione negli header di tutte le
`XotBaseListRecords` e costruisce colonne/griglia da `$layoutView`).

## Contratto (single source of truth)

Il bug "il bottone non alterna" nasceva da due fonti di verita' non sincronizzate: `HasXotTable::table()` rendeva da
`$this->layoutView` (Livewire), mentre l'azione scriveva solo la sessione. Regole attuali:

1. **runtime**: `$layoutView` sul componente Livewire guida `table()`;
2. **persistenza**: sessione, stesso `identifier`, tramite `TableLayoutTrait`;
3. **mount**: caricare la sessione in `$layoutView` (`mountTableLayoutFromSession()`);
4. **toggle**: `resolveLayout()->toggle()`, poi `setTableLayout()` (sessione), poi `applyLayoutView()` se il componente
   lo espone; le list page delle Resource non hanno la proprieta' e valgono solo la sessione;
5. **refresh**: `bootedInteractsWithTable()`, **non** `resetTable()` (in Filament 5 azzera anche i filtri: passando a
   griglia si perdeva l'anno filtrato);
6. **icona/tooltip**: closure valutate sul layout corrente, mai statiche in `setUp()`.

## Errori gia' incontrati

- `Access level ... getCurrentLayout() must be public`: l'azione importava il trait sbagliato; il trait giusto e'
  `Modules\UI\Filament\Actions\Table\TableLayoutTrait`. Non reimplementare nell'azione i metodi gia' nel trait.
- `isset($livewire->layoutView)` e non `property_exists()`: le proprieta' Livewire sono magiche.
- `HasTableLayoutPage::applyLayoutTo()` statico di trait chiamato direttamente e' deprecato da PHP 8.1 (segnalato in
  8.4): chiamare `applyLayoutView()` sull'istanza.
- `SvgNotFound` sull'icona: la traduzione `table_layout_enum` non risolveva (chiave mancante), non e' un bug del toggle.

## Uso

```php
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

TableLayoutToggleTableAction::make()   // negli header action di una tabella
```

Per un componente Livewire proprio: `use HasTableLayoutPage;` (espone `$layoutView`, default `LIST`) e passare
`TableLayoutEnum::getTableContentGrid()` a `->contentGrid()` quando e' `GRID`.

Test: `tests/Feature/TableLayoutToggleTest.php`, `tests/Unit/Enums`. Storia delle risoluzioni di conflitto sul trait:
[merge-conflict-markers-committed.md](merge-conflict-markers-committed.md).
