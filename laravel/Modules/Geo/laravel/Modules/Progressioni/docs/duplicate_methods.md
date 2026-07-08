# Metodi duplicati — Progressioni

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **445**
- Metodi duplicati trovati: **54**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `definition` | 19 | candidato a trait/helper |
| `getHeaderActions` | 19 | candidato a trait/helper |
| `getPages` | 19 | candidato a trait/helper |
| `getTableColumns` | 19 | candidato a trait/helper |
| `getFormSchema` | 18 | candidato a trait/helper |
| `populateFromLastYear` | 14 | candidato a trait/helper |
| `setUp` | 8 | candidato a trait/helper |
| `execute` | 7 | candidato a trait/helper |
| `up` | 7 | candidato a trait/helper |
| `getDefaultName` | 6 | candidato a trait/helper |
| `checkGgCatecoPosfunNoAsz` | 4 | candidato a trait/helper |
| `findStabi0` | 4 | candidato a trait/helper |
| `forAnno` | 4 | candidato a trait/helper |
| `getRelations` | 4 | candidato a trait/helper |
| `schede` | 4 | candidato a trait/helper |
| `syncProgressioniRepQua` | 4 | candidato a trait/helper |
| `trovaEsclusi` | 4 | candidato a trait/helper |
| `xlsProgressioni` | 4 | candidato a trait/helper |
| `__construct` | 3 | candidato a trait/helper |
| `getTableActions` | 3 | candidato a trait/helper |

... altri 34 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
