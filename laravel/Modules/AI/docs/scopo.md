---
title: "AI — scopo e perche'"
type: concept
module: AI
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [scopo, ai, llm, proposte-azione, ollama]
qmd: "ai scopo perche assistenti llm proposte azione ollama ds4 thread senza mutare dati civici"
---

# AI — scopo e perche'

## Perche' esiste

Il modulo AI esiste per **assistere i maintainer e gli operatori con thread LLM, classificazione e proposte di azione**, senza mutare silenziosamente i dati di dominio degli altri moduli. Espone client (Ollama, DS4, OpenAI), modelli di conversazione (`AiThread`, `AiMessage`) e un registro di proposte (`AiActionProposal`) che richiedono conferma esplicita prima di qualsiasi side-effect.

In una riga:

> **AI e' il posto delle Actions e dei pannelli che parlano con un LLM; non e' il dominio ticket/cittadino, e non e' un server MCP.**

## Cosa e' (e cosa no)

| E' | Non e' |
|----|--------|
| Owner delle Actions AI in `app/Actions/` | Un server MCP (nel codice del modulo non c'e' MCP) |
| Proposte di azione con conferma | Un mutatore silenzioso di dati civici |
| Pannello Filament `ai/admin` | Una chat utente pubblica (manca l'UI di chat) |

Dettaglio verificato sul codice: [README.md](./README.md). Ownership Actions: [wiki/concepts/ollama-actions-ownership.md](./wiki/concepts/ollama-actions-ownership.md).

## Wave PHPStan

Ground truth errori della lane: `.cursor-scratch/phpstan-wave/AI.tsv` (coordinator-owned). Non rilanciare `analyse Modules` dalla lane. Coordinamento docs: [stories/phpstan-wave-coord.story.md](./stories/phpstan-wave-coord.story.md). Lane implementativa: [stories/phpstan-ai-swarm-wave.story.md](./stories/phpstan-ai-swarm-wave.story.md). Wave2 costanti: [stories/phpstan-wave2-constant-type-coverage.story.md](./stories/phpstan-wave2-constant-type-coverage.story.md) (`analyse Modules/AI` → 0).

## Collegamenti

- [00-INDEX.md](./00-index.md) — indice canonico
- [wiki/scopo.md](./wiki/scopo.md) — nota BMAD breve (rimanda qui)
- [Lang — scopo](../../Lang/docs/scopo.md) · [User — scopo](../../User/docs/scopo.md)
