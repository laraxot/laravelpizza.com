# Metodi duplicati — Sigma

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **930**
- Metodi duplicati trovati: **178**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `up` | 281 | candidato a trait/helper |
| `down` | 279 | candidato a trait/helper |
| `definition` | 262 | candidato a trait/helper |
| `annFieldName` | 9 | candidato a trait/helper |
| `rangeFromField` | 9 | candidato a trait/helper |
| `rangeToField` | 9 | candidato a trait/helper |
| `casts` | 8 | candidato a trait/helper |
| `execute` | 8 | candidato a trait/helper |
| `getCategoriaEcoAttribute` | 6 | candidato a trait/helper |
| `getGgAttribute` | 6 | candidato a trait/helper |
| `enteField` | 5 | candidato a trait/helper |
| `matrField` | 5 | candidato a trait/helper |
| `codici` | 4 | candidato a trait/helper |
| `getCognomeAttribute` | 4 | candidato a trait/helper |
| `getNomeAttribute` | 4 | candidato a trait/helper |
| `getPosizTxtAttribute` | 4 | candidato a trait/helper |
| `gg` | 4 | candidato a trait/helper |
| `giorni` | 4 | candidato a trait/helper |
| `scopeOfYear` | 4 | candidato a trait/helper |
| `scopeWithDays` | 4 | candidato a trait/helper |

... altri 158 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
