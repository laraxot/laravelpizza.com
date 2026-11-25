---
title: "Project Structure — Module User"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [structure, architecture, module]
related:
<<<<<<< .merge_file_eLhxV8
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "../../../actions-path-convention-2.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "../../../actions-path-convention-2.md"
<<<<<<< .merge_file_uuojqs
qmd: "project structure user"
=======
>>>>>>> .merge_file_ojnTJK
=======
qmd: "project structure user"
>>>>>>> .merge_file_MRuNZY
---

# Project Structure — Module **User**

## Directory Structure

### ❌ Forbidden Root Folders

At module root level, these folders MUST NOT exist:
- ❌ `Actions/` (move to `app/Actions/`)
- ❌ `Application/` (move to `app/Application/`)
- ❌ `Events/` (move to `app/Events/`)
- ❌ `Listeners/` (move to `app/Listeners/`)
- ❌ `Database/` (rename to lowercase `database/`)

\`\`\`
./laravel/Modules/User/docs/
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
├── qmd-setup-3.md                  # Configurazione QMD
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
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |

## Convenzioni

### Naming

- **Filenames**: lowercase-kebab-case.md
- **Directories**: lowercase
- **Titles**: Title Case

### Frontmatter Schema

\`\`\`yaml
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

- [Project Wiki Root](../..)
- [Global Rules](../../rules)
- [Global Skills](../../skills)
- [Global Commands](../../commands)
- [Global Memories](../../memories)

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
git commit -m "docs: add wiki structure for User"
\`\`\`

---
*Pattern: On-Demand | Source: docs/wiki/*

---

<!-- Merged from project-structure.md, which collided with this file on case-insensitive filesystems. -->

---
title: "Project Structure — Module User"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [structure, architecture, module]
---

# Project Structure — Module **User**

## Directory Structure

### ❌ Forbidden Root Folders

At module root level, these folders MUST NOT exist:
- ❌ `Actions/` (move to `app/Actions/`)
- ❌ `Application/` (move to `app/Application/`)
- ❌ `Events/` (move to `app/Events/`)
- ❌ `Listeners/` (move to `app/Listeners/`)
- ❌ `Database/` (rename to lowercase `database/`)

\`\`\`
./laravel/Modules/User/docs/
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
<<<<<<< .merge_file_eLhxV8
<<<<<<< .merge_file_uuojqs
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_ojnTJK
=======
>>>>>>> .merge_file_MRuNZY
├── ON-DEMAND-PATTERN.md          # 🌟 QUESTO FILE — Pattern on-demand
├── qmd-setup-3.md                  # Configurazione QMD
├── PERFORMANCE-OPTIMIZATION.md    # Metriche e best practice
├── ARCHITECTURE.md               # (opzionale) Architettura modulo
<<<<<<< .merge_file_eLhxV8
<<<<<<< .merge_file_uuojqs
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_ojnTJK
=======
>>>>>>> .merge_file_MRuNZY
├── on-demand-pattern.md          # 🌟 QUESTO FILE — Pattern on-demand
├── qmd-setup-3.md                  # Configurazione QMD
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
<<<<<<< .merge_file_eLhxV8
<<<<<<< .merge_file_uuojqs
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
=======
<<<<<<< HEAD
| `ON-DEMAND-PATTERN.md` | **Leggi prima** — pattern da seguire |
=======
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_ojnTJK
=======
| `on-demand-pattern.md` | **Leggi prima** — pattern da seguire |
>>>>>>> .merge_file_MRuNZY

## Convenzioni

### Naming

- **Filenames**: lowercase-kebab-case.md
- **Directories**: lowercase
- **Titles**: Title Case

### Frontmatter Schema

\`\`\`yaml
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

- [Project Wiki Root](../..)
- [Global Rules](../../rules)
- [Global Skills](../../skills)
- [Global Commands](../../commands)
- [Global Memories](../../memories)

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
git commit -m "docs: add wiki structure for User"
\`\`\`

---
*Pattern: On-Demand | Source: docs/wiki/*
