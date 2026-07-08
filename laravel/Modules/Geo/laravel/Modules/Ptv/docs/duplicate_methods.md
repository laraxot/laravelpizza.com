# Metodi duplicati — Ptv

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **286**
- Metodi duplicati trovati: **51**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 65 | candidato a trait/helper |
| `setUp` | 38 | candidato a trait/helper |
| `getDefaultName` | 28 | candidato a trait/helper |
| `definition` | 13 | candidato a trait/helper |
| `getTableColumns` | 11 | candidato a trait/helper |
| `getFormSchema` | 10 | candidato a trait/helper |
| `getHeaderActions` | 10 | candidato a trait/helper |
| `casts` | 9 | candidato a trait/helper |
| `getTableFilters` | 9 | candidato a trait/helper |
| `getSchema` | 8 | candidato a trait/helper |
| `make` | 8 | candidato a trait/helper |
| `mount` | 8 | candidato a trait/helper |
| `appendColumns` | 7 | candidato a trait/helper |
| `getTableBulkActions` | 6 | candidato a trait/helper |
| `getTableActions` | 5 | candidato a trait/helper |
| `up` | 5 | candidato a trait/helper |
| `__construct` | 4 | candidato a trait/helper |
| `getPages` | 4 | candidato a trait/helper |
| `save` | 4 | candidato a trait/helper |
| `schede` | 4 | candidato a trait/helper |

... altri 31 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
