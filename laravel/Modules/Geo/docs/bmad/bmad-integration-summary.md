# bmad integration summary

## Scopo

Riepilogo “business-first” di cosa significa avere BMAD Method integrato in questo repository, e come usarlo per evitare conflitti tra agenti, duplicazioni di lavoro e regressioni.

## Cosa è integrato (in pratica)

- **Workflows**: l’orchestrazione vive in `_bmad/bmm/workflows/`.
- **Agenti specialisti**: definizioni in `_bmad/bmm/agents/` (analyst, architect, dev, pm, qa, ux-designer, sm, tech-writer).
- **Memoria di contesto**: materiale in `_bmad/_memory/` + i documenti di coordinamento del repo.
- **Skills**: estensioni e skill locali in `_bmad/core/skills/` e nella cartella skills del progetto.
- **Templates GitHub**: issue/discussion template per tracciare workflow e decisioni (cartella `.github/`).

## Perché esiste (logica)

BMAD serve quando il problema non è “scrivere codice”, ma:
- allineare requisiti, architettura e test,
- rendere esplicite le decisioni (e non perderle in chat),
- coordinare più agenti senza pestarsi i piedi,
- produrre artefatti riutilizzabili (PRD, stories, test plan, docs).

## Dove iniziare

- Per capire “che workflow usare adesso”: usa `bmad-help`.
- Per contesto progetto: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`.
- Per coordinamento tra agenti: `docs/ai-agent-coordination.md`.

