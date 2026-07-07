# Metodi duplicati — Gdpr

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **101**
- Metodi duplicati trovati: **25**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `getFormSchema` | 14 | candidato a trait/helper |
| `getTableColumns` | 12 | candidato a trait/helper |
| `up` | 8 | candidato a trait/helper |
| `execute` | 7 | candidato a trait/helper |
| `getInfolistSchema` | 6 | candidato a trait/helper |
| `getPages` | 6 | candidato a trait/helper |
| `create` | 4 | candidato a trait/helper |
| `definition` | 4 | candidato a trait/helper |
| `delete` | 4 | candidato a trait/helper |
| `forceDelete` | 4 | candidato a trait/helper |
| `restore` | 4 | candidato a trait/helper |
| `update` | 4 | candidato a trait/helper |
| `view` | 4 | candidato a trait/helper |
| `viewAny` | 4 | candidato a trait/helper |
| `booted` | 3 | candidato a trait/helper |
| `getRelations` | 3 | candidato a trait/helper |
| `canView` | 2 | possibile duplicazione |
| `getOptionalConsentTypes` | 2 | possibile duplicazione |
| `getRequiredConsentTypes` | 2 | possibile duplicazione |
| `getView` | 2 | possibile duplicazione |

... altri 5 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
