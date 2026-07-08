# Metodi duplicati — Pdnd

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **111**
- Metodi duplicati trovati: **83**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `__construct` | 72 | candidato a trait/helper |
| `toArray` | 63 | candidato a trait/helper |
| `fromArray` | 60 | candidato a trait/helper |
| `getForms` | 8 | candidato a trait/helper |
| `getPdndFormActions` | 8 | candidato a trait/helper |
| `pdndForm` | 8 | candidato a trait/helper |
| `perCodiceFiscale` | 8 | candidato a trait/helper |
| `send` | 8 | candidato a trait/helper |
| `canAccess` | 7 | candidato a trait/helper |
| `isValidDataFormat` | 6 | candidato a trait/helper |
| `perIdAnpr` | 6 | candidato a trait/helper |
| `generateOperationId` | 5 | candidato a trait/helper |
| `getStatus` | 5 | candidato a trait/helper |
| `hasSoggetti` | 5 | candidato a trait/helper |
| `cercaPerCodiceFiscale` | 4 | candidato a trait/helper |
| `count` | 4 | candidato a trait/helper |
| `extractAnomalieData` | 4 | candidato a trait/helper |
| `extractErroriData` | 4 | candidato a trait/helper |
| `extractSoggettiData` | 4 | candidato a trait/helper |
| `getNumeroErrori` | 4 | candidato a trait/helper |

... altri 63 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
