# Metodi duplicati — Incentivi

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **149**
- Metodi duplicati trovati: **44**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getHeaderActions` | 22 | candidato a trait/helper |
| `getFormSchema` | 16 | candidato a trait/helper |
| `getTableColumns` | 16 | candidato a trait/helper |
| `create` | 13 | candidato a trait/helper |
| `up` | 13 | candidato a trait/helper |
| `update` | 13 | candidato a trait/helper |
| `delete` | 12 | candidato a trait/helper |
| `getDefaultName` | 12 | candidato a trait/helper |
| `setUp` | 12 | candidato a trait/helper |
| `view` | 12 | candidato a trait/helper |
| `viewAny` | 12 | candidato a trait/helper |
| `definition` | 10 | candidato a trait/helper |
| `getTableActions` | 10 | candidato a trait/helper |
| `getPages` | 9 | candidato a trait/helper |
| `getRelations` | 8 | candidato a trait/helper |
| `casts` | 6 | candidato a trait/helper |
| `run` | 6 | candidato a trait/helper |
| `project` | 5 | candidato a trait/helper |
| `table` | 5 | candidato a trait/helper |
| `employees` | 4 | candidato a trait/helper |

... altri 24 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
