# BMAD Method — Quick Start Guide

> **Versione**: 6.2.0 | **Ultimo aggiornamento**: 2026-03-31  
> **Progetto**: Laraxot PTVX | **Stack**: Laravel 12 + Filament v5 + Pest v4

---

## 🚀 Introduzione

**BMAD Method** (Build More Architect Dreams) è un framework di sviluppo AI-driven con agenti specializzati per trasformare idee vaghe in specifiche tecniche rigorose e codice di qualità.

### Quando Usare BMAD vs GSD

| Scenario | Framework | Perché |
|----------|-----------|--------|
| **Nuovo modulo completo** | 🎯 **BMAD** | Serve architettura, epics, stories |
| **Feature complessa multi-file** | 🎯 **BMAD** | Serve pianificazione strutturata |
| **Architettura, stakeholder alignment** | 🎯 **BMAD** | Serve PM + Architect agents |
| **Sprint planning, epics, stories** | 🎯 **BMAD** | Serve SM agent |
| **Feature singola, refactoring** | ⚡ **GSD** | Spec-driven, context engineering |
| **Bug fix complesso** | ⚡ **GSD** | Piano rapido, esecuzione atomica |
| **Quick ad-hoc task** | ⚡ **GSD quick** o **BMAD quick-dev** | Entrambi validi |
| **Brainstorming, research** | 🎯 **BMAD** | Analyst agent specializzato |

---

## 📦 Installazione

BMAD v6.2.0 è **già installato** in questo progetto:

```bash
# Verifica installazione
ls -la _bmad/

# Struttura
_bmad/
├── _config/           # Configurazione (manifest, agents, skills)
├── _memory/           # Memoria e preferenze
├── bmm/               # BMAD Method Module (agents + workflows)
├── core/              # Core skills e tasks
└── output/            # Artefatti generati
```

### Agenti Installati (9)

| Agente | Nome | Ruolo | Quando Usare |
|--------|------|-------|--------------|
| 📊 **Analyst** | Mary | Research, brainstorming | Analisi mercato, dominio, tecnico |
| 📋 **PM** | John | PRD, requisiti | Pianificazione, stakeholder |
| 🎨 **UX Designer** | Sally | User research, UX | Interaction design, wireframes |
| 🏗️ **Architect** | Winston | Architettura | Decisioni tecniche, stack |
| 💻 **Developer** | Amelia | Story execution | Implementazione, TDD |
| 🧪 **QA** | Quinn | Test automation | E2E, API tests |
| 🏃 **Scrum Master** | Bob | Sprint planning | Cerimonie agile, tracking |
| 📚 **Tech Writer** | Paige | Documentation | Documentazione tecnica |
| 🚀 **Quick Flow** | Barry | Rapid dev | Task piccoli, fix veloci |

---

## 🎯 Le 4 Fasi BMAD

### Phase 1: Analysis (Opzionale)

Esplora il **problem space** prima di pianificare.

```bash
# Brainstorming iniziale
bmad-brainstorming

# Ricerche
bmad-market-research      # Mercato e competitor
bmad-domain-research      # Dominio business
bmad-technical-research   # Fattibilità tecnica

# Product Brief
bmad-create-product-brief # Definizione core idea
```

**Output**: `planning-artifacts/brainstorming-report.md`, `research/`

---

### Phase 2: Planning (Required)

Definisci **COSA** costruire e **PER CHI**.

```bash
# PRD (Product Requirements Document)
bmad-create-prd           # Crea PRD da zero
bmad-validate-prd         # Validazione qualità
bmad-edit-prd             # Modifica PRD esistente

# UX Design
bmad-create-ux-design     # User research + interaction design
```

**Output**: `planning-artifacts/PRD.md`, `planning-artifacts/ux-spec.md`

---

### Phase 3: Solutioning (Required per Enterprise)

Decidi **COME** costruirlo e dividi il lavoro.

```bash
# Architettura
bmad-create-architecture  # Decisioni tecniche, stack, DB schema

# Epics & Stories
bmad-create-epics-and-stories  # Scomposizione in task atomici

# Validation
bmad-check-implementation-readiness  # Verifica allineamento PRD→UX→Arch→Epics
```

**Output**: `planning-artifacts/architecture.md`, `planning-artifacts/epics/`

---

### Phase 4: Implementation

Costruisci, **una story alla volta**.

```bash
# Sprint Planning
bmad-sprint-planning      # Piano di sprint, sequenziamento
bmad-sprint-status        # Check stato sprint

# Story Cycle (ripeti per ogni story)
bmad-create-story         # Prepara story con contesto
bmad-dev-story            # Implementa + test
bmad-code-review          # Quality gate
bmad-qa-generate-e2e-tests  # Test E2E (opzionale)

# Retrospettiva
bmad-retrospective        # A fine epic
bmad-correct-course       # Se serve cambio direzione
```

**Output**: `implementation-artifacts/sprint-status.yaml`, `implementation-artifacts/story-*.md`

---

## ⚡ Quick Flow (Track Parallelo)

Per **task piccoli e ben compresi** — salta le fasi 1-3:

```bash
# Quick Spec + Implementazione
bmad-quick-spec           # Crea tech spec veloce (5 min)
bmad-quick-dev            # Implementa con spec
bmad-quick-dev-new-preview  # Workflow unificato (sperimentale)
```

**Quando usare**:
- ✅ Bug fix isolati
- ✅ Small features (< 2 ore)
- ✅ Refactoring局部
- ✅ Utility scripts

**Quando NON usare**:
- ❌ Nuovi moduli completi
- ❌ Architettura complessa
- ❌ Feature con impatto su più moduli

---

## 🛠️ Utility Workflows (Anytime)

```bash
# Guida intelligente
bmad-help                 # "Cosa devo fare dopo?"

# Documentazione
bmad-document-project     # Analizza codebase esistente
bmad-generate-project-context  # Genera regole per AI agents
bmad-index-docs           # Crea indice docs per LLM
bmad-shard-doc            # Splitta documenti grandi (>500 righe)

# Review qualità
bmad-editorial-review-prose      # Review prosa
bmad-editorial-review-structure  # Review struttura
bmad-review-adversarial-general  # Review critico
bmad-review-edge-case-hunter     # Trova edge case

# Compressione contesto
bmad-distillator          # Compressione lossless per LLM

# Multi-agent
bmad-party-mode           # Discussione multi-agente
```

---

## 📁 Struttura Output

```
_bmad-output/
├── project-context.md          # "Costituzione" del progetto
├── planning-artifacts/
│   ├── PRD.md
│   ├── architecture.md
│   ├── ux-spec.md
│   └── epics/
│       └── epic-001-user-auth.md
└── implementation-artifacts/
    ├── sprint-status.yaml
    └── story-001-login.md
```

---

## 🔄 Context Flow

Ogni documento diventa contesto per la fase successiva:

```
product-brief.md
       ↓
    PRD.md
       ↓
architecture.md
       ↓
   epics/
       ↓
  story-*.md
       ↓
implementation
```

Il file `_bmad-output/project-context.md` è la **costituzione** del progetto — guida le decisioni di implementazione in tutti i workflow.

---

## 📋 Planning Tracks

BMAD offre **tre track** basati sulla complessità:

### Track 1: Quick Flow

```
Idea → bmad-quick-dev → Done
```

**Quando**: Bug fix, small tasks (< 2 ore)  
**Output**: Codice + test

---

### Track 2: BMad Method

```
Idea → PRD → Architecture → Epics/Stories → Sprint → Implementation
```

**Quando**: Feature medie (2-20 ore)  
**Output**: PRD + Arch + Code + Tests

---

### Track 3: Enterprise

```
Idea → Research → Brief → PRD → UX → Arch → Epics/Stories → Sprint → Implementation
```

**Quando**: Moduli completi, nuovi prodotti (20+ ore)  
**Output**: Full documentation + Code + Tests

---

## 🎓 Esempi Pratici

### Esempio 1: Nuovo Modulo "Performance"

```bash
# Phase 1: Analysis
bmad-domain-research      # Studio dominio HR/Performance
bmad-technical-research   # Valutazione architettura

# Phase 2: Planning
bmad-create-prd           # Requisiti modulo Performance

# Phase 3: Solutioning
bmad-create-architecture  # DB schema, API, integrazioni
bmad-create-epics-and-stories  # 5 epics, 23 stories

# Phase 4: Implementation
bmad-sprint-planning      # Sprint 1: Epic 1 (Models + Migrations)
bmad-create-story story-001
bmad-dev-story story-001
bmad-code-review
# ... ripeti per ogni story
```

---

### Esempio 2: Fix PHPStan Errors

```bash
# Quick Flow
bmad-quick-dev "Fix PHPStan level 10 errors in Modules/Xot"
```

---

### Esempio 3: Refactoring Filament Resource

```bash
# GSD (più adatto)
gsd quick "Refactor PtvResource form per usare Spatie Data"

# Oppure BMAD Quick Flow
bmad-quick-dev "Refactor PtvResource form"
```

---

## 🔗 Integrazione con GSD

BMAD e GSD **coesistono** in questo progetto:

| Fase | BMAD | GSD |
|------|------|-----|
| **Analysis** | ✅ Brainstorming, Research | ❌ |
| **Planning** | ✅ PRD, UX | ❌ |
| **Solutioning** | ✅ Architecture, Epics | ✅ Discuss + Plan |
| **Implementation** | ✅ Story Cycle | ✅ Execute |
| **Quick Tasks** | ✅ Quick Flow | ✅ GSD Quick |

**Regola pratica**:
- **BMAD**: Nuovo, complesso, multi-agente
- **GSD**: Feature singola, refactoring, bug fix

---

## 🚨 Regole Importanti

1. **Sempre fresh chat** per ogni workflow — previene context rot
2. **`bmad-help` first** — se non sai cosa fare, chiedi
3. **PRD prima di architecture** — non progettare senza requisiti
4. **Architecture prima di stories** — Stories più informate
5. **`project-context.md`** — essenziale per brownfield come Laraxot
6. **Build cycle**: `create-story → dev-story → code-review → next story`

---

## 📚 Risorse

- **Repo**: [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)
- **Docs**: [docs.bmad-method.org](https://docs.bmad-method.org)
- **Workflow Map**: [docs.bmad-method.org/reference/workflow-map/](https://docs.bmad-method.org/reference/workflow-map/)
- **Discord**: [discord.gg/gk8jAdXWmj](https://discord.gg/gk8jAdXWmj)
- **YouTube**: [youtube.com/@BMadCode](https://www.youtube.com/@BMadCode)

---

## 🎯 Prossimi Passi

1. **Leggi** `_bmad-output/project-context.md` — regole implementazione
2. **Prova** `bmad-help` — guida interattiva
3. **Scegli** un workflow in base alla complessità
4. **Documenta** il risultato in `_bmad-output/`

---

**Ultimo aggiornamento**: 2026-03-31  
**Mantenuto da**: AI Agent Team  
**Feedback**: Crea issue su GitHub o chiedi `bmad-help`
