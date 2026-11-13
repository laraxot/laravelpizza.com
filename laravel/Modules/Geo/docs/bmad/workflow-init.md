# BMAD Workflow Init — Guida alla Configurazione

> **Versione**: 6.2.0 | **Progetto**: Laraxot PTVX  
> **Ultimo aggiornamento**: 2026-03-31

---

## 🎯 Obiettivo

Questa guida configura **workflow-init** per integrare BMAD Method con il tuo IDE (Claude Code, Cursor, Windsurf).

---

## ✅ Prerequisiti

- [x] BMAD v6.2.0 già installato in `_bmad/`
- [x] Node.js 18+ installato
- [x] IDE supportato (Claude Code, Cursor, Windsurf)
- [x] Accesso al progetto PTVX

---

## 📦 Installazione

### Step 1: Verifica Installazione

```bash
# Verifica che BMAD sia installato
ls -la _bmad/

# Output atteso:
# _config/  _memory/  bmm/  core/
```

### Step 2: Configura IDE

#### Claude Code

BMAD è già configurato per Claude Code in `_bmad/_config/ides/claude-code.yaml`.

**Non serve configurazione aggiuntiva** — Claude Code legge automaticamente:
- `_bmad/bmm/agents/*.md` (agent personas)
- `_bmad/bmm/workflows/**/*.md` (workflow definitions)
- `_bmad-output/project-context.md` (regole progetto)

#### Cursor

1. Crea `.cursor/rules/bmad-workflows.mdc`:

```markdown
---
description: BMAD Method Workflows
globs: **
---

This project uses BMAD Method v6.2.0 for structured AI-driven development.

## Available Workflows

### Analysis Phase
- bmad-brainstorming
- bmad-market-research
- bmad-domain-research
- bmad-technical-research
- bmad-create-product-brief

### Planning Phase
- bmad-create-prd
- bmad-validate-prd
- bmad-edit-prd
- bmad-create-ux-design

### Solutioning Phase
- bmad-create-architecture
- bmad-create-epics-and-stories
- bmad-check-implementation-readiness

### Implementation Phase
- bmad-sprint-planning
- bmad-sprint-status
- bmad-create-story
- bmad-dev-story
- bmad-code-review
- bmad-qa-generate-e2e-tests
- bmad-retrospective
- bmad-correct-course

### Quick Flow
- bmad-quick-spec
- bmad-quick-dev
- bmad-quick-dev-new-preview

### Utility
- bmad-help (use this when unsure!)
- bmad-document-project
- bmad-generate-project-context
- bmad-index-docs
- bmad-shard-doc
- bmad-distillator

## Project Context

Always reference: `_bmad-output/project-context.md`

## When to Use BMAD vs GSD

- **BMAD**: New modules, complex features, architecture, multi-agent
- **GSD**: Single features, refactoring, bug fixes, quick tasks
```

2. Crea `.cursor/commands/bmad.json`:

```json
{
  "commands": [
    {
      "name": "bmad-help",
      "description": "Get guidance on what to do next",
      "prompt": "Invoke bmad-help skill to analyze project state and recommend next workflow"
    },
    {
      "name": "bmad-create-prd",
      "description": "Create Product Requirements Document",
      "prompt": "Invoke bmad-create-prd skill to create a lean PRD following 2025-2026 standards"
    },
    {
      "name": "bmad-dev-story",
      "description": "Execute story implementation",
      "prompt": "Invoke bmad-dev-story skill to implement a story from the sprint plan"
    }
  ]
}
```

#### Windsurf

Windsurf è già configurato tramite `_bmad/_config/`.

Per abilitare i comandi rapidi, aggiungi a `.windsurf/settings.json`:

```json
{
  "bmad": {
    "version": "6.2.0",
    "enabled": true,
    "projectContext": "_bmad-output/project-context.md"
  }
}
```

---

## 🔧 Workflow Init Script

Crea lo script di inizializzazione `bashscripts/bmad/workflow-init.sh`:

```bash
#!/bin/bash

# =============================================================================
# BMAD Workflow Init
# =============================================================================
# Configura BMAD Method per il progetto PTVX
# =============================================================================

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Project root
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"

echo -e "${BLUE}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   BMAD Workflow Init — Laraxot PTVX                   ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════╝${NC}"
echo ""

# Step 1: Verify BMAD installation
echo -e "${YELLOW}[1/5] Verifying BMAD installation...${NC}"
if [ ! -d "$PROJECT_ROOT/_bmad" ]; then
    echo -e "${RED}❌ BMAD not found in _bmad/${NC}"
    echo "Run: npx bmad-method@6.2.0 install"
    exit 1
fi
echo -e "${GREEN}✓ BMAD installation found${NC}"

# Step 2: Check version
echo -e "${YELLOW}[2/5] Checking BMAD version...${NC}"
VERSION=$(grep -oP 'version: \K[0-9.]+' "$PROJECT_ROOT/_bmad/_config/manifest.yaml" 2>/dev/null || echo "unknown")
if [ "$VERSION" != "6.2.0" ]; then
    echo -e "${YELLOW}⚠ Expected v6.2.0, found v$VERSION${NC}"
    echo "Consider updating: npx bmad-method@next install"
else
    echo -e "${GREEN}✓ BMAD version: $VERSION${NC}"
fi

# Step 3: Verify project context
echo -e "${YELLOW}[3/5] Checking project context...${NC}"
if [ ! -f "$PROJECT_ROOT/_bmad-output/project-context.md" ]; then
    echo -e "${YELLOW}⚠ Project context not found${NC}"
    echo "Generating..."
    # Invoke BMAD to generate context
    echo "Run: bmad-generate-project-context"
else
    echo -e "${GREEN}✓ Project context found${NC}"
fi

# Step 4: Check IDE configuration
echo -e "${YELLOW}[4/5] Checking IDE configuration...${NC}"
IDE_COUNT=0

if [ -f "$PROJECT_ROOT/_bmad/_config/ides/claude-code.yaml" ]; then
    echo -e "${GREEN}  ✓ Claude Code configured${NC}"
    ((IDE_COUNT++))
fi

if [ -d "$PROJECT_ROOT/.cursor" ]; then
    echo -e "${GREEN}  ✓ Cursor configured${NC}"
    ((IDE_COUNT++))
fi

if [ -d "$PROJECT_ROOT/.windsurf" ]; then
    echo -e "${GREEN}  ✓ Windsurf configured${NC}"
    ((IDE_COUNT++))
fi

if [ $IDE_COUNT -eq 0 ]; then
    echo -e "${YELLOW}⚠ No IDE configured${NC}"
    echo "See: docs/bmad/workflow-init.md"
fi

# Step 5: Verify workflows
echo -e "${YELLOW}[5/5] Checking workflows...${NC}"
WORKFLOW_COUNT=$(find "$PROJECT_ROOT/_bmad/bmm/workflows" -name "*.md" | wc -l)
echo -e "${GREEN}✓ Found $WORKFLOW_COUNT workflow files${NC}"

# Summary
echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Setup Complete!                                      ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${GREEN}BMAD Method v$VERSION is ready!${NC}"
echo ""
echo -e "${YELLOW}Quick Start:${NC}"
echo "  1. Read: docs/bmad/bmad-quickstart-guide.md"
echo "  2. Run: bmad-help (to get started)"
echo "  3. Reference: _bmad-output/project-context.md"
echo ""
echo -e "${YELLOW}Documentation:${NC}"
echo "  - Quick Start: docs/bmad/bmad-quickstart-guide.md"
echo "  - Workflow Catalog: docs/bmad/bmad-workflow-catalog.md"
echo "  - Official Docs: https://docs.bmad-method.org"
echo ""
```

Rendi lo script eseguibile:

```bash
chmod +x bashscripts/bmad/workflow-init.sh
```

---

## 🚀 Utilizzo

### Esecuzione Init

```bash
# Esegui workflow init
./bashscripts/bmad/workflow-init.sh
```

**Output atteso**:
```
╔════════════════════════════════════════════════════════╗
║   BMAD Workflow Init — Laraxot PTVX                   ║
╚════════════════════════════════════════════════════════╝

[1/5] Verifying BMAD installation...
✓ BMAD installation found
[2/5] Checking BMAD version...
✓ BMAD version: 6.2.0
[3/5] Checking project context...
✓ Project context found
[4/5] Checking IDE configuration...
  ✓ Claude Code configured
  ✓ Cursor configured
[5/5] Checking workflows...
✓ Found 243 workflow files

╔════════════════════════════════════════════════════════╗
║   Setup Complete!                                      ║
╚════════════════════════════════════════════════════════╝

BMAD Method v6.2.0 is ready!

Quick Start:
  1. Read: docs/bmad/bmad-quickstart-guide.md
  2. Run: bmad-help (to get started)
  3. Reference: _bmad-output/project-context.md
```

---

## 📚 Comandi Rapidi

### BMAD Help (Sempre Primo)

```bash
# Chiedi "cosa devo fare dopo?"
bmad-help
```

### Creazione PRD

```bash
# Nuovo modulo o feature complessa
bmad-create-prd
```

### Sviluppo Story

```bash
# Story cycle
bmad-create-story    # Prepara story
bmad-dev-story       # Implementa
bmad-code-review     # Review
```

### Quick Tasks

```bash
# Task rapidi (< 2 ore)
bmad-quick-dev "Fix PHPStan errors in Xot module"
```

---

## 🔗 Integrazione con Skill

BMAD usa il sistema **skill** di Laravel Boost:

```bash
# Installa skill (se necessario)
php artisan boost:add-skill <owner/repo>

# Lista skill installate
php artisan boost:list-skills
```

**Skill BMAD**:
- `bmad-brainstorming`
- `bmad-create-prd`
- `bmad-create-architecture`
- `bmad-dev-story`
- `bmad-help`
- ... (vedi `_bmad/_config/bmad-help.csv`)

---

## 🎯 Best Practices

### 1. Fresh Chat per Ogni Workflow

```bash
# ❌ NON usare la stessa chat per fasi diverse
# ✅ Apri fresh chat per ogni workflow

# Example:
# Chat 1: bmad-create-prd
# Chat 2: bmad-create-architecture
# Chat 3: bmad-dev-story
```

**Perché**: Previene **context rot** — il degrado qualitativo quando il contesto dell'AI si riempie.

---

### 2. bmad-help First

```bash
# ❌ NON indovinare il prossimo passo
# ✅ Chiedi a bmad-help

bmad-help  # "Cosa devo fare dopo?"
```

---

### 3. Project Context Sempre

```bash
# Ogni AI agent DEVE leggere:
_bmad-output/project-context.md

# Contiene:
- Stack tecnologico
- Architecture patterns
- Critical implementation rules
- Coding standards (Laraxot)
```

---

### 4. Documenta Tutto

```bash
# Output BMAD in:
_bmad-output/
├── planning-artifacts/     # PRD, architecture, epics
└── implementation-artifacts/  # Sprint status, stories
```

---

## 🐛 Troubleshooting

### BMAD Non Risponde

```bash
# Verifica installazione
ls -la _bmad/

# Se manca, reinstalla
npx bmad-method@6.2.0 install
```

### Workflow Non Trovato

```bash
# Verifica file workflow
find _bmad/bmm/workflows -name "*.md" | head -10

# Se vuoto, reinstalla BMAD
```

### Contesto Obsoleto

```bash
# Rigenera project context
bmad-generate-project-context
```

---

## 📖 Risorse

- **Quick Start**: [docs/bmad/bmad-quickstart-guide.md](./bmad-quickstart-guide.md)
- **Workflow Catalog**: [docs/bmad/bmad-workflow-catalog.md](./bmad-workflow-catalog.md)
- **Project Context**: [_bmad-output/project-context.md](../../_bmad-output/project-context.md)
- **Official Docs**: [docs.bmad-method.org](https://docs.bmad-method.org)
- **Discord**: [discord.gg/gk8jAdXWmj](https://discord.gg/gk8jAdXWmj)

---

**Ultimo aggiornamento**: 2026-03-31  
**Mantenuto da**: AI Agent Team  
**Feedback**: GitHub Issues o `bmad-help`
