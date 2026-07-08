# Audit — ereditarietà Base* Filament Resource

## Scopo

Tracciare lo stato di allineamento alla [regola Base*](../filament-resource-base-inheritance.md) nei moduli figli.

## Corretto (2026-06)

### Resource

| Modulo | Classe | Estende |
| :--- | :--- | :--- |
| Progressioni | `CriteriEsclusioneResource` | `BaseCriteriEsclusioneResource` |
| Progressioni | `MessageResource` | `BaseMessageResource` |
| Progressioni | `SchedaResource` | `BaseSchedaResource` |
| Performance | `CriteriEsclusioneResource` | `BaseCriteriEsclusioneResource` |
| Performance | `CriteriOptionResource` | `BaseCriteriOptionResource` |
| Performance | `OptionResource` | `BaseOptionResource` |
| Performance | `StabiDirigenteResource` | `BaseStabiDirigenteResource` |
| IndennitaResponsabilita | `MessageResource`, `MyLogResource`, `StabiDirigenteResource` | rispettive `Base*` |
| IndennitaCondizioniLavoro | `StabiDirigenteResource` | `BaseStabiDirigenteResource` |
| Incentivi | `StabiDirigenteResource` | `BaseStabiDirigenteResource` |

### Pages (campione)

Pagine CRUD che estendevano classi **concrete** Ptv sono state migrate su `Base*` per: CriteriEsclusione, StabiDirigente, Message, MyLog, Option, CriteriOption (Performance + Indennita*).

## Eccezioni ammesse

| Pattern | Motivo |
| :--- | :--- |
| `extends PtvBaseYearListRecords` | Base condivisa per filtro anno; non è una page concreta di una singola resource |
| `ListScheda` thin → `BaseListSchedas` | Alias Performance; vedi [scheda-resource-pages-inheritance](../scheda-resource-pages-inheritance.md) |
| List page con UI totalmente custom (es. `Incentivi\ListStabiDirigentes`) | Non riusa list Ptv; estende `XotBaseListRecords` |

## Da valutare (prossimo giro)

- `Performance\ListScheda` / `ListIndividuales` — già su catena `ListScheda` → `BaseListSchedas` (OK)
- Modelli Eloquent `extends Ptv\Model` — regola separata ([eloquent-inheritance](../../../docs/wiki/patterns/eloquent-inheritance.md))
- Resource Progressioni solo-locali senza controparte Ptv — nessuna `Base*` richiesta

## Collegamenti

- [filament-resource-base-inheritance.md](../filament-resource-base-inheritance.md)
- [scheda-resource-pages-inheritance.md](../scheda-resource-pages-inheritance.md)
