---
id: module-ai-readme
title: "AI — Integrazioni LLM e Agenti"
type: module-readme
category: module-documentation
module: AI
status: active
tags: [ai, llm, mcp, actions, agents]
created: 2026-09-14
updated: 2026-09-14
qmd: "AI MCP LLM actions agents prompt context module documentation"
issues:
  - "https://github.com/laraxot/module_ai_fila5/issues/23"
discussions:
  - "https://github.com/laraxot/module_ai_fila5/discussions/24"
related:
  - "./docs/"
sources: []
---

# 🤖 AI

> **Integrazioni AI, MCP e automazioni assistite.**

Connettori, Actions AI, prompt e tooling con guardrail espliciti.

## Cosa offre

- **MCP e connettori**
- **Actions in app/Actions**
- **prompt e contesto**
- **Notify/Xot**

## Confini architetturali

Questo modulo possiede le responsabilità elencate sopra e pubblica contratti riusabili agli altri moduli. La logica applicativa vive in Actions del modulo; l’interfaccia amministrativa segue le basi Laraxot/XotBase. Le dipendenze verso altri moduli devono restare esplicite e orientate verso contratti stabili.

## Integrazione rapida

Il modulo è caricato dall’architettura modulare Laraxot. Per verificarne lo stato:

````bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/AI
````

Per i test e le convenzioni operative, consultare la documentazione locale prima di introdurre nuove integrazioni.

## Documentazione

La mappa tecnica è in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Le modifiche devono mantenere `declare(strict_types=1);` nel codice PHP, rispettare PHPStan configurato dal progetto e aggiornare la documentazione tecnica quando cambiano contratti, dipendenze o flussi. Le story BMAD restano accanto al codice del modulo per conservare ownership e contesto.

---

**Modulo** `ai` · **Laraxot ecosystem** · **Project-agnostic**
