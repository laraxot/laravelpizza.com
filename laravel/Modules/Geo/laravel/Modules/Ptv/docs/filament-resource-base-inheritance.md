# Filament Resource — ereditarietà Base* (moduli figli)

## Scopo

Quando un modulo figlio (Progressioni, Performance, Indennita*, Incentivi) riusa una Filament Resource definita in **Ptv**, non deve estendere la classe **concreta** Ptv. Deve estendere la classe **astratta** `Base*` nel namespace Ptv, impostando solo `$model` e override mirati.

**Perché:** la classe concreta Ptv è il binding del modulo Ptv (modello, panel, pages Ptv). I figli condividono la logica comune dalla base astratta senza accoppiarsi all'istanza Ptv.

## Regola generale

| Livello | Ptv | Modulo figlio |
| :--- | :--- | :--- |
| Resource | `Base{Entity}Resource` (abstract) + `{Entity}Resource` (thin) | `{Entity}Resource extends Base{Entity}Resource` + `$model` modulo |
| Page | `BaseList{Plural}` / `BaseCreate{Entity}` / … (abstract) | `List{Plural} extends BaseList{Plural}` + `$resource` modulo |
| Table / Form / Infolist | `Base{Entities}Table` / `Base{Entity}Form` / … | thin extends base Ptv; override solo se UI diversa |

### Workflow

1. Esiste già `Base*` in Ptv → il figlio estende **solo** quella.
2. Non esiste `Base*` ma più moduli estendono la concreta Ptv → estrarre `Base*` in Ptv, rendere thin la concreta Ptv, aggiornare i figli.
3. Override nel figlio **solo** per differenze reali (`$model`, `getPages()`, schema/campi extra).

### Anti-pattern

```php
// ❌ Figlio su concreta Ptv
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource as PtvCriteriEsclusioneResource;
class CriteriEsclusioneResource extends PtvCriteriEsclusioneResource {}

// ❌ Figlio su page concreta Ptv
class ListCriteriEsclusiones extends PtvListCriteriEsclusiones {}

// ✅ Figlio su base astratta Ptv
use Modules\Ptv\Filament\Resources\BaseCriteriEsclusioneResource;
class CriteriEsclusioneResource extends BaseCriteriEsclusioneResource
{
    protected static ?string $model = CriteriEsclusione::class;
}
```

## Base* esistenti in Ptv

| Resource | Base Resource | Base Pages | Base Table / Form |
| :--- | :--- | :--- | :--- |
| Scheda | `BaseSchedaResource` | `BaseListSchedas`, `BaseCreateScheda`, `BaseEditScheda` | `BaseSchedasTable`, `BaseSchedaForm`, `BaseSchedaInfolist` |
| CriteriEsclusione | `BaseCriteriEsclusioneResource` | `BaseListCriteriEsclusiones`, `BaseCreate/EditCriteriEsclusione` | `BaseCriteriEsclusionesTable`, `BaseCriteriEsclusioneForm`, `BaseCriteriEsclusioneInfolist` |
| StabiDirigente | `BaseStabiDirigenteResource` | `BaseListStabiDirigentes`, `BaseCreate/EditStabiDirigente` | (schemas in fase 2) |
| Message | `BaseMessageResource` | `BaseListMessages`, `BaseCreate/EditMessage` | (schemas in fase 2) |
| MyLog | `BaseMyLogResource` | `BaseListMyLogs`, `BaseViewMyLog` | (schemas in fase 2) |
| Option | `BaseOptionResource` | `BaseListOptions`, `BaseCreate/EditOption` | (schemas in fase 2) |

## Audit moduli figli

Vedi [filament-resource-base-inheritance-audit.md](./filament-resource-base-inheritance-audit.md) per lo stato delle correzioni e le eccezioni residue.

## Collegamenti

- [Scheda — ereditarietà pagine](./scheda-resource-pages-inheritance.md)
- [Progressioni — schemas/tables](../../Progressioni/docs/filament-resource-schemas-tables.md)
- [Regola cursor scheda-resource-pages-inheritance](../../../.cursor/rules/scheda-resource-pages-inheritance.mdc)
