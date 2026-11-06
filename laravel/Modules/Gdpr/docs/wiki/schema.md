---
title: "Wiki Schema - Gdpr"
description: Schema e convenzioni per la manutenzione della wiki
type: note
tags: [schema, conventions, llm-instructions]
created: 2026-04-15
updated: 2026-10-25
qmd: "gdpr wiki schema convenzioni ingest llm"
issues: []
discussions: []
status: draft
---

# Wiki Schema - Gdpr

Istruzioni per l'LLM su come mantenere questa wiki.

## Struttura

```
docs/
├── wiki/
│   ├── index.md           # Catalogo
│   ├── log.md             # Registro
│   ├── schema.md          # Questo file
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

## Regole ingest

- `docs/` = raw source layer (immutabile)
- `docs/wiki/` = compiled wiki layer (LLM aggiorna)
- Nuovi concetti → `concepts/<kebab-case>.md`

## QMD collection

```bash
qmd search "gdpr consent" -c mod-gdpr
```
