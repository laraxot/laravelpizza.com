# Metodi duplicati — IndennitaCondizioniLavoro

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **209**
- Metodi duplicati trovati: **43**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `aggiornaPerc` | 16 | candidato a trait/helper |
| `aggiornaTot` | 16 | candidato a trait/helper |
| `getHeaderActions` | 8 | candidato a trait/helper |
| `getFormSchema` | 6 | candidato a trait/helper |
| `indennitaTipoDettaglio` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `create` | 5 | candidato a trait/helper |
| `delete` | 5 | candidato a trait/helper |
| `forceDelete` | 5 | candidato a trait/helper |
| `getTableColumns` | 5 | candidato a trait/helper |
| `getTotAttribute` | 5 | candidato a trait/helper |
| `restore` | 5 | candidato a trait/helper |
| `update` | 5 | candidato a trait/helper |
| `view` | 5 | candidato a trait/helper |
| `viewAny` | 5 | candidato a trait/helper |
| `annFieldName` | 4 | candidato a trait/helper |
| `compila` | 4 | candidato a trait/helper |
| `definition` | 4 | candidato a trait/helper |
| `getPages` | 4 | candidato a trait/helper |
| `getTotXPtimeAttribute` | 4 | candidato a trait/helper |

... altri 23 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
