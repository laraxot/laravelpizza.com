---
title: "filament admin patterns"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "filament admin patterns"
issues: []
discussions: []
---

# 6. Filament (Admin) Patterns

- ALWAYS extend XotBase classes (NOT raw Filament classes)
- Use AutoLabelAction (NEVER use `->label()`)
- Translation keys: `module::resource.field.attribute`
- NEVER hardcode labels - use auto-generated translations

| Filament Class | Use Instead |
|----------------|-------------|
| `Resource` | `XotBaseResource` |
| `Page` | `XotBasePage` |
| `Widget` | `XotBaseWidget` |

---

title: "filament admin patterns"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "filament admin patterns"
issues: []
discussions: []
