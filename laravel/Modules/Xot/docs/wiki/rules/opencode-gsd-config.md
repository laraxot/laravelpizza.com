# OpenCode & GSD — Allineamento Schema Agenti

**Rule type**: infrastructure / config alignment
**Status**: enforced (2026-05-11)
**Trigger**: Errore `Configuration is invalid` in file `.opencode/agents/*.md`

## Overview

Il framework **GSD (Get Shit Done)**, quando integrato con **OpenCode.ai**, richiede una configurazione YAML frontmatter specifica e rigorosa. Molti template generati da `get-shit-done` seguono lo standard **Claude Code**, che usa stringhe CSV per i tool (es. `tools: Read, Write`). OpenCode richiede invece un oggetto `tools` o, preferibilmente, un blocco `permission` esplicito.

## Schema Corretto (OpenCode)

### Campi Obbligatori
- `name`: identificativo univoco.
- `description`: scopo dell'agente.
- `mode`: `primary` | `subagent` | `all`. Gli agenti GSD sono tipicamente `subagent`.

### Gestione Tool (Nuovo Standard)
Invece di `tools: CSV`, usare il blocco `permission` per un controllo fine-grained:

```yaml
permission:
  read: allow
  write: allow
  edit: ask
  bash:
    "*": allow
  external_directory: allow # CRITICO per GSD (access a ~/.gsd/)
```

### Valori Ammessi per Permission
- `allow`: esecuzione silenziosa.
- `ask`: richiede conferma all'utente.
- `deny`: blocco totale.

## Migrazione dei Template GSD

Se un file `.opencode/agents/gsd-*.md` causa errori di validazione:

1. **Aggiungere `mode: subagent`** se mancante.
2. **Convertire `tools: CSV`** in formato oggetto booleano o rimuoverlo a favore di `permission`.
3. **Hex Color**: Usare codici hex per `color` (es. `#FFA500` invece di `orange`).
4. **Heredoc Prohibition**: Mai usare `Bash(cat << 'EOF')` per creare file; usare sempre il tool `Write`.

## Esempio Fix Applicato

```yaml
---
name: gsd-debug-session-manager
description: ...
mode: subagent
color: "#FFA500"
permission:
  read: allow
  write: allow
  bash: allow
  external_directory: allow
---
```

## Workflow di Ripristino
In caso di rigenerazione dei template (es. `gsd update`):
1. Eseguire lo script di patch `bashscripts/ai/patch-opencode-agents.sh`.
2. Verificare con `opencode doctor`.

## Riferimenti
- [OpenCode Docs](https://opencode.ai/docs/agents/)
- [GSD Official Help](https://getshitdone.help)
- Wiki interna: `docs/wiki/rules/opencode-agent-schema.md`
