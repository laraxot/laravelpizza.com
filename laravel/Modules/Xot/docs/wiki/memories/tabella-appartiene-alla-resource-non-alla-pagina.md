---
title: "La tabella appartiene alla Resource, non alla pagina List"
type: memory
module: Xot
created: 2026-09-29
updated: 2026-09-29
tags: [filament, table, list-page, dry, phpstan, pest]
qmd: "tabella resource list page getTableColumns final table hook filamentext"
issues: []
discussions: []
related:
  - "./merge-marker-spazzatura-worktree.md"
  - "./xot-table-filters-method-name.md"
status: draft
---

# La tabella appartiene alla Resource, non alla pagina List

> **SUMMARY**: In Laraxot la tabella di una List page la costruisce la **Resource**, non la
> pagina. Un `getTableColumns()` scritto su una `Pages/List*.php` non viene neanche chiamato, e
> su `XotBaseListRecords` è un **fatal**, non un warning. Prima della guardia era un difetto
> **silenzoso**: tabella vuota, nessun errore, nessun log.

## La catena di chiamate (verificata in `vendor/filament/`, 2026-09-29)

| # | Punto | Cosa fa |
|---|-------|---------|
| 1 | `InteractsWithTable::bootedInteractsWithTable()`: `tables/src/Concerns/InteractsWithTable.php:45-47` | `$this->table = $this->table($this->makeTable());` |
| 2 | `ListRecords::makeTable()`: `filament/src/Resources/Pages/ListRecords.php:213` | `static::getResource()::configureTable($table)` |
| 3 | `Resource::configureTable()`: `filament/src/Filament/Resources/Resource.php:81` | `static::table($table)`: **il valore di ritorno è IGNORATO** (`@phpstan-ignore staticMethod.resultUnused`) |
| 4 | `XotBaseResource::table()`: `Modules/Xot/app/Filament/Resources/XotBaseResource.php:202` | `$class::configure($table)` |
| 5 | `XotBaseResourceTable::configure()` | `app(static::class)` e `$instance->table($table)` (da `HasXotTable`) |
| 6 | `HasXotTable::table()`: `Modules/Xot/app/Filament/Traits/HasXotTable.php:222+` | applica colonne, filtri, azioni, header actions |

Il passo 2 è **il** punto in cui la Resource prende il controllo della tabella. Da lì in
giù nessun hook della pagina viene consultato.

## Perché `getTableColumns()` è `final`

`XotBaseListRecords::getTableColumns()` è `final public function ... { return []; }`.

- Un override su una pagina è un **fatal** "Cannot override final method" **al caricamento**:
  si prende la pagina intera, non solo la tabella.
- Prima della guardia era un difetto **silenzoso**: la pagina veniva caricata, la colonna non
  compariva, e nessun errore né log diceva perché. La rimozione di `HasXotTable` da
  `XotBaseListRecords` aveva reso morti 90 hook di pagina in un colpo e nessuno se n'è accorto
  per giorni.
- `XotBaseListRecords` **non usa `HasXotTable`** ed è deliberato: è la pagina a non avere la
  tabella, non la Resource a non averla.

## `XotBaseResource::getTableClass()`

Deduce `{PluralStudly}Table` da `Str::plural(class_basename(static::getModel()))` cercando
`{Resource}\Tables\{Plural}Table`. Se non esiste, risolve via
`GetResourceClassNameByModelClassAction`: cioè la Resource può trovarsi anche in un altro
modulo. Da qui i pattern `Base*Resource/Tables/Base*Table` (tabella condivisa da più Resource
concrete): sono legittimi e voluti.

## L'eccezione: `XotBaseManageRelatedRecords`

Lì `table()` è `final` e **il valore di ritorno conta**:
`$this->relatedResourceTable = $resourceClass::table($table)`, e poi la pagina applica
`->columns($this->getTableColumns())`. I `getTable*` sulla pagina sono il **punto di estensione
previsto**, perché:

1. le azioni header dipendono dal **contesto owner** (`$this->getRecord()`,
   `$this->getOwnerRecord()`), che la Resource correlata non conosce;
2. `getTableColumns()` non è bloccato da `final` (non discende da `XotBaseListRecords`);
3. l'ordine conta: le colonne vengono applicate **dopo** la Resource.

Documentato in `XotBaseManageRelatedRecords.php:253-270`.

## I due test di guardia

- `Modules/Xot/tests/Unit/Filament/TableColumnsBelongsToTableClassTest.php`
  - test 1: nessuna List page dichiara `getTableColumns()`;
  - test 2: `getTableColumns()` è `final` (Reflection);
  - test 3: la guardia vede davvero delle List page (`count > 100`), per non essere verde per
    il motivo sbagliato.
- `Modules/Xot/tests/Unit/ListPageHasTableClassTest.php:23`: ogni List page concreta
  risolve la sua `Table` class.

Entrambe scansionano `base_path('Modules')` **e** `base_path('Themes')`.

## TRE regole operative, imparate sul campo

1. **Tokenizer, mai regex, per i metodi dichiarati.** `declaresMethod()` usa
   `token_get_all` + `T_FUNCTION` + `T_STRING`. Con `grep -n "function getTable"` si
   ottengono **42 falsi positivi** (blocchi `/* ... */` attorno a metodi morti, metodi con
   prefisso custom come `notificationTableColumns`). Peggio: un `preg_match` su un blocco di
   commento farebbe scattare la guardia **disattivandola** invece di farla rispettare: la
   guardia verde per il motivo sbagliato. Caso reale:
   `Performance/.../ListOrganizzativas.php` ha un `/* ... */` attorno a un vecchio
   `getTableColumns()`.
2. **La guardia è statica di proposito.** `is_subclass_of()` richiederebbe di caricare la
   pagina, e il fatal ucciderebbe il processo invece di far fallire il test.
3. **Se il metodo è già nella `Table` class, il lavoro è togliere il duplicato, non
   spostare.** Nel caso reale del 2026-09-29 i metodi erano già stati copiati nelle `Table`
   class da un altro agente: spostarli li avrebbe duplicati un terzo posto. Verificare
   l'equivalenza riga per riga **prima** di scrivere.

## Limite noto della guardia

Copre **SOLO** `getTableColumns`, non gli altri `getTable*`. Allargarla senza aver prima
ripulito tutto la accenderebbe su metodi legittimi (le pagine `ManageRelatedRecords`) e
fallirebbe. Estenderla è un compito separato.

## Cosa NON è un hook della tabella

`getHeaderActions()` (protected, trait `InteractsWithHeaderActions` in
`vendor/filament/filament/src/Pages/Concerns/`) è il **page header**, distinto dal **table
header** di `getTableHeaderActions()`. Non è un `getTable*` e resta sulla pagina. Ma i due
sono due barre diverse: vedi `header-actions-doppi-filament.md` per il difetto di doppio
pulsante che ne deriva.
