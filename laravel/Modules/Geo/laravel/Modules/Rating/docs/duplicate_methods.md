# Metodi duplicati — Rating

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **79**
- Metodi duplicati trovati: **35**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getTableColumns` | 6 | candidato a trait/helper |
| `up` | 5 | candidato a trait/helper |
| `getFormSchema` | 4 | candidato a trait/helper |
| `ratings` | 4 | candidato a trait/helper |
| `casts` | 3 | candidato a trait/helper |
| `create` | 3 | candidato a trait/helper |
| `execute` | 3 | candidato a trait/helper |
| `getActions` | 3 | candidato a trait/helper |
| `run` | 3 | candidato a trait/helper |
| `__construct` | 2 | possibile duplicazione |
| `delete` | 2 | possibile duplicazione |
| `dislikedBy` | 2 | possibile duplicazione |
| `down` | 2 | possibile duplicazione |
| `forceDelete` | 2 | possibile duplicazione |
| `fromArray` | 2 | possibile duplicazione |
| `getInfolistSchema` | 2 | possibile duplicazione |
| `getLabel` | 2 | possibile duplicazione |
| `getMyRatingAttribute` | 2 | possibile duplicazione |
| `getPages` | 2 | possibile duplicazione |
| `getRatingsAvgAttribute` | 2 | possibile duplicazione |

... altri 15 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
