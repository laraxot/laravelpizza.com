# Project Agents (Modular)

This file provides guidance and memory for Codex CLI. The content has been split into modular files for better efficiency.

## Overview & Directory

- [How To Use With Codex](./.agents/docs/main-rules/agents-how-to.md)
- [Agent Directory (Table)](./.agents/docs/main-rules/agents-directory.md)

## Specialized Agents

- [UX Expert (Sally)](./.agents/docs/main-rules/agent-ux-expert.md)
- [Scrum Master (Bob)](./.agents/docs/main-rules/agent-sm.md)
- [Test Architect & Quality Advisor (Quinn)](./.agents/docs/main-rules/agent-qa.md)
- [Product Owner (Sarah)](./.agents/docs/main-rules/agent-po.md)
- [Product Manager (John)](./.agents/docs/main-rules/agent-pm.md)
- [Full Stack Developer (James)](./.agents/docs/main-rules/agent-dev.md)
- [BMad Master Orchestrator](./.agents/docs/main-rules/agent-orchestrator.md)
- [BMad Master Task Executor](./.agents/docs/main-rules/agent-master.md)
- [Architect (Winston)](./.agents/docs/main-rules/agent-architect.md)
- [Business Analyst (Mary)](./.agents/docs/main-rules/agent-analyst.md)

## LLM Wiki Knowledge Base

Questo progetto usa il pattern **LLM Wiki** di Andrej Karpathy per costruire una knowledge base persistente.

### Struttura Wiki

```
docs/
├── wiki/           # Wiki LLM-maintained (compilata)
│   ├── concepts/  # Pattern, architetture, metodologie
│   ├── entities/  # Moduli, classi, componenti
│   ├── summaries/ # Sintesi di documenti
│   └── ...
├── raw/            # Sorgenti grezzi (immutabili)
│   ├── articles/  # Articoli e reference
│   ├── papers/    # Paper tecnici
│   └── notes/     # Note e appunti
├── .schema/       # Schema per l'LLM
│   └── WIKI_SCHEMA.md
├── wiki/index.md  # Indice principale
└── log.md         # Log cronologico
```

### Convenzioni

1. **Raw sources**: IMMUTABILI - l'LLM legge ma non modifica
2. **Wiki pages**: Create e mantenute dall'LLM
3. **Ogni modulo/tema** ha la propria `wiki/` e `raw/`

### Riferimenti

- [Schema Wiki](./docs/.schema/WIKI_SCHEMA.md) - Istruzioni per l'LLM
- [Index Globale](./docs/wiki/index.md) - Catalogo di tutte le wiki
- [Log](./docs/log.md) - Cronologia delle operazioni

### Workflow

- **Ingest**: Leggi un sorgente → aggiungi a wiki
- **Query**: Chiedi → consulta wiki → rispondi con citazioni
- **Lint**: Verifica consistenza e cross-references

---

## Reusable Tasks

- [Task: validate-next-story](./.agents/docs/main-rules/task-validate-next-story.md)
- [Task: trace-requirements](./.agents/docs/main-rules/task-trace-requirements.md)
- [Task: test-design](./.agents/docs/main-rules/task-test-design.md)
- [Task: shard-doc](./.agents/docs/main-rules/task-shard-doc.md)
- [Task: risk-profile](./.agents/docs/main-rules/task-risk-profile.md)
- [Task: review-story](./.agents/docs/main-rules/task-review-story.md)
- [Task: qa-gate](./.agents/docs/main-rules/task-qa-gate.md)
- [Task: nfr-assess](./.agents/docs/main-rules/task-nfr-assess.md)

---
**See also:**
- [CLAUDE.md](./CLAUDE.md)
- [QWEN.md](./QWEN.md)
- [GEMINI.md](./GEMINI.md)

*Ultimo aggiornamento: Aprile 2026*


<claude-mem-context>
# Memory Context

# [base_fixcity_fila5] recent context, 2026-04-15 10:19pm GMT+2

No previous sessions found.
</claude-mem-context>