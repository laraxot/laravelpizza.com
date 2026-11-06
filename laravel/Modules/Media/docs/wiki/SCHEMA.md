---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "SCHEMA"
issues: []
discussions: []
title: "Rimando a schema.md"
description: "Documento unificato: il contenuto canonico vive in schema.md."
status: merged
tags: [merge, duplicato, case-only]
---

# Wiki Schema - Media

Istruzioni per l'LLM su come mantenere questa wiki.

## Struttura

```
docs/
├── wiki/
│   ├── index.md           # Catalogo
│   ├── log.md             # Registro
│   ├── SCHEMA.md          # Questo file
│   ├── concepts/          # Pattern, architettura
│   ├── entities/          # Modelli, azioni
│   ├── sources/           # Doc esterna
│   └── comparisons/       # Tabelle comparative
└── raw/                   # Sorgenti immutable
```

## Convenzioni

- File: kebab-case (es. `entity-user.md`)
- Frontmatter: title, description, tags, created
- Cross-ref: `[Link](../concepts/name.md)`
- NON modificare mai `docs/raw/`