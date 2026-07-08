# BMAD Method — Quick Start Guide

> **Versione Installata**: 6.2.0  
> **Ultimo Aggiornamento**: 2026-03-18  
> **IDE Supportati**: Claude Code, Cursor, Windsurf

---

## Cos'è BMAD?

**BMAD Method** (Build More Architect Dreams) è un framework di sviluppo AI-driven con:
- 🤖 **9 agenti specializzati** (PM, Architect, Developer, QA, UX, ecc.)
- 📋 **Workflow guidati** per ogni fase dello sviluppo
- 🎯 **Pianificazione intelligente** che si adatta alla complessità
- 📚 **Documentazione automatica** di requisiti, architettura e decisioni

**100% free and open source** — [docs.bmad-method.org](https://docs.bmad-method.org)

---

## Installazione

BMAD è **già installato** in questo progetto. La struttura:

```
_bmad/                          # Configurazione BMAD
├── _config/
│   ├── manifest.yaml           # Versione: 6.2.0
│   ├── bmad-help.csv           # Catalogo workflow (42 entry)
│   └── agents/                 # Configurazione agenti
├── bmm/                        # BMad Method Modules
│   ├── agents/                 # 9 agenti specializzati
│   └── workflows/              # 243 workflow files
└── core/                       # Core skills & tasks

_bmad-output/                   # Artefatti generati
├── project-context.md          # "Costituzione" del progetto
├── planning-artifacts/         # PRD, architecture, epics
└── implementation-artifacts/   # Sprint status, stories
```

---

## Come Iniziare

### Il Comando Magico: `bmad-help`

Quando non sai cosa fare, usa sempre:

```bash
bmad-help
```

Ti guida in base al contesto del progetto e ai workflow disponibili.

### Workflow Rapidi per Scenario

| Scenario | Comando | Descrizione |
|----------|---------|-------------|
| **Non sai cosa fare** | `bmad-help` | Guida intelligente |
| Bug fix / Small task | `bmad-quick-dev` | Spec + implementazione rapida |
| Nuova feature media | `bmad-create-prd` → `bmad-create-architecture` → `bmad-sprint-planning` |
| Nuovo modulo completo | `bmad-create-product-brief` → `bmad-create-prd` → `bmad-create-architecture` → `bmad-create-epics-and-stories` → `bmad-sprint-planning` |
| Brainstorming | `bmad-brainstorming` | Sessione creativa |
| Documentare progetto | `bmad-document-project` | Analisi codebase esistente |

---

## Le 4 Fasi BMAD

### Fase 1: Analysis (Opzionale)

Esplora il problem space.

```bash
# Brainstorming idee
bmad-brainstorming

# Ricerca di mercato
bmad-market-research

# Ricerca tecnica
bmad-technical-research

# Definisci product brief
bmad-create-product-brief
```

**Output**: `product-brief.md`, research docs

### Fase 2: Planning (Required)

Definisci COSA costruire.

```bash
# Crea PRD (Product Requirements Document)
bmad-create-prd

# Crea UX design
bmad-create-ux-design
```

**Output**: `PRD.md`, `ux-spec.md`

### Fase 3: Solutioning (Required)

Decidi COME costruirlo.

```bash
# Architettura tecnica
bmad-create-architecture

# Crea epics e stories
bmad-create-epics-and-stories

# Verifica readiness
bmad-check-implementation-readiness
```

**Output**: `architecture.md`, `epics/`, readiness report

### Fase 4: Implementation

Costruisci, una story alla volta.

```bash
# Pianifica sprint
bmad-sprint-planning

# Crea story
bmad-create-story <story-id>

# Sviluppa story
bmad-dev-story <story-file>

# Code review
bmad-code-review

# Retro a fine epic
bmad-retrospective
```

**Output**: Implementazione, test, sprint status

---

## Agenti Specializzati

| Agente | Nome | Ruolo | Quando Usare |
|--------|------|-------|--------------|
| 📊 **Analyst** | Mary | Research, brief | Analisi iniziale, market research |
| 📋 **PM** | John | PRD, requisiti, epics | Planning, stakeholder alignment |
| 🎨 **UX Designer** | Sally | UX design, user research | Interfacce, user experience |
| 🏗️ **Architect** | Winston | Architettura, tech decisions | Solutioning, technical choices |
| 💻 **Developer** | Amelia | Story execution, TDD | Implementazione, code review |
| 🧪 **QA** | Quinn | Test automation, E2E | Test coverage, quality |
| 🏃 **Scrum Master** | Bob | Sprint planning, ceremonies | Implementation phase |
| 📚 **Tech Writer** | Paige | Documentation | Documentazione tecnica |
| 🚀 **Quick Flow** | Barry | Rapid dev | Task piccoli, bug fix |

---

## BMAD vs GSD

Questo progetto usa **entrambi** i framework:

| Scenario | Framework | Perché |
|----------|-----------|--------|
| Feature singola, refactoring | **GSD** | Leggero, spec-driven, context engineering |
| Bug fix complesso multi-file | **GSD** | Atomic commits, state tracking |
| Nuovo modulo completo | **BMAD** | Agenti specializzati, struttura enterprise |
| Architettura nuova | **BMAD** | Architect agent, stakeholder alignment |
| Sprint planning, epics | **BMAD** | SM + PM agents, structured |
| Brainstorming, research | **BMAD** | Analyst agent, facilitation |
| Quick ad-hoc task | **GSD quick** o **BMAD quick-dev** | Entrambi validi |

### Regola Pratica

```
Task piccolo (< 1 giorno) → GSD quick / BMAD quick-dev
Feature media (1-5 giorni) → GSD completo / BMAD Planning+Solutioning
Modulo completo (> 5 giorni) → BMAD completo (tutte 4 le fasi)
```

---

## Context Management

BMAD genera contesto per la fase successiva:

```
product-brief.md
    ↓
PRD.md
    ↓
architecture.md
    ↓
epics/ + stories/
    ↓
implementation
```

Il file **`_bmad-output/project-context.md`** è la "costituzione" del progetto — guida le decisioni di implementazione.

---

## Planning Tracks

BMAD offre 3 track basati sulla complessità:

### Track 1: Quick Flow

Per bug fix e task piccoli.

```bash
bmad-quick-spec   # Tech spec veloce
bmad-quick-dev    # Implementazione
```

**Fasi saltate**: 1, 2, 3

### Track 2: BMad Method

Per feature medie.

```bash
bmad-create-prd
bmad-create-architecture
bmad-create-epics-and-stories
bmad-sprint-planning
bmad-dev-story
```

**Fasi**: 2 + 3 + 4

### Track 3: Enterprise

Per moduli completi.

```bash
bmad-create-product-brief   # Fase 1: Analysis
bmad-create-prd             # Fase 2: Planning
bmad-create-architecture    # Fase 3: Solutioning
bmad-create-epics-and-stories
bmad-sprint-planning        # Fase 4: Implementation
bmad-dev-story
```

**Tutte le 4 fasi**

---

## Comandi Rapidi

### Analisi
```bash
bmad-brainstorming              # Brainstorming session
bmad-market-research            # Market analysis
bmad-domain-research            # Domain deep dive
bmad-technical-research         # Technical feasibility
bmad-create-product-brief       # Product brief
```

### Planning
```bash
bmad-create-prd                 # Product Requirements Document
bmad-validate-prd               # Validate PRD quality
bmad-edit-prd                   # Edit existing PRD
bmad-create-ux-design           # UX specification
```

### Solutioning
```bash
bmad-create-architecture        # Technical architecture
bmad-create-epics-and-stories   # Break down into tasks
bmad-check-implementation-readiness  # Verify alignment
```

### Implementation
```bash
bmad-sprint-planning            # Sprint plan
bmad-sprint-status              # Check sprint status
bmad-create-story               # Create story from sprint plan
bmad-dev-story                  # Implement story
bmad-qa-generate-e2e-tests      # Generate E2E tests
bmad-code-review                # Code review
bmad-retrospective              # Epic retrospective
bmad-correct-course             # Major changes
```

### Anytime
```bash
bmad-help                       # What's next?
bmad-document-project           # Document existing codebase
bmad-generate-project-context   # Generate context rules
bmad-party-mode                 # Multi-agent discussion
bmad-index-docs                 # Create docs index
bmad-shard-doc                  # Split large documents
bmad-editorial-review-prose     # Review prose
bmad-editorial-review-structure # Review structure
bmad-review-adversarial-general # Critical review
bmad-review-edge-case-hunter    # Edge case analysis
bmad-distillator                # Compress documents
```

---

## Regole Importanti

1. ✅ **Sempre fresh chat** per ogni workflow — previene context rot
2. ✅ **`bmad-help` first** — se non sai cosa fare, chiedi
3. ✅ **PRD prima di architecture** — non progettare senza requisiti
4. ✅ **Architecture prima di stories** — stories più informate
5. ✅ **`project-context.md`** — essenziale per brownfield (Laraxot)
6. ✅ **Build cycle**: `create-story → dev-story → code-review → next story`

---

## Documenti Correlati

- [BMAD Method Integration](./project/bmad-method-integration.md) — Documentazione completa
- [GSD Methodology](./project/gsd-methodology.md) — Framework alternativo
- [AGENTS.md](../AGENTS.md) — Regole progetto
- [Workflow Map Online](https://docs.bmad-method.org/reference/workflow-map/)

---

## Risorse

- **Repo**: [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)
- **Docs**: [docs.bmad-method.org](https://docs.bmad-method.org)
- **Discord**: [discord.gg/gk8jAdXWmj](https://discord.gg/gk8jAdXWmj)
- **YouTube**: [youtube.com/@BMadCode](https://www.youtube.com/@BMadCode)

---

## Prossimi Passi

1. ✅ Leggi questo file — **Fatto!**
2. 🔄 Usa `bmad-help` per iniziare il tuo primo workflow
3. 📚 Consulta [bmad-method-integration.md](./project/bmad-method-integration.md) per dettagli
4. 🎯 Scegli il track giusto per il tuo task (Quick / BMad / Enterprise)

**Ready to build more architect dreams?** 🚀

```bash
bmad-help
```
