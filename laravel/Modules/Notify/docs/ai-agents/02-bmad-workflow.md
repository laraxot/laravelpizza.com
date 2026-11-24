---
title: "02 BMAD Workflow"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
qmd: "02 BMAD Workflow"
issues: []
discussions: []
---

# 🎨 BMAD Workflow (Breakthrough Method for Agile AI-Driven Development)

<<<<<<< HEAD
=======
<<<<<<< HEAD
**Part of**: [00-INDEX.md](00-index.md) — AI Agents Coordination  
**Related**: [01-GSD-WORKFLOW.md](01-gsd-workflow.md) — GSD Method

## 📋 Overview

=======
>>>>>>> laraxot/dev
**Part of**: [00-index.md](00-index.md) — AI Agents Coordination  
**Related**: [01-gsd-workflow.md](01-gsd-workflow.md) — GSD Method

---

title: "02 BMAD WORKFLOW"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "02 BMAD WORKFLOW"
issues: []
discussions: []
## 📋 Overview

BMAD is an AI-driven agile development framework with 12+ specialized agents.

**Philosophy**:
- AI agents as **expert collaborators**, not replacements
- Structured process to bring out **your best thinking**
- 100% free and open source

---

<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
## 🔧 Installation

```bash
# Interactive install
npx bmad-method install

# Non-interactive (CI/CD)
npx bmad-method install \
  --directory /path/to/project \
  --modules bmm \
  --tools claude-code \
  --yes

# Prerelease
npx bmad-method@next install
```

**Post-Install**:
```bash
bmad-help  # Ask for help
```

---

## 🎯 Specialized Agents (12+)

| Agent | Role | When to Use |
|-------|------|-------------|
| **PM** | Product Manager | Requirements, prioritization |
| **Architect** | System Architect | Architecture decisions |
| **Developer** | Implementation | Code implementation |
| **UX Designer** | UI/UX Design | User experience |
| **QA** | Quality Assurance | Testing, verification |
| **Analyst** | Research | Benchmarking, analysis |
| **Scrum Master** | Process | Agile workflow |
| **+ 5 more** | Various | Specialized tasks |

---

## 📊 Modules

| Module | Purpose | Workflows |
|--------|---------|-----------|
| **BMM** (BMad Method) | Core framework | 34+ workflows |
| **BMB** (BMad Builder) | Custom agents | Create custom workflows |
| **TEA** (Test Architect) | Test strategy | Risk-based testing |
| **BMGD** (Game Dev) | Game development | Unity, Unreal, Godot |
| **CIS** (Creative Intelligence) | Innovation | Brainstorming, design thinking |

---

## 🎭 Party Mode

Bring multiple agent personas into one session to collaborate:

```bash
bmad-party --agents pm,architect,developer
```

Agents discuss together and reach consensus.

---

## 🛠️ Core Workflows

### 1. Analysis Phase
- Requirements gathering
- Stakeholder analysis
- Risk assessment

### 2. Planning Phase
- Architecture design
- Task breakdown
- Estimation

### 3. Implementation Phase
- Code generation
- Review cycles
- Testing

### 4. Verification Phase
- UAT
- Quality gates
- Documentation

---

## ✅ Best Practices

### DO
- ✅ Use specialized agents for their domain
- ✅ Engage in structured discussions
<<<<<<< HEAD
- ✅ Document decisions in STATE.md
=======
<<<<<<< HEAD
- ✅ document decisions in state.md
=======
- ✅ Document decisions in STATE.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- ✅ Update requirements as you learn

### DON'T
- ❌ Skip analysis phase
- ❌ Use generic agent for specialized tasks
- ❌ Forget to capture learnings
- ❌ Work without clear requirements

---

## 🔗 Related Documentation

- **GSD Method**: [01-gsd-workflow.md](01-gsd-workflow.md)
- **Architecture**: [03-architecture-zen.md](03-architecture-zen.md)
- **External**: https://github.com/bmad-code-org/BMAD-METHOD
- **Docs**: https://docs.bmad-method.org

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Active  
**Enforcement**: Code Review + Pre-commit Hook
