# LLM Wiki Schema — FixCity

Questo file è il "AGENTS.md" della wiki: istruzioni per l'LLM su come mantenere la wiki.

---

## Regole Fondamentali

### R1 — Raw è Immutabile
I file in `docs/` (il "raw") **non vengono mai modificati** durante operazioni wiki.
Si leggono, si sintetizzano, si linkano. Mai editare direttamente.

### R2 — Wiki è Proprietà dell'LLM
I file in `docs/wiki/` vengono **creati e aggiornati** dall'LLM.
L'umano li può leggere e correggere, ma la manutenzione è delegata all'LLM.

### R3 — Log è Append-Only
`log.md` si aggiunge soltanto. Non si modificano voci precedenti.
Formato entry: `## [YYYY-MM-DD] Operazione — Descrizione`

### R4 — Index è la Porta d'Ingresso
`index.md` viene letto **per primo** in ogni sessione.
Ogni nuova pagina wiki **deve essere registrata** in `index.md`.

### R5 — Wikilink per Cross-Reference
Usare sintassi `[[PageName]]` o link markdown `[text](./path.md)`.
Ogni pagina deve avere almeno un link in entrata (niente pagine orfane).

### R6 — Una Pagina per Entità
No duplicati. Se esiste già una pagina per un concetto, aggiornarla.
Prima di creare una nuova pagina, cercare in `index.md`.

---

## Formato Pagina Wiki

```markdown
# Titolo Pagina

**Tipo:** [concept | guide | entity | architecture | decision]  
**Modulo/Tema:** [nome]  
**Ultimo aggiornamento:** YYYY-MM-DD  
**Raw sources:** [link ai file docs/ da cui è derivata]

---

## Sintesi

[2-5 righe: cosa è, perché esiste]

## Dettagli

[contenuto compilato — non copiare verbatim dal raw, sintetizzare]

## Decisioni Chiave

[se è una pagina architetturale — le decisioni prese e perché]

## Cross-Reference

- [[PageName]] — relazione
- [[OtherPage]] — relazione

## Domande Aperte

- [ ] domanda da investigare
```

---

## Workflow Ingest

Quando arriva un nuovo file in `docs/`:

```
1. Leggi il file sorgente
2. Cerca in index.md se esiste già una pagina wiki per questo topic
3a. Se esiste → aggiorna la pagina esistente con nuove informazioni
3b. Se non esiste → crea nuova pagina in docs/wiki/<category>/
4. Aggiorna index.md con il nuovo entry (o aggiorna quello esistente)
5. Aggiorna i cross-link nelle pagine wiki correlate
6. Appendi a log.md: "## [date] INGEST — <filename> → <wiki-page>"
```

---

## Workflow Query

```
1. Leggi index.md
2. Identifica le pagine wiki rilevanti
3. Leggi quelle pagine
4. Formula risposta con citazioni
5. Se la risposta è riutilizzabile → salva come nuova pagina wiki
6. Appendi a log.md: "## [date] QUERY — <topic> → <risposta-salvata o no>"
```

---

## Workflow Lint

```
1. Leggi index.md — lista tutte le pagine
2. Per ogni pagina:
   a. Verifica che i raw sources esistano ancora
   b. Verifica che i cross-link siano validi
   c. Cerca claim che contraddicono altri claim
3. Cerca pagine in wiki/ non registrate in index.md
4. Genera report in docs/wiki/lint-YYYY-MM-DD.md
5. Appendi a log.md: "## [date] LINT — <n> issues found"
```

---

## Categorie Wiki

Per il **root wiki** (`docs/wiki/`):

| Categoria     | Path                    | Contenuto                              |
|---------------|-------------------------|----------------------------------------|
| `concepts/`   | `wiki/concepts/`        | Concetti architetturali Laraxot/Xot    |
| `modules/`    | `wiki/modules/`         | Pagina sintetica per ogni modulo       |
| `themes/`     | `wiki/themes/`          | Pagina sintetica per ogni tema         |
| `guides/`     | `wiki/guides/`          | Guide compilate (how-to)               |
| `entities/`   | `wiki/entities/`        | Model, Service, Repository chiave      |
| `decisions/`  | `wiki/decisions/`       | Architectural Decision Records (ADR)   |

Per wiki di **modulo** (`Modules/<Name>/docs/wiki/`):

| File/Dir          | Contenuto                                   |
|-------------------|---------------------------------------------|
| `index.md`        | Indice del modulo                           |
| `overview.md`     | Panoramica, scopo, dipendenze               |
| `architecture.md` | Struttura interna, pattern usati            |
| `api.md`          | Interfacce pubbliche (Actions, Models, API) |
| `guides/`         | How-to specifici del modulo                 |
| `log.md`          | Log append-only del modulo                  |

---

## Stack FixCity — Vocabolario Wiki

Termini specifici del progetto da usare consistentemente:

| Termine          | Significato                                               |
|------------------|-----------------------------------------------------------|
| `Laraxot`        | Framework base, pattern architetturale                    |
| `XotBase*`       | Classi base (XotBaseModel, XotBaseAction, etc.)           |
| `Folio`          | Routing file-based Laravel (frontend)                     |
| `Filament`       | Panel admin (backend)                                     |
| `Volt`           | Componenti Livewire single-file                           |
| `Module`         | Unità funzionale in `laravel/Modules/`                    |
| `Theme`          | Presentazione in `laravel/Themes/`                        |
| `SSOT`           | Single Source of Truth — documento master per un topic    |
| `raw`            | File in `docs/` — sorgenti immutabili                     |
| `wiki`           | File in `docs/wiki/` — conoscenza compilata               |

---

## Note sul Contesto FixCity

- **13.174+ file raw** nei moduli — non si leggono tutti in una sessione
- **Molti archivi obsoleti** (Xot/archive/, Cms/archive/, etc.) — ignorarli nel lint
- **DRY**: niente duplicati — aggiornare SSOT esistente
- **Lingua**: documentazione mista italiano/inglese — accettabile
- **Modulo Xot** = base di tutto, compilare la sua wiki per prima
