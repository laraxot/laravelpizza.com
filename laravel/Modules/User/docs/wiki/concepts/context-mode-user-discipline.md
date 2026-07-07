---
title: "User Module — Context-Mode Discipline"
type: "rule"
tags: [user, context-mode, atomic-wiki, filament-translations]
created: 2026-05-12
updated: 2026-05-12
---

# User Module — Context-Mode Discipline

> User module context-mode per traduzioni Filament e LangServiceProvider.

## File Wiki Limits

```
laravel/Modules/User/docs/wiki/
├── index.md                           # ≤30 righe
├── rules/
│   ├── INDEX.md                       # ≤20 righe → root trigger map
│   └── filament-user-labels.md        # ≤150 righe
├── skills/
│   ├── INDEX.md                       # ≤20 righe
│   └── filament-translation-audit.md  # ≤100 righe
└── concepts/
    └── langserviceprovider-pattern.md  # ≤150 righe
```

---

## On-Demand Loading

| Trigger | Load |
|---------|------|
| User Filament translations | `laravel/Modules/User/docs/wiki/skills/filament-translation-audit.md` |
| LangServiceProvider setup | `laravel/Modules/User/docs/wiki/concepts/langserviceprovider-pattern.md` |

---

## Context Savings

- **Max per session:** 5K tokens (User wiki small)
- **Query limit:** 2-3 risultati per ricerca
- **Vietato:** Caricare tutto il `docs/wiki/` User

---

## Vedi anche

- Lang module: `laravel/Modules/Lang/docs/wiki/concepts/context-mode-lang-discipline.md`
- Root: `docs/wiki/concepts/context-mode-optimal-configuration.md`
