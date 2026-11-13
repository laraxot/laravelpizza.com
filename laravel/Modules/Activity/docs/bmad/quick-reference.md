---
<<<<<<< .merge_file_CHG86D
title: "Activity — BMAD Quick Reference"
=======
title: "Activity: BMAD Quick Reference"
>>>>>>> .merge_file_8t1ByP
description: "Comandi rapidi BMAD per il modulo Activity"
module: "Activity"
alias: "activity"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
<<<<<<< .merge_file_CHG86D
---

# Activity — BMAD Quick Reference
=======
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad quick reference activity"
---

# Activity: BMAD Quick Reference
>>>>>>> .merge_file_8t1ByP

## Comandi Rapidi

### Help
```bash
bmad-help
```

### Workflow Activity

```bash
# Phase 1
bmad-domain-research      # Studio audit, logging
bmad-technical-research   # Fattibilità event sourcing

# Phase 2
bmad-create-prd           # PRD activity tracking
bmad-create-architecture  # Architettura logging

# Phase 3
bmad-create-epics-and-stories  # Epic: user actions, audit
bmad-check-implementation-readiness  # Quality gate

# Phase 4
bmad-sprint-planning      # Sprint planning
bmad-create-story         # Story: ActivityLog
bmad-dev-story            # Implementazione
bmad-code-review          # Review con focus privacy
```

### Agenti per Activity

| Agente | Skill | Scopo |
|--------|-------|-------|
| Mary (analyst) | `skill: "bmad-agent-analyst"` | ricerca audit |
| John (pm) | `skill: "bmad-agent-pm"` | PRD retention |
| Winston (architect) | `skill: "bmad-agent-architect"` | architettura logging |
| Amelia (dev) | `skill: "bmad-agent-dev"` | implementazione |
| Quinn (qa) | `skill: "bmad-agent-qa"` | test privacy, GDPR |

## Quick Flow

```bash
bmad-quick-dev "Aggiungi logging evento X"
bmad-quick-spec "Specifica retention log"
```

---

*Activity · BMAD Quick Reference · data 2026-05-27*