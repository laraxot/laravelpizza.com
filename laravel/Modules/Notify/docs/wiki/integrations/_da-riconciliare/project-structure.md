---
qmd: "project structure"
issues: []
discussions: []
title: "Project Structure — Module Notify"
type: documentation
created: 2026-05-11
<<<<<<< HEAD
<<<<<<< .merge_file_arHcxx
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_lxNHJ1
updated: 2026-05-11
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_arHcxx
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1
tags: [structure, architecture, module]
related:
  - "./00-index-1.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
<<<<<<< .merge_file_arHcxx
<<<<<<< HEAD
=======
>>>>>>> .merge_file_lxNHJ1
  - "./acronym-naming-conventions.md"
=======
<<<<<<< HEAD
  - "./acronym-naming-conventions.md"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
  - "./action-plan-immediate.md"
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
│   │   ├── 00-index-1.md          # Indice regole
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
├── on-demand-pattern.md          # 🌟 QUESTO FILE — Pattern on-demand
├── qmd-setup.md                  # Configurazione QMD
├── performance-optimization-1.md    # Metriche e best practice
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
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |

## Convenzioni

### Naming

<<<<<<< HEAD
<<<<<<< .merge_file_arHcxx
- **filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
<<<<<<< HEAD
- **Filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
- **filenames**: lowercase-kebab-case.md
=======
- **Filenames**: lowercase-kebab-case.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- **filenames**: lowercase-kebab-case.md
=======
- **Filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
- **filenames**: lowercase-kebab-case.md
=======
- **Filenames**: lowercase-kebab-case.md
>>>>>>> .merge_file_lxNHJ1
>>>>>>> laraxot/dev
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

---

<!-- Merged from project-structure.md, which collided with this file on case-insensitive filesystems. -->

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---
title: "Project Structure — Module Notify"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [structure, architecture, module]
---
title: "Project Structure — Module Notify"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [structure, architecture, module]
---

<<<<<<< .merge_file_arHcxx
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1
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
<<<<<<< .merge_file_arHcxx
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1
├── ON-DEMAND-PATTERN.md          # 🌟 QUESTO FILE — Pattern on-demand
├── QMD-SETUP.md                  # Configurazione QMD
├── PERFORMANCE-OPTIMIZATION.md    # Metriche e best practice
├── ARCHITECTURE.md               # (opzionale) Architettura modulo
<<<<<<< .merge_file_arHcxx
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1
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
<<<<<<< .merge_file_arHcxx
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_lxNHJ1
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
=======
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_arHcxx
=======
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1

## Convenzioni

### Naming

<<<<<<< HEAD
<<<<<<< .merge_file_arHcxx
- **filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_lxNHJ1
- **Filenames**: lowercase-kebab-case.md
=======
<<<<<<< HEAD
- **filenames**: lowercase-kebab-case.md
=======
- **Filenames**: lowercase-kebab-case.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_arHcxx
=======
- **filenames**: lowercase-kebab-case.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_lxNHJ1
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
