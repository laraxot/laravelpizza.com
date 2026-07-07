# Metodi duplicati — Job

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **211**
- Metodi duplicati trovati: **45**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getTableColumns` | 21 | candidato a trait/helper |
| `getFormSchema` | 19 | candidato a trait/helper |
| `casts` | 15 | candidato a trait/helper |
| `definition` | 15 | candidato a trait/helper |
| `up` | 13 | candidato a trait/helper |
| `update` | 11 | candidato a trait/helper |
| `__construct` | 10 | candidato a trait/helper |
| `getInfolistSchema` | 9 | candidato a trait/helper |
| `execute` | 8 | candidato a trait/helper |
| `create` | 7 | candidato a trait/helper |
| `delete` | 7 | candidato a trait/helper |
| `view` | 7 | candidato a trait/helper |
| `viewAny` | 7 | candidato a trait/helper |
| `getRelations` | 6 | candidato a trait/helper |
| `getHeaderActions` | 5 | candidato a trait/helper |
| `getPages` | 5 | candidato a trait/helper |
| `forceDelete` | 4 | candidato a trait/helper |
| `getTableActions` | 4 | candidato a trait/helper |
| `getTableBulkActions` | 4 | candidato a trait/helper |
| `getTags` | 4 | candidato a trait/helper |

... altri 25 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
