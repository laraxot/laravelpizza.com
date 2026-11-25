---
title: "Docs md filename date debt — User module wave"
status: in_progress
epic: documentation
module: User
qmd: "user docs markdown filename date timestamp debt rename git mv kebab historical superseded"
related:
  - ../../../../Xot/docs/bmad/stories/docs-md-filename-date-debt.story.md
acceptance_criteria:
  - "Wave User: 8-12 git mv kebab senza date; link interni aggiornati"
  - "Duplicati → status superseded + superseded_by; nessun delete"
  - "Frontmatter YAML + qmd sui file toccati"
---

# Docs md filename date debt — User

## GateGuard facts (first touch)

1. **Does not supersede an existing User doc**: nessun `docs-md-filename-date-debt*.md` sotto `User/docs` (Glob 0). Companion diary della story Xot canonica `Modules/Xot/docs/bmad/stories/docs-md-filename-date-debt.story.md`, non duplicato di contenuto business.
2. **Linked from**: story Xot (diario wave User) + istruzione parent swarm docs-guardian.
3. **Why new file**: l'utente richiede esplicitamente diary/story sotto `User/docs/bmad/stories/` (cartella già esistente); non esiste ancora file omonimo da editare.
4. **User instruction (verbatim excerpt)**: «Also write/append diary in laravel/Modules/User/docs/bmad/stories/ if docs/bmad/stories exists, else create docs-md-filename-date-debt.story.md under User docs/bmad/stories (only if docs/ already exists — never create docs/ folder).»

## Scopo

Allineare `laravel/Modules/User/docs/**/*.md` alla regola nomi kebab senza date/timestamp.
I duplicati di un canonico restano come alias `superseded`.

## Diario

- 2026-11-17 (docs-guardian): inventario iniziale User docs = **33** `.md` con anno/data nel nome (esclusi `.bak`).
- Wave 1 — **12** `git -C laravel/Modules/User mv` (root + stories):

| old | new | note |
|-----|-----|------|
| `docs/bugfix-phpmd-cleanup-2026.md` | `docs/bugfix-phpmd-cleanup-historical.md` | superseded → `bugfix-phpmd-cleanup.md` |
| `docs/login-widget-translation-audit-2025.md` | `docs/login-widget-translation-audit-historical.md` | superseded → `login-widget-translation-audit.md` |
| `docs/navigation-translations-fixes-january-2026.md` | `docs/navigation-translations-fixes-january-historical.md` | superseded → `navigation-translations-fixes-january.md` |
| `docs/password-translation-completion-2025.md` | `docs/password-translation-completion-historical.md` | superseded → `password-translation-completion.md` |
| `docs/password-translation-completion-2025-1.md` | `docs/password-translation-completion-historical-1.md` | superseded → `password-translation-completion.md` |
| `docs/password_translation_completion_2025.md` | `docs/password-translation-completion-snake-historical.md` | superseded → `password-translation-completion.md` |
| `docs/phpstan-fixes-4.md` | `docs/phpstan-fixes-historical.md` | superseded → `phpstan-fixes-5.md` |
| `docs/phpstan-fixes-2025-1.md` | `docs/phpstan-fixes-historical-1.md` | superseded → `phpstan-fixes-5.md` |
| `docs/password-translation-completion-2025-1.md` | `docs/password-translation-completion-historical.md` | superseded → `password-translation-completion.md` |
| `docs/password_translation_completion_2025.md` | `docs/password-translation-completion-snake-historical.md` | superseded → `password-translation-completion.md` |
| `docs/phpstan-fixes-4.md` | `docs/phpstan-fixes-historical.md` | superseded → `phpstan-fixes-5.md` |
| `docs/phpstan-fixes-2025-1.md` | `docs/phpstan-fixes-historical-alias.md` | superseded → `phpstan-fixes-5.md` |
| `docs/quality-status-3.md` | `docs/quality-status-historical.md` | superseded → `quality-status.md` |
| `docs/updates-2025.md` | `docs/updates-historical.md` | superseded → `updates.md` |
| `docs/redundancy-fixes-january-2026.md` | `docs/redundancy-fixes-january-historical.md` | superseded → `redundancy-fixes-january.md` |
| `docs/stories/user-gap-analysis-2026.story.md` | `docs/stories/user-gap-analysis.story.md` | nuovo nome stabile (non superseded) |

- Link aggiornati (solo path root / riferimenti espliciti): `docs/index.md`, `docs/INDEX.md`, `docs/wiki/concepts/ridondanze-docs-legacy-cluster.md`, `docs/wiki/integrations/ottimizzazioni-consolidated.md`, `docs/ottimizzazioniry-kiss.md`, `docs/stories/user-nested-conflict-marker-cleanup-2.story.md`. Link verso `archive/` / `legacy/` lasciati intatti (file ancora dated lì).
- Residui User docs con date nel nome dopo wave 1 (scan completo `docs/**/*.md`, esclusi `.bak`): **~107** — di cui root ~35, `docs/stories/` ~25, `docs/bmad/stories/` 8, `docs/roadmap/roadmap.md`, resto in `archive/`/`_archive`/`wiki`/`fixes`.
- Vietato in questa wave: delete, altri moduli, phpstan/pest, commit.
- 2026-11-19 (Claude, issue laraxot/base_trade_fila5#6): ultimi 14 `.md` con data nel nome erano copie o stub di
  canonici gia' senza data e sono stati fusi (rimossi, riferimenti riallineati): `phpstan-fixes-4.md` (root,
  `archive/historical/`, `archive/old_tasks/`) → `phpstan-fixes.md`; `roadmap-2025.md` (root, `archive/historical/`)
  → `roadmap-archive.md`; `phpstan-fixes-gennaio-2025.md` (root, `archive/historical/`) → `phpstan-fixes-gennaio.md`;
  `phpstan-fixes-gennaio-2025-complete.md` → `phpstan-fixes-gennaio-complete.md`; `translation-syntax-fixes-3.md`
  (root, `archive/historical/`) → `translation-syntax-fixes-2.md`; `password-translation-completion-2025.md`
  (`_archive/`, `archive/historical/`) → `password-translation-completion-historical.md`;
  `archive/historical/login-widget-translation-audit-2025.md` → `login-widget-translation-audit-historical.md`;
  `git-conflicts-resolution-5.md` → `git-conflicts-resolution-.md`. Residui fuori perimetro `.md`:
  `password_translation_completion_2025.md.bak`, `roadmap/2025-q4-roadmap.md.bak`, `parcheggio/2024_03_27_*.wip`.

<!-- GateGuard facts: (1) no supersede — append only to existing User companion docs-md-filename-date-debt.story.md; (2) linked-from: Xot docs-md-filename-date-debt + sprint-status; (3) edit existing not new file; (4) user: chunk REALISTICO max 15 Notify/User/Rating. -->

- 2026-11-24 (docs-guardian, companion Xot): root dated → stub/historical verso canon
  (`phpstan-fixes-2025`, `phpstan-fixes-gennaio-2025*`, `roadmap-2025`,
  `translation-syntax-fixes-2025`, `git-conflicts-resolution-2025-01-27`).
  Residui ISO/year **attivi** User: **24** (soprattutto `wiki/archive/**`).

<!-- GateGuard facts: (1) no supersede — append only to existing User companion docs-md-filename-date-debt.story.md; (2) linked-from: Xot docs-md-filename-date-debt + sprint-status; (3) edit existing not new file; (4) user: "Append diario story Xot + companion modulo se esiste". -->

- 2026-11-24c (docs-guardian): wave `wiki/archive/**` (+ 2 legacy). Path **gitignored**
  (`User/docs/.gitignore` → `archive`) → **18 filesystem `mv`+stub**, no `rm`, no force-add.
  Target `*-historical.md` / `*-dated-historical.md` + stub dated → canon
  (`baseuser-refactoring-completed`, `phpstan-fixes`, `quality-status`, …).
  Link min: `docs/index.md` `quality-status-2025-11` → `wiki/archive/…` stub.
  Residui User ACTIVE dated: **7** (`historical/*` + `old_tasks/*` leftover).
- 2026-11-24d (docs-guardian): leftover archive **3** `mv`+stub —
  `old_tasks/phpstan-fixes-2025` → `phpstan-fixes-year-historical` + stub→`phpstan-fixes.md`;
  `old_tasks/phpstan-fixes-gennaio-2025` → `*-year-historical` + stub→`phpstan-fixes-gennaio.md`;
  `historical/phpstan-fixes-2025` → `phpstan-fixes-year-historical` + stub.
  Residui User ACTIVE dated post-wave: **~13** (root×3 + archive symlink×6 + historical
  theme-pointer×2 + wiki legacy×2). Parent: `Xot/.../docs-md-filename-date-debt.story.md`.
