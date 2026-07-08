# 🎨 BMAD Workflow (Breakthrough Method for Agile AI-Driven Development)

**Part of**: [00-INDEX.md](00-INDEX.md) — AI Agents Coordination  
**Related**: [01-GSD-WORKFLOW.md](01-GSD-WORKFLOW.md) — GSD Method

---

## 📋 Overview

BMAD is an AI-driven agile development framework with 12+ specialized agents.

**Philosophy**:
- AI agents as **expert collaborators**, not replacements
- Structured process to bring out **your best thinking**
- 100% free and open source

---

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
- ✅ Document decisions in STATE.md
- ✅ Update requirements as you learn

### DON'T
- ❌ Skip analysis phase
- ❌ Use generic agent for specialized tasks
- ❌ Forget to capture learnings
- ❌ Work without clear requirements

---

## 🔗 Related Documentation

- **GSD Method**: [01-GSD-WORKFLOW.md](01-GSD-WORKFLOW.md)
- **Architecture**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md)
- **External**: https://github.com/bmad-code-org/BMAD-METHOD
- **Docs**: https://docs.bmad-method.org

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Active  
**Enforcement**: Code Review + Pre-commit Hook
