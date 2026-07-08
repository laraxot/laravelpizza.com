---
title: "Ruflo Local Orchestration for Xot"
type: concept
confidence: high
updated: 2026-05-08
tags: [xot, ruflo, mcp, tooling, quality]
---

# Ruflo Local Orchestration for Xot

Ruflo e' tooling di orchestrazione locale, non codice runtime del modulo. Per Xot e' utile come supporto a quality gates, analisi PHPStan/Pest e memoria operativa cross-session.

## Regola Owner

- Xot resta owner delle regole architetturali Laravel/Filament/PHPStan.
- Ruflo puo' assistere con MCP tools, memoria e routing agentico.
- Ruflo non deve introdurre nuove dipendenze Composer nei moduli.

## Stato Locale

- CLI `ruflo v3.7.0-alpha.11`
- `.claude-flow/config.yaml` presente
- daemon attivo
- MCP `ruflo` connesso in Claude Code
- memoria locale verificata con store/retrieve

## Uso Consigliato

```bash
ruflo doctor
ruflo memory search -q "phpstan xotbase"
ruflo mcp tools
ruflo mcp exec --tool analyze_file-risk --params '{"file":"laravel/Modules/Xot/app"}'
```

## Guardrail

- Non usare `ruflo init --codex --force`: puo' sovrascrivere `AGENTS.md` e `.agents`.
- Non delegare fix Xot a swarm autonomi senza test target chiari.
- Ogni modifica Xot resta soggetta a PHPStan, PHPMD phar, PHPInsights e Pest.

Riferimento root: [ruflo-local-orchestration](../../../../../docs/wiki/concepts/ruflo-local-orchestration.md).
