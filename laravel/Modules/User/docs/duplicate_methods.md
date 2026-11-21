# Metodi duplicati — User

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **887**
- Metodi duplicati trovati: **158**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getFormSchema` | 109 | candidato a trait/helper |
| `getTableColumns` | 76 | candidato a trait/helper |
| `getInfolistSchema` | 63 | candidato a trait/helper |
| `up` | 59 | candidato a trait/helper |
| `__construct` | 49 | candidato a trait/helper |
| `execute` | 39 | candidato a trait/helper |
| `definition` | 38 | candidato a trait/helper |
| `getHeaderActions` | 31 | candidato a trait/helper |
| `mount` | 31 | candidato a trait/helper |
| `update` | 29 | candidato a trait/helper |
| `delete` | 28 | candidato a trait/helper |
| `create` | 27 | candidato a trait/helper |
| `view` | 25 | candidato a trait/helper |
| `viewAny` | 25 | candidato a trait/helper |
| `getPages` | 24 | candidato a trait/helper |
| `handle` | 24 | candidato a trait/helper |
| `casts` | 22 | candidato a trait/helper |
| `forceDelete` | 21 | candidato a trait/helper |
| `restore` | 21 | candidato a trait/helper |
| `getTableActions` | 19 | candidato a trait/helper |

... altri 138 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
