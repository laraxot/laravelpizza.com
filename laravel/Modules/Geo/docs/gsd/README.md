# GSD (Get Shit Done) Integration Guide

**Version**: 1.0.0  
**Date**: 2026-03-18  
**Status**: Active  
**GSD Version**: v1.25.1

---

## 🎯 Overview

**GSD (Get Shit Done)** è un framework di **meta-prompting, context engineering, e spec-driven development** per AI coding assistants.

### Cos'è GSD?

GSD risolve il **context rot** — il degrado della qualità che accade quando gli AI assistant riempiono la loro context window.

**Filosofia**:
> "The complexity is in the system, not in your workflow."

### Caratteristiche Principali

| Feature | Descrizione |
|---------|-------------|
| **Wave Execution** | Esecuzione parallela di task con gestione intelligente delle dipendenze |
| **Atomic Commits** | Un commit per task — git bisect, rollback facili |
| **Manual Verification** | User acceptance testing con debugging automatizzato |
| **Brownfield Support** | Analisi codebase esistenti prima di iniziare |
| **Model Profiles** | Bilancia qualità vs costo con agenti configurabili |
| **Multi-Runtime** | Funziona con Claude Code, OpenCode, Gemini, Codex, Copilot |

### Perché GSD?

**Problema**: Altri strumenti spec-driven aggiungono complessità:
- Sprint ceremonies
- Story points
- Jira workflows
- Overhead processes

**Soluzione GSD**: Complessità nel sistema, non nel tuo workflow.

---

## 📦 Installazione

### Installazione Completa

GSD è già installato per tutti gli AI agents in questo progetto:

```bash
# Installazione automatica completata
✅ Claude Code: ~/.claude/commands/gsd/
✅ Gemini CLI: ~/.gemini/get-shit-done/
✅ GitHub Copilot: ~/.github/get-shit-done/
✅ OpenCode: ~/.config/opencode/
```

### Verifica Installazione

```bash
# Claude Code / Gemini
/gsd:help

# OpenCode
/gsd-help

# Codex
$gsd-help

# GitHub Copilot
/gsd:help
```

### Struttura Directory

```
.gemini/get-shit-done/
├── commands/              # Comandi GSD per Gemini
├── skills/                # Skill GSD
└── docs/                  # Documentazione

.github/get-shit-done/
├── commands/              # Comandi per Copilot
└── skills/                # Skill GSD

.claude/commands/gsd/
├── new-project.md         # Inizializza progetto
├── discuss-phase.md       # Discuti fase
├── plan-phase.md          # Pianifica fase
├── execute-phase.md       # Esegui fase
└── verify-work.md         # Verifica lavoro
```

---

## 🔄 Workflow GSD

### Ciclo Completo

```
┌─────────────────────────────────────────────────────────────┐
│                    GSD WORKFLOW                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  /gsd:new-project                                            │
│    ↓ Domande → Research → Requirements → Roadmap             │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │  PHASE LOOP (per ogni fase)                           │ │
│  │                                                         │ │
│  │  /gsd:discuss-phase [N]                                 │ │
│  │    → Cattura decisioni implementative → CONTEXT.md      │ │
│  │                                                         │ │
│  │  /gsd:plan-phase [N]                                    │ │
│  │    → Research + Plan + Verify → PLAN.md                 │ │
│  │                                                         │ │
│  │  /gsd:execute-phase [N]                                 │ │
│  │    → Esecuzione a wave → Commit atomici → SUMMARY.md    │ │
│  │                                                         │ │
│  │  /gsd:verify-work [N]                                   │ │
│  │    → User acceptance testing → UAT.md                   │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  /gsd:complete-milestone                                     │
│    → Archivia milestone, tag release                         │
│                                                              │
│  /gsd:new-milestone [nome]                                   │
│    → Inizia nuova versione                                   │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### 1. Inizializza Progetto

```bash
/gsd:new-project
```

**Cosa fa**:
1. **Ti intervista** — Fa domande finché non capisce il progetto
2. **Research** — Spawning agent paralleli per investigare il dominio
3. **Estrae requirements** — Separa v1, v2, e out of scope
4. **Crea roadmap** — Mappa requirements a fasi eseguibili

**File creati**:
- `PROJECT.md` — Vision del progetto
- `REQUIREMENTS.md` — Requirements scoped con traceability
- `ROADMAP.md` — Fasi mappate ai requirements
- `STATE.md` — Documento living per decisioni e blockers
- `.planning/research/` — Research findings

**Pro tip**: Preparati con descrizione dettagliata:
- Goals
- Target users
- Core features
- Constraints
- Tech stack preferences

### 2. Discuti la Fase

```bash
/gsd:discuss-phase 1
```

**NON saltare questo step!**

GSD identifica aree grigie e fa domande mirate:
- **Feature visuali?** — Layout, density, interactions, empty states
- **API/CLIs?** — Response format, error handling, flags
- **Content systems?** — Structure, tone, depth

Le tue risposte vanno in `CONTEXT.md`, che feeda planning ed execution.

> "Plan twice. Prompt once." — Mauvis Ledford

### 3. Pianifica la Fase

```bash
/gsd:plan-phase 1
```

GSD:
1. **Research** — Come implementare questa fase
2. **Plan** — Crea 2-3 atomic task plans in struttura XML
3. **Verify** — Check plans against requirements, loops until pass

**Esempio atomic plan**:

```xml
<task type="auto">
  <name>Crea endpoint login</name>
  <files>src/app/api/auth/login/route.ts</files>
  <action>
    Usa jose per JWT (non jsonwebtoken - CommonJS issues).
    Valida credentials contro users table.
    Ritorna httpOnly cookie on success.
  </action>
  <verify>curl -X POST localhost:3000/api/auth/login returns 200</verify>
  <done>Valid credentials return cookie, invalid return 401</done>
</task>
```

### 4. Esegui la Fase

```bash
/gsd:execute-phase 1
```

GSD:
1. **Groups plans into waves** — Task indipendenti in parallelo, dipendenti aspettano
2. **Spawns fresh sub-agents** — Ognuno ha 200K tokens puri per implementation
3. **Commits per task** — Ogni task completato ha il suo atomic git commit
4. **Verifies against goals** — Check che il codice consegni ciò che la fase ha promesso

**Visualizzazione**:

```
WAVE 1 (parallel)          WAVE 2 (parallel)          WAVE 3
+-----------+ +-----------+  +-----------+ +-----------+  +-----------+
| User      | | Product   |  | Orders    | | Cart      |  | Checkout  |
| Model     | | Model     |  | API       | | API       |  | UI        |
+-----------+ +-----------+  +-----------+ +-----------+  +-----------+
     |            |               ^            ^               ^
     +------------+---------------+------------+               |
         Dependencies flow forward through waves
```

### 5. Verifica il Lavoro

```bash
/gsd:verify-work 1
```

GSD:
1. **Estrae deliverables testabili** — Cosa dovresti poter fare ora
2. **Ti guida attraverso ognuno** — "Puoi fare login con email?" Yes/no.
3. **Diagnostica failures** — Spawning debug agents per root causes
4. **Crea fix plans** — Ready per re-execution

Se tutto passa, procedi. Se qualcosa è rotto, run `/gsd:execute-phase` again.

### 6. Ripeti

```bash
/gsd:discuss-phase 2
/gsd:plan-phase 2
/gsd:execute-phase 2
/gsd:verify-work 2
...
/gsd:complete-milestone
```

Loop through all phases. When done, `/gsd:complete-milestone` archivia tutto e tagga il release.

Vuoi costruire di più? `/gsd:new-milestone` inizia la next version.

---

## 🚀 Comandi

### Core Workflow Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:new-project` | Inizializza nuovo progetto: questions → research → requirements → roadmap |
| `/gsd:discuss-phase [N]` | Cattura decisioni implementative prima del planning |
| `/gsd:plan-phase [N]` | Research + plan + verify per una fase |
| `/gsd:execute-phase <N>` | Esegui tutti i plans in parallel waves |
| `/gsd:verify-work [N]` | Manual user acceptance testing |
| `/gsd:audit-milestone` | Verify milestone ha raggiunto definition of done |
| `/gsd:complete-milestone` | Archivia milestone, tag release |
| `/gsd:new-milestone [name]` | Inizia nuova versione |

### Navigation Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:progress` | Dove sono? Cosa segue? |
| `/gsd:help` | Mostra tutti i comandi e usage guide |
| `/gsd:update` | Aggiorna GSD con changelog preview |
| `/gsd:join-discord` | Join the GSD Discord community |

### Phase Management Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:add-phase` | Append phase to roadmap |
| `/gsd:insert-phase [N]` | Insert urgent work between phases |
| `/gsd:remove-phase [N]` | Remove future phase, renumber |
| `/gsd:list-phase-assumptions [N]` | See Claude's intended approach |
| `/gsd:plan-milestone-gaps` | Create phases to close gaps from audit |

### Session Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:pause-work` | Create handoff quando ti fermi mid-phase |
| `/gsd:resume-work` | Restore from last session |

### Utility Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:settings` | Configure model profile e workflow agents |
| `/gsd:set-profile <profile>` | Switch model profile |
| `/gsd:add-todo [desc]` | Capture idea for later |
| `/gsd:check-todos` | List pending todos |
| `/gsd:debug [desc]` | Systematic debugging with persistent state |
| `/gsd:quick` | Execute ad-hoc task with GSD guarantees |
| `/gsd:health` | Validate .planning/ directory integrity |
| `/gsd:stats` | Display project statistics |

### Brownfield Commands

| Command | Descrizione |
|---------|-------------|
| `/gsd:map-codebase [area]` | Analyze existing codebase before new-project |

---

## 📁 Structured Files

GSD usa structured files per context engineering:

| File | Purpose | Always Loaded |
|------|---------|---------------|
| **PROJECT.md** | Project vision | ✅ |
| **REQUIREMENTS.md** | Scoped v1/v2 requirements | ✅ |
| **ROADMAP.md** | Where you're going, what's done | ✅ |
| **STATE.md** | Decisions, blockers, memory | ✅ |
| **research/** | Ecosystem knowledge | Per-phase |
| **CONTEXT.md** | Implementation decisions | Per-phase |
| **PLAN.md** | Atomic task with XML structure | Per-task |
| **SUMMARY.md** | What happened, committed to history | Per-task |
| **VERIFICATION.md** | Verification results | Per-phase |
| **UAT.md** | User acceptance testing | Per-phase |
| **todos/** | Captured ideas for later | ✅ |

### Esempio Struttura

```
.planning/
├── config.json              # Project configuration
├── PROJECT.md               # Project vision
├── REQUIREMENTS.md          # Scoped requirements (v1/v2)
├── ROADMAP.md               # Phase roadmap with completion status
├── STATE.md                 # Decisions, blockers, memory
├── research/                # Domain research per phase
│   └── {phase_num}-RESEARCH.md
├── {phase_num}-CONTEXT.md   # Implementation decisions
├── {phase_num}-{N}-PLAN.md  # Atomic task plans (XML)
├── {phase_num}-{N}-SUMMARY.md # Execution results
├── {phase_num}-VERIFICATION.md # Phase verification
├── {phase_num}-UAT.md       # User acceptance testing
├── todos/                   # Captured ideas
│   └── pending.md
└── quick/                   # Quick mode tasks
    └── 001-task-name/
        ├── PLAN.md
        └── SUMMARY.md
```

---

## ⚙️ Configuration

### Model Profiles

GSD supporta tre profili per bilanciare qualità e costo:

| Profile | Planning | Execution | Verification | Use Case |
|---------|----------|-----------|--------------|----------|
| **quality** | Opus | Opus | Sonnet | Critical architecture |
| **balanced** (default) | Opus | Sonnet | Sonnet | Balanced performance |
| **budget** | Sonnet | Sonnet | Haiku | High-volume work |

**Switch profiles**:
```bash
/gsd:set-profile budget
```

### Core Settings

| Setting | Options | Default | Description |
|---------|---------|---------|-------------|
| `mode` | yolo, interactive | interactive | Auto-approve vs confirm |
| `granularity` | coarse, standard, fine | standard | Phase scoping |
| `workflow.research` | true, false | true | Research domain before planning |
| `workflow.plan_check` | true, false | true | Verify plans achieve goals |
| `workflow.verifier` | true, false | true | Confirm deliverables after execution |

---

## 🎯 Quick Mode

Per task ad-hoc che non need full planning:

```bash
/gsd:quick
> "Add dark mode toggle to settings"
```

### Flags

| Flag | Description |
|------|-------------|
| `--discuss` | Lightweight discussion to surface gray areas |
| `--research` | Spawns focused researcher before planning |
| `--full` | Enables plan-checking and post-execution verification |

**Composable**:
```bash
/gsd:quick --discuss --research --full
```

**Output**:
- `.planning/quick/001-add-dark-mode-toggle/PLAN.md`
- `.planning/quick/001-add-dark-mode-toggle/SUMMARY.md`

---

## 🔧 Best Practices

### 1. Usa la Discussion Phase

Non saltare `/gsd:discuss-phase`. Più vai deep, più il sistema build ciò che vuoi davvero.

### 2. Batch Questions

Usa `--batch` per faster intake:
```bash
/gsd:discuss-phase 2 --batch
```

### 3. Fresh Context Per Task

Ogni plan esegue in fresh 200k token context — no degradation.

### 4. Verify Before Moving On

Always run `/gsd:verify-work` prima di iniziare la next phase.

### 5. Small, Atomic Commits

Ogni task ha il suo commit — enables `git bisect`, easy reverts.

### 6. Usa Wave Execution

Plans indipendenti run in parallelo, piani dipendenti aspettano.

### 7. Update Regularly

```bash
npx get-shit-done-cc@latest
```

---

## 📊 GSD + BMAD Integration

Questo progetto usa **sia GSD che BMAD-METHOD**:

### Come Insieme

| Framework | Purpose | When to Use |
|-----------|---------|-------------|
| **GSD** | Meta-prompting, context engineering, atomic commits | Multi-phase projects, spec-driven development |
| **BMAD** | AI agent orchestration, agile workflows | Module development, Filament pages, Laravel patterns |

### Integration Pattern

```
┌─────────────────────────────────────────────────────────┐
│  GSD (High-level project management)                    │
│  - Context engineering                                   │
│  - Atomic commits                                        │
│  - Wave execution                                        │
│  - User acceptance testing                               │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│  BMAD-METHOD (Domain-specific workflows)                │
│  - Laravel module development                            │
│  - Filament page creation                                │
│  - PHPStan Level 10 compliance                           │
│  - Pest testing                                          │
└─────────────────────────────────────────────────────────┘
```

### Example Workflow

```bash
# 1. GSD: Initialize project
/gsd:new-project

# 2. GSD: Plan phase
/gsd:plan-phase 1

# 3. BMAD: Execute with Laravel skills
bmad-laravel-module-dev --module=Scheda

# 4. GSD: Verify work
/gsd:verify-work 1

# 5. GSD: Complete milestone
/gsd:complete-milestone
```

---

## 🔗 References

### Internal Documentation

- **GSD Guide**: `docs/gsd/README.md`
- **BMAD Integration**: `docs/bmad/README.md`
- **AI Coordination**: `docs/ai-agent-coordination.md`
- **Project Context**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`

### External Resources

- **GSD GitHub**: https://github.com/gsd-build/get-shit-done
- **GSD Docs**: https://gsd-build-get-shit-done.mintlify.app/
- **GSD Discord**: Run `/gsd:join-discord`
- **BMAD-METHOD**: https://docs.bmad-method.org

---

## 📝 Quick Reference Card

```
┌─────────────────────────────────────────────────────┐
│  GSD WORKFLOW                                       │
├─────────────────────────────────────────────────────┤
│  1. /gsd:new-project                                │
│     ↓                                               │
│  2. Discuss Phase                                   │
│     ↓                                               │
│  3. Plan Phase (PLAN.md)                            │
│     ↓                                               │
│  4. Execute (Wave Execution)                        │
│     ↓                                               │
│  5. Verify (UAT + Debug)                            │
│     ↓                                               │
│  6. Complete Milestone (STATE.md)                   │
└─────────────────────────────────────────────────────┘

KEY FILES:
- PROJECT.md    → Vision
- REQUIREMENTS.md → Scope
- ROADMAP.md    → Direction
- STATE.md      → Memory
- PLAN.md       → Tasks
- SUMMARY.md    → History

QUICK MODE:
/gsd:quick [--discuss] [--research] [--full]
```

---

*GSD Integration Guide v1.0.0*  
*Created: 2026-03-18*  
*Status: ✅ Active*
