# Scheda Resource — ereditarietà pagine Filament

## Scopo

Le pagine CRUD delle risorse che estendono `BaseSchedaResource` (Ptv, Progressioni, Performance) condividono comportamento tramite classi base nel modulo **Ptv**. Evita duplicazione e mantiene allineati list/create/edit tra moduli.

## Regola

### Pagine

| Classe concreta nel modulo | Deve estendere (namespace Ptv) | Non estendere |
| :--- | :--- | :--- |
| `ListSchedas` | `Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseListSchedas` | `XotBaseListRecords` |
| `EditScheda` | `BaseEditScheda` | `XotBaseEditRecord`, `EditRecord` |
| `CreateScheda` | `BaseCreateScheda` | `XotBaseCreateRecord`, `CreateRecord` |

### Tabelle

| Classe concreta nel modulo | Deve estendere (namespace Ptv) | Non estendere |
| :--- | :--- | :--- |
| `SchedasTable` | `Modules\Ptv\Filament\Resources\SchedaResource\Tables\BaseSchedasTable` | `XotBaseResourceTable` |

### Form

| Classe concreta nel modulo | Deve estendere (namespace Ptv) | Non estendere |
| :--- | :--- | :--- |
| `SchedaForm` | `Modules\Ptv\Filament\Resources\SchedaResource\Schemas\BaseSchedaForm` | `XotBaseResourceForm` |

### Infolist

| Classe concreta nel modulo | Deve estendere (namespace Ptv) | Non estendere |
| :--- | :--- | :--- |
| `SchedaInfolist` | `Modules\Ptv\Filament\Resources\SchedaResource\Schemas\BaseSchedaInfolist` | `XotBaseResourceInfolist` |

La classe concreta imposta solo `protected static string $resource` sulla propria Resource (pagine) e, se serve, override di `getTable*()` (pagine o `SchedasTable`), `getFormSchema()` (`SchedaForm`) o `getInfolistSchema()` (`SchedaInfolist`).

## Naming index

`XotBaseResource::getPages()` risolve l'index come `List{plural}` → per `SchedaResource` la page è **`ListSchedas`**, non `ListScheda`.

`ListScheda` in Ptv resta come alias thin per Performance (`ListIndividuales`, `ListOrganizzativas`, …) che estendono `ListScheda` → `BaseListSchedas`.

## Moduli

### Ptv

- `ListSchedas` — override colonne flat e azioni tabella
- `ListScheda` — thin wrapper su `BaseListSchedas`
- `EditScheda` / `CreateScheda` — thin su base Ptv
- `SchedasTable` — thin su `BaseSchedasTable` (default Ptv)
- `SchedaForm` — thin su `BaseSchedaForm` (default Ptv)
- `SchedaInfolist` — thin su `BaseSchedaInfolist` (default Ptv)

### Progressioni

- `ListSchedas` — override completo di header, colonne, filtri e bulk (template email `progressioni-{anno}`); `getHeaderWidgets()` vuoto (no widget firma Ptv)
- `SchedasTable` — estende `Ptv\BaseSchedasTable`; colonne/bulk Progressioni; filtri vuoti (fino al wire fase 3 su `ListSchedas`)
- `SchedaForm` — estende `Ptv\BaseSchedaForm`; schema flat campi progressioni (override completo `getFormSchema()`)
- `SchedaInfolist` — estende `Ptv\BaseSchedaInfolist`; schema flat campi progressioni (override completo `getInfolistSchema()`)
- `ListScheda.php` — **rimosso** (duplicato)
- `EditScheda` — `BaseEditScheda` + `DeleteAction` in header

### Performance

- `ListIndividuales`, `ListOrganizzativas`, `ListIndividualeAdms` estendono `Ptv\ListScheda` → ereditano `BaseListSchedas` senza modifiche aggiuntive

## Override consigliato (Progressioni vs Ptv)

Quando un modulo ha UI lista diversa dalla base Ptv, estendere `BaseListSchedas` e sovrascrivere esplicitamente:

- `getHeaderActions()`
- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getHeaderWidgets()` se non si vogliono i widget Ptv

## Anti-pattern

```php
// ❌ ERRATO
class ListSchedas extends XotBaseListRecords { }

// ❌ ERRATO
class CreateScheda extends CreateRecord { }

// ✅ CORRETTO
class ListSchedas extends BaseListSchedas
{
    protected static string $resource = SchedaResource::class;
}
```

## Collegamenti

- [scheda-contract-inheritance.md](./wiki/concepts/scheda-contract-inheritance.md) — modello e `BaseSchedaResource`
- [Progressioni — getPages naming](../../Progressioni/docs/filament-resource-getpages-naming.md)
- [Progressioni — filament-resource-schemas-tables](../../Progressioni/docs/filament-resource-schemas-tables.md) — `SchedasTable` → `BaseSchedasTable`
- [filament-resources.md](./filament-resources.md)

*Ultimo aggiornamento: giugno 2025*
