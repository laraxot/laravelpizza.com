---
title: "Git: inventario conflitti merge (User)"
type: troubleshooting
module: User
tags: [git, merge, conflict, user]
created: 2026-04-28
updated: 2026-07-08
qmd: "git merge conflict markers User docs inventory rebase"
related:
  - "./filament-user-creation-pty-error.md"
  - "./git-merge-conflict-inventory.md"
  - "./git-push-lfs-missing-objects.md"
  - "./phpstan-module-analysis-memory.md"
  - "./phpstan-widget-property-types.md"
  - "./phpstan-widget-property-types.md"
  - "./spatie-permission-team-model-not-configured.md"
  - "./git-merge-conflict-inventory-stato-rinominato.md"
  - "./git-push-lfs-missing-objects.md"
  - "./phpstan-module-analysis-memory.md"
  - "./phpstan-widget-property-types-stato-rinominato.md"
  - "./phpstan-widget-property-types.md"
  - "./spatie-permission-team-model-not-configured.md"
status: draft
---

# Git: inventario conflitti merge (User)

## Stato 2026-07-08

- **Rebase abortito** su `dev` (328 pick, 623 file `AA`): causa: tentativo rebase sopra `laraxot/dev` con storico LFS corrotto.
- Dopo `git rebase --abort`: **0** marker `<<<<<<<` nei `.md` tracciati (`git grep`).
- Push risolto con squash → [git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md).

## Inventario storico (2026-04-28)

File con marker (da risolvere forward-only se riappaiono):

- `docs/archive/historical/volt-folio-logout-error.md`
- `docs/archive/historical/volt-folio-logout.md`
- `docs/phpstan-fixes-roadmap.md`
- `docs/volt-folio-logout-error.md`
- `docs/wiki/README.md`

## Note operative

- Rigenerare lista: `git grep -l '^<<<<<<<' -- '*.md' 'docs/'`
- Non risolvere in parallelo senza lock; preferire wiki canonico `docs/wiki/` rispetto a duplicati root `docs/*.md`.
- Task dedicato marker doc: `docs/tasks/fix-doc-merge-markers.md`