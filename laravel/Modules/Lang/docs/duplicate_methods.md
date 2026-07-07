# Metodi duplicati — Lang

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **87**
- Metodi duplicati trovati: **32**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 11 | candidato a trait/helper |
| `getHeaderActions` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `getFormSchema` | 4 | candidato a trait/helper |
| `render` | 4 | candidato a trait/helper |
| `run` | 4 | candidato a trait/helper |
| `up` | 4 | candidato a trait/helper |
| `changeLanguage` | 3 | candidato a trait/helper |
| `create` | 3 | candidato a trait/helper |
| `definition` | 3 | candidato a trait/helper |
| `delete` | 3 | candidato a trait/helper |
| `forceDelete` | 3 | candidato a trait/helper |
| `getLanguageFromPath` | 3 | candidato a trait/helper |
| `getLanguageUrl` | 3 | candidato a trait/helper |
| `getTranslatableLocales` | 3 | candidato a trait/helper |
| `restore` | 3 | candidato a trait/helper |
| `setUp` | 3 | candidato a trait/helper |
| `update` | 3 | candidato a trait/helper |
| `view` | 3 | candidato a trait/helper |
| `viewAny` | 3 | candidato a trait/helper |

... altri 12 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
