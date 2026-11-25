---
title: "Colonne tabella (Filament Tables)"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui table columns GroupColumn IDColumn SortableIdColumn TimestampColumn IconStateColumn SelectStateColumn IconStateSplitColumn PersonColumn AddressColumn mount toEmbeddedHtml"
---

# Colonne tabella

Codice: `app/Filament/Tables/Columns/` (17 classi), view in `resources/views/filament/tables/columns/`
(`group`, `icon`, `icon-state-split`, `tree`, `dummy-actions`). Ogni colonna estende la base speculare
`Modules\Xot\Filament\Tables\Columns\XotBase*` (vedi [conventions.md](conventions.md)). La regola di parita'
con i componenti form e' in [form-column-parity.md](form-column-parity.md).

## Catalogo

| Classe | Base | A cosa serve |
|---|---|---|
| `IDColumn` | `XotBaseTextColumn` | PK obbligatoria in ogni tabella ([ADR 0002](adr/0002-idcolumn-mandatory-on-tables.md)): ordinabile, copiabile, la cella emette l'ancora `#record-{id}` |
| `SortableIdColumn` | `XotBaseTextColumn` | `id` "di convenzione": `sortable()->copyable()->toggleable(isToggledHiddenByDefault: true)`; nome diverso da `IDColumn` per evitare collisioni case-insensitive |
| `TimestampColumn` | `XotBaseTextColumn` | `dateTime()->sortable()->placeholder('—')`; il `toggleable()` resta al chiamante |
| `OrderColumn` | `XotBaseTextColumn` | `order_column` come badge, nascosta di default (il riordino resta drag-and-drop) |
| `GroupColumn` | `XotBaseColumn` | piu' colonne figlie in una cella (vedi sotto) |
| `PersonColumn`, `AddressColumn`, `EventColumn`, `OrganizationColumn` | `GroupColumn` | gruppi pronti: stessi campi dei componenti form gemelli (`PersonSection`, `AddressField`, `EventSection`, `OrganizationSection`), nomi mappati su schema.org solo come documentazione; `fields([...])` restringe l'elenco |
| `OpeningHoursColumn` | `XotBaseTextColumn` | riepilogo testuale degli orari settimanali (`summarizeOpeningHours()` statico, testabile); non e' un `GroupColumn` perche' 28 `TimePicker` non sono leggibili in lista |
| `IconColumn` | `XotBaseIconColumn` | icona con view `ui::filament.tables.columns.icon` |
| `IconStateColumn` | `XotBaseIconColumn` | icona/colore/tooltip da `XotStateContract`; l'azione `change-state` apre un select con `transitionableStates()` |
| `IconStateGroupColumn` | `XotBaseColumnGroup` | stati raggruppati (`stateClass($stateClass, $modelClass)`) |
| `IconStateSplitColumn` | `XotBaseColumn` | griglia compatta di icone-transizione; `getRecordStates()`, `canTransitionTo()`, `transitionState()` |
| `SelectStateColumn` | `XotBaseSelectColumn` | select inline degli stati raggiungibili (da `transitionableStates()`, con fallback `getStatesFor()`) |
| `TreeColumn` | `XotBaseColumn` | albero (view `tree`) |
| `DummyActionsColumn` | `XotBaseColumnGroup` | segnaposto per le azioni di riga |

Le colonne "stato" dipendono da `spatie/laravel-model-states`: la proprieta' del pacchetto e' condivisa fra UI
(componenti) e Xot (`XotBaseState`, `XotBaseTransition`); non va aggiunto al `composer.json` radice ne' a un modulo di
dominio. Il pacchetto `2.13.x` richiede PHP 8.4: su runtime PHP 8.3 non si reinstalla, il primo punto da aggiornare e'
il `composer.json` del modulo owner.

## Uso

```php
use Modules\UI\Filament\Tables\Columns\{IDColumn, GroupColumn, TimestampColumn};

'id' => IDColumn::make('id'),
'owner' => GroupColumn::make('owner')->schema([
    TextColumn::make('first_name'),
    TextColumn::make('owner.email'),          // dot-notation: funziona (data_get nella view)
    IconColumn::make('is_active')->boolean(), // colonne visuali: rese con toEmbeddedHtml()
]),
'created_at' => TimestampColumn::make('created_at'),
```

## GroupColumn: come funziona e perche'

Le colonne figlie vivono in `GroupColumn::$schema` e **Filament non le monta**: il montaggio automatico
(`$column->record($record)`) avviene solo per le colonne di primo livello. Il gruppo deve farlo a mano, e lo fa in
due punti:

- `GroupColumn::schema()` e `GroupColumn::table()` propagano la `Table` a ogni figlia (`mountChildrenToTable()`);
  senza, Filament lancia `LogicException: The column [x] is not mounted to a table`.
- la view `group.blade.php`, per ogni figlia, chiama `table($getTable())`, `record($record)` e `clearCachedState()`
  (senza `clearCachedState()` lo state della riga precedente resta in cache e tutte le righe mostrano la stessa icona).

Regole di resa nella view:

- colonne **visuali** (`IconColumn`, `ColorColumn`, `ImageColumn`): si salta solo `null` e si delega a
  `toEmbeddedHtml()`; `false`/`0` sono informazione (icona rossa), non assenza. Stampare lo state grezzo mostrava `1`
  al posto dell'icona.
- colonne **testuali**: si salta `empty()` tranne `0` e `'0'`; la riga e' `Etichetta: valore`.
- `SelectColumn` figlia: sempre resa via `toEmbeddedHtml()`, anche con valore `null`.
- `getState()` e, se `null`, `data_get($record, $name)`: cosi' `TextColumn::make('relazione.campo')` funziona nel gruppo
  come fuori (la risoluzione delle relazioni di Filament passa da `data_get()` in `HasCellState`).
- etichetta: `getLabel()` (Closure/Htmlable gestiti), poi `__('ui::table.columns.{name}.label')`, poi `Str::headline($name)`.
- le figlie devono essere `Column` (il filtro in `schema()` scarta il resto); i valori enum sono resi con
  `getLabel()` (se `HasLabel`), altrimenti `value`/`name`; gli oggetti senza `__toString()` non vengono castati.
- se esiste una colonna dedicata del dominio (un `GroupColumn` derivato), usarla invece di ripetere i `TextColumn`:
  incapsula schema, ricerca di gruppo e stile.

Test: `tests/Feature/GroupColumnTest.php` (schema, filtro non-Column, dot-notation annidata, zeri preservati, vuoti
saltati) e `tests/Unit/Filament/IDColumnAnchorTest.php`.

## IDColumn e ancora di riga

Filament 5 non emette `id` o `data-*` per riga (sul `<tr>` c'e' solo `wire:key`, rigenerato a ogni caricamento), quindi
l'ancora la emette la cella: `<span id="record-1875" class="scroll-mt-24">1875</span>`. Il formato sta in
`Modules\Xot\Filament\Support\RecordAnchor` (la colonna lo legge, i link di ritorno dall'edit lo appendono): non
duplicare la stringa `record-`. Funziona anche come figlia di `GroupColumn` perche' la view rispetta `isHtml()`.

## Convenzioni emerse dai bug

- il nome della view segue il nome del file senza suffisso `-column` (`icon`, `tree`, `group`, `icon-state-split`,
  `dummy-actions`); una view inesistente da' 404 al render;
- nessuna colonna estende `Filament\Tables\Columns\*` direttamente (audit: `TreeColumn`, `DummyActionsColumn`,
  `IconStateSplitColumn`, `SelectStateColumn` e `IconColumn` sono stati portati su `XotBase*`); se manca il mirror
  in Xot, va creato prima di usarlo;
- `SelectStateColumn` con modale di conferma + messaggio: il messaggio e' il secondo parametro di `transitionTo()`;
  la conferma passa da `beforeStateUpdated`, serve verifica dei permessi lato server.
