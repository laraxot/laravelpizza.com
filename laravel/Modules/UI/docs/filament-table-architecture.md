---
title: "Dove si configura la tabella di una Resource Filament"
type: guideline
module: UI
updated: 2026-09-01
qmd: "tabella filament resource table class getTableFilters XotBaseResourceTable HasXotTable list page ui"
---

# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\UI\Filament\Resources\FooResource\Tables;

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

```
List<Plurale>  (estende XotBaseListRecords)
  -> Filament: ListRecords::table()
    -> <Nome>Resource::table()            (XotBaseResource)
      -> ::getTableClass()                risolve <Plurale>Table
        -> XotBaseResourceTable::configure()
          -> HasXotTable::table()          legge getTableColumns/Filters/Actions
```

`XotBaseListRecords` **non usa** `HasXotTable`. Se lo usasse, definirebbe `table()` sulla
pagina, e in Filament il `table()` della pagina vince su quello della Resource: la Table
class non verrebbe mai eseguita. E' esattamente quello che succedeva fino al 1 settembre
2026, con 166 classi `*Table` scritte e mai chiamate.

## I nomi dei metodi non hanno prefisso

Si chiamano `getTableColumns()`, `getTableFilters()`, `getTableActions()`,
`getTableBulkActions()`, `getTableHeaderActions()`, `getTableHeading()`,
`getTableEmptyStateActions()`, `getTableFiltersLayout()`,
`getTableRecordActionsPosition()`, e — sulla sola `XotBaseResourceTable` —
`getTableSortColumn()` / `getTableSortDirection()`.

**Il nome dell'hook decide quanta impalcatura serve.** Tre casi:

| Il nome è… | Esito | Esempio |
|---|---|---|
| libero in Filament | `table()` lo chiama e basta | `getTableFiltersLayout()` |
| occupato da un metodo `@deprecated` | serve un resolver a reflection, per non far scattare `method.deprecated` | `getTableFilters()`, `getTableActions()` |
| occupato da un metodo **vivo del contratto** `HasTable` | dichiararlo nel trait rompe il framework | `getTableSortColumn()` |

Il terzo caso è il più insidioso: i metodi di un trait vincono su quelli ereditati dalla
classe padre, quindi un `getTableSortColumn()` nel trait sostituirebbe l'accessor che
Filament usa per leggere lo stato di sort corrente (`$tableSort`), e il click
sull'intestazione di colonna smetterebbe di funzionare. Per questo quei due hook stanno
**solo su `XotBaseResourceTable`**, che non implementa `HasTable`; relation manager e
widget, che invece lo implementano, usano il default privato del trait.

**Niente costanti hardcoded dentro `table()`.** Ogni scelta di configurazione passa da un
hook: il trait fornisce il default, la Table class lo cambia sovrascrivendo il metodo,
senza dover riscrivere `table()`. Un `->filtersLayout(FiltersLayout::AboveContent)` scritto
inline non e' un default, e' un muro: obbliga a duplicare tutto `table()` per cambiare una
riga.

**Niente `array_values()` sui risultati degli hook.** Filament reindicizza da solo
(`foreach (Arr::wrap($actions) as $action) { ...[] = $action; }`), quindi le chiavi
stringa degli array associativi non danno fastidio: normalizzare al chiamante e' rumore
ripetuto a ogni riga.

**`getXotTableFilters()` e i suoi fratelli non esistono piu'.** Erano nati per non
collidere con i metodi omonimi e deprecati di `Filament\Resources\Pages\ListRecords`,
quando il trait stava sulla pagina. Da quando sta solo su `XotBaseResourceTable` — che e'
una classe normale, non una pagina Filament — la collisione non c'e' e il prefisso non ha
piu' ragione di esistere.

Il prefisso non era neutro: `table()` chiamava il nome prefissato mentre le sottoclassi
overridavano quello semplice, quindi ogni override veniva **ignorato in silenzio**. Nessun
errore, nessun warning, nessun test rosso: solo filtri che non compaiono.

## Il nome della Table class

`getTableClass()` prova due candidati, in quest'ordine:

1. dal **model**: `Str::plural(class_basename(getModel())).'Table'`;
2. dalla **Resource**: `Str::plural(<Resource senza il suffisso Resource>).'Table'`.

Il secondo esiste perche' i file seguono la Resource e non sempre il model: `PesiResource`
ha `PesisTable` ma il suo model e' `Peso`, e `SettlementResource` non dichiara `$model`
affatto. Senza quel candidato si finiva nel fallback per model, che su alcune Resource
restituiva la Table class **di un altro modulo**.

Se nessuno dei due esiste, `getTableClass()` alza `LogicException`: una Resource senza
Table class non degrada a tabella vuota, va in errore. Il contratto e' tenuto da
`Modules/Xot/tests/Unit/ListPageHasTableClassTest.php`, che percorre tutte le list page
concrete del progetto.

## Come accorgersi che si sta sbagliando

Il sintomo e' sempre lo stesso: **la pagina si apre, la tabella c'e', i filtri no**.
Nessun errore da nessuna parte.

```bash
# la Table class che verra' usata davvero
php artisan tinker --execute="echo <Nome>Resource::getTableClass();"
```

Se quello che vedi a schermo non corrisponde a quel file, stai modificando il file
sbagliato.

## Storia, per non ripeterla

- **19 agosto 2026** — rename da `getTableX()` a `getXotTableX()` per schivare la
  deprecazione Filament. Fatto solo dentro `table()`: le sottoclassi restano al nome
  vecchio e diventano mute. `getTableColumns` fu l'unico salvato, con un adapter a
  reflection.
- **1 settembre 2026** — segnalazione utente: i filtri non compaiono su
  `/indennitaresponsabilita/admin/scheda-dips`. La catena reale passava per
  `BaseListSchedas::getTableFilters()`, col nome vecchio.
- **1 settembre 2026** — `use HasXotTable;` tolto da `XotBaseListRecords`, prefisso `Xot`
  rimosso dai nomi, candidato per-Resource in `getTableClass()`, test di regressione.
