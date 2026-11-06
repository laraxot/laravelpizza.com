---
title: "MCP consigliati: modulo Xot / monorepo PTVX"
type: note
status: active
created: 2026-09-24
updated: 2026-10-21
module: Xot
tags: [xot, mcp, context7, playwright, laravel-boost, qmd]
qmd: "mcp consigliati xot ptvx lean stack context7 playwright laravel-boost qmd skip filesystem fetch"
related:
  - ./mcp-errors-and-lessons.md
  - ./mcp-integration.md
  - ../../../../docs/wiki/how-to/mcp-minimum-stack.md
  - ../../../.mcp.json
---

# MCP consigliati (Xot / PTVX)

## Scopo

Xot e' il modulo base: Actions, Filament XotBase*, contratti, gate qualita'.
Gli MCP devono **aumentare accuratezza** (docs Laravel/Filament aggiornate, UI
verificata, second brain) senza gonfiare il contesto.

SSoT config: [`.mcp.json`](../../../.mcp.json) · how-to:
[mcp-minimum-stack](../../../../docs/wiki/how-to/mcp-minimum-stack.md).

## Consigliati (attivi)

| Server | Perche' per Xot |
|--------|-----------------|
| **laravel-boost** | Docs e search sul codice Laravel del monorepo |
| **context7** | API Filament 5 / Laravel 13 / Pest aggiornate (niente API inventate) |
| **qmd** | Memoria BMAD/wiki moduli; preferire `search` a `query` su CPU |
| **playwright** | Verifica pagine Filament / widget dopo cambi XotBase* |
| **token-optimizer** | Sessioni lunghe e swarm PHPStan |

## Opt-in

| Server | Quando |
|--------|--------|
| **github** HTTP ufficiale | PR/issue strutturati oltre `gh` |
| **chrome-devtools** | Performance FE / console (plugin Cursor ECC gia' spesso presente) |
| **firecrawl** | Crawl docs esterne (serve `FIRECRAWL_API_KEY`) |
| **sentry** | Incident produzione |

## Vietati / inutili qui

Non aggiungere per Xot:

- `filesystem`, `fetch`, `memory`, `sequential-thinking`: Cursor li ha gia'
- `puppeteer`: usare Playwright
- MCP Postgres su DB reali: dati sacri; solo `*_test` via Pest

## Config minima (gia' in root)

Non duplicare JSON nei moduli. Se un agente chiede "quali MCP?", punta a
`.mcp.json` e a questo file per il **perche'**, non per una seconda config.
