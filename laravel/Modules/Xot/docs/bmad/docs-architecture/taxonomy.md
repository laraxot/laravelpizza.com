---
title: "Documentation taxonomy"
type: rule
status: active
updated: 2026-10-13
tags: [documentation, taxonomy, naming, qmd]
qmd: "documentation taxonomy canonical folders naming status"
---

# Tassonomia

| Cartella | Scopo | Autorità |
|---|---|---|
| `architecture/` | struttura, confini e flussi stabili | architettura |
| `wiki/` | concetti, regole e how-to riusabili | conoscenza operativa |
| `bmad/` | PRD, brief, UX, architetture e decisioni di iniziativa | BMAD |
| `stories/` | una unità implementabile con AC e verifica | BMAD delivery |
| `investigation/` | sintomi, prove e ipotesi non ancora decisioni | evidenza diagnostica |
| `reports/`, `visual-parity/` | risultati misurati, con data e viewport | evidenza verificata |
| `raw/`, `sources/`, `screenshots/` | input o output grezzo | non canonica |
| `prompts/` | istruzioni ripetibili per agenti | operativa |
| `decision-log.md` | registro append-only delle decisioni locali | decisioni |

I documenti in `raw/`, `sources/` e `screenshots/` non devono essere citati come
regole. Un report diventa canonico solo quando è collegato da una story o da un
indice e contiene data, ambiente, sorgente e risultato.

## Naming

I nuovi file sono lowercase kebab-case, con front matter YAML e senza timestamp,
ma le story e gli evidence report possono mantenere l'identificativo BMAD o la
data richiesta dalla loro convenzione. I file storici con maiuscole, underscore,
`-1` o `-old` non vengono rinominati in massa: sono indicizzati come legacy o
marcati `superseded` solo dopo verifica dei link.
