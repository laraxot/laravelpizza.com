---
title: Wiki Schema
description: Schema e convenzioni per la manutenzione della wiki
tags:
  - schema
  - conventions
  - llm-instructions
created: 2026-04-15
<<<<<<< .merge_file_TlqFHb
<<<<<<< .merge_file_s1bm0D
<<<<<<< .merge_file_2oFPKM
qmd: "schema wiki"
=======
>>>>>>> .merge_file_uoto8R
=======
qmd: "schema wiki"
>>>>>>> .merge_file_OBDHvh
=======
qmd: "schema wiki"
>>>>>>> .merge_file_s6HhDh
---

# Wiki Schema - User

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
