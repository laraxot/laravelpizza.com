---
title: "REPLIKATE - Design Comuni Index"
type: index
tags: [notify, docs, design-comuni]
module: Notify
created: 2026-07-20
updated: 2026-07-20
qmd: "notify documentazione design comuni index replikate - design comuni index index readme frontmatter qmd search"
issues:
  - "https://github.com/laraxot/module_notify_fila5/issues/56"
discussions:
  - "https://github.com/laraxot/module_notify_fila5/discussions/57"
related:
  - ../README.md
  - ../wiki/index.md
  - ../notifications/readme.md
  - ../integrations/readme.md
  - ../templates/readme.md
status: draft
---
# REPLIKATE - Design Comuni Index

Documentazione per replica Design Comuni → Tailwind + Alpine.js

## 📂 Struttura

```
docs/
├── design-comuni/
│   ├── pages/              # Analisi per pagina
│   │   └── argomenti.md   # Argomenti analysis (IN PROGRESS)
│   └── screenshots/       # Screenshot comparison
├── theme/
│   └── sixteen/
│       └── analysis/       # Homepage analysis (~90%)
└── index.md               # Questo file
```

## 📋 Pagine Prioritarie

| # | Pagina | Status | HTML Match | Note |
|---|-------|--------|------------|------|
| 1 | homepage | ~90% ✓ | ✓ | Base CSS applicati |
| 2 | argomenti | IN PROGRESS | ~60% | Topics grid diversa |
| 3 | servizi | In queue | - | Da processare |
| 4 | amministrazione | In queue | - | Da processare |
| 5 | novita | In queue | - | Da processare |
| 6 | eventi | In queue | - | Da processare |
| ... | altre | In queue | - | ~90+ pagine |

## 📝 Ultime Analisi

### Argomenti (IN PROGRESS)
- **Screenshot**: `/tmp/argomenti-ref.png` + `/tmp/argomenti-local.png`
- **Issues**: Topics grid manca layout cards con immagini
- **Fix**: Aggiungere CSS grid per topics cards

## 🔗 Link Utili

- [Prompt REPLIKATE](./laravel/Themes/Sixteen/docs/prompts/replikate.txt)
- [Theme Analysis](./docs/theme/sixteen/analysis/)
- [Homepage Results](./docs/theme/sixteen/analysis/results.md)
- [Argomenti Analysis](./docs/design-comuni/pages/argomenti.md)
- [Theme Analysis](../theme/sixteen/analysis)
- [Homepage Results](../theme/sixteen/analysis/results.md)
- [Argomenti Analysis](./pages/argomenti.md)

---

*Category: design-comuni-replication*
*Last Updated: 2026-04-07*
