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
<<<<<<< HEAD
<<<<<<< HEAD
`index.md` (maiuscolo) e' stub superseded → questo file.
=======
<<<<<<< HEAD
`INDEX.md` (maiuscolo) e' stub superseded → questo file.
=======
`index.md` (maiuscolo) e' stub superseded → questo file.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
`INDEX.md` (maiuscolo) e' stub superseded → questo file.
>>>>>>> laraxot/dev

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
- `phpstan-fixes-january.md` / `phpstan-fixes-correzioni-gennaio.md` / `phpstan-fixes-november.md` (+ varianti)
- `translations-update.md`
- `wiki/troubleshooting/*-2026-*.md`
- collisione case: `ARCHITECTURE_2025.md` / `architecture-2025.md` / `architecture_2025.md`
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
<<<<<<< .merge_file_Zt0T0k
- `phpstan-fixes.md` / `phpstan-fixes.md` / `phpstan-fixes.md` (+ varianti)
=======
- `phpstan-fixes-january.md` / `phpstan-fixes-correzioni-gennaio.md` / `phpstan-fixes-november.md` (+ varianti)
>>>>>>> .merge_file_5sUf68
- `translations-update.md`
- `wiki/troubleshooting/*-2026-*.md`
- collisione case: `ARCHITECTURE_2025.md` / `architecture.md` / `architecture_2025.md`
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev

```bash
python3 -I bashscripts/tools/docs/md-filenames.py check --paths laravel/Modules/UI/docs
```
<<<<<<< HEAD
<<<<<<< HEAD
=======

## Mappa delle cartelle

Elenco generato dall'audit qualita' (issue #64): ogni cartella di `docs/` con il numero di file `.md`.
Le cartelle di import grezzo (`raw/`, `root-*-files/`), immagini e log sono escluse.

| Cartella | File .md |
|---|---|
| [`actions/`](actions/) | 3 |
| [`archive/`](archive/) | 140 |
| [`audits/`](audits/) | 1 |
| [`bmad/`](bmad/README.md) | 52 |
| [`bugfix/`](bugfix/) | 4 |
| [`charts/`](charts/) | 6 |
| [`clean-code/`](clean-code/) | 1 |
| [`components/`](components/) | 5 |
| [`concepts/`](concepts/) | 1 |
| [`ecc/`](ecc/) | 2 |
| [`epics/`](epics/) | 1 |
| [`filament/`](filament/) | 3 |
| [`icons/`](icons/) | 1 |
| [`investigation/`](investigation/) | 1 |
| [`lessons-learned/`](lessons-learned/) | 1 |
| [`llm-wiki/`](llm-wiki/index.md) | 4 |
| [`prompts/`](prompts/) | 4 |
| [`quality-analysis/`](quality-analysis/) | 1 |
| [`roadmap/`](roadmap/index.md) | 34 |
| [`standards/`](standards/README.md) | 6 |
| [`stories/`](stories/) | 37 |
| [`tasks/`](tasks/) | 9 |
| [`themes/`](themes/) | 2 |
| [`wiki/`](wiki/index.md) | 119 |
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
