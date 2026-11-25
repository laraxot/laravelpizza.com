---
type: note
updated: 2026-09-26
qmd: "schema"
issues: []
discussions: []
title: Wiki Schema
description: Schema e convenzioni per la manutenzione della wiki
tags:
  - schema
  - conventions
  - llm-instructions
created: 2026-04-15
status: draft
---

# Wiki Schema - Rating

Istruzioni per l'LLM su come mantenere questa wiki.

## Struttura

```
docs/
├── wiki/
│   ├── index.md           # Catalogo
│   ├── log.md             # Registro
---
│   ├── schema.md          # Questo file
---
│   ├── schema.md          # Questo file
---
---
│   ├── schema.md          # Questo file
---
---
│   ├── schema.md          # Questo file
---
│   ├── SCHEMA.md          # Questo file
---
---
---
---
│   ├── schema.md          # Questo file
│   ├── SCHEMA.md          # Questo file (case-duplicate di schema.md)
│   ├── concepts/          # Pattern, architettura
│   ├── entities/          # Modelli, azioni
│   ├── sources/           # Doc esterna
│   └── comparisons/       # Tabelle comparative
└── raw/                   # Sorgenti immutable
```

## Convenzioni

- File: kebab-case (es. `entity-user.md`)
- Frontmatter: title, description, tags, created
- Cross-ref: `Link`
- NON modificare mai `docs/raw/`

## Contenuto fuso da `schema.md`

```
docs/
├── wiki/
│   ├── index.md           # Catalogo
│   ├── log.md             # Registro
│   ├── schema.md          # Questo file
│   ├── SCHEMA.md          # Questo file (case-duplicate di schema.md)
│   ├── concepts/          # Pattern, architettura
│   ├── entities/          # Modelli, azioni
│   ├── sources/           # Doc esterna
│   └── comparisons/       # Tabelle comparative
└── raw/                   # Sorgenti immutable
```

- File: kebab-case (es. `entity-user.md`)
- Frontmatter: title, description, tags, created
- Cross-ref: `[Link](../concepts/name.md)`
- NON modificare mai `docs/raw/`
