# Metodi duplicati — Performance

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **367**
- Metodi duplicati trovati: **65**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 32 | candidato a trait/helper |
| `up` | 30 | candidato a trait/helper |
| `getTableColumns` | 24 | candidato a trait/helper |
| `getPages` | 20 | candidato a trait/helper |
| `getHeaderActions` | 19 | candidato a trait/helper |
| `getTableFilters` | 17 | candidato a trait/helper |
| `getFormSchema` | 16 | candidato a trait/helper |
| `down` | 15 | candidato a trait/helper |
| `casts` | 12 | candidato a trait/helper |
| `definition` | 12 | candidato a trait/helper |
| `getTableActions` | 11 | candidato a trait/helper |
| `getTableBulkActions` | 11 | candidato a trait/helper |
| `__construct` | 10 | candidato a trait/helper |
| `viewAny` | 8 | candidato a trait/helper |
| `update` | 7 | candidato a trait/helper |
| `delete` | 6 | candidato a trait/helper |
| `massMail` | 6 | candidato a trait/helper |
| `pdfIndividualeStabiRepar` | 6 | candidato a trait/helper |
| `setUp` | 6 | candidato a trait/helper |
| `view` | 6 | candidato a trait/helper |

... altri 45 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
