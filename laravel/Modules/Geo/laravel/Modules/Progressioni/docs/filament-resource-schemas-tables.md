# Filament Resource: cartelle Schemas e Tables (migrazione Filament 5)

## Scopo

Separare form, infolist e tabella dalle classi `*Resource.php`, seguendo il layout del [demo Filament 5](https://github.com/filamentphp/demo/tree/5.x/app/Filament/Resources/Blog/Categories) ma adattato a **Laraxot** (`XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable`).

**Perché:** una sola responsabilità per file, migrazione incrementale senza rompere il panel, allineamento con gli altri moduli (Activity, Notify, User).

## Riferimenti demo Filament 5

| Demo | Ruolo Laraxot |
| :--- | :--- |
| [CategoryForm.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Schemas/CategoryForm.php) | `{Model}Form` → `getFormSchema()` |
| [CategoryInfolist.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Schemas/CategoryInfolist.php) | `{Model}Infolist` → `getInfolistSchema()` |
| [CategoriesTable.php](https://github.com/filamentphp/demo/blob/5.x/app/Filament/Resources/Blog/Categories/Tables/CategoriesTable.php) | `{Models}Table` → `getTableColumns()` |

Il demo usa `configure(Schema): Schema`; in Laraxot la fase corrente usa ancora **array con chiavi stringa** tramite le classi base Xot. Vedi [filament-v5-hybrid-pattern](../../Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md) per l’evoluzione futura.

## Struttura obbligatoria

```
Modules/Progressioni/app/Filament/Resources/{ResourceName}/
├── Schemas/
│   ├── {Entity}Form.php
│   └── {Entity}Infolist.php
├── Tables/
│   └── {Entities}Table.php
└── Pages/
    └── ...
```

Namespace:

- `Modules\Progressioni\Filament\Resources\{ResourceName}\Schemas\{Entity}Form`
- `Modules\Progressioni\Filament\Resources\{ResourceName}\Schemas\{Entity}Infolist`
- `Modules\Progressioni\Filament\Resources\{ResourceName}\Tables\{Entities}Table`

## Regole Laraxot (non negoziabili)

1. **Estendere sempre** `XotBaseResourceForm`, `XotBaseResourceInfolist`, `XotBaseResourceTable` — mai Filament diretto.
2. **Mai** `->label()`, `->placeholder()`, `->helperText()` sui componenti: traduzioni automatiche via LangServiceProvider.
3. **Chiavi stringa** obbligatorie:
   - `getFormSchema(): array<string, Component>`
   - `getInfolistSchema(): array<string, Component>`
   - `getTableColumns(): array<string, Column>`
4. **Fase wire (fase 3):** Resource delega a `{ModelBasename}Form`; List page delega colonne a `*Table` via `app()`. Vedi [filament-resource-wire-assenze](./filament-resource-wire-assenze.md).
5. **`getPages()`:** rimuovere dalla Resource se solo CRUD standard e naming Page allineato a `XotBaseResource` — [dettaglio modulo](./filament-resource-getpages-naming.md), [regola Xot](../../Xot/docs/filament/getpages-redundancy-rule.md).

## Fasi di migrazione

| Fase | Stato | Azione |
| :--- | :---: | :--- |
| 1 – Scaffold | ✅ | Creare `Schemas/` e `Tables/` con classi vuote |
| 2 – Spostamento | ✅ | Copiare schema da Resource / List / View → classi dedicate ([script](../../../bashscripts/progressioni/populate-filament-schemas.php), [doc](../../../bashscripts/docs/progressioni/populate-filament-schemas.md)) |
| 3 – Delega | ⏳ | Resource e List delegano a Form/Table **solo quando la fase 3 è completata**; guida pilota: [Assenza](./filament-resource-wire-assenza.md) (wire **non** ancora applicato) |
| 4 – Pulizia | ⏳ | Rimuovere metodi inline duplicati; rimuovere `getPages()` ridondanti (script `analyze-redundant-getpages.php`) |

**Priorità fase 3:** pilota Assenza (guida pronta) → risorse CRUD semplici → List con override → `ProgressioniResource` / `SchedaResource`.

**Durante fasi 1–2:** non modificare `*Resource.php` né `Pages/List*` per delegare; restano la sorgente di verità fino al wire manuale.

## Inventario scaffold (modulo Progressioni)

| Resource | Form | Infolist | Table |
| :--- | :--- | :--- | :--- |
| Asz00fResource | Asz00fForm | Asz00fInfolist | Asz00fsTable |
| AssenzaResource | AssenzaForm | AssenzaInfolist | AssenzasTable |
| CategoriaProproResource | CategoriaProproForm | CategoriaProproInfolist | CategoriaProprosTable |
| CedDiffResource | CedDiffForm | CedDiffInfolist | CedDiffsTable |
| CoeffResource | CoeffForm | CoeffInfolist | CoeffsTable |
| CriteriEsclusioneResource | CriteriEsclusioneForm | CriteriEsclusioneInfolist | CriteriEsclusionesTable |
| CriteriOptionResource | CriteriOptionForm | CriteriOptionInfolist | CriteriOptionsTable |
| CriteriPrecedenzaResource | CriteriPrecedenzaForm | CriteriPrecedenzaInfolist | CriteriPrecedenzasTable |
| CriteriValutazioneResource | CriteriValutazioneForm | CriteriValutazioneInfolist | CriteriValutazionesTable |
| EsclusiExtraResource | EsclusiExtraForm | EsclusiExtraInfolist | EsclusiExtrasTable |
| IntegparamResource | IntegparamForm | IntegparamInfolist | IntegparamsTable |
| MailTemplateResource | MailTemplateForm | MailTemplateInfolist | MailTemplatesTable |
| MaxCatecoPosfunAnnoResource | MaxCatecoPosfunAnnoForm | MaxCatecoPosfunAnnoInfolist | MaxCatecoPosfunAnnosTable |
| MessageResource | MessageForm | MessageInfolist | MessagesTable |
| MyLogResource | MyLogForm | MyLogInfolist | MyLogsTable |
| PesiResource | PesiForm | PesiInfolist | PesisTable |
| ProgressioniResource | ProgressioniForm | ProgressioniInfolist | ProgressionisTable |
| SchedaCriteriResource | SchedaCriteriForm | SchedaCriteriInfolist | SchedaCriterisTable |
| SchedaResource | SchedaForm → estende `Ptv\...\BaseSchedaForm` | SchedaInfolist → estende `Ptv\...\BaseSchedaInfolist` | SchedasTable → estende `Ptv\...\BaseSchedasTable` |

### SchedaResource: form condiviso con Ptv

`Modules\Progressioni\Filament\Resources\SchedaResource\Schemas\SchedaForm` **estende** `Modules\Ptv\Filament\Resources\SchedaResource\Schemas\BaseSchedaForm` (non `XotBaseResourceForm` direttamente).

- Schema Progressioni: override completo `getFormSchema()` (campi flat assenze/categoria).
- Ptv: `SchedaForm` thin su `BaseSchedaForm` (sezioni diritto/lavoratore/qualifica).

### SchedaResource: infolist condiviso con Ptv

`Modules\Progressioni\Filament\Resources\SchedaResource\Schemas\SchedaInfolist` **estende** `Modules\Ptv\Filament\Resources\SchedaResource\Schemas\BaseSchedaInfolist` (non `XotBaseResourceInfolist` direttamente).

- Schema Progressioni: override completo `getInfolistSchema()` (campi flat assenze/categoria).
- Ptv: `SchedaInfolist` thin su `BaseSchedaInfolist` (default Ptv).

### SchedaResource: tabella condivisa con Ptv

`Modules\Progressioni\Filament\Resources\SchedaResource\Tables\SchedasTable` **estende** `Modules\Ptv\Filament\Resources\SchedaResource\Tables\BaseSchedasTable` (non `XotBaseResourceTable` direttamente).

- Colonne, bulk e azioni riga: override Progressioni dove serve; filtri vuoti fino al wire fase 3 su `ListSchedas`.
- Pagine: `ListSchedas` / `EditScheda` / `CreateScheda` estendono le rispettive `Base*` in Ptv.

Dettaglio ereditarietà: [Ptv — scheda-resource-pages-inheritance](../../Ptv/docs/scheda-resource-pages-inheritance.md).

### CriteriEsclusioneResource: resource condivisa con Ptv

`Modules\Progressioni\Filament\Resources\CriteriEsclusioneResource` **estende** `Modules\Ptv\Filament\Resources\BaseCriteriEsclusioneResource` (non la concreta `Ptv\CriteriEsclusioneResource`).

- Resource figlia: solo `$model` Progressioni.
- Pages / Form / Table / Infolist: thin su rispettive `Base*` in `Ptv\...\CriteriEsclusioneResource\`.

Regola generale moduli figli: [Ptv — filament-resource-base-inheritance](../../Ptv/docs/filament-resource-base-inheritance.md).

Select con opzioni fisse: enum + `EnumTrait`, mai array inline — [Ptv — filament-select-options-enum](../../Ptv/docs/filament-select-options-enum.md). Naming enum sul concetto: [enum-naming-reusable](../../Ptv/docs/enum-naming-reusable.md).

| StabiDirigenteResource | StabiDirigenteForm | StabiDirigenteInfolist | StabiDirigentesTable |
| StipendioTabellareResource | StipendioTabellareForm | StipendioTabellareInfolist | StipendioTabellaresTable |
| ValutatoreResource | ValutatoreForm | ValutatoreInfolist | ValutatoresTable |

### Asz00fResource — widget stats overview

`Asz00fStatsOverview` in `Asz00fResource/Widgets/`; wire su `ListAsz00fs::getHeaderWidgets()`. Dettaglio: [asz00f-filament-stats-overview](./wiki/concepts/asz00f-filament-stats-overview.md).

## Esempio scaffold (corretto)

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Schemas;

use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ProgressioniForm extends XotBaseResourceForm
{
    /**
     * @return array<string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            // TODO fase 2: spostare campi da ProgressioniResource::getFormSchema()
        ];
    }
}
```

## Copia metodi tabella Page → classe `*Table`: override utili vs inutili

Quando si sposta la configurazione tabella dalla Page `List*` alla classe `*Table` (estesa da `XotBaseResourceTable`, trait `HasXotTable`), copiare un metodo **solo se aggiunge logica custom** rispetto al default di `HasXotTable`/al parent.

### Conversioni obbligatorie nella copia

| Origine (Page) | Destinazione (`*Table`) |
| :--- | :--- |
| `getHeaderActions()` (header di pagina) | `getTableHeaderActions()` (cablato da `HasXotTable::table()`) |
| `$this->getModel()` | FQCN esplicito del model (es. `Rating::class`) — la classe Table non ha `getModel()` |
| `$this->tableFilters` | `$this->tableFilters ?? []` (null-safe); filtri annidati via `Arr::get($f, 'anno/valutatore')` |

- **Niente `#[Override]`** nella `*Table`: `XotBaseResourceTable` non dichiara questi metodi (eccetto `getTableColumns`).

### NON copiare (override inutile, viola DRY+KISS)

Un metodo è inutile e va **omesso** se equivale al comportamento ereditato:

```php
// ❌ Passthrough puro: identico al default del parent → NON aggiungerlo
public function getTableActions(): array
{
    return parent::getTableActions();
}

// ❌ Array vuoto: identico al default di HasXotTable (filters/bulk vuoti)
public function getTableFilters(): array
{
    return [];
}
```

**Regola generale:** copia un metodo nella `*Table` **iff** il corpo contiene azioni/colonne/filtri specifici. Se dopo la conversione resta solo `return parent::getTableXxx();` o `return [];`, **non** creare il metodo (il default lo fornisce già). Vale anche per `getTableHeaderActions`: il default `HasXotTable` fornisce già `create` + toggle layout, quindi un override va aggiunto solo per azioni aggiuntive/custom (import, populate, seeder, ecc.).

## Anti-pattern

```php
// ❌ Override passthrough inutile nella *Table
public function getTableActions(): array { return parent::getTableActions(); }

// ❌ Schema inline nella Resource dopo la migrazione completata
public static function getFormSchema(): array { return [ TextInput::make('foo') ]; }

// ❌ Label hardcoded
TextInput::make('name')->label('Nome');

// ❌ Array senza chiavi stringa
return [ TextColumn::make('name') ];

// ❌ Estendere Filament direttamente
class ProgressioniForm extends \Filament\Forms\Form { }
```

## Collegamenti

- [Xot – Filament v5 hybrid pattern](../../Xot/docs/wiki/concepts/filament-v5-hybrid-pattern.md)
- [Xot – array keys rule](../../Xot/docs/wiki/array-keys-rule.md)
- [Activity – schemas-tables pattern](../../Activity/docs/wiki/concepts/schemas-tables-pattern.md)
- [filament-resource-wire-assenze](./filament-resource-wire-assenze.md) — pilota fase 3
- [filament-resource-getpages-naming](./filament-resource-getpages-naming.md)
- [Xot — getpages-redundancy-rule](../../Xot/docs/filament/getpages-redundancy-rule.md)
- [Themes One – filament-resource-schemas-tables](../../../Themes/One/docs/filament-resource-schemas-tables.md)
- [Themes Zero – filament-resource-schemas-tables](../../../Themes/Zero/docs/filament-resource-schemas-tables.md)
- [Themes Three – filament-resource-schemas-tables](../../../Themes/Three/docs/filament-resource-schemas-tables.md)
- [Ptv — scheda-resource-pages-inheritance](../../Ptv/docs/scheda-resource-pages-inheritance.md) — `BaseSchedaForm`, `BaseSchedasTable` / pagine Scheda
- [bashscripts — populate-filament-schemas](../../../bashscripts/docs/progressioni/populate-filament-schemas.md)

*Ultimo aggiornamento: giugno 2025*
