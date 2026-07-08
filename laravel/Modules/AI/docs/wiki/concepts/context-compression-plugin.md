---
name: context-compression-plugin
description: Installazione e configurazione del plugin context-compression con context-mode MCP.
type: concept
---

# Context Compression Plugin (context-mode)

## Scopo

Quando una richiesta supera la context window del modello, servono due livelli:

1. plugin OpenRouter `context-compression` nella request API;
2. retrieval locale tramite `context-mode` MCP per non inviare output grezzi molto lunghi.

## Installazione

```bash
npm install -g context-mode@latest
```

## Configurazione

### Provider OpenRouter

Nel file `laravel/opencode.json`:

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

### MCP server context-mode

Sempre in `laravel/opencode.json`:

```json
{
  "mcp": {
    "context-mode": {
      "type": "local",
      "command": ["context-mode"],
      "enabled": true
    },
    "qmd": {
      "type": "local",
      "command": ["qmd", "--index", "fixcity", "mcp"],
      "enabled": true,
      "environment": {
        "XDG_CONFIG_HOME": "{env:HOME}/.cache/fixcity/qmd-config",
        "XDG_CACHE_HOME": "{env:HOME}/.cache/fixcity/qmd-cache",
        "HOME": "{env:HOME}/.cache/fixcity/qmd-home"
      }
    }
  }
}
```

## Verifica operativa

- `command -v context-mode` deve restituire il path del binario.
- `npm list -g context-mode --depth=0` deve mostrare la versione installata.
- `opencode debug config` da `laravel/` deve completare senza errori.
- `laravel/.mcp.json` deve puntare le cache QMD fuori repo (`${HOME}/.cache/fixcity/...`).

## Note pratiche

- `context-mode --help` avvia il server MCP su stdio (comportamento normale).
- Il plugin OpenRouter non sostituisce la disciplina docs/wiki: evita overflow, non crea memoria persistente.
- `compaction.auto` e `compaction.prune` in `laravel/opencode.json` riducono il rischio di trascinare tool output vecchi nella stessa sessione.

## Collegamenti

- [openrouter-context-compression](./openrouter-context-compression.md)
- [index wiki modulo AI](../index.md)
- [log wiki modulo AI](../log.md)
- [context-mode-mcp root](../../../../../../docs/wiki/concepts/context-mode-mcp.md)
- [context-compression-plugin-openrouter root](../../../../../../docs/wiki/concepts/context-compression-plugin-openrouter.md)