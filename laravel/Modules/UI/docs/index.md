---
title: "UI: Documentazione"
type: index
status: active
updated: 2026-11-16
tags: [docs, ui]
qmd: "ui documentazione indice naming debt kebab-case wiki bmad"
---

# UI: Documentazione

Ingresso del modulo UI. Nomi: kebab-case, **senza date** nel filename
([55-md-conventions](../../../../bashscripts/docs/prompts/55-md-conventions.md)).
`index.md` (maiuscolo) e' stub superseded → questo file.

## Orientamento

- [completion-status.md](./completion-status.md) — cosa manca
- [wiki/index.md](./wiki/index.md) — wiki locale
- [theme-build.md](./theme-build.md) — build tema
- [bmad/](./bmad/) — story e decisioni BMAD
- [tasks/tasks-index.md](./tasks/tasks-index.md) — task aperti

## Debito naming (flag)

File con date/mesi nel nome ancora presenti (non cancellare; marca `superseded` +
canonico senza data via [docs-clean.md](../../../../bashscripts/docs/prompts/docs-clean.md)):

- `audits/quality-gates.md`
- `bugfix-*-2025-01-27.md` (+ copie in `archive/`)
- `phpstan-fixes-january.md` / `phpstan-fixes-correzioni-gennaio.md` / `phpstan-fixes-november.md` (+ varianti)
- `translations-update.md`
- `wiki/troubleshooting/*-2026-*.md`
- collisione case: `ARCHITECTURE_2025.md` / `architecture-2025.md` / `architecture_2025.md`

```bash
python3 -I bashscripts/tools/docs/md-filenames.py check --paths laravel/Modules/UI/docs
```
