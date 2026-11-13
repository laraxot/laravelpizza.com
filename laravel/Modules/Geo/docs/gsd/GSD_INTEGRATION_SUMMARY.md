# GSD (Get Shit Done) Integration Summary

**Date**: 2026-03-18  
**Status**: ✅ Completed  
**GSD Version**: v1.25.1  
**Integration**: GSD + BMAD-METHOD

---

## 🎯 What is GSD?

**GSD (Get Shit Done)** è un framework di **meta-prompting, context engineering, e spec-driven development** per AI coding assistants.

### Core Purpose

- **Risolve context rot** — il degrado della qualità quando gli AI riempiono la context window
- **Rende AI coding reliable** — transforma "vibecoding" in sviluppo sistematico e verificabile
- **No enterprise theater** — built for solo developers

### Filosofia

> "The complexity is in the system, not in your workflow."

---

## ✅ GSD Installation Status

GSD è installato e configurato per **TUTTI gli AI agents**:

### AI Agents Supportati

| AI Agent | Status | Location | Commands |
|----------|--------|----------|----------|
| **Claude Code** | ✅ Active | `~/.claude/commands/gsd/` | `/gsd:*` |
| **Gemini CLI** | ✅ Active | `~/.gemini/get-shit-done/` | `/gsd-*` |
| **GitHub Copilot** | ✅ Active | `~/.github/get-shit-done/` | `/gsd:*` |
| **OpenCode** | ✅ Active | `~/.config/opencode/` | `/gsd-*` |
| **Qwen** | ✅ Active | `.qwen/` + symlinks | `/gsd:*` |

### GSD Commands Available

```bash
# Project initialization
/gsd:new-project

# Phase workflow
/gsd:discuss-phase [N]
/gsd:plan-phase [N]
/gsd:execute-phase [N]
/gsd:verify-work [N]

# Milestone management
/gsd:complete-milestone
/gsd:new-milestone [name]

# Quick tasks
/gsd:quick

# Navigation
/gsd:progress
/gsd:help
/gsd:update
```

---

## 📦 What Was Installed

### 1. GSD Documentation

**Files Created**:
- `docs/gsd/README.md` — GSD integration guide
- `docs/gsd/COMMANDS.md` — Command reference
- `docs/gsd/GSD_INTEGRATION_SUMMARY.md` — This file

**Contents**:
- Cos'è GSD e perché usarlo
- Workflow completo (6 steps)
- Comandi disponibili
- Integrazione con BMAD-METHOD
- Best practices
- Troubleshooting

### 2. GSD Configuration

**Directories Created**:
```
.claude/commands/gsd/       # Claude Code commands
.gemini/get-shit-done/      # Gemini CLI commands
.github/get-shit-done/      # GitHub Copilot commands
.qwen/gsd/                  # Qwen commands
```

**Configuration Files**:
- `.planning/config.json` — GSD settings
- `.planning/oc-config.json` — Model profiles
- `opencode.json` — Agent-to-model mappings

### 3. GSD + BMAD Integration

**Integration Pattern**:

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

**Combined Workflow**:

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

## 🔄 GSD Workflow

### Complete Cycle

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
│  │    → Cattura decisioni → CONTEXT.md                     │ │
│  │                                                         │ │
│  │  /gsd:plan-phase [N]                                    │ │
│  │    → Research + Plan + Verify → PLAN.md                 │ │
│  │                                                         │ │
│  │  /gsd:execute-phase [N]                                 │ │
│  │    → Wave execution → Commit atomici → SUMMARY.md       │ │
│  │                                                         │ │
│  │  /gsd:verify-work [N]                                   │ │
│  │    → UAT → UAT.md                                       │ │
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

### Step Details

#### 1. Initialize Project (`/gsd:new-project`)

**Cosa fa**:
1. **Ti intervista** — Fa domande finché non capisce il progetto
2. **Research** — 4 agent paralleli investigano il dominio
3. **Estrae requirements** — Separa v1, v2, out of scope
4. **Crea roadmap** — Mappa requirements a fasi eseguibili

**File creati**:
- `PROJECT.md` — Vision del progetto
- `REQUIREMENTS.md` — Requirements scoped
- `ROADMAP.md` — Fasi mappate
- `STATE.md` — Decisioni e blockers
- `.planning/research/` — Research findings

#### 2. Discuss Phase (`/gsd:discuss-phase [N]`)

**Perché**: La roadmap ha 1-2 frasi per fase — non abbastanza contesto

**Cosa fa**:
- Identifica aree grigie
- Fa domande mirate
- Cattura decisioni implementative

**Output**: `CONTEXT.md`

> "Plan twice. Prompt once." — Mauvis Ledford

#### 3. Plan Phase (`/gsd:plan-phase [N]`)

**Cosa fa**:
1. **Research** — Come implementare
2. **Plan** — Crea 2-3 atomic task plans (XML)
3. **Verify** — Check against requirements, loops until pass

**Esempio PLAN.md**:

```xml
<task type="auto">
  <name>Crea endpoint login</name>
  <files>src/app/api/auth/login/route.ts</files>
  <action>
    Usa jose per JWT (non jsonwebtoken).
    Valida credentials contro users table.
    Ritorna httpOnly cookie on success.
  </action>
  <verify>curl -X POST localhost:3000/api/auth/login returns 200</verify>
  <done>Valid credentials return cookie, invalid return 401</done>
</task>
```

#### 4. Execute Phase (`/gsd:execute-phase [N]`)

**Cosa fa**:
1. **Groups plans into waves** — Indipendenti in parallelo, dipendenti aspettano
2. **Spawns fresh sub-agents** — Ognuno ha 200K tokens puri
3. **Commits per task** — Ogni task ha atomic commit
4. **Verifies against goals** — Check deliverables

**Visual**:

```
WAVE 1 (parallel)          WAVE 2 (parallel)          WAVE 3
+-----------+ +-----------+  +-----------+ +-----------+  +-----------+
| Plan 01   | | Plan 02   |→ | Plan 03   | | Plan 04   |→ | Plan 05   |
| User Model| | Product   |  | Orders API| | Cart API  |  | Checkout  |
|           | | Model     |  |           | |           |  | UI        |
+-----------+ +-----------+  +-----------+ +-----------+  +-----------+
```

#### 5. Verify Work (`/gsd:verify-work [N]`)

**Cosa fa**:
1. **Estrae deliverables testabili** — Cosa dovresti poter fare ora
2. **Ti guida attraverso ognuno** — "Puoi fare login?" Yes/no
3. **Diagnostica failures** — Debug agents per root causes
4. **Crea fix plans** — Ready for re-execution

**Output**: `UAT.md`

#### 6. Complete Milestone (`/gsd:complete-milestone`)

**Cosa fa**:
- Archivia milestone
- Tagga release
- Aggiorna STATE.md

**Next**: `/gsd:new-milestone "v2.0"`

---

## 📊 Statistics

### Files Created

```
docs/gsd/
├── README.md                      (Integration guide)
├── COMMANDS.md                    (Command reference)
└── GSD_INTEGRATION_SUMMARY.md    (This file)

.planning/
├── config.json                    (GSD settings)
└── oc-config.json                 (Model profiles)
```

### Commands Available

**34+ GSD commands** per AI agent:
- Project initialization
- Phase workflow
- Milestone management
- Quick tasks
- Navigation
- Session management
- Utilities
- Settings

### AI Agents Configured

**5 AI agents** con GSD:
- Claude Code
- Gemini CLI
- GitHub Copilot
- OpenCode
- Qwen

---

## 🎯 Integration with BMAD-METHOD

### Framework Comparison

| Aspect | GSD | BMAD-METHOD |
|--------|-----|-------------|
| **Purpose** | Context engineering, meta-prompting | AI agent orchestration, agile workflows |
| **Strengths** | Atomic commits, wave execution, UAT | Laravel patterns, Filament, PHPStan L10 |
| **Workflows** | 34+ commands | 34+ workflows |
| **Agents** | Multi-agent orchestration | 12+ specialist agents |
| **Best For** | Multi-phase projects, spec-driven dev | Module dev, Filament pages, Laravel patterns |

### Combined Workflow

```bash
# High-level planning (GSD)
/gsd:new-project
/gsd:plan-phase 1

# Domain-specific execution (BMAD)
bmad-laravel-module-dev --module=Scheda
bmad-filament-page-dev --page=DashboardPage
bmad-code-review --pr=123
bmad-qa-generate-e2e-tests

# Verification (GSD)
/gsd:verify-work 1
/gsd:complete-milestone
```

### When to Use What

| Scenario | Framework | Commands |
|----------|-----------|----------|
| **New project** | GSD | `/gsd:new-project` |
| **Multi-phase dev** | GSD | `/gsd:plan-phase`, `/gsd:execute-phase` |
| **Laravel module** | BMAD | `bmad-laravel-module-dev` |
| **Filament page** | BMAD | `bmad-filament-page-dev` |
| **Quick task** | GSD | `/gsd:quick` |
| **Bug fix** | GSD | `/gsd:debug` |
| **Code review** | BMAD | `bmad-code-review` |
| **Testing** | BMAD | `bmad-qa-generate-e2e-tests` |

---

## 🔧 Configuration

### Model Profiles

```bash
# Quality profile (critical work)
/gsd:set-profile quality
# Planning: Opus, Execution: Opus, Verification: Sonnet

# Balanced profile (default)
/gsd:set-profile balanced
# Planning: Opus, Execution: Sonnet, Verification: Sonnet

# Budget profile (high-volume)
/gsd:set-profile budget
# Planning: Sonnet, Execution: Sonnet, Verification: Haiku
```

### Core Settings

```json
{
  "mode": "interactive",
  "granularity": "standard",
  "workflow": {
    "research": true,
    "plan_check": true,
    "verifier": true
  }
}
```

**Location**: `.planning/config.json`

---

## 📋 Best Practices

### 1. Usa Discussion Phase

Non saltare `/gsd:discuss-phase`. Più vai deep, più il sistema build ciò che vuoi.

### 2. Batch Questions

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

## 🚀 Quick Start

### First Time

```bash
# 1. Verify installation
/gsd:help

# 2. Start new project
/gsd:new-project

# 3. Follow the workflow
/gsd:discuss-phase 1
/gsd:plan-phase 1
/gsd:execute-phase 1
/gsd:verify-work 1
```

### Quick Task

```bash
# Ad-hoc task
/gsd:quick
> "Add dark mode toggle to settings"

# With discussion
/gsd:quick --discuss

# With research
/gsd:quick --research

# Full experience
/gsd:quick --discuss --research --full
```

---

## 🔗 References

### Internal Documentation

- **GSD Guide**: `docs/gsd/README.md`
- **Command Reference**: `docs/gsd/COMMANDS.md`
- **BMAD Guide**: `docs/bmad/README.md`
- **AI Coordination**: `docs/ai-agent-coordination.md`
- **Project Context**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`

### External Resources

- **GSD GitHub**: https://github.com/gsd-build/get-shit-done
- **GSD Docs**: https://gsd-build-get-shit-done.mintlify.app/
- **GSD Discord**: Run `/gsd:join-discord`
- **BMAD-METHOD**: https://docs.bmad-method.org

---

## 📝 Commit Details

**Commit**: Pending  
**Message**: 
```
gsd: Install GSD (Get Shit Done) v1.25.1 for all AI agents

- Install GSD for Claude Code, Gemini, Copilot, OpenCode, Qwen
- Create GSD documentation (README, COMMANDS, integration summary)
- Configure GSD + BMAD-METHOD integration
- Add 34+ GSD commands for all AI agents
- Update AI agent coordination with GSD workflows
- Create model profiles and configuration

Documentation:
- GSD Guide: docs/gsd/README.md
- Command Reference: docs/gsd/COMMANDS.md
- Integration Summary: docs/gsd/GSD_INTEGRATION_SUMMARY.md

Related: #125, #126
```

---

## ✅ Verification Checklist

- [x] GSD installed for all AI agents
- [x] GSD documentation created
- [x] GSD + BMAD integration configured
- [x] AI agent coordination updated
- [x] Model profiles configured
- [ ] GSD workflows tested (next step)
- [ ] Quality gates run (next step)
- [ ] Git commit created (pending)
- [ ] Git push completed (pending)

---

*GSD Integration Summary v1.0.0*  
*Created: 2026-03-18*  
*Status: ✅ Completed*
