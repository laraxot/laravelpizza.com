# Metodi duplicati — Tenant

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **76**
- Metodi duplicati trovati: **26**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 13 | candidato a trait/helper |
| `definition` | 11 | candidato a trait/helper |
| `active` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `getJsonFile` | 5 | candidato a trait/helper |
| `run` | 5 | candidato a trait/helper |
| `canResolve` | 4 | candidato a trait/helper |
| `getRows` | 4 | candidato a trait/helper |
| `getSushiRows` | 4 | candidato a trait/helper |
| `inactive` | 4 | candidato a trait/helper |
| `resolve` | 4 | candidato a trait/helper |
| `authId` | 2 | possibile duplicazione |
| `ensureDirectoryExists` | 2 | possibile duplicazione |
| `findRowIndexById` | 2 | possibile duplicazione |
| `getFormSchema` | 2 | possibile duplicazione |
| `getOriginalConfig` | 2 | possibile duplicazione |
| `getTenantConfig` | 2 | possibile duplicazione |
| `highPriority` | 2 | possibile duplicazione |
| `loadExistingData` | 2 | possibile duplicazione |
| `pending` | 2 | possibile duplicazione |

... altri 6 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
