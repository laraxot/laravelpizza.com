---
title: "Case-Insensitive File Conflicts"
module: "Lang"
type: concept
tags: [phpstan, level10, fixes, 1]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan level10 fixes 1"
related:
  - "./italian-text-refined-audit-report.md"
---
# Case-Insensitive File Conflicts

Nel modulo `Lang` sono presenti i seguenti duplicati con differenze solo di maiuscole/minuscole:

- `Modules/Lang/docs`: `LOCALE_MANAGEMENT.md`, `locale-management-3.md`
- `Modules/Lang/docs`: `QUICK_REFERENCE.md`, `quick-reference-3.md`
- `Modules/Lang/docs`: `TRANSLATION_STRATEGIES.md`, `translation-strategies-3.md`
- `Modules/Lang/docs`: `TRANSLATION_PROCESS.md`, `translation-process-3.md`
- `Modules/Lang/docs`: `MCAMARA_IMPLEMENTATION_GUIDE.md`, `mcamara-implementation-guide-3.md`
- `Modules/Lang/docs/translations`: `readme-2.it.md`, `readme-2.it.md`
- `Modules/Lang/docs/translations`: `readme-2.es.md`, `readme-2.es.md`

È necessario mantenere una sola variante per ogni file (ad esempio quella con il prefisso maiuscolo già utilizzato per altri documenti globali) e rimuovere la duplicazione.
