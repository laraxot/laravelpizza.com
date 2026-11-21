---
title: "User — BMAD Quick Reference"
description: "Comandi rapidi BMAD per il modulo User"
module: "User"
alias: "user"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
---

# User — BMAD Quick Reference

## Comandi Rapidi

### Help
```bash
bmad-help
```

### Workflow User

```bash
# Phase 1
bmad-domain-research      # Studio dominio identità
bmad-technical-research   # Fattibilità architettura

# Phase 2
bmad-create-prd           # PRD modulo User
bmad-create-architecture  # Architettura DB separata

# Phase 3
bmad-create-epics-and-stories  # Epic User auth, OAuth, SSO
bmad-check-implementation-readiness  # Quality gate

# Phase 4
bmad-sprint-planning      # Sprint planning
bmad-create-story         # Story implementazione
bmad-dev-story            # Dev + test
bmad-code-review          # Review
```

### Agenti per User

| Agente | Skill | Scopo |
|--------|-------|-------|
| Mary (analyst) | `skill: "bmad-agent-analyst"` | ricerca dominio |
| John (pm) | `skill: "bmad-agent-pm"` | PRD auth, social |
| Winston (architect) | `skill: "bmad-agent-architect"` | architettura DB |
| Amelia (dev) | `skill: "bmad-agent-dev"` | implementazione login |
| Quinn (qa) | `skill: "bmad-agent-qa"` | test sicurezza |

## Quick Flow

```bash
bmad-quick-dev "Aggiungi social provider"
bmad-quick-spec "Spec OTP 2FA"
```

## Vedi Anche

- [setup-guide](setup-guide.md)

---

*User · BMAD Quick Reference · data 2026-05-27*