---
title: "UI: BMAD Quick Reference"
description: "Comandi rapidi BMAD per il modulo UI"
module: "UI"
alias: "ui"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
type: note
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   bmad quick reference ui"
---

# UI: BMAD Quick Reference

## Comandi Rapidi

### Workflow UI

```bash
# Phase 1
bmad-domain-research      # Studio design system
bmad-technical-research   # Valutazione stack

# Phase 2
bmad-create-prd           # PRD design system
bmad-create-ux-design    # UX componenti

# Phase 3
bmad-create-architecture  # Architettura design system
bmad-create-epics-and-stories  # Epic componenti

# Phase 4
bmad-sprint-planning     # Sprint planning
bmad-dev-story           # Implementazione
bmad-code-review         # Review
```

### Agenti per UI

| Agente | Skill | Scopo |
|--------|-------|-------|
| Sally (ux) | `skill: "bmad-agent-ux-designer"` | design system |
| Amelia (dev) | `skill: "bmad-agent-dev"` | implementazione |
| Quinn (qa) | `skill: "bmad-agent-qa"` | test accessibilità |

## Vedi Anche

- [setup-guide](setup-guide.md)

---

*UI · BMAD Quick Reference · data 2026-05-27*