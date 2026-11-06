---
title: "🚀 Installazione Strumenti di Sviluppo"
type: concept
tags: [installazione, strumenti]
created: 2026-07-14
updated: 2026-07-14
qmd: "installazione-strumenti 🚀 installazione strumenti di sviluppo"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "../../../00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "../../../acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# 🚀 Installazione Strumenti di Sviluppo

## Superpowers
https://github.com/obra/superpowers

```bash
npm install --save-dev @obra/superpowers
```

## BMAD Method
https://github.com/bmad-code-org/BMAD-METHOD

```bash
# Skill già installata in ~/.qwen/skills/bmad-*
```

## GSD (Get Shit Done)
https://github.com/gsd-build/get-shit-done

```bash
# Skill già installata in ~/.qwen/skills/gsd-*
```

## Ralph Loop
https://github.com/snarktank/ralph

```bash
# Skill già installata in ~/.qwen/skills/ralph-loop
```

## OpenViking
https://github.com/volcengine/OpenViking

```bash
# Installato globalmente
```

## NotebookLM MCP

```bash
npm install -g @notebooklm/mcp
```

### Configurazione MCP

Aggiungi a `~/.cursor/mcp.json`:

```json
{
  "mcpServers": {
    "notebooklm": {
      "command": "npx",
      "args": ["-y", "@notebooklm/mcp"],
      "env": {
        "NOTEBOOKLM_API_KEY": "your-key"
      }
    }
  }
}
```

---

## Documentazione Progetto

### Struttura

```
docs/
├── installazione-strumenti.md  ← Questo file
├── SUPERPOWERS_GUIDE.md
├── BMAD_WORKFLOW.md
├── GSD_PHASES.md
├── RALPH_LOOP_USAGE.md
└── OPENVIKING_CONTEXT.md
```

### Skill Installate

- ✅ BMAD: `bmad-*` (15 skills)
- ✅ GSD: `gsd-*` (50+ skills)
- ✅ Ralph Loop: `ralph-loop`
- ✅ UI/UX: `ui-ux-pro-max`, `frontend-design`
- ✅ Laravel: `laravel-best-practices`, `laravel-folio`

---

## Prossimi Passi

1. Configurare OpenViking context per Notify
1. Configurare OpenViking context per <nome progetto>
2. Creare BMAD stories per allineamento HTML
3. Eseguire GSD phase per fix componenti
4. Usare Ralph Loop per iterazioni rapide
5. Documentare su NotebookLM
