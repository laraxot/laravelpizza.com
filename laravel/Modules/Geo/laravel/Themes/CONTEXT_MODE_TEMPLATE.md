---
title: "Theme Name — Context-Mode Discipline Template"
type: "rule"
tags: [theme, context-mode, atomic-wiki]
created: 2026-05-12
updated: 2026-05-12
---

# Theme Name — Context-Mode Discipline

> Template per context-mode discipline in ogni tema.

## Instrzioni di Setup

1. Renomina questo file a `docs/wiki/concepts/context-mode-<theme-name>-discipline.md`
2. Aggiorna il title e i riferimenti
3. Mantieni max 150 righe per tema

---

## File Wiki Limits

```
laravel/Themes/<ThemeName>/docs/wiki/
├── index.md                    # ≤30 righe
├── rules/INDEX.md              # ≤20 righe
└── concepts/
    └── context-mode-discipline.md  # ≤150 righe
```

---

## On-Demand Loading

| Trigger | Load |
|---------|------|
| Theme creation | `laravel/Themes/<ThemeName>/docs/wiki/concepts/context-mode-discipline.md` |

---

## Context Savings

- **Max:** 1-2K tokens per session
- **Minimal wiki:** Solo essenziale per tema

---

## Vedi anche

- Root: `docs/wiki/concepts/context-mode-optimal-configuration.md`
- Module examples: `laravel/Modules/Xot/docs/wiki/concepts/context-mode-xot-discipline.md`
