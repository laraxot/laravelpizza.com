# 🚀 GSD Workflow (Get Shit Done)

**Part of**: [00-INDEX.md](00-INDEX.md) — AI Agents Coordination  
**Related**: [02-BMAD-WORKFLOW.md](02-BMAD-WORKFLOW.md) — BMAD Method

---

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
| `REQUIREMENTS.md` | Scoped requirements v1/v2 |
| `ROADMAP.md` | Where you're going |
| `STATE.md` | Decisions, blockers, memory |
| `PLAN.md` | Atomic task with XML structure |
| `SUMMARY.md` | What happened, commit history |

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
- ✅ Update STATE.md after each session

### DON'T
- ❌ Skip discussion phase
- ❌ Ship without verification
- ❌ Use wrong profile for production
- ❌ Forget to update state files

---

## 🔗 Related Documentation

- **BMAD Method**: [02-BMAD-WORKFLOW.md](02-BMAD-WORKFLOW.md)
- **Architecture**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md)
- **External**: https://github.com/gsd-build/get-shit-done

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Active  
**Enforcement**: Code Review + Pre-commit Hook
