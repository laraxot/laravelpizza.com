---
title: OpenRouter Context Compression Plugin
type: concept
---

# OpenRouter — Context Compression Plugin

## Problema

Le chiamate API OpenRouter falliscono con HTTP 400 quando il contesto supera il limite del modello (es. 131072 token per `claude-sonnet-4-5`):

```
API Error: 400 {"error":{"message":"This endpoint's maximum context length is 131072 tokens.
However, you requested about 132262 tokens (...). Please reduce the length of either one,
or use the context-compression plugin to compress your prompt automatically."}}
```

## Soluzione: Context Compression Plugin

OpenRouter offre un plugin che comprime automaticamente i prompt che superano il limite del modello, rimuovendo o tronchando i messaggi centrali meno critici.

### Abilitazione globale (account OpenRouter)

Vai su https://openrouter.ai/settings/plugins e abilita `context-compression` come plugin predefinito. Funziona per **tutte** le chiamate API del tuo account.

### Abilitazione via API (per-request)

Aggiungere nel body della richiesta:

```json
{
  "plugins": [{ "id": "context-compression" }]
}
```

### Abilitazione in OpenCode (`laravel/opencode.json`)

Aggiungere la sezione `provider.openrouter.options`:

```json
{
  "provider": {
    "openrouter": {
      "options": {
        "plugins": [{ "id": "context-compression" }]
      }
    }
  }
}
```

Questo passa i parametri extra a OpenRouter per ogni chiamata effettuata tramite il provider OpenRouter.

## Contesto progetto

- Il file di configurazione OpenCode è `laravel/opencode.json`
- Il modello principale è `anthropic/claude-sonnet-4-5` via OpenRouter
- Il problema si manifesta durante BMAD `create-story` con prompt molto lunghi (agenti con system prompt + tool input + output = ~132K token)
- La regola `context-compression-discipline.md` descrive come ridurre il context anche lato client (ctx_batch_execute, context-mode MCP)
- Il retrieval QMD deve usare cache fuori repo via `laravel/.mcp.json`

## Riferimenti

- OpenRouter docs: https://openrouter.ai/docs/guides/features/message-transforms
- OpenRouter plugins: https://openrouter.ai/docs/guides/features/plugins
- Regola locale: `bashscripts/ai/.claude/rules/context-compression-discipline.md`
- Root wiki: `docs/wiki/concepts/context-compression-discipline.md`