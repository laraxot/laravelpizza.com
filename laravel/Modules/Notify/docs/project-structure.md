---
qmd: "PROJECT STRUCTURE"
issues: []
discussions: []
title: "Project Structure — Module Notify"
type: documentation
created: 2026-05-11
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
updated: 2026-05-11
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
tags: [structure, architecture, module]
---

# Project Structure — Module **Notify**

## Directory Structure

\`\`\`
./laravel/Modules/Notify/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-index.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── memories/                 # Memorie progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── decisions/                # Architecture decision records
│   └── troubleshooting/          # Bug fixes, error resolutions
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
├── ON-DEMAND-PATTERN.md          # 🌟 QUESTO FILE — Pattern on-demand
├── qmd-setup-3.md                  # Configurazione QMD
├── performance-optimization-2.md    # Metriche e best practice
├── ARCHITECTURE.md               # (opzionale) Architettura modulo
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
├── on-demand-pattern.md          # 🌟 QUESTO FILE — Pattern on-demand
├── qmd-setup.md                  # Configurazione QMD
├── performance-optimization.md    # Metriche e best practice
├── architecture.md               # (opzionale) Architettura modulo
└── README.md                     # (opzionale) Overview modulo
\`\`\`

## File Chiave

| File | Purpose |
|------|---------|
| `wiki/index.md` | Catalogo di tutto il sapere del modulo |
| `wiki/log.md` | Storico attività (ingest/query/lint) |
| `wiki/rules/` | Regole + trigger map locale |
| `wiki/concepts/` | Concetti specifici del modulo |
<<<<<<< HEAD
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
<<<<<<< HEAD
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
=======
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
=======
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev

## Convenzioni

### Naming

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
- **filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
- **Filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
- **filenames**: lowercase-kebab-case.md
=======
- **Filenames**: lowercase-kebab-case.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< HEAD
<<<<<<< .merge_file_rKiznc
=======
<<<<<<< .merge_file_QmwjZ8
>>>>>>> laraxot/dev
=======
- **filenames**: lowercase-kebab-case.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
<<<<<<< HEAD
>>>>>>> .merge_file_k3sMYk
=======
>>>>>>> .merge_file_zlZcvR
>>>>>>> laraxot/dev
- **Directories**: lowercase
- **Titles**: Title Case

### Frontmatter Schema

\`\`\`yaml
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---
title: "Page Title"
type: concept|entity|source|comparison|decision|troubleshooting
sources: []  # Solo per raw sources
confidence: high|medium|low
created: YYYY-MM-DD
updated: YYYY-MM-DD
tags: [tag1, tag2]
related:
  - ../concepts/related.md
---
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
\`\`\`

### Link Rules

- **Interno modulo**: `[[concepts/page]]` o `[link](./concepts/page.md)`
- **Modulo altro**: `[[../../OtherModule/docs/wiki/concepts/page]]`
- **Project wiki**: `[Global rule](../../docs/wiki/rules/rule.md)`

## Workflow con On-Demand Pattern

\`\`\`mermaid
graph TD
    A[Task Received] --> B{Has trigger?}
    B -->|Yes| C[Read trigger_map]
    C --> D[Load specific file]
    B -->|No| E[qmd search]
    E --> D
    D --> F[Apply knowledge]
    F --> G[Update wiki/log]
\`\`\`

## Riferimenti Globali

- [Project Wiki Root](../../docs/wiki/)
- [Global Rules](../../docs/wiki/rules/)
- [Global Skills](../../docs/wiki/skills/)
- [Global Commands](../../docs/wiki/commands/)
- [Global Memories](../../docs/wiki/memories/)

## Setup Iniziale (per nuovi moduli)

\`\`\`bash
# 1. Crea struttura wiki
mkdir -p docs/wiki/{rules,skills,commands,memories,concepts,entities,decisions,troubleshooting}

# 2. Crea INDEX files (già creati)
cp docs/wiki/rules/index.md docs/wiki/rules/
# ... etc

# 3. Aggiungi a QMD collection (opzionale, già incluso global)
# Il .qmd/index.yml include automaticamente docs/**/wiki/

# 4. Committa
git add docs/
git commit -m "docs: add wiki structure for Notify"
\`\`\`

---
*Pattern: On-Demand | Source: docs/wiki/*
