---
title: "Topic filament-table"
type: digest
status: active
qmd: "digest ceiling 100 filament-table"
---

# Topic filament-table

Sintesi automatica di 3 documenti (chiave `filament-table`).

## Risoluzione conflitto git su Filament Table ConvertAction

_Fonte: `filament-table-actions-conflict-resolution.md`_

# Risoluzione conflitto git su Filament Table ConvertAction

## Problema
Sono presenti marker di conflitto git nel file `app/Filament/Actions/Table/ConvertAction.php` del modulo Media. Le differenze riguardano la configurazione e la catena dei metodi nell'azione personalizzata di Filament.

## Analisi
- Il conflitto coinvolge la catena di metodi all'interno del metodo `setUp()` della classe `ConvertAction`.
- Alcune versioni aggiungono metodi come `->tooltip('convert')`, `->openUrlInNewTab()`, `->icon('convert01')` e la definizione del form con Radio.
- È necessario mantenere la versione più completa e coerente con le best practice Filament e con la UX desiderata.

## Scelta
- Verrà mantenuta la catena di metodi più completa e aggiornata, garantendo la presenza di tooltip, apertura in nuova tab, icona personalizzata e form con opzioni radio.
- Verrà verificata la sintassi e la coerenza dopo la correzione.

## Collegamenti
- [Documentazione root risoluzione conflitti](../../../../docs/risoluzione_conflitti_git.md#media-filament-actions-table-convertactionphp)

## Convenzioni per le Table Actions in Filament

_Fonte: `filament-table-actions.md`_

# Convenzioni per le Table Actions in Filament

## Regola Fondamentale
Tutte le azioni delle tabelle in Filament devono avere chiavi di tipo stringa nell'array restituito dai metodi getTable*Actions().

## Metodi Interessati
Questa convenzione si applica a tutti i seguenti metodi:
- `getTableHeaderActions()`
- `getTableActions()`
- `getBulkActions()`
- `getHeaderActions()`
- `getActions()`

## Esempi

### ✅ Corretto
```php
public function getTableHeaderActions(): array
{
    return [
        'add_new' => AddAction::make(),
        'export' => ExportAction::make(),
        'import' => ImportAction::make(),
    ];
}

public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),

## La tabella si configura nella Table class, non nella pagina

_Fonte: `filament-table-architecture.md`_

# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\Media\Filament\Resources\FooResource\Tables;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FoosTable extends XotBaseResourceTable
{
    /** @return array<string, Column> */
    public function getTableColumns(): array { return [...]; }

    /** @return array<string|int, BaseFilter> */
    public function getTableFilters(): array { return [...]; }
}
```

## Il percorso, per intero
