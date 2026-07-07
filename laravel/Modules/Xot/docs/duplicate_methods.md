# Metodi duplicati — Xot

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **634**
- Metodi duplicati trovati: **194**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 162 | candidato a trait/helper |
| `__construct` | 44 | candidato a trait/helper |
| `handle` | 32 | candidato a trait/helper |
| `getFormSchema` | 30 | candidato a trait/helper |
| `getTableColumns` | 25 | candidato a trait/helper |
| `make` | 22 | candidato a trait/helper |
| `definition` | 16 | candidato a trait/helper |
| `setUp` | 16 | candidato a trait/helper |
| `view` | 15 | candidato a trait/helper |
| `create` | 14 | candidato a trait/helper |
| `update` | 14 | candidato a trait/helper |
| `delete` | 13 | candidato a trait/helper |
| `viewAny` | 13 | candidato a trait/helper |
| `forceDelete` | 12 | candidato a trait/helper |
| `getInfolistSchema` | 12 | candidato a trait/helper |
| `restore` | 12 | candidato a trait/helper |
| `getDefaultName` | 10 | candidato a trait/helper |
| `supports` | 10 | candidato a trait/helper |
| `up` | 10 | candidato a trait/helper |
| `casts` | 9 | candidato a trait/helper |

... altri 174 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
