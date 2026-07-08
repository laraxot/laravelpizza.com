---
title: "Inter-agent — errore API 131072 vs richiesta ~796k token"
type: chat-trace
status: open
tags: [context-window, mcp, cursor, agents]
created: "2026-05-20T00:00:00Z"
related:
  - "../wiki/how-to/api-context-length-exceeded-131072.md"
  - "../wiki/concepts/context-overflow-prevention.md"
---

# Confronto agenti — limite endpoint 131072 token

## Contesto

Errore vendor: finestra massima **131072** token sull’endpoint, richiesta **~796638** token (prevale **text input** ~722k + **tool input** ~42k + riserva **output** ~32k).

## Fix strutturale verificato (2026-05-20)

`laravel/AGENTS.md` (~2.5MB) e `laravel/CLAUDE.md` (~1.3MB) embeddavano tutto `.ai` → ~722k token in **text input**. Sostituiti con stub; backup `laravel/*.embedded-rules.FULL.md.bak` (gitignored). Gate: `laravel/AGENTS.md` e `laravel/CLAUDE.md` ≤50 righe in `verify-llm-wiki.sh`.

## Ipotesi condivise (da validare)

1. **Text input** alto → cronologia lunga + troppe regole/file nel contesto + `@` troppo ampi.
2. **Tool input** alto → output MCP/tool non compresso prima della serializzazione nella richiesta.
3. Il messaggio invita esplicitamente al **context-compression plugin** → allineamento con **context-mode MCP** e disciplina `ctx_*` nel repo.

## Decisioni documentate (wiki)

Playbook canonico: [`docs/wiki/how-to/api-context-length-exceeded-131072.md`](../wiki/how-to/api-context-length-exceeded-131072.md).

## Domande agli altri agenti

- Su **Cursor**: confermate che i **5 MCP minimi** partono dopo reload (`docs/wiki/how-to/mcp-minimum-stack.md`): context-mode, playwright, puppeteer, token-optimizer, laravel-boost.
- Qual è il rapporto **cost/benefit** tra context-mode esistente e progetti tipo **universal-context-mode** per questo stack?
- Serve uno **snippet `.cursor/mcp.json` versionato** nel repo (template) o va tenuto solo locale per segreti/path?

## Issue GitHub

Tracciamento e commenti: issue **[#127](https://github.com/provtv/base_ptv_fila5_mono/issues/127)** (titolo operativo sul limite 131072 — aggiornare il link se il numero cambia dopo creazione).

## Prossimo passo

1. Ogni agent che riproduce l’errore allega **solo** i numeri (text/tool/output) e **non** il payload intero.
2. Aggiornare questa pagina con una riga «verified fix» quando una sessione stabile riproduce il workflow senza 400.
