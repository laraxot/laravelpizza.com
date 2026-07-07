---
title: "Lang Module — Context-Mode Discipline"
type: "rule"
tags: [lang, context-mode, translations, governance]
created: 2026-05-12
updated: 2026-05-12
---

# Lang Module — Context-Mode Discipline

> Lang module context-mode per translation keys governance.

## File Wiki Limits

```
laravel/Modules/Lang/docs/wiki/
├── index.md                              # ≤30 righe
├── rules/
│   ├── INDEX.md                          # ≤20 righe
│   ├── translation-key-governance.md     # ≤200 righe
│   └── translation-audit.md              # ≤150 righe
├── skills/
│   ├── INDEX.md                          # ≤20 righe
│   └── translation-key-audit.md          # ≤100 righe
└── concepts/
    └── translation-ownership.md           # ≤150 righe
```

---

## On-Demand Loading

| Trigger | Load |
|---------|------|
| Translation key governance | `laravel/Modules/Lang/docs/wiki/rules/translation-key-governance.md` |
| Translation ownership audit | `laravel/Modules/Lang/docs/wiki/skills/translation-key-audit.md` |

---

## Query Discipline

```bash
# ✅ Specifico
qmd search "translation key governance" --limit 2

# ❌ Troppo generico
qmd search "translation"  # Carica archivi
```

---

## Context Savings

- **Max:** 3K tokens per session
- **No archive loads:** Archivi disabilitati nel .gitignore
- **Query limit:** 1-2 risultati

---

## Vedi anche

- User module: `laravel/Modules/User/docs/wiki/concepts/context-mode-user-discipline.md`
- Root: `docs/wiki/concepts/context-mode-optimal-configuration.md`
