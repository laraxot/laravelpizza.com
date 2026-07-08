# Metodi duplicati — IndennitaResponsabilita

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **201**
- Metodi duplicati trovati: **35**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `update` | 14 | candidato a trait/helper |
| `create` | 13 | candidato a trait/helper |
| `delete` | 13 | candidato a trait/helper |
| `forceDelete` | 13 | candidato a trait/helper |
| `restore` | 13 | candidato a trait/helper |
| `view` | 13 | candidato a trait/helper |
| `viewAny` | 13 | candidato a trait/helper |
| `definition` | 9 | candidato a trait/helper |
| `getPages` | 8 | candidato a trait/helper |
| `compila` | 7 | candidato a trait/helper |
| `execute` | 7 | candidato a trait/helper |
| `getFormSchema` | 7 | candidato a trait/helper |
| `__construct` | 6 | candidato a trait/helper |
| `getTableColumns` | 6 | candidato a trait/helper |
| `getTableFilters` | 6 | candidato a trait/helper |
| `up` | 6 | candidato a trait/helper |
| `getEloquentQuery` | 4 | candidato a trait/helper |
| `getHeaderActions` | 4 | candidato a trait/helper |
| `aggiornaTot` | 3 | candidato a trait/helper |
| `casts` | 3 | candidato a trait/helper |

... altri 15 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
