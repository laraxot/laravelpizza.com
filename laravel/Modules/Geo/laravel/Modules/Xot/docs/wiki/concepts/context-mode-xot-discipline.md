---
title: "Xot Module — Context-Mode Discipline"
type: "rule"
tags: [xot, context-mode, atomic-wiki, compression]
created: 2026-05-12
updated: 2026-05-12
---

# Xot Module — Context-Mode Discipline

> Core module context-mode configuration per evitare context overflow.

## File Wiki Limits

```
laravel/Modules/Xot/docs/wiki/
├── index.md                    # ≤30 righe
├── rules/
│   ├── INDEX.md               # ≤20 righe → root trigger map
│   ├── xotbase-critical-rules.md      # ≤200 righe
│   └── filament-resource-property.md  # ≤200 righe
├── skills/
│   ├── INDEX.md               # ≤20 righe
│   └── filament-page-creation.md      # ≤150 righe
└── concepts/
    ├── xotbase-resource-zen-pattern.md    # ≤200 righe
    └── xotbase-provider-pattern.md        # ≤200 righe
```

**Regola:** Nessun file > 200 righe. Split atomico per idea.

---

## On-Demand Loading

### Trigger → Load Map

| Trigger | Load |
|---------|------|
| Xot resource creation | `laravel/Modules/Xot/docs/wiki/rules/xotbase-critical-rules.md` |
| XotBaseListRecords | `laravel/Modules/Xot/docs/wiki/rules/filament-resource-property.md` |
| $resource property | `laravel/Modules/Xot/docs/wiki/rules/filament-resource-property.md` |
| Filament page in Xot | `laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md` |

---

## Search Commands

```bash
# Load only Xot wiki
qmd search "xotbase" --limit 3

# Load specific rule
qmd search "xotbase critical" --limit 1
```

---

## Context Savings

- **Per query:** Load only ≤5 results (ctx_search limit: 3-5)
- **Per session:** Max 50K context tokens (Xot wiki alone ≤10K)
- **Atomicity:** Each wiki page = one pattern/rule

---

## Vedi anche

- Root: `docs/wiki/concepts/context-mode-optimal-configuration.md`
- Root: `docs/wiki/rules/laraxot-module-namespace.md`
- `../rules/xotbase-critical-rules.md`
