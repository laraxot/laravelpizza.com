---
title: "01 GSD Workflow"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_FMFhW6
<<<<<<< .merge_file_GdMPEV
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_V3faQK
=======
>>>>>>> .merge_file_HryMrd
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_FMFhW6
<<<<<<< .merge_file_GdMPEV
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_V3faQK
=======
>>>>>>> .merge_file_HryMrd
qmd: "01 GSD Workflow"
issues: []
discussions: []
---

# 🚀 GSD Workflow (Get Shit Done)

<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< .merge_file_FMFhW6
<<<<<<< .merge_file_GdMPEV
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_V3faQK
=======
>>>>>>> .merge_file_HryMrd
**Part of**: [00-INDEX.md](00-index.md) — AI Agents Coordination  
**Related**: [02-bmad-workflow-2.md](02-bmad-workflow.md) — BMAD Method

## 📋 Overview

<<<<<<< .merge_file_FMFhW6
<<<<<<< .merge_file_GdMPEV
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
=======
=======
>>>>>>> .merge_file_V3faQK
=======
=======
>>>>>>> .merge_file_HryMrd
>>>>>>> laraxot/dev
**Part of**: [00-index.md](00-index.md) — AI Agents Coordination  
**Related**: [02-bmad-workflow.md](02-bmad-workflow.md) — BMAD Method

---

title: "01 GSD WORKFLOW"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "01 GSD WORKFLOW"
issues: []
discussions: []
## 📋 Overview

GSD is a spec-driven development system for AI coding agents.

**Problem Solved**:
- **Context Rot**: Quality degradation when AI fills context window
- **Inconsistent Vibecoding**: Garbage code on large scale

**Solution**:
- Context engineering layer
- Meta-prompting with XML formatting
- Multi-agent orchestration
- Atomic Git commits

---

<<<<<<< HEAD
=======
<<<<<<< .merge_file_FMFhW6
<<<<<<< .merge_file_GdMPEV
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
=======
>>>>>>> .merge_file_V3faQK
=======
>>>>>>> .merge_file_HryMrd
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
## 🔧 Installation

```bash
# Interactive install
npx get-shit-done-cc@latest

# Non-interactive (specific runtime)
npx get-shit-done-cc --claude --global
npx get-shit-done-cc --opencode --global
npx get-shit-done-cc --gemini --global
```

**Verify**:
```bash
/gsd:help    # Claude Code / Gemini
/gsd-help    # OpenCode
$gsd-help    # Codex
```

---

## 📊 Core Workflow

### 1. New Project
```bash
/gsd:new-project [--auto]
```
- Questions → Research → Requirements → Roadmap

### 2. Phase Workflow
```bash
# For each phase:
/gsd:discuss-phase 1      # Capture decisions
/gsd:plan-phase 1         # Research + planning
/gsd:execute-phase 1      # Implementation
/gsd:verify-work 1        # Human verification
/gsd:ship 1               # Create PR
```

### 3. Milestone Management
```bash
/gsd:complete-milestone   # Archive milestone
/gsd:new-milestone        # Start new version
```

---

## 🎯 Wave Execution

```
WAVE 1 (parallel)     WAVE 2 (parallel)     WAVE 3
┌─────────┐ ┌─────────┐  ┌─────────┐ ┌─────────┐  ┌─────────┐
│ Plan 01 │ │ Plan 02 │→ │ Plan 03 │ │ Plan 04 │→ │ Plan 05 │
│ User    │ │ Product │  │ Orders  │ │ Cart    │  │ Checkout│
│ Model   │ │ Model   │  │ API     │ │ API     │  │ UI      │
└─────────┘ └─────────┘  └─────────┘ └─────────┘  └─────────┘
```

- **Independent plans** → Same wave → Executed in parallel
- **Dependent plans** → Next wave → Wait for dependencies

---

## 🛠️ Commands Reference

### Core Commands
| Command | Description |
|---------|-------------|
| `/gsd:new-project` | Initialize complete project |
| `/gsd:discuss-phase [N]` | Capture implementation decisions |
| `/gsd:plan-phase [N]` | Research + plan for phase |
| `/gsd:execute-phase <N>` | Execute all plans in parallel waves |
| `/gsd:verify-work [N]` | Manual user acceptance testing |
| `/gsd:ship [N] [--draft]` | Create PR from verified work |
| `/gsd:complete-milestone` | Archive milestone, tag release |
| `/gsd:new-milestone [name]` | Start new version |

### Navigation & Utils
| Command | Description |
|---------|-------------|
| `/gsd:progress` | Where am I? What's next? |
| `/gsd:help` | Show all commands |
| `/gsd:update` | Update GSD |
| `/gsd:pause-work` | Create handoff (mid-phase) |
| `/gsd:resume-work` | Resume session |
| `/gsd:settings` | Configure workflow |
| `/gsd:set-profile <profile>` | quality/balanced/budget/inherit |
| `/gsd:add-todo [desc]` | Capture idea for later |
| `/gsd:debug [desc]` | Systematic debugging |
| `/gsd:health [--repair]` | Verify `.planning/` integrity |
| `/gsd:stats` | Project statistics |

### Quick Mode (Ad-hoc Tasks)
```bash
/gsd:quick [--full] [--discuss] [--research]
```
- `--discuss`: Capture context before planning
- `--research`: Investigate approaches before planning
- `--full`: Enable plan-checking + verification

---

## 📁 State Files

GSD maintains these files always loaded in context:

| File | Purpose |
|------|---------|
| `PROJECT.md` | Project vision |
| `research/` | Ecosystem knowledge |
| `requirements-2.md` | Scoped requirements v1/v2 |
| `roadmap.md` | Where you're going |
| `state-2.md` | Decisions, blockers, memory |
| `plan-2.md` | Atomic task with XML structure |
| `summary-2.md` | What happened, commit history |

---

## 🎯 Model Profiles

| Profile | Planning | Execution | Verification |
|---------|----------|-----------|--------------|
| **quality** | Opus | Opus | Sonnet |
| **balanced** (default) | Opus | Sonnet | Sonnet |
| **budget** | Sonnet | Sonnet | Haiku |
| **inherit** | Inherit | Inherit | Inherit |

```bash
/gsd:set-profile budget
```

---

## ✅ Best Practices

### DO
- ✅ Use `/gsd:discuss-phase` before planning
- ✅ Verify with `/gsd:verify-work` before shipping
- ✅ Create atomic commits per task
- ✅ Update state-2.md after each session

### DON'T
- ❌ Skip discussion phase
- ❌ Ship without verification
- ❌ Use wrong profile for production
- ❌ Forget to update state files

---

## 🔗 Related Documentation

- **BMAD Method**: [02-bmad-workflow.md](02-bmad-workflow.md)
- **Architecture**: [03-architecture-zen.md](03-architecture-zen.md)
- **External**: https://github.com/gsd-build/get-shit-done

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Active  
**Enforcement**: Code Review + Pre-commit Hook
